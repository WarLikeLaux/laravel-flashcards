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
            'code_example' => null,
            'code_language' => null,
            'correct_streak' => 0,
            'required_correct' => 1,
            'is_learned' => false,
        ];
    }

    public function withCode(?string $code = null, string $language = 'php'): self
    {
        return $this->state(fn () => [
            'code_example' => $code ?? "<?php\n\$x = 1;",
            'code_language' => $language,
        ]);
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
