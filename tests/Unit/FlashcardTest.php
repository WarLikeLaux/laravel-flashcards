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
        ->and($card->correct_modes)->toBe(['reveal', 'type_in', 'multiple_choice']);
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

it('clears correct_modes on a mistake', function (): void {
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
        ->and($card->is_learned)->toBeFalse();
});

it('resets progress fully', function (): void {
    $card = Flashcard::query()->create([
        'question' => 'Q',
        'answer' => 'A',
        'correct_streak' => 4,
        'correct_modes' => ['reveal', 'type_in', 'cloze'],
        'is_learned' => true,
    ]);

    $card->resetProgress();

    expect($card->correct_streak)->toBe(0)
        ->and($card->correct_modes)->toBe([])
        ->and($card->is_learned)->toBeFalse();
});

it('scopes due to non-learned cards', function (): void {
    Flashcard::factory()->create();
    Flashcard::factory()->learned()->create();

    expect(Flashcard::query()->due()->count())->toBe(1);
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
