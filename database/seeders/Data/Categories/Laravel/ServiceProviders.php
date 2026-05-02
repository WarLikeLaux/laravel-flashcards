<?php

namespace Database\Seeders\Data\Categories\Laravel;

class ServiceProviders
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Что такое Service Provider и в чём разница между методами register и boot?',
                'answer' => 'Service Provider - это класс, в котором вы регистрируете сервисы в контейнере и настраиваете их. register() - только биндинги в контейнер, нельзя обращаться к другим сервисам. boot() - вызывается после регистрации всех провайдеров, здесь можно использовать другие сервисы (роуты, события, директивы Blade).',
                'code_example' => 'class AppServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->app->singleton(PaymentInterface::class, StripePayment::class);
    }

    public function boot(): void {
        Blade::directive(\'money\', fn($expr) => "<?= number_format($expr, 2) ?>");
    }
}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.service_providers',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое deferred providers (отложенные провайдеры)?',
                'answer' => 'Deferred provider - это провайдер, который загружается только когда реально нужен один из его сервисов. Простыми словами: если вы зарегистрировали тяжёлый сервис, но он используется редко, отложенный провайдер не будет загружаться при каждом запросе. Нужно реализовать DeferrableProvider и вернуть массив provides().',
                'code_example' => 'class HeavyServiceProvider extends ServiceProvider implements DeferrableProvider {
    public function register(): void {
        $this->app->singleton(HeavyService::class, fn() => new HeavyService());
    }

    public function provides(): array {
        return [HeavyService::class];
    }
}',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.service_providers',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работают deferred service providers и зачем они нужны?',
                'answer' => 'Deferred provider не загружается при бутстрапе; в кэшированном manifest указано, какие сервисы он предоставляет. Когда контейнер впервые резолвит один из этих сервисов, провайдер регистрируется и загружается лениво. Это сокращает cold-start: тяжёлые провайдеры (платёжные SDK, поисковые движки) не запускаются, если не нужны. Условия: реализовать DeferrableProvider, метод provides() возвращает список биндов.',
                'code_example' => '<?php
class StripeServiceProvider extends ServiceProvider implements DeferrableProvider {
    public function register(): void {
        $this->app->singleton(StripeClient::class, fn() => new StripeClient(config("services.stripe.key")));
    }
    public function provides(): array { return [StripeClient::class]; }
}',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.service_providers',
            ],
        ];
    }
}
