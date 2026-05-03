<?php

use App\Models\Flashcard;
use App\Models\FlashcardEvent;

function logEvent(Flashcard $card, string $kind, ?string $when = null): void
{
    FlashcardEvent::create([
        'flashcard_id' => $card->id,
        'kind' => $kind,
        'occurred_at' => $when ?? now(),
    ]);
}

it('renders empty state when there are no events', function (): void {
    Flashcard::factory()->count(3)->create();

    $this->get(route('troubled.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('troubled/index')
            ->where('rows', [])
        );
});

it('lists cards with high error rate', function (): void {
    $bad = Flashcard::factory()->create(['question' => 'Bad']);
    $good = Flashcard::factory()->create(['question' => 'Good']);

    foreach (range(1, 4) as $_) {
        logEvent($bad, 'study_incorrect');
    }
    logEvent($bad, 'study_correct');

    foreach (range(1, 5) as $_) {
        logEvent($good, 'study_correct');
    }

    $this->get(route('troubled.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('rows', 1)
            ->where('rows.0.flashcard.id', $bad->id)
            ->where('rows.0.metrics.bad', 4)
            ->where('rows.0.metrics.total', 5)
            ->where('rows.0.metrics.error_rate', 0.8)
        );
});

it('counts skipped events as bad', function (): void {
    $card = Flashcard::factory()->create();

    logEvent($card, 'skipped');
    logEvent($card, 'skipped');
    logEvent($card, 'study_correct');

    $this->get(route('troubled.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('rows', 1)
            ->where('rows.0.metrics.skipped', 2)
            ->where('rows.0.metrics.bad', 2)
        );
});

it('ignores cards with fewer than 3 events', function (): void {
    $card = Flashcard::factory()->create();

    logEvent($card, 'study_incorrect');
    logEvent($card, 'study_incorrect');

    $this->get(route('troubled.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->where('rows', []));
});

it('only considers events from the last 30 days', function (): void {
    $card = Flashcard::factory()->create();

    logEvent($card, 'study_incorrect', now()->subDays(40));
    logEvent($card, 'study_incorrect', now()->subDays(35));
    logEvent($card, 'study_incorrect', now()->subDays(31));

    $this->get(route('troubled.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->where('rows', []));
});

it('orders cards by error rate descending', function (): void {
    $worse = Flashcard::factory()->create(['question' => '90%']);
    $better = Flashcard::factory()->create(['question' => '50%']);

    foreach (range(1, 9) as $_) {
        logEvent($worse, 'study_incorrect');
    }
    logEvent($worse, 'study_correct');

    foreach (range(1, 2) as $_) {
        logEvent($better, 'study_incorrect');
    }
    foreach (range(1, 2) as $_) {
        logEvent($better, 'study_correct');
    }

    $this->get(route('troubled.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('rows.0.flashcard.id', $worse->id)
            ->where('rows.1.flashcard.id', $better->id)
        );
});

it('logs a skipped event when learn skip is hit', function (): void {
    $card = Flashcard::factory()->unstudied()->create();

    $this->post(route('learn.skip', $card))->assertRedirect();

    $event = FlashcardEvent::query()->latest('id')->first();
    expect($event?->kind)->toBe('skipped')
        ->and($event?->flashcard_id)->toBe($card->id);
});

it('logs a skipped event when study skip is hit', function (): void {
    $card = Flashcard::factory()->create();

    $this->post(route('study.skip', $card))->assertRedirect();

    $event = FlashcardEvent::query()->latest('id')->first();
    expect($event?->kind)->toBe('skipped')
        ->and($event?->flashcard_id)->toBe($card->id);
});

it('logs a skipped event when review skip is hit', function (): void {
    $card = Flashcard::factory()->learned()->create();

    $this->post(route('review.skip', $card))->assertRedirect();

    $event = FlashcardEvent::query()->latest('id')->first();
    expect($event?->kind)->toBe('skipped')
        ->and($event?->flashcard_id)->toBe($card->id);
});
