<?php

namespace Database\Factories;

use App\Models\Flashcard;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Flashcard>
 */
class FlashcardFactory extends Factory
{
    protected $model = Flashcard::class;

    public function definition(): array
    {
        return [
            'category' => $this->faker->randomElement(['PHP', 'Laravel', 'OOP', 'Database']),
            'question' => $this->faker->sentence().'?',
            'answer' => $this->faker->paragraph(),
            'correct_streak' => 0,
            'required_correct' => 1,
            'is_learned' => false,
        ];
    }

    public function learned(): self
    {
        return $this->state(fn () => [
            'correct_streak' => 1,
            'required_correct' => 1,
            'is_learned' => true,
        ]);
    }
}
