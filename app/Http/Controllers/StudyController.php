<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class StudyController extends Controller
{
    public function show(): Response
    {
        $flashcard = Flashcard::query()->due()->inRandomOrder()->first();

        return Inertia::render('study/index', [
            'flashcard' => $flashcard?->only(['id', 'category', 'question', 'answer', 'correct_streak', 'required_correct']),
            'stats' => [
                'total' => Flashcard::query()->count(),
                'due' => Flashcard::query()->due()->count(),
                'learned' => Flashcard::query()->where('is_learned', true)->count(),
            ],
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
}
