<?php

use App\Models\Flashcard;

it('renders the index page with cards and stats', function (): void {
    Flashcard::factory()->count(3)->create();
    Flashcard::factory()->learned()->create();

    $this->get(route('flashcards.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('flashcards/index')
            ->has('flashcards', 4)
            ->where('stats.total', 4)
            ->where('stats.learned', 1)
            ->where('stats.due', 3)
        );
});

it('redirects root to flashcards', function (): void {
    $this->get('/')->assertRedirect(route('flashcards.index'));
});

it('renders the create page', function (): void {
    $this->get(route('flashcards.create'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('flashcards/create'));
});

it('stores a flashcard', function (): void {
    $this->post(route('flashcards.store'), [
        'category' => 'PHP',
        'question' => 'What is PSR-4?',
        'answer' => 'Autoloading standard.',
        'code_example' => "<?php\necho 1;",
        'code_language' => 'php',
    ])->assertRedirect(route('flashcards.index'));

    $card = Flashcard::query()->sole();
    expect($card->question)->toBe('What is PSR-4?')
        ->and($card->code_example)->toBe("<?php\necho 1;")
        ->and($card->code_language)->toBe('php');
});

it('stores a flashcard without optional code', function (): void {
    $this->post(route('flashcards.store'), [
        'question' => 'Q',
        'answer' => 'A',
    ])->assertRedirect(route('flashcards.index'));

    $card = Flashcard::query()->sole();
    expect($card->code_example)->toBeNull()
        ->and($card->code_language)->toBeNull();
});

it('validates required fields when storing', function (): void {
    $this->post(route('flashcards.store'), [])
        ->assertSessionHasErrors(['question', 'answer']);
});

it('deletes a flashcard', function (): void {
    $card = Flashcard::factory()->create();

    $this->delete(route('flashcards.destroy', $card))
        ->assertRedirect(route('flashcards.index'));

    expect(Flashcard::query()->count())->toBe(0);
});

it('resets progress for all cards', function (): void {
    Flashcard::factory()->learned()->count(3)->create();

    $this->post(route('flashcards.reset'))
        ->assertRedirect(route('flashcards.index'));

    expect(Flashcard::query()->where('is_learned', true)->count())->toBe(0);
    expect(Flashcard::query()->where('required_correct', 1)->count())->toBe(3);
});
