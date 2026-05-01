<?php

use App\Models\Flashcard;

it('shows a due card with stats', function (): void {
    Flashcard::factory()->count(2)->create();
    Flashcard::factory()->learned()->create();

    $this->get(route('study.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('study/index')
            ->has('flashcard')
            ->where('stats.total', 3)
            ->where('stats.due', 2)
            ->where('stats.learned', 1)
        );
});

it('shows null flashcard when nothing is due', function (): void {
    Flashcard::factory()->learned()->create();

    $this->get(route('study.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->where('flashcard', null));
});

it('marks a card correct via the answer endpoint', function (): void {
    $card = Flashcard::factory()->create();

    $this->post(route('study.answer', $card), ['result' => 'correct'])
        ->assertRedirect(route('study.show'));

    expect($card->fresh()->is_learned)->toBeTrue();
});

it('marks a card incorrect and bumps required_correct', function (): void {
    $card = Flashcard::factory()->create();

    $this->post(route('study.answer', $card), ['result' => 'incorrect'])
        ->assertRedirect(route('study.show'));

    $fresh = $card->fresh();
    expect($fresh->is_learned)->toBeFalse()
        ->and($fresh->required_correct)->toBe(2);
});

it('rejects an unknown result value', function (): void {
    $card = Flashcard::factory()->create();

    $this->post(route('study.answer', $card), ['result' => 'maybe'])
        ->assertSessionHasErrors('result');
});
