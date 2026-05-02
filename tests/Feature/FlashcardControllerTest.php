<?php

use App\Models\Flashcard;

it('renders the index page with cards and stats', function (): void {
    Flashcard::factory()->count(3)->create();
    Flashcard::factory()->learned()->create();

    $this->get(route('flashcards.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('flashcards/index')
            ->has('flashcards.data', 4)
            ->has('categoryStats')
            ->where('filters.q', '')
            ->where('filters.status', 'all')
            ->where('filters.category', 'all')
            ->where('stats.total', 4)
            ->where('stats.learned', 1)
            ->where('stats.due', 3)
        );
});

it('filters cards by status=due', function (): void {
    Flashcard::factory()->create(['question' => 'Q1']);
    Flashcard::factory()->learned()->create(['question' => 'Q2']);

    $this->get(route('flashcards.index', ['status' => 'due']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('flashcards.data', 1)
            ->where('flashcards.data.0.question', 'Q1')
            ->where('filters.status', 'due')
        );
});

it('filters cards by status=learned', function (): void {
    Flashcard::factory()->count(2)->create();
    Flashcard::factory()->learned()->create(['question' => 'Done']);

    $this->get(route('flashcards.index', ['status' => 'learned']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('flashcards.data', 1)
            ->where('flashcards.data.0.question', 'Done')
        );
});

it('filters cards by category', function (): void {
    Flashcard::factory()->create(['category' => 'PHP']);
    Flashcard::factory()->create(['category' => 'PHP']);
    Flashcard::factory()->create(['category' => 'Laravel']);

    $this->get(route('flashcards.index', ['category' => 'PHP']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('flashcards.data', 2)
            ->where('filters.category', 'PHP')
        );
});

it('searches by question, answer, category, short_answer', function (): void {
    Flashcard::factory()->create([
        'question' => 'What is PSR-4?',
        'answer' => 'Autoloading standard.',
    ]);
    Flashcard::factory()->create([
        'question' => 'What is implode?',
        'answer' => 'Joins array values.',
        'short_answer' => 'implode',
    ]);

    $this->get(route('flashcards.index', ['q' => 'PSR']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->has('flashcards.data', 1));

    $this->get(route('flashcards.index', ['q' => 'implode']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->has('flashcards.data', 1));

    $this->get(route('flashcards.index', ['q' => 'array values']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->has('flashcards.data', 1));
});

it('returns category breakdown counts', function (): void {
    Flashcard::factory()->count(3)->create(['category' => 'PHP']);
    Flashcard::factory()->learned()->create(['category' => 'PHP']);
    Flashcard::factory()->count(2)->create(['category' => 'Laravel']);

    $this->get(route('flashcards.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('categoryStats', 2)
            ->where('categoryStats.0.name', 'Laravel')
            ->where('categoryStats.0.total', 2)
            ->where('categoryStats.0.learned', 0)
            ->where('categoryStats.1.name', 'PHP')
            ->where('categoryStats.1.total', 4)
            ->where('categoryStats.1.learned', 1)
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

it('renders the edit page with the card payload', function (): void {
    $card = Flashcard::factory()->create([
        'category' => 'PHP',
        'question' => 'Q?',
        'answer' => 'A.',
    ]);

    $this->get(route('flashcards.edit', $card))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('flashcards/edit')
            ->where('flashcard.id', $card->id)
            ->where('flashcard.question', 'Q?')
            ->where('flashcard.category', 'PHP')
        );
});

it('updates a flashcard preserving progress', function (): void {
    $card = Flashcard::factory()->create([
        'question' => 'Old',
        'answer' => 'Old A',
        'correct_streak' => 1,
        'required_correct' => 3,
    ]);

    $this->patch(route('flashcards.update', $card), [
        'category' => 'Laravel',
        'question' => 'New',
        'answer' => 'New A',
        'short_answer' => 'foo',
    ])->assertRedirect(route('flashcards.index'));

    $fresh = $card->fresh();
    expect($fresh->question)->toBe('New')
        ->and($fresh->category)->toBe('Laravel')
        ->and($fresh->short_answer)->toBe('foo')
        ->and($fresh->correct_streak)->toBe(1)
        ->and($fresh->required_correct)->toBe(3);
});

it('validates required fields when updating', function (): void {
    $card = Flashcard::factory()->create();

    $this->patch(route('flashcards.update', $card), [])
        ->assertSessionHasErrors(['question', 'answer']);
});

it('resets progress for all cards', function (): void {
    Flashcard::factory()->learned()->count(3)->create();

    $this->post(route('flashcards.reset'))
        ->assertRedirect(route('flashcards.index'));

    expect(Flashcard::query()->where('is_learned', true)->count())->toBe(0);
    expect(Flashcard::query()
        ->where('required_correct', \App\Models\Flashcard::LEARN_THRESHOLD)
        ->count())->toBe(3);
});
