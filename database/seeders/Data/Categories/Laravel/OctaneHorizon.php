<?php

namespace Database\Seeders\Data\Categories\Laravel;

class OctaneHorizon
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Что такое Laravel Octane? Какие у него плюсы и подводные камни?',
                'answer' => 'Octane - это пакет для Laravel, который держит приложение в памяти между запросами вместо перезагрузки. Простыми словами: обычный PHP при каждом запросе заново загружает Laravel - это медленно. Octane загружает один раз и потом каждый запрос обрабатывается мгновенно. Серверы: Swoole, RoadRunner, FrankenPHP. Подводные камни: 1) Утечки памяти - переменные класса не сбрасываются. 2) Состояние singleton-ов сохраняется. 3) Глобальные/статические переменные опасны. 4) Нужно использовать scoped-биндинги вместо singleton там, где состояние per-request. 5) Закрытые соединения с БД могут "висеть".',
                'code_example' => 'composer require laravel/octane
php artisan octane:install
php artisan octane:start --workers=4 --task-workers=2

// scoped binding для per-request состояния
$this->app->scoped(RequestContext::class);',
                'code_language' => 'bash',
                'difficulty' => 5,
                'topic' => 'laravel.octane_horizon',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Laravel Horizon?',
                'answer' => 'Horizon - это пакет для управления Redis-очередями: красивый dashboard, балансировка воркеров (auto/simple), метрики, мониторинг failed jobs, теги задач. Простыми словами: GUI и автомасштабирование для php artisan queue:work на Redis.',
                'code_example' => 'composer require laravel/horizon
php artisan horizon:install
php artisan horizon

// config/horizon.php
\'environments\' => [
    \'production\' => [
        \'supervisor-1\' => [
            \'connection\' => \'redis\',
            \'queue\' => [\'default\', \'high\'],
            \'balance\' => \'auto\',
            \'maxProcesses\' => 10,
        ],
    ],
],',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.octane_horizon',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие подводные камни у Octane по сравнению с обычным FPM?',
                'answer' => 'Octane держит фреймворк в памяти между запросами. Singletons и статические свойства не сбрасываются - типичный источник утечек данных между пользователями. Запрещено хранить в Auth::user() в синглтонах, использовать array-кэши на жизнь приложения, изменять контейнер из контроллеров. Решение: scoped()-биндинги, RefreshDatabase-аналоги в OctaneServiceProvider::tick. Также Octane не любит долгие и блокирующие операции - нужна модель Tasks/Coroutines.',
                'code_example' => '<?php
// плохо в Octane
class CartHolder { public static array $items = []; }

// хорошо
$this->app->scoped(CartHolder::class, fn() => new CartHolder());',
                'code_language' => 'php',
                'difficulty' => 5,
                'topic' => 'laravel.octane_horizon',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работает Laravel Horizon и какие метрики он даёт?',
                'answer' => 'Horizon - дашборд и супервизор для Redis-очередей. Конфигурируется в config/horizon.php: массив supervisors с балансингом (auto/simple), maxProcesses, queues. Дашборд показывает throughput, runtime, failed jobs, worker memory. auto-balance перераспределяет процессы между очередями по нагрузке. horizon:terminate грейсфул-перезапускает воркеры при деплое.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'laravel.octane_horizon',
            ],
        ];
    }
}
