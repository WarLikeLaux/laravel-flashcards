<?php

namespace Database\Seeders\Data\Categories\Laravel;

class Testing
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Чем отличаются PHPUnit и Pest в Laravel?',
                'answer' => 'PHPUnit - стандартный фреймворк тестирования для PHP, тесты пишутся как методы класса. Pest - надстройка над PHPUnit с более лаконичным синтаксисом (как Jest для JS): тесты как функции, expect-API. Под капотом всё равно PHPUnit. Можно использовать оба одновременно.',
                'code_example' => '// PHPUnit
class UserTest extends TestCase {
    public function test_user_can_register(): void {
        $response = $this->post(\'/register\', [...]);
        $response->assertOk();
    }
}

// Pest
test(\'user can register\', function () {
    $response = $this->post(\'/register\', [...]);
    expect($response->status())->toBe(200);
});',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'laravel.testing',
            ],
            [
                'category' => 'Laravel',
                'question' => 'В чём разница между RefreshDatabase и DatabaseTransactions?',
                'answer' => 'RefreshDatabase - перед запуском всего тест-сьюта мигрирует БД с нуля, каждый тест оборачивается в транзакцию и откатывается. DatabaseTransactions - не мигрирует, просто оборачивает каждый тест в транзакцию (требует чтобы БД была уже мигрирована). RefreshDatabase надёжнее - всегда чистая БД. DatabaseMigrations - запускает миграции для каждого теста (медленно).',
                'code_example' => 'use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase {
    use RefreshDatabase;

    public function test_create_user(): void {
        $user = User::factory()->create();
        $this->assertDatabaseHas(\'users\', [\'id\' => $user->id]);
    }
}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.testing',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое HTTP-тесты в Laravel?',
                'answer' => 'HTTP-тесты позволяют делать "фейковые" запросы к приложению без реального HTTP. Методы: get, post, put, delete, json, getJson, postJson. Помощники для assert: assertOk, assertStatus, assertRedirect, assertSee, assertJson, assertJsonStructure. Можно работать с auth: actingAs($user).',
                'code_example' => 'public function test_index_returns_users(): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->getJson(\'/api/users\');

    $response->assertOk()
        ->assertJsonStructure([\'data\' => [[\'id\', \'name\']]]);
}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.testing',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое fakes в Laravel-тестах?',
                'answer' => 'Fake - это подмена реального сервиса фейковым для тестов, чтобы проверить, что нужный код был вызван, без побочных эффектов. Fakes: Mail::fake(), Queue::fake(), Notification::fake(), Event::fake(), Bus::fake(), Storage::fake(), Http::fake().',
                'code_example' => 'public function test_email_sent(): void {
    Mail::fake();

    $this->post(\'/orders\', [...]);

    Mail::assertSent(OrderShipped::class, fn($m) => $m->hasTo(\'a@b.c\'));
}

public function test_job_dispatched(): void {
    Queue::fake();

    ProcessOrder::dispatch();

    Queue::assertPushed(ProcessOrder::class);
}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.testing',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как делать mocking в Laravel-тестах?',
                'answer' => 'Через фасады (Cache::shouldReceive), через Mockery (mock(), partialMock()), либо через подмену в контейнере ($this->instance(...)). Фасады удобно мокать сразу - они изначально проксируют через контейнер.',
                'code_example' => '// Mock фасада
Cache::shouldReceive(\'get\')->once()->with(\'key\')->andReturn(\'value\');

// Mock сервиса
$mock = $this->mock(PaymentService::class);
$mock->shouldReceive(\'charge\')->once()->andReturn(true);

// Подмена в контейнере
$this->instance(PaymentService::class, new FakePaymentService());',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.testing',
            ],
        ];
    }
}
