<?php

namespace App\Models;

use Database\Factories\FlashcardFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    /** @use HasFactory<FlashcardFactory> */
    use HasFactory;

    public const LEARN_THRESHOLD = 3;

    /** @var array<int, int> Days between SRS reviews after a card is learned. */
    public const SRS_INTERVALS_DAYS = [1, 3, 5, 7];

    protected $fillable = [
        'category',
        'topic',
        'difficulty',
        'question',
        'answer',
        'code_example',
        'code_language',
        'cloze_text',
        'short_answer',
        'assemble_chunks',
        'note',
        'correct_streak',
        'correct_modes',
        'required_correct',
        'is_learned',
        'next_review_at',
        'srs_step',
        'studied',
    ];

    protected $casts = [
        'assemble_chunks' => 'array',
        'correct_modes' => 'array',
        'difficulty' => 'integer',
        'correct_streak' => 'integer',
        'required_correct' => 'integer',
        'is_learned' => 'boolean',
        'studied' => 'boolean',
        'next_review_at' => 'datetime',
        'srs_step' => 'integer',
    ];

    protected $attributes = [
        'difficulty' => 1,
        'correct_streak' => 0,
        'required_correct' => self::LEARN_THRESHOLD,
        'is_learned' => false,
        'studied' => false,
        'srs_step' => 0,
    ];

    public function scopeDue(Builder $query): Builder
    {
        return $query
            ->where('studied', true)
            ->where(function (Builder $q) {
                $q->where('is_learned', false)
                    ->orWhere(function (Builder $q2) {
                        $q2->where('is_learned', true)
                            ->whereNotNull('next_review_at')
                            ->where('next_review_at', '<=', now());
                    });
            });
    }

    public function scopeUnstudied(Builder $query): Builder
    {
        return $query->where('studied', false);
    }

    public function markStudied(): void
    {
        $this->studied = true;
        $this->save();
    }

    public function markCorrect(?string $mode = null): void
    {
        $this->correct_streak++;

        if ($this->is_learned) {
            $this->advanceSrsStep();
        } else {
            if ($mode !== null) {
                $modes = (array) ($this->correct_modes ?? []);
                if (! in_array($mode, $modes, true)) {
                    $modes[] = $mode;
                }
                $this->correct_modes = array_values($modes);
            }

            if ($this->isReadyToLearn()) {
                $this->is_learned = true;
                $this->srs_step = 0;
                $this->next_review_at = now()->addDays(self::SRS_INTERVALS_DAYS[0]);
            }
        }

        $this->save();
    }

    public function markIncorrect(): void
    {
        $this->correct_streak = 0;
        $this->correct_modes = [];
        $this->is_learned = false;
        $this->srs_step = 0;
        $this->next_review_at = null;
        $this->save();
    }

    public function resetProgress(): void
    {
        $this->correct_streak = 0;
        $this->correct_modes = [];
        $this->is_learned = false;
        $this->studied = false;
        $this->srs_step = 0;
        $this->next_review_at = null;
        $this->save();
    }

    private function advanceSrsStep(): void
    {
        $this->srs_step++;

        if ($this->srs_step >= count(self::SRS_INTERVALS_DAYS)) {
            $this->next_review_at = null;

            return;
        }

        $this->next_review_at = now()->addDays(self::SRS_INTERVALS_DAYS[$this->srs_step]);
    }

    private function isReadyToLearn(): bool
    {
        $distinct = count((array) ($this->correct_modes ?? []));
        $threshold = (int) ($this->required_correct ?: self::LEARN_THRESHOLD);

        return $distinct >= $threshold;
    }
}
