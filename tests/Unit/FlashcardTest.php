<?php

use App\Models\Flashcard;

it('marks a card learned after three distinct modes by default', function (): void {
    $card = Flashcard::query()->create([
        'category' => 'PHP',
        'question' => 'Q',
        'answer' => 'A',
    ]);

    $card->markCorrect('reveal');
    expect($card->is_learned)->toBeFalse()
        ->and($card->correct_modes)->toBe(['reveal']);

    $card->markCorrect('type_in');
    expect($card->is_learned)->toBeFalse();

    $card->markCorrect('multiple_choice');
    expect($card->is_learned)->toBeTrue()
        ->and($card->correct_streak)->toBe(3)
        ->and($card->correct_modes)->toBe(['reveal', 'type_in', 'multiple_choice'])
        ->and($card->srs_step)->toBe(0)
        ->and($card->next_review_at)->not->toBeNull();
});

it('does not double-count the same mode', function (): void {
    $card = Flashcard::query()->create([
        'question' => 'Q',
        'answer' => 'A',
    ]);

    $card->markCorrect('reveal');
    $card->markCorrect('reveal');
    $card->markCorrect('reveal');

    expect($card->is_learned)->toBeFalse()
        ->and($card->correct_modes)->toBe(['reveal'])
        ->and($card->correct_streak)->toBe(3);
});

it('clears correct_modes and srs state on a mistake', function (): void {
    $card = Flashcard::query()->create([
        'question' => 'Q',
        'answer' => 'A',
    ]);

    $card->markCorrect('reveal');
    $card->markCorrect('type_in');
    expect($card->correct_modes)->toBe(['reveal', 'type_in']);

    $card->markIncorrect();
    expect($card->correct_streak)->toBe(0)
        ->and($card->correct_modes)->toBe([])
        ->and($card->is_learned)->toBeFalse()
        ->and($card->srs_step)->toBe(0)
        ->and($card->next_review_at)->toBeNull();
});

it('resets progress fully', function (): void {
    $card = Flashcard::factory()->learned()->create([
        'question' => 'Q',
        'answer' => 'A',
    ]);

    $card->resetProgress();

    expect($card->correct_streak)->toBe(0)
        ->and($card->correct_modes)->toBe([])
        ->and($card->is_learned)->toBeFalse()
        ->and($card->studied)->toBeFalse()
        ->and($card->srs_step)->toBe(0)
        ->and($card->next_review_at)->toBeNull();
});

it('scopes due to non-learned, studied cards', function (): void {
    Flashcard::factory()->create();
    Flashcard::factory()->learned()->create();
    Flashcard::factory()->unstudied()->create();

    expect(Flashcard::query()->due()->count())->toBe(1);
});

it('marks a card as studied', function (): void {
    $card = Flashcard::factory()->unstudied()->create();

    expect($card->studied)->toBeFalse();

    $card->markStudied();

    expect($card->fresh()->studied)->toBeTrue();
});

it('honors a custom required_correct threshold', function (): void {
    $card = Flashcard::query()->create([
        'question' => 'Q',
        'answer' => 'A',
        'required_correct' => 2,
    ]);

    $card->markCorrect('reveal');
    expect($card->is_learned)->toBeFalse();

    $card->markCorrect('type_in');
    expect($card->is_learned)->toBeTrue();
});

it('schedules the first SRS review one day after learning', function (): void {
    $card = Flashcard::query()->create(['question' => 'Q', 'answer' => 'A']);

    $card->markCorrect('reveal');
    $card->markCorrect('type_in');
    $card->markCorrect('multiple_choice');

    expect($card->is_learned)->toBeTrue()
        ->and($card->srs_step)->toBe(0)
        ->and($card->next_review_at)->not->toBeNull()
        ->and(abs($card->next_review_at->diffInHours(now(), true)))->toBeGreaterThanOrEqual(23);
});

it('advances SRS interval on correct review of a learned card', function (): void {
    $card = Flashcard::factory()->dueForReview()->create();

    $card->markCorrect('reveal');
    expect($card->srs_step)->toBe(1)
        ->and(round(abs($card->next_review_at->diffInDays(now(), true))))->toBe(3.0);

    $card->markCorrect('reveal');
    expect($card->srs_step)->toBe(2)
        ->and(round(abs($card->next_review_at->diffInDays(now(), true))))->toBe(5.0);

    $card->markCorrect('reveal');
    expect($card->srs_step)->toBe(3)
        ->and(round(abs($card->next_review_at->diffInDays(now(), true))))->toBe(7.0);
});

it('graduates a card after the final SRS step', function (): void {
    $card = Flashcard::factory()->create([
        'is_learned' => true,
        'correct_modes' => ['reveal', 'type_in', 'multiple_choice'],
        'srs_step' => 3,
        'next_review_at' => now()->subDay(),
    ]);

    $card->markCorrect('reveal');

    expect($card->srs_step)->toBe(4)
        ->and($card->next_review_at)->toBeNull()
        ->and($card->is_learned)->toBeTrue();
});

it('resets a learned card to relearn on incorrect review', function (): void {
    $card = Flashcard::factory()->dueForReview()->create();

    $card->markIncorrect();

    expect($card->is_learned)->toBeFalse()
        ->and($card->correct_modes)->toBe([])
        ->and($card->srs_step)->toBe(0)
        ->and($card->next_review_at)->toBeNull();
});

it('scopeDue includes overdue SRS reviews', function (): void {
    $learning = Flashcard::factory()->create();
    $review = Flashcard::factory()->dueForReview()->create();
    Flashcard::factory()->learned()->create();
    Flashcard::factory()->graduated()->create();

    $due = Flashcard::query()->due()->pluck('id')->all();

    expect($due)->toContain($learning->id, $review->id)->toHaveCount(2);
});
