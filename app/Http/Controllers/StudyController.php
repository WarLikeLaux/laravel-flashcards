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
        'correct_streak', 'required_correct',
    ];

    public function show(): Response
    {
        $flashcard = Flashcard::query()->due()->inRandomOrder()->first();

        if ($flashcard === null) {
            return Inertia::render('study/index', [
                'mode' => null,
                'flashcard' => null,
                'shown' => null,
                'options' => null,
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
        $sameCategoryCount = Flashcard::query()
            ->where('id', '!=', $card->id)
            ->where('category', $card->category)
            ->count();

        $optionsCount = max(4, min(10, $sameCategoryCount + 1));

        $distractors = Flashcard::query()
            ->where('id', '!=', $card->id)
            ->where('category', $card->category)
            ->inRandomOrder()
            ->limit($optionsCount - 1)
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
