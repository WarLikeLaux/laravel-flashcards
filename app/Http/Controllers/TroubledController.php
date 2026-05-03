<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class TroubledController extends Controller
{
    private const FIELDS = [
        'id', 'category', 'topic', 'difficulty',
        'question', 'answer',
        'code_example', 'code_language',
        'cloze_text', 'short_answer', 'assemble_chunks', 'note',
        'is_learned', 'studied', 'srs_step', 'next_review_at',
    ];

    private const BAD_KINDS = [
        'study_incorrect',
        'matching_incorrect',
        'review_forgot',
        'skipped',
    ];

    private const WINDOW_DAYS = 30;

    private const MIN_EVENTS = 3;

    private const LIMIT = 50;

    public function show(): Response
    {
        $window = now()->subDays(self::WINDOW_DAYS);

        $stats = DB::table('flashcard_events')
            ->where('occurred_at', '>=', $window)
            ->select(
                'flashcard_id',
                DB::raw('COUNT(*) as total'),
                DB::raw($this->badSumExpression().' as bad'),
                DB::raw($this->kindCountExpression('skipped').' as skipped'),
                DB::raw($this->kindCountExpression('study_incorrect').' as incorrect'),
                DB::raw($this->kindCountExpression('matching_incorrect').' as matching_incorrect'),
                DB::raw($this->kindCountExpression('review_forgot').' as forgot'),
                DB::raw('MAX(occurred_at) as last_seen'),
            )
            ->groupBy('flashcard_id')
            ->having('total', '>=', self::MIN_EVENTS)
            ->havingRaw($this->badSumExpression().' > 0')
            ->orderByRaw('('.$this->badSumExpression().' * 1.0 / COUNT(*)) DESC')
            ->orderByRaw($this->badSumExpression().' DESC')
            ->limit(self::LIMIT)
            ->get();

        $cards = Flashcard::query()
            ->whereIn('id', $stats->pluck('flashcard_id'))
            ->get(self::FIELDS)
            ->keyBy('id');

        $rows = $stats
            ->map(function ($stat) use ($cards) {
                /** @var \App\Models\Flashcard|null $card */
                $card = $cards->get($stat->flashcard_id);
                if ($card === null) {
                    return null;
                }

                $total = (int) $stat->total;
                $bad = (int) $stat->bad;

                return [
                    'flashcard' => $card->only(self::FIELDS),
                    'metrics' => [
                        'total' => $total,
                        'bad' => $bad,
                        'incorrect' => (int) $stat->incorrect,
                        'matching_incorrect' => (int) $stat->matching_incorrect,
                        'forgot' => (int) $stat->forgot,
                        'skipped' => (int) $stat->skipped,
                        'error_rate' => $total > 0 ? round($bad / $total, 3) : 0.0,
                        'last_seen' => (string) $stat->last_seen,
                    ],
                ];
            })
            ->filter()
            ->values()
            ->all();

        return Inertia::render('troubled/index', [
            'rows' => $rows,
            'window_days' => self::WINDOW_DAYS,
            'min_events' => self::MIN_EVENTS,
        ]);
    }

    private function badSumExpression(): string
    {
        $kinds = collect(self::BAD_KINDS)
            ->map(fn (string $k) => "'{$k}'")
            ->implode(',');

        return "SUM(CASE WHEN kind IN ({$kinds}) THEN 1 ELSE 0 END)";
    }

    private function kindCountExpression(string $kind): string
    {
        return "SUM(CASE WHEN kind = '{$kind}' THEN 1 ELSE 0 END)";
    }
}
