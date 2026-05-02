<?php

use App\Models\Flashcard;
use App\Models\FlashcardEvent;

it('renders the stats page with zero stats', function (): void {
    $this->get(route('stats.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('stats/index')
            ->where('streak', 0)
            ->where('today.studied', 0)
            ->where('today.correct', 0)
            ->where('today.incorrect', 0)
            ->where('today.remembered', 0)
            ->where('today.forgot', 0)
            ->where('totals.total', 0)
            ->where('totals.due_now', 0)
            ->has('daily', 14)
            ->has('categories', 0)
            ->has('weak_topics', 0)
        );
});

it("counts today's events correctly", function (): void {
    $card = Flashcard::factory()->create();

    FlashcardEvent::create([
        'flashcard_id' => $card->id,
        'kind' => 'studied',
        'occurred_at' => now(),
    ]);
    FlashcardEvent::create([
        'flashcard_id' => $card->id,
        'kind' => 'study_correct',
        'mode' => 'reveal',
        'occurred_at' => now(),
    ]);
    FlashcardEvent::create([
        'flashcard_id' => $card->id,
        'kind' => 'study_correct',
        'mode' => 'true_false',
        'occurred_at' => now(),
    ]);
    FlashcardEvent::create([
        'flashcard_id' => $card->id,
        'kind' => 'study_incorrect',
        'mode' => 'cloze',
        'occurred_at' => now(),
    ]);
    FlashcardEvent::create([
        'flashcard_id' => $card->id,
        'kind' => 'matching_correct',
        'occurred_at' => now(),
    ]);
    FlashcardEvent::create([
        'flashcard_id' => $card->id,
        'kind' => 'review_remember',
        'occurred_at' => now(),
    ]);
    FlashcardEvent::create([
        'flashcard_id' => $card->id,
        'kind' => 'review_forgot',
        'occurred_at' => now(),
    ]);
    // Old event — must not be counted in today.
    FlashcardEvent::create([
        'flashcard_id' => $card->id,
        'kind' => 'studied',
        'occurred_at' => now()->subDays(5),
    ]);

    $this->get(route('stats.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('today.studied', 1)
            ->where('today.correct', 3)
            ->where('today.incorrect', 1)
            ->where('today.remembered', 1)
            ->where('today.forgot', 1)
        );
});

it('builds 14-day daily array even when most days are empty', function (): void {
    $card = Flashcard::factory()->create();

    FlashcardEvent::create([
        'flashcard_id' => $card->id,
        'kind' => 'studied',
        'occurred_at' => now(),
    ]);
    FlashcardEvent::create([
        'flashcard_id' => $card->id,
        'kind' => 'study_correct',
        'mode' => 'reveal',
        'occurred_at' => now()->subDays(3),
    ]);

    $this->get(route('stats.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('daily', 14)
            ->where('daily.13.date', now()->toDateString())
            ->where('daily.13.studied', 1)
            ->where('daily.10.date', now()->subDays(3)->toDateString())
            ->where('daily.10.correct', 1)
            ->where('daily.0.date', now()->subDays(13)->toDateString())
            ->where('daily.0.studied', 0)
            ->where('daily.0.correct', 0)
        );
});

it('counts streak as consecutive days from today backward', function (): void {
    $card = Flashcard::factory()->create();

    foreach ([0, 1, 2] as $offset) {
        FlashcardEvent::create([
            'flashcard_id' => $card->id,
            'kind' => 'studied',
            'occurred_at' => now()->subDays($offset),
        ]);
    }

    // gap on day 3, then activity on day 4
    FlashcardEvent::create([
        'flashcard_id' => $card->id,
        'kind' => 'studied',
        'occurred_at' => now()->subDays(4),
    ]);

    $this->get(route('stats.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->where('streak', 3));
});

it('streak counts from yesterday when today has no events', function (): void {
    $card = Flashcard::factory()->create();

    FlashcardEvent::create([
        'flashcard_id' => $card->id,
        'kind' => 'studied',
        'occurred_at' => now()->subDay(),
    ]);
    FlashcardEvent::create([
        'flashcard_id' => $card->id,
        'kind' => 'studied',
        'occurred_at' => now()->subDays(2),
    ]);

    $this->get(route('stats.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->where('streak', 2));
});

it('streak is zero when latest activity was 2+ days ago', function (): void {
    $card = Flashcard::factory()->create();

    FlashcardEvent::create([
        'flashcard_id' => $card->id,
        'kind' => 'studied',
        'occurred_at' => now()->subDays(3),
    ]);

    $this->get(route('stats.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->where('streak', 0));
});

it('ranks weak topics by error rate', function (): void {
    $easy = Flashcard::factory()->create(['topic' => 'php.arrays']);
    $hard = Flashcard::factory()->create(['topic' => 'php.regex']);
    $mid = Flashcard::factory()->create(['topic' => 'php.oop']);

    // Easy topic: 1 incorrect / 5 events = 20%
    FlashcardEvent::create(['flashcard_id' => $easy->id, 'kind' => 'study_correct', 'mode' => 'reveal', 'occurred_at' => now()]);
    FlashcardEvent::create(['flashcard_id' => $easy->id, 'kind' => 'study_correct', 'mode' => 'reveal', 'occurred_at' => now()]);
    FlashcardEvent::create(['flashcard_id' => $easy->id, 'kind' => 'study_correct', 'mode' => 'reveal', 'occurred_at' => now()]);
    FlashcardEvent::create(['flashcard_id' => $easy->id, 'kind' => 'study_correct', 'mode' => 'reveal', 'occurred_at' => now()]);
    FlashcardEvent::create(['flashcard_id' => $easy->id, 'kind' => 'study_incorrect', 'mode' => 'reveal', 'occurred_at' => now()]);

    // Hard topic: 3 incorrect / 4 events = 75%
    FlashcardEvent::create(['flashcard_id' => $hard->id, 'kind' => 'study_correct', 'mode' => 'reveal', 'occurred_at' => now()]);
    FlashcardEvent::create(['flashcard_id' => $hard->id, 'kind' => 'study_incorrect', 'mode' => 'reveal', 'occurred_at' => now()]);
    FlashcardEvent::create(['flashcard_id' => $hard->id, 'kind' => 'study_incorrect', 'mode' => 'reveal', 'occurred_at' => now()]);
    FlashcardEvent::create(['flashcard_id' => $hard->id, 'kind' => 'study_incorrect', 'mode' => 'reveal', 'occurred_at' => now()]);

    // Mid topic: 1 incorrect / 3 = 33%
    FlashcardEvent::create(['flashcard_id' => $mid->id, 'kind' => 'study_correct', 'mode' => 'reveal', 'occurred_at' => now()]);
    FlashcardEvent::create(['flashcard_id' => $mid->id, 'kind' => 'study_correct', 'mode' => 'reveal', 'occurred_at' => now()]);
    FlashcardEvent::create(['flashcard_id' => $mid->id, 'kind' => 'review_forgot', 'occurred_at' => now()]);

    // Below threshold: 1 event only — must be excluded.
    $rare = Flashcard::factory()->create(['topic' => 'php.cloze']);
    FlashcardEvent::create(['flashcard_id' => $rare->id, 'kind' => 'study_incorrect', 'mode' => 'reveal', 'occurred_at' => now()]);

    $this->get(route('stats.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->has('weak_topics', 3)
            ->where('weak_topics.0.topic', 'php.regex')
            ->where('weak_topics.0.error_rate', 0.75)
            ->where('weak_topics.1.topic', 'php.oop')
            ->where('weak_topics.2.topic', 'php.arrays')
        );
});

it('computes per-category accuracy over study events', function (): void {
    $php = Flashcard::factory()->create(['category' => 'PHP']);
    $sql = Flashcard::factory()->create(['category' => 'Database']);

    FlashcardEvent::create(['flashcard_id' => $php->id, 'kind' => 'study_correct', 'mode' => 'reveal', 'occurred_at' => now()]);
    FlashcardEvent::create(['flashcard_id' => $php->id, 'kind' => 'study_correct', 'mode' => 'reveal', 'occurred_at' => now()]);
    FlashcardEvent::create(['flashcard_id' => $php->id, 'kind' => 'study_incorrect', 'mode' => 'reveal', 'occurred_at' => now()]);

    // matching events should NOT influence category accuracy
    FlashcardEvent::create(['flashcard_id' => $sql->id, 'kind' => 'matching_correct', 'occurred_at' => now()]);

    $this->get(route('stats.show'))
        ->assertOk()
        ->assertInertia(function ($page) {
            $page->has('categories', 2);
            $page->where('categories.0.name', 'Database');
            $page->where('categories.0.accuracy', null);
            $page->where('categories.1.name', 'PHP');
            $page->where('categories.1.accuracy', round(2 / 3, 4));

            return $page;
        });
});
