<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReviewController extends Controller
{
    private const SESSION_KEY = 'review.seen';

    private const FIELDS = [
        'id', 'category', 'topic', 'difficulty',
        'question', 'answer',
        'code_example', 'code_language',
        'cloze_text', 'short_answer', 'assemble_chunks',
        'is_learned', 'srs_step', 'next_review_at',
    ];

    public function show(Request $request): Response
    {
        $excludeId = $request->integer('exclude') ?: null;
        $seen = $this->seenIds($request);

        $flashcard = $this->pickCard($seen, $excludeId);

        $totalLearned = Flashcard::query()->where('is_learned', true)->count();
        $remaining = Flashcard::query()
            ->where('is_learned', true)
            ->whereNotIn('id', $seen)
            ->count();

        return Inertia::render('review/index', [
            'flashcard' => $flashcard?->only(self::FIELDS),
            'stats' => [
                'total' => $totalLearned,
                'seen' => count($seen),
                'remaining' => $remaining,
            ],
        ]);
    }

    public function remember(Request $request, Flashcard $flashcard): RedirectResponse
    {
        $this->markSeen($request, $flashcard->id);

        return redirect()->route('review.show');
    }

    public function forgot(Request $request, Flashcard $flashcard): RedirectResponse
    {
        $flashcard->markIncorrect();
        $this->markSeen($request, $flashcard->id);

        return redirect()->route('review.show');
    }

    public function reset(Request $request): RedirectResponse
    {
        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('review.show');
    }

    /**
     * @param  array<int, int>  $seen
     */
    private function pickCard(array $seen, ?int $excludeId): ?Flashcard
    {
        $build = function () use ($seen): Builder {
            return Flashcard::query()
                ->where('is_learned', true)
                ->whereNotIn('id', $seen);
        };

        if ($excludeId !== null) {
            $card = $build()->where('id', '!=', $excludeId)->inRandomOrder()->first();
            if ($card !== null) {
                return $card;
            }
        }

        return $build()->inRandomOrder()->first();
    }

    /**
     * @return array<int, int>
     */
    private function seenIds(Request $request): array
    {
        $raw = $request->session()->get(self::SESSION_KEY, []);

        return array_values(array_map('intval', (array) $raw));
    }

    private function markSeen(Request $request, int $id): void
    {
        $seen = $this->seenIds($request);
        if (! in_array($id, $seen, true)) {
            $seen[] = $id;
        }
        $request->session()->put(self::SESSION_KEY, $seen);
    }
}
