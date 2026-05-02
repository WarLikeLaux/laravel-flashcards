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
            'topic' => null,
            'difficulty' => $this->faker->numberBetween(1, 5),
            'question' => $this->faker->sentence().'?',
            'answer' => $this->faker->paragraph(),
            'code_example' => null,
            'code_language' => null,
            'cloze_text' => null,
            'short_answer' => null,
            'assemble_chunks' => null,
            'correct_streak' => 0,
            'correct_modes' => null,
            'required_correct' => Flashcard::LEARN_THRESHOLD,
            'is_learned' => false,
            'studied' => true,
            'next_review_at' => null,
            'srs_step' => 0,
        ];
    }

    public function unstudied(): self
    {
        return $this->state(fn () => ['studied' => false]);
    }

    public function withCode(?string $code = null, string $language = 'php'): self
    {
        return $this->state(fn () => [
            'code_example' => $code ?? "<?php\n\$x = 1;",
            'code_language' => $language,
        ]);
    }

    public function withCloze(string $template = 'php artisan {{make:controller}} UserController'): self
    {
        return $this->state(fn () => ['cloze_text' => $template]);
    }

    public function withShortAnswer(string $value = 'explode'): self
    {
        return $this->state(fn () => ['short_answer' => $value]);
    }

    /**
     * @param  array<int, string>|null  $chunks
     */
    public function withAssemble(?array $chunks = null): self
    {
        return $this->state(fn () => [
            'assemble_chunks' => $chunks ?? ['User::', "where('active', 1)", '->', 'get()'],
        ]);
    }

    public function learned(): self
    {
        return $this->state(fn () => [
            'correct_streak' => Flashcard::LEARN_THRESHOLD,
            'correct_modes' => ['reveal', 'true_false', 'multiple_choice'],
            'required_correct' => Flashcard::LEARN_THRESHOLD,
            'is_learned' => true,
            'srs_step' => 0,
            'next_review_at' => now()->addDays(Flashcard::SRS_INTERVALS_DAYS[0]),
        ]);
    }

    public function dueForReview(): self
    {
        return $this->state(fn () => [
            'correct_streak' => Flashcard::LEARN_THRESHOLD,
            'correct_modes' => ['reveal', 'true_false', 'multiple_choice'],
            'required_correct' => Flashcard::LEARN_THRESHOLD,
            'is_learned' => true,
            'srs_step' => 0,
            'next_review_at' => now()->subDay(),
        ]);
    }

    public function graduated(): self
    {
        return $this->state(fn () => [
            'correct_streak' => Flashcard::LEARN_THRESHOLD + count(Flashcard::SRS_INTERVALS_DAYS),
            'correct_modes' => ['reveal', 'true_false', 'multiple_choice'],
            'required_correct' => Flashcard::LEARN_THRESHOLD,
            'is_learned' => true,
            'srs_step' => count(Flashcard::SRS_INTERVALS_DAYS),
            'next_review_at' => null,
        ]);
    }
}
