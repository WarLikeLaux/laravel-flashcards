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
        'correct_streak',
        'correct_modes',
        'required_correct',
        'is_learned',
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
    ];

    protected $attributes = [
        'difficulty' => 1,
        'correct_streak' => 0,
        'required_correct' => self::LEARN_THRESHOLD,
        'is_learned' => false,
        'studied' => false,
    ];

    public function scopeDue(Builder $query): Builder
    {
        return $query->where('studied', true)->where('is_learned', false);
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

        if ($mode !== null) {
            $modes = (array) ($this->correct_modes ?? []);
            if (! in_array($mode, $modes, true)) {
                $modes[] = $mode;
            }
            $this->correct_modes = array_values($modes);
        }

        if ($this->isReadyToLearn()) {
            $this->is_learned = true;
        }

        $this->save();
    }

    public function markIncorrect(): void
    {
        $this->correct_streak = 0;
        $this->correct_modes = [];
        $this->is_learned = false;
        $this->save();
    }

    public function resetProgress(): void
    {
        $this->correct_streak = 0;
        $this->correct_modes = [];
        $this->is_learned = false;
        $this->studied = false;
        $this->save();
    }

    private function isReadyToLearn(): bool
    {
        $distinct = count((array) ($this->correct_modes ?? []));
        $threshold = (int) ($this->required_correct ?: self::LEARN_THRESHOLD);

        return $distinct >= $threshold;
    }
}
