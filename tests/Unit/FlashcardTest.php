<?php

use App\Models\Flashcard;

it('marks a card learned after one correct answer by default', function (): void {
    $card = new Flashcard([
        'category' => 'PHP',
        'question' => 'Q',
        'answer' => 'A',
    ]);
    $card->save();

    $card->markCorrect();

    expect($card->is_learned)->toBeTrue()
        ->and($card->correct_streak)->toBe(1)
        ->and($card->required_correct)->toBe(1);
});

it('increases required_correct on every mistake', function (): void {
    $card = Flashcard::query()->create([
        'question' => 'Q',
        'answer' => 'A',
    ]);

    $card->markIncorrect();
    expect($card->correct_streak)->toBe(0)
        ->and($card->required_correct)->toBe(2)
        ->and($card->is_learned)->toBeFalse();

    $card->markIncorrect();
    expect($card->required_correct)->toBe(3);
});

it('requires consecutive correct answers after a mistake', function (): void {
    $card = Flashcard::query()->create([
        'question' => 'Q',
        'answer' => 'A',
    ]);

    $card->markIncorrect();
    expect($card->required_correct)->toBe(2);

    $card->markCorrect();
    expect($card->is_learned)->toBeFalse()
        ->and($card->correct_streak)->toBe(1);

    $card->markCorrect();
    expect($card->is_learned)->toBeTrue()
        ->and($card->correct_streak)->toBe(2);
});

it('resets streak on a mistake after partial progress', function (): void {
    $card = Flashcard::query()->create([
        'question' => 'Q',
        'answer' => 'A',
        'required_correct' => 3,
        'correct_streak' => 2,
    ]);

    $card->markIncorrect();

    expect($card->correct_streak)->toBe(0)
        ->and($card->required_correct)->toBe(4)
        ->and($card->is_learned)->toBeFalse();
});

it('resets progress fully', function (): void {
    $card = Flashcard::query()->create([
        'question' => 'Q',
        'answer' => 'A',
        'required_correct' => 5,
        'correct_streak' => 4,
        'is_learned' => true,
    ]);

    $card->resetProgress();

    expect($card->correct_streak)->toBe(0)
        ->and($card->required_correct)->toBe(1)
        ->and($card->is_learned)->toBeFalse();
});

it('scopes due to non-learned cards', function (): void {
    Flashcard::factory()->create();
    Flashcard::factory()->learned()->create();

    expect(Flashcard::query()->due()->count())->toBe(1);
});
