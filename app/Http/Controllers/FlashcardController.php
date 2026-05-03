<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFlashcardRequest;
use App\Models\Flashcard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class FlashcardController extends Controller
{
    private const FIELDS = [
        'id', 'category', 'topic', 'difficulty',
        'question', 'answer',
        'code_example', 'code_language',
        'cloze_text', 'short_answer', 'assemble_chunks', 'note',
        'correct_streak', 'correct_modes', 'required_correct',
        'is_learned', 'next_review_at', 'srs_step',
    ];

    public function index(Request $request): Response
    {
        $q = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', 'all');
        $category = (string) $request->query('category', 'all');

        $query = Flashcard::query();

        if ($q !== '') {
            $like = '%'.$q.'%';
            $query->where(function ($w) use ($like) {
                $w->where('question', 'like', $like)
                    ->orWhere('answer', 'like', $like)
                    ->orWhere('category', 'like', $like)
                    ->orWhere('short_answer', 'like', $like);
            });
        }

        if ($status === 'due') {
            $query->where('is_learned', false);
        } elseif ($status === 'learned') {
            $query->where('is_learned', true);
        }

        if ($category !== 'all' && $category !== '') {
            $query->where('category', $category);
        }

        return Inertia::render('flashcards/index', [
            'flashcards' => $query
                ->orderBy('difficulty')
                ->orderBy('id')
                ->paginate(24, self::FIELDS)
                ->withQueryString(),
            'stats' => $this->stats(),
            'categoryStats' => $this->categoryStats(),
            'filters' => [
                'q' => $q,
                'status' => in_array($status, ['all', 'due', 'learned'], true) ? $status : 'all',
                'category' => $category,
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

    public function edit(Flashcard $flashcard): Response
    {
        return Inertia::render('flashcards/edit', [
            'flashcard' => $flashcard->only(self::FIELDS),
        ]);
    }

    public function update(StoreFlashcardRequest $request, Flashcard $flashcard): RedirectResponse
    {
        $flashcard->update($request->validated());

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
            'correct_modes' => null,
            'required_correct' => Flashcard::LEARN_THRESHOLD,
            'is_learned' => false,
            'studied' => false,
            'next_review_at' => null,
            'srs_step' => 0,
        ]);

        return redirect()->route('flashcards.index');
    }

    /**
     * @return array{total: int, due: int, learned: int}
     */
    private function stats(): array
    {
        return [
            'total' => Flashcard::query()->count(),
            'learned' => Flashcard::query()->where('is_learned', true)->count(),
            'due' => Flashcard::query()->due()->count(),
        ];
    }

    /**
     * @return array<int, array{name: string, total: int, learned: int}>
     */
    private function categoryStats(): array
    {
        return Flashcard::query()
            ->select('category', DB::raw('COUNT(*) as total'), DB::raw('SUM(CASE WHEN is_learned = 1 THEN 1 ELSE 0 END) as learned'))
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderBy('category')
            ->get()
            ->map(fn ($r) => [
                'name' => (string) $r->category,
                'total' => (int) $r->total,
                'learned' => (int) $r->learned,
            ])
            ->all();
    }
}
