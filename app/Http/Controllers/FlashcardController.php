<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFlashcardRequest;
use App\Models\Flashcard;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class FlashcardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('flashcards/index', [
            'flashcards' => Flashcard::query()
                ->latest('id')
                ->get(['id', 'category', 'question', 'answer', 'correct_streak', 'required_correct', 'is_learned']),
            'stats' => [
                'total' => Flashcard::query()->count(),
                'learned' => Flashcard::query()->where('is_learned', true)->count(),
                'due' => Flashcard::query()->due()->count(),
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('flashcards/create');
    }

    public function store(StoreFlashcardRequest $request): RedirectResponse
    {
        Flashcard::query()->create($request->validated());

        return redirect()->route('flashcards.index');
    }

    public function destroy(Flashcard $flashcard): RedirectResponse
    {
        $flashcard->delete();

        return redirect()->route('flashcards.index');
    }

    public function reset(): RedirectResponse
    {
        Flashcard::query()->update([
            'correct_streak' => 0,
            'required_correct' => 1,
            'is_learned' => false,
        ]);

        return redirect()->route('flashcards.index');
    }
}
