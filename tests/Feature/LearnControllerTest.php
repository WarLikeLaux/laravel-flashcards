<?php

use App\Models\Flashcard;

it('renders the learn page with an unstudied flashcard', function (): void {
    Flashcard::factory()->unstudied()->count(3)->create(['category' => 'PHP']);

    $this->get(route('learn.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('learn/index')
            ->has('flashcard')
            ->has('categories')
            ->where('stats.total', 3)
            ->where('stats.unstudied', 3)
            ->where('stats.studied', 0)
            ->where('filters.category', 'all')
        );
});

it('only picks unstudied cards', function (): void {
    Flashcard::factory()->create(['question' => 'studied-card']);
    $unstudied = Flashcard::factory()->unstudied()->create(['question' => 'fresh-card']);

    $this->get(route('learn.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('flashcard.id', $unstudied->id)
        );
});

it('starts with the easiest unstudied difficulty', function (): void {
    Flashcard::factory()->unstudied()->create(['difficulty' => 5, 'question' => 'hard']);
    $easy = Flashcard::factory()->unstudied()->create(['difficulty' => 1, 'question' => 'easy']);

    $this->get(route('learn.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('flashcard.id', $easy->id)
        );
});

it('filters cards by category on the learn page', function (): void {
    Flashcard::factory()->unstudied()->count(2)->create(['category' => 'PHP']);
    Flashcard::factory()->unstudied()->count(3)->create(['category' => 'Laravel']);

    $this->get(route('learn.show', ['category' => 'PHP']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('stats.total', 2)
            ->where('stats.unstudied', 2)
            ->where('filters.category', 'PHP')
            ->where('flashcard.category', 'PHP')
        );
});

it('marks a card as studied via the studied endpoint', function (): void {
    $card = Flashcard::factory()->unstudied()->create();

    $this->post(route('learn.studied', $card))
        ->assertRedirect();

    expect($card->fresh()->studied)->toBeTrue();
});

it('shows empty state when no unstudied cards remain', function (): void {
    Flashcard::factory()->count(2)->create();

    $this->get(route('learn.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('flashcard', null)
            ->where('stats.total', 2)
            ->where('stats.unstudied', 0)
            ->where('stats.studied', 2)
        );
});

it('respects exclude param', function (): void {
    $a = Flashcard::factory()->unstudied()->create();
    $b = Flashcard::factory()->unstudied()->create();

    $this->get(route('learn.show', ['exclude' => $a->id]))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('flashcard.id', $b->id)
        );
});
