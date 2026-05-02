<?php

namespace Database\Seeders\Data\Categories\Laravel;

class ServiceContainer
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Что такое Service Container (IoC контейнер) в Laravel?',
                'answer' => 'Service Container - это механизм для управления зависимостями и инъекции зависимостей (DI). Простыми словами: контейнер - это "склад" объектов, который умеет сам создавать и подставлять нужные зависимости. Когда вы в конструкторе указываете тип параметра, Laravel автоматически найдёт и подставит нужный объект.',
                'code_example' => '// Bind
app()->bind(PaymentInterface::class, StripePayment::class);

// Resolve
$payment = app(PaymentInterface::class);

// Через DI в контроллере
public function __construct(PaymentInterface $payment) {
    $this->payment = $payment;
}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.service_container',
            ],
            [
                'category' => 'Laravel',
                'question' => 'В чём разница между bind, singleton, scoped и instance в Service Container?',
                'answer' => 'bind - каждый раз создаётся новый объект при resolve. singleton - объект создаётся один раз и переиспользуется в течение всего приложения. scoped - объект живёт в рамках одного запроса/job (важно для Octane). instance - регистрирует уже созданный объект как singleton.',
                'code_example' => '$this->app->bind(Foo::class, fn() => new Foo());
$this->app->singleton(Bar::class, fn() => new Bar());
$this->app->scoped(Baz::class, fn() => new Baz());
$this->app->instance(Qux::class, new Qux());',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.service_container',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое contextual binding в Service Container?',
                'answer' => 'Contextual binding - это привязка разных реализаций интерфейса для разных классов. Например, в одном контроллере нужен Stripe, в другом - PayPal, оба реализуют PaymentInterface.',
                'code_example' => '$this->app->when(OrderController::class)
    ->needs(PaymentInterface::class)
    ->give(StripePayment::class);

$this->app->when(SubscriptionController::class)
    ->needs(PaymentInterface::class)
    ->give(PayPalPayment::class);',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.service_container',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем bind отличается от singleton и от scoped в сервис-контейнере Laravel?',
                'answer' => 'bind() - каждый make() создаёт новый экземпляр. singleton() - один экземпляр на весь жизненный цикл приложения (т.е. на воркер). scoped() - один экземпляр в рамках запроса/job; Octane сбрасывает scoped-привязки между запросами, а singleton - нет, что важно для предотвращения утечки состояния. В FPM-режиме scoped и singleton ведут себя одинаково.',
                'code_example' => '<?php
$this->app->bind(Mailer::class, SmtpMailer::class);
$this->app->singleton(Cache::class, fn() => new RedisCache(...));
$this->app->scoped(RequestContext::class, fn() => new RequestContext());',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.service_container',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое contextual binding и приведите кейс из реального проекта.',
                'answer' => 'Contextual binding позволяет внедрять разные реализации интерфейса в зависимости от потребляющего класса. Пример: PhotoController должен использовать LocalFilesystem, а VideoController - S3, оба зависят от Filesystem. Без contextual binding пришлось бы вводить именованные интерфейсы или конкреты в типах. when()->needs()->give() решает это в одном месте.',
                'code_example' => '<?php
$this->app->when(PhotoController::class)
    ->needs(Filesystem::class)
    ->give(fn() => Storage::disk("local"));

$this->app->when(VideoController::class)
    ->needs(Filesystem::class)
    ->give(fn() => Storage::disk("s3"));',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.service_container',
            ],
        ];
    }
}
