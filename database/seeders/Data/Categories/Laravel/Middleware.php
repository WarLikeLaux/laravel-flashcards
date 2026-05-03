<?php

namespace Database\Seeders\Data\Categories\Laravel;

class Middleware
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Что такое Middleware и для чего оно нужно?',
                'answer' => 'Middleware - это слой между запросом и контроллером, который может перехватывать, модифицировать или отклонять запросы. Простыми словами: это "фильтр" для HTTP-запросов. Используется для аутентификации, логирования, CORS, throttle, проверки прав и т.д.',
                'code_example' => 'class CheckAge {
    public function handle(Request $request, Closure $next) {
        if ($request->age < 18) {
            return redirect(\'/home\');
        }
        return $next($request);
    }
}',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'laravel.middleware',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие типы middleware бывают в Laravel?',
                'answer' => 'Глобальные middleware - выполняются для всех запросов. Group middleware - применяются к группе роутов (web, api). Route middleware - назначаются вручную на конкретные роуты через alias. Terminate-middleware - выполняется после отправки ответа клиенту (метод terminate). В Laravel 10 и ниже регистрация шла через app/Http/Kernel.php, в Laravel 11+ всё это переехало в bootstrap/app.php (метод withMiddleware).',
                'code_example' => '// Laravel 11+ bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->append(EnsureUserIsActive::class);          // глобально
    $middleware->web(append: [TrackVisits::class]);          // в группу web
    $middleware->alias([\'subscribed\' => Subscribed::class]); // alias для роутов
})

Route::middleware([\'auth\', \'verified\', \'subscribed\'])->group(function () {
    Route::get(\'/dashboard\', [DashboardController::class, \'index\']);
});',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'laravel.middleware',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое terminate middleware?',
                'answer' => 'Terminate middleware - это middleware, у которого есть метод terminate(), вызываемый ПОСЛЕ отправки ответа пользователю. Используется для тяжёлых задач, которые не должны блокировать ответ: логирование, очистка ресурсов, аналитика. Работает только с FastCGI и не работает на встроенном PHP-сервере.',
                'code_example' => 'class LogRequestMiddleware {
    public function handle($request, Closure $next) {
        return $next($request);
    }

    public function terminate($request, $response): void {
        Log::info(\'Request finished\', [\'url\' => $request->url()]);
    }
}',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.middleware',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как реализовать rate limiting в Laravel?',
                'answer' => 'Через middleware throttle. Можно по умолчанию (60 запросов в минуту), кастомный лимит, по группам. Сложные правила задаются через RateLimiter::for() в RouteServiceProvider/AppServiceProvider.',
                'code_example' => 'Route::middleware(\'throttle:60,1\')->group(...);

// Кастомный
RateLimiter::for(\'api\', function (Request $request) {
    return $request->user()
        ? Limit::perMinute(120)->by($request->user()->id)
        : Limit::perMinute(30)->by($request->ip());
});

Route::middleware(\'throttle:api\')->group(...);',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.middleware',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работает rate limiting в Laravel и в чём разница между Redis и database драйвером?',
                'answer' => 'RateLimiter использует cache-store: Redis даёт атомарные INCR/EXPIRE, что критично при гонках; database-драйвер делает SELECT/UPDATE и подвержен race-conditions при высоких RPS. Для распределённой системы и точного counting нужен Redis с sliding-window или token-bucket. RateLimiter::for() в RouteServiceProvider определяет лимиты, throttle:apiName применяет.',
                'code_example' => '<?php
RateLimiter::for("api", fn (Request $r) =>
    $r->user() ? Limit::perMinute(60)->by($r->user()->id)
               : Limit::perMinute(10)->by($r->ip())
);
// routes/api.php
Route::middleware("throttle:api")->group(...);',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.middleware',
            ],
        ];
    }
}
