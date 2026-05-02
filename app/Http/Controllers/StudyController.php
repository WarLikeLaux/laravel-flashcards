<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use App\Models\FlashcardEvent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class StudyController extends Controller
{
    private const FIELDS = [
        'id', 'category', 'topic', 'difficulty',
        'question', 'answer',
        'code_example', 'code_language',
        'cloze_text', 'short_answer', 'assemble_chunks',
        'correct_streak', 'correct_modes', 'required_correct',
        'is_learned', 'next_review_at', 'srs_step',
    ];

    private const MODES = [
        'reveal', 'true_false', 'multiple_choice',
        'cloze', 'type_in', 'assemble', 'matching',
    ];

    public function show(): Response
    {
        $excludeId = request()->integer('exclude') ?: null;

        $matching = $this->buildMatching();

        if ($matching !== null && random_int(1, 5) === 1) {
            return Inertia::render('study/index', [
                'mode' => 'matching',
                'flashcard' => null,
                'shown' => null,
                'options' => null,
                'assemble' => null,
                'matching' => $matching,
                'stats' => $this->stats(),
            ]);
        }

        $flashcard = $this->pickDueCard($excludeId);

        if ($flashcard === null) {
            return Inertia::render('study/index', [
                'mode' => null,
                'flashcard' => null,
                'shown' => null,
                'options' => null,
                'assemble' => null,
                'matching' => null,
                'stats' => $this->stats(),
            ]);
        }

        $modes = $this->availableModes($flashcard);
        $mode = $this->pickMode($flashcard, $modes);

        return Inertia::render('study/index', [
            'mode' => $mode,
            'flashcard' => $flashcard->only(self::FIELDS),
            'shown' => $mode === 'true_false' ? $this->trueFalseAnswer($flashcard) : null,
            'options' => $mode === 'multiple_choice' ? $this->multipleChoiceOptions($flashcard) : null,
            'assemble' => $mode === 'assemble' ? $this->assemblePool($flashcard) : null,
            'matching' => null,
            'stats' => $this->stats(),
        ]);
    }

    public function answer(Flashcard $flashcard): RedirectResponse
    {
        $data = request()->validate([
            'result' => ['required', Rule::in(['correct', 'incorrect'])],
            'mode' => ['nullable', 'string', Rule::in(self::MODES)],
        ]);

        $data['result'] === 'correct'
            ? $flashcard->markCorrect($data['mode'] ?? null)
            : $flashcard->markIncorrect();

        FlashcardEvent::create([
            'flashcard_id' => $flashcard->id,
            'kind' => $data['result'] === 'correct' ? 'study_correct' : 'study_incorrect',
            'mode' => $data['mode'] ?? null,
            'occurred_at' => now(),
        ]);

        return redirect()->route('study.show');
    }

    public function matching(): RedirectResponse
    {
        $data = request()->validate([
            'pairs' => ['required', 'array', 'min:1', 'max:20'],
            'pairs.*.question_id' => ['required', 'integer', 'exists:flashcards,id'],
            'pairs.*.answer_id' => ['required', 'integer', 'exists:flashcards,id'],
        ]);

        foreach ($data['pairs'] as $pair) {
            $card = Flashcard::query()->find($pair['question_id']);
            if ($card === null) {
                continue;
            }

            $pair['question_id'] === $pair['answer_id']
                ? $card->markCorrect('matching')
                : $card->markIncorrect();

            FlashcardEvent::create([
                'flashcard_id' => $card->id,
                'kind' => $pair['question_id'] === $pair['answer_id']
                    ? 'matching_correct'
                    : 'matching_incorrect',
                'occurred_at' => now(),
            ]);
        }

        return redirect()->route('study.show');
    }

    private function pickDueCard(?int $excludeId = null): ?Flashcard
    {
        $build = function () use ($excludeId): Builder {
            $q = Flashcard::query()->due();
            if ($excludeId !== null) {
                $q->where('id', '!=', $excludeId);
            }

            return $q;
        };

        $minDifficulty = $build()->min('difficulty');

        if ($minDifficulty === null) {
            return $excludeId !== null ? $this->pickDueCard(null) : null;
        }

        return $build()
            ->where('difficulty', $minDifficulty)
            ->inRandomOrder()
            ->first();
    }

    /**
     * @param array<int, string> $modes
     */
    private function pickMode(Flashcard $card, array $modes): string
    {
        $taken = (array) ($card->correct_modes ?? []);
        $remaining = array_values(array_diff($modes, $taken));

        $pool = $remaining !== [] ? $remaining : $modes;

        return $pool[array_rand($pool)];
    }

    /**
     * @return array<int, string>
     */
    private function availableModes(Flashcard $card): array
    {
        $modes = ['reveal'];

        $sameTopicOrCategory = Flashcard::query()
            ->where('id', '!=', $card->id)
            ->where(fn (Builder $q) => $this->scopeNeighbors($q, $card))
            ->count();

        if ($sameTopicOrCategory >= 1) {
            $modes[] = 'true_false';
        }

        if ($sameTopicOrCategory >= 3) {
            $modes[] = 'multiple_choice';
        }

        if ($card->cloze_text !== null && preg_match('/\{\{(.+?)\}\}/', $card->cloze_text) === 1) {
            $modes[] = 'cloze';
        }

        if (filled($card->short_answer)) {
            $modes[] = 'type_in';
        }

        if (is_array($card->assemble_chunks) && count($card->assemble_chunks) >= 2) {
            $modes[] = 'assemble';
        }

        return $modes;
    }

    private function scopeNeighbors(Builder $q, Flashcard $card): Builder
    {
        if ($card->topic !== null) {
            return $q->where('topic', $card->topic);
        }

        return $q->where('category', $card->category);
    }

    /**
     * @return array{answer: string, is_correct: bool}
     */
    private function trueFalseAnswer(Flashcard $card): array
    {
        $showReal = random_int(0, 1) === 0;

        if ($showReal) {
            return ['answer' => $card->answer, 'is_correct' => true];
        }

        $distractor = $this->neighborQuery($card)
            ->inRandomOrder()
            ->first();

        if ($distractor === null) {
            return ['answer' => $card->answer, 'is_correct' => true];
        }

        return ['answer' => $distractor->answer, 'is_correct' => false];
    }

    /**
     * @return array<int, array{id: int, answer: string, is_correct: bool}>
     */
    private function multipleChoiceOptions(Flashcard $card): array
    {
        $distractors = $this->neighborQuery($card)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        if ($distractors->count() < 3 && $card->topic !== null) {
            $needed = 3 - $distractors->count();
            $extra = Flashcard::query()
                ->where('id', '!=', $card->id)
                ->where('category', $card->category)
                ->whereNotIn('id', $distractors->pluck('id'))
                ->inRandomOrder()
                ->limit($needed)
                ->get();
            $distractors = $distractors->concat($extra);
        }

        return $distractors
            ->map(fn (Flashcard $c) => [
                'id' => $c->id,
                'answer' => $c->answer,
                'is_correct' => false,
            ])
            ->push([
                'id' => $card->id,
                'answer' => $card->answer,
                'is_correct' => true,
            ])
            ->shuffle()
            ->values()
            ->toArray();
    }

    /**
     * @return array{pool: array<int, string>}
     */
    private function assemblePool(Flashcard $card): array
    {
        /** @var array<int, string> $correct */
        $correct = (array) $card->assemble_chunks;

        $distractors = $this->neighborQuery($card)
            ->whereNotNull('assemble_chunks')
            ->inRandomOrder()
            ->limit(5)
            ->get()
            ->flatMap(fn (Flashcard $c) => (array) $c->assemble_chunks)
            ->reject(fn (string $chunk) => in_array($chunk, $correct, true))
            ->unique()
            ->shuffle()
            ->take(2)
            ->values()
            ->all();

        $pool = collect([...$correct, ...$distractors])
            ->shuffle()
            ->values()
            ->all();

        return ['pool' => $pool];
    }

    private function neighborQuery(Flashcard $card): Builder
    {
        $query = Flashcard::query()->where('id', '!=', $card->id);

        return $card->topic !== null
            ? $query->where('topic', $card->topic)
            : $query->where('category', $card->category);
    }

    /**
     * @return array{
     *     category: string,
     *     questions: array<int, array{id: int, text: string}>,
     *     answers: array<int, array{id: int, text: string}>
     * }|null
     */
    private function buildMatching(): ?array
    {
        $topic = Flashcard::query()
            ->due()
            ->whereNotNull('short_answer')
            ->whereNotNull('topic')
            ->groupBy('topic')
            ->havingRaw('COUNT(*) >= 4')
            ->inRandomOrder()
            ->value('topic');

        if ($topic !== null) {
            $cards = Flashcard::query()
                ->due()
                ->whereNotNull('short_answer')
                ->where('topic', $topic)
                ->inRandomOrder()
                ->limit(4)
                ->get(['id', 'category', 'question', 'short_answer']);
        } else {
            $category = Flashcard::query()
                ->due()
                ->whereNotNull('short_answer')
                ->groupBy('category')
                ->havingRaw('COUNT(*) >= 4')
                ->inRandomOrder()
                ->value('category');

            if ($category === null) {
                return null;
            }

            $cards = Flashcard::query()
                ->due()
                ->whereNotNull('short_answer')
                ->where('category', $category)
                ->inRandomOrder()
                ->limit(4)
                ->get(['id', 'category', 'question', 'short_answer']);
        }

        return [
            'category' => (string) $cards->first()?->category,
            'questions' => $cards
                ->map(fn (Flashcard $c) => ['id' => $c->id, 'text' => $c->question])
                ->values()
                ->all(),
            'answers' => $cards
                ->shuffle()
                ->map(fn (Flashcard $c) => ['id' => $c->id, 'text' => (string) $c->short_answer])
                ->values()
                ->all(),
        ];
    }

    /**
     * @return array{total: int, due: int, learned: int}
     */
    private function stats(): array
    {
        return [
            'total' => Flashcard::query()->count(),
            'due' => Flashcard::query()->due()->count(),
            'learned' => Flashcard::query()->where('is_learned', true)->count(),
        ];
    }
}
