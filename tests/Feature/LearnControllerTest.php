<?php

use App\Models\Flashcard;

it('renders the learn page with a flashcard', function (): void {
    Flashcard::factory()->count(3)->create(['category' => 'PHP']);

    $this->get(route('learn.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('learn/index')
            ->has('flashcard')
            ->has('categories')
            ->where('stats.total', 3)
            ->where('filters.category', 'all')
        );
});

it('filters cards by category on the learn page', function (): void {
    Flashcard::factory()->count(2)->create(['category' => 'PHP']);
    Flashcard::factory()->count(3)->create(['category' => 'Laravel']);

    $this->get(route('learn.show', ['category' => 'PHP']))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('stats.total', 2)
            ->where('filters.category', 'PHP')
            ->where('flashcard.category', 'PHP')
        );
});

it('respects exclude param to avoid the same card twice', function (): void {
    $a = Flashcard::factory()->create();
    $b = Flashcard::factory()->create();

    $response = $this->get(route('learn.show', ['exclude' => $a->id]));

    $response->assertOk()->assertInertia(fn ($page) => $page
        ->where('flashcard.id', $b->id)
    );
});

it('falls back to full deck when exclude leaves nothing', function (): void {
    $only = Flashcard::factory()->create();

    $this->get(route('learn.show', ['exclude' => $only->id]))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('flashcard.id', $only->id)
        );
});

it('shows empty state when no cards exist', function (): void {
    $this->get(route('learn.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('flashcard', null)
            ->where('stats.total', 0)
        );
});
