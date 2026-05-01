<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class StudyController extends Controller
{
    private const FIELDS = [
        'id', 'category', 'question', 'answer',
        'code_example', 'code_language',
        'cloze_text', 'short_answer', 'assemble_chunks',
        'correct_streak', 'required_correct',
    ];

    public function show(): Response
    {
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

        $flashcard = Flashcard::query()->due()->inRandomOrder()->first();

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
        $mode = $modes[array_rand($modes)];

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
        ]);

        $data['result'] === 'correct'
            ? $flashcard->markCorrect()
            : $flashcard->markIncorrect();

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
                ? $card->markCorrect()
                : $card->markIncorrect();
        }

        return redirect()->route('study.show');
    }

    /**
     * @return array<int, string>
     */
    private function availableModes(Flashcard $card): array
    {
        $modes = ['reveal'];

        $sameCategoryCount = Flashcard::query()
            ->where('id', '!=', $card->id)
            ->where('category', $card->category)
            ->count();

        if ($sameCategoryCount >= 1) {
            $modes[] = 'true_false';
        }

        if ($sameCategoryCount >= 3) {
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

    /**
     * @return array{answer: string, is_correct: bool}
     */
    private function trueFalseAnswer(Flashcard $card): array
    {
        $showReal = random_int(0, 1) === 0;

        if ($showReal) {
            return ['answer' => $card->answer, 'is_correct' => true];
        }

        $distractor = Flashcard::query()
            ->where('id', '!=', $card->id)
            ->where('category', $card->category)
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
        $distractors = Flashcard::query()
            ->where('id', '!=', $card->id)
            ->where('category', $card->category)
            ->inRandomOrder()
            ->limit(3)
            ->get();

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

        $distractors = Flashcard::query()
            ->where('id', '!=', $card->id)
            ->where('category', $card->category)
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

    /**
     * @return array{
     *     category: string,
     *     questions: array<int, array{id: int, text: string}>,
     *     answers: array<int, array{id: int, text: string}>
     * }|null
     */
    private function buildMatching(): ?array
    {
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
            ->get(['id', 'question', 'short_answer']);

        return [
            'category' => $category,
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
