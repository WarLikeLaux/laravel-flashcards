<?php

use App\Models\Flashcard;

it('renders a learned card on the review page', function (): void {
    $learned = Flashcard::factory()->learned()->create();
    Flashcard::factory()->create();

    $this->get(route('review.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('review/index')
            ->where('flashcard.id', $learned->id)
            ->where('stats.total', 1)
            ->where('stats.seen', 0)
            ->where('stats.remaining', 1)
        );
});

it('only shows learned cards', function (): void {
    Flashcard::factory()->count(3)->create();
    $learned = Flashcard::factory()->learned()->create();

    $this->get(route('review.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->where('flashcard.id', $learned->id));
});

it('marks a card as remembered and removes it from the queue', function (): void {
    $a = Flashcard::factory()->learned()->create();
    $b = Flashcard::factory()->learned()->create();

    $this->withSession([])->post(route('review.remember', $a))
        ->assertRedirect(route('review.show'));

    $this->get(route('review.show'))
        ->assertInertia(fn ($page) => $page
            ->where('flashcard.id', $b->id)
            ->where('stats.seen', 1)
            ->where('stats.remaining', 1)
        );
});

it('marks a card as forgotten and sends it back to study', function (): void {
    $a = Flashcard::factory()->learned()->create();

    $this->post(route('review.forgot', $a))
        ->assertRedirect(route('review.show'));

    $fresh = $a->fresh();
    expect($fresh->is_learned)->toBeFalse()
        ->and($fresh->correct_modes)->toBe([])
        ->and($fresh->srs_step)->toBe(0)
        ->and($fresh->next_review_at)->toBeNull();
});

it('respects exclude param for repeat', function (): void {
    $a = Flashcard::factory()->learned()->create();
    $b = Flashcard::factory()->learned()->create();

    $this->get(route('review.show', ['exclude' => $a->id]))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->where('flashcard.id', $b->id));
});

it('shows empty state once every learned card has been seen', function (): void {
    $a = Flashcard::factory()->learned()->create();

    $this->withSession(['review.seen' => [$a->id]])
        ->get(route('review.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('flashcard', null)
            ->where('stats.remaining', 0)
        );
});

it('resets the session via the reset endpoint', function (): void {
    $a = Flashcard::factory()->learned()->create();

    $this->withSession(['review.seen' => [$a->id]])
        ->post(route('review.reset'))
        ->assertRedirect(route('review.show'));

    $this->get(route('review.show'))
        ->assertInertia(fn ($page) => $page->where('stats.seen', 0));
});

it('shows empty state when there are no learned cards at all', function (): void {
    Flashcard::factory()->count(2)->create();

    $this->get(route('review.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('flashcard', null)
            ->where('stats.total', 0)
        );
});
