<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LearnController extends Controller
{
    private const FIELDS = [
        'id', 'category', 'topic', 'difficulty',
        'question', 'answer',
        'code_example', 'code_language',
        'cloze_text', 'short_answer', 'assemble_chunks',
        'is_learned',
    ];

    public function show(Request $request): Response
    {
        $excludeId = $request->integer('exclude') ?: null;
        $category = trim((string) $request->query('category', ''));
        $topic = trim((string) $request->query('topic', ''));

        $flashcard = $this->pickCard($excludeId, $category, $topic);

        $stats = $this->stats($category, $topic);
        $categories = Flashcard::query()
            ->whereNotNull('category')
            ->select('category')
            ->groupBy('category')
            ->orderBy('category')
            ->pluck('category')
            ->all();

        return Inertia::render('learn/index', [
            'flashcard' => $flashcard?->only(self::FIELDS),
            'stats' => $stats,
            'categories' => $categories,
            'filters' => [
                'category' => $category === '' ? 'all' : $category,
                'topic' => $topic === '' ? null : $topic,
            ],
        ]);
    }

    private function pickCard(?int $excludeId, string $category, string $topic): ?Flashcard
    {
        $build = function () use ($excludeId, $category, $topic): Builder {
            $q = Flashcard::query();
            if ($excludeId !== null) {
                $q->where('id', '!=', $excludeId);
            }
            if ($category !== '') {
                $q->where('category', $category);
            }
            if ($topic !== '') {
                $q->where('topic', $topic);
            }

            return $q;
        };

        $card = $build()->inRandomOrder()->first();

        if ($card === null && $excludeId !== null) {
            return $this->pickCard(null, $category, $topic);
        }

        return $card;
    }

    /**
     * @return array{total: int, learned: int}
     */
    private function stats(string $category, string $topic): array
    {
        $q = Flashcard::query();
        if ($category !== '') {
            $q->where('category', $category);
        }
        if ($topic !== '') {
            $q->where('topic', $topic);
        }

        $total = (clone $q)->count();
        $learned = (clone $q)->where('is_learned', true)->count();

        return ['total' => $total, 'learned' => $learned];
    }
}
