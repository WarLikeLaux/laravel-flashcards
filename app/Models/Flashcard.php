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

    protected $fillable = [
        'category',
        'question',
        'answer',
        'correct_streak',
        'required_correct',
        'is_learned',
    ];

    protected $casts = [
        'correct_streak' => 'integer',
        'required_correct' => 'integer',
        'is_learned' => 'boolean',
    ];

    protected $attributes = [
        'correct_streak' => 0,
        'required_correct' => 1,
        'is_learned' => false,
    ];

    public function scopeDue(Builder $query): Builder
    {
        return $query->where('is_learned', false);
    }

    public function markCorrect(): void
    {
        $this->correct_streak++;

        if ($this->correct_streak >= $this->required_correct) {
            $this->is_learned = true;
        }

        $this->save();
    }

    public function markIncorrect(): void
    {
        $this->correct_streak = 0;
        $this->required_correct++;
        $this->is_learned = false;
        $this->save();
    }

    public function resetProgress(): void
    {
        $this->correct_streak = 0;
        $this->required_correct = 1;
        $this->is_learned = false;
        $this->save();
    }
}
