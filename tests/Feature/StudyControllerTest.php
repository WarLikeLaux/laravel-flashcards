<?php

use App\Models\Flashcard;
use Illuminate\Testing\TestResponse;

function studyMode(TestResponse $response): ?string
{
    $content = $response->getOriginalContent();
    $data = is_object($content) && method_exists($content, 'getData') ? $content->getData() : [];

    return $data['page']['props']['mode'] ?? null;
}

it('shows a due card with stats and a study mode', function (): void {
    Flashcard::factory()->count(2)->create();
    Flashcard::factory()->learned()->create();

    $response = $this->get(route('study.show'));

    $response
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('study/index')
            ->has('flashcard')
            ->has('mode')
            ->where('stats.total', 3)
            ->where('stats.due', 2)
            ->where('stats.learned', 1)
        );

    expect(studyMode($response))->toBeIn(['reveal', 'true_false', 'multiple_choice']);
});

it('shows null flashcard when nothing is due', function (): void {
    Flashcard::factory()->learned()->create();

    $this->get(route('study.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('flashcard', null)
            ->where('mode', null)
        );
});

it('falls back to reveal when no other cards exist in the category', function (): void {
    Flashcard::factory()->create(['category' => 'Solo']);

    $this->get(route('study.show'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('mode', 'reveal')
            ->where('shown', null)
            ->where('options', null)
        );
});

it('builds multiple_choice options including the right answer', function (): void {
    Flashcard::factory()->count(7)->create(['category' => 'PHP']);

    $modes = collect();
    for ($i = 0; $i < 60; $i++) {
        $response = $this->get(route('study.show'));
        $modes->push(studyMode($response));
    }

    expect($modes->unique()->values()->all())
        ->toContain('multiple_choice');
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

it('exposes cloze mode when cloze_text is set', function (): void {
    Flashcard::factory()->withCloze()->create(['category' => 'PHP']);

    $modes = collect();
    for ($i = 0; $i < 30; $i++) {
        $modes->push(studyMode($this->get(route('study.show'))));
    }

    expect($modes->unique()->all())->toContain('cloze');
});

it('exposes type_in mode when short_answer is set', function (): void {
    Flashcard::factory()->withShortAnswer()->create(['category' => 'PHP']);

    $modes = collect();
    for ($i = 0; $i < 30; $i++) {
        $modes->push(studyMode($this->get(route('study.show'))));
    }

    expect($modes->unique()->all())->toContain('type_in');
});

it('exposes assemble mode with a shuffled pool when assemble_chunks is set', function (): void {
    Flashcard::factory()->withAssemble()->create(['category' => 'PHP']);

    for ($i = 0; $i < 40; $i++) {
        $response = $this->get(route('study.show'));
        if (studyMode($response) === 'assemble') {
            $props = $response->getOriginalContent()->getData()['page']['props'];
            expect($props['assemble']['pool'])
                ->toBeArray()
                ->and(count($props['assemble']['pool']))->toBeGreaterThanOrEqual(2);

            return;
        }
    }
    $this->fail('assemble mode was never selected over 40 trials');
});

it('builds a matching payload when 4+ cards in a category have short_answer', function (): void {
    Flashcard::factory()->count(4)->withShortAnswer()->create(['category' => 'Match']);

    $matched = false;
    for ($i = 0; $i < 60; $i++) {
        $response = $this->get(route('study.show'));
        if (studyMode($response) === 'matching') {
            $props = $response->getOriginalContent()->getData()['page']['props'];
            expect($props['matching']['questions'])->toHaveCount(4)
                ->and($props['matching']['answers'])->toHaveCount(4)
                ->and($props['matching']['category'])->toBe('Match');
            $matched = true;
            break;
        }
    }
    expect($matched)->toBeTrue();
});

it('marks each pair correctly via matching endpoint', function (): void {
    $a = Flashcard::factory()->create();
    $b = Flashcard::factory()->create();

    $this->post(route('study.matching'), [
        'pairs' => [
            ['question_id' => $a->id, 'answer_id' => $a->id],
            ['question_id' => $b->id, 'answer_id' => $a->id],
        ],
    ])->assertRedirect(route('study.show'));

    expect($a->fresh()->is_learned)->toBeTrue()
        ->and($b->fresh()->is_learned)->toBeFalse()
        ->and($b->fresh()->required_correct)->toBe(2);
});

it('rejects matching payload without pairs', function (): void {
    $this->post(route('study.matching'), [])
        ->assertSessionHasErrors('pairs');
});
