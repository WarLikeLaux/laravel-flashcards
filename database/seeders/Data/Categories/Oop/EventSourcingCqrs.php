<?php

namespace Database\Seeders\Data\Categories\Oop;

class EventSourcingCqrs
{
    public static function all(): array
    {
        return [
            [
                'category' => 'ООП',
                'topic' => 'oop.event_sourcing_cqrs',
                'difficulty' => 5,
                'question' => 'Что такое Event Sourcing?',
                'answer' => 'Event Sourcing (событийное хранилище) - подход, при котором состояние системы хранится не как текущий снимок, а как последовательность событий, которые к нему привели. Простыми словами: вместо "баланс счёта = 100" мы храним "положили 50, положили 80, сняли 30". Текущее состояние получается воспроизведением событий. Плюсы: полный аудит, возможность отмотать историю, легко добавить новые проекции данных. Минусы: сложность, eventual consistency, миграции событий.',
                'code_example' => '<?php
abstract class Event { public \DateTimeImmutable $occurredAt; }
class MoneyDeposited extends Event {
    public function __construct(public readonly int $amount) {
        $this->occurredAt = new \DateTimeImmutable();
    }
}
class MoneyWithdrawn extends Event {
    public function __construct(public readonly int $amount) {
        $this->occurredAt = new \DateTimeImmutable();
    }
}

class Account
{
    private int $balance = 0;
    /** @var Event[] */
    private array $events = [];

    public function deposit(int $amount): void
    {
        $this->apply(new MoneyDeposited($amount));
    }

    public function withdraw(int $amount): void
    {
        if ($amount > $this->balance) {
            throw new \DomainException(\'Недостаточно средств\');
        }
        $this->apply(new MoneyWithdrawn($amount));
    }

    private function apply(Event $e): void
    {
        match (true) {
            $e instanceof MoneyDeposited => $this->balance += $e->amount,
            $e instanceof MoneyWithdrawn => $this->balance -= $e->amount,
            default => throw new \LogicException(\'Unknown event\'),
        };
        $this->events[] = $e;
    }

    // Восстановление состояния из истории (replay)
    public static function fromEvents(array $events): self
    {
        $account = new self();
        foreach ($events as $e) {
            $account->apply($e);
        }
        return $account;
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.event_sourcing_cqrs',
                'difficulty' => 4,
                'question' => 'Что такое CQRS?',
                'answer' => 'CQRS (Command Query Responsibility Segregation) - разделение операций записи (Command) и чтения (Query) на разные модели. Простыми словами: одни классы только пишут изменения, другие только читают данные. Зачем: запись и чтение часто имеют разные требования (запись требует валидации/транзакций, чтение - быстрых выборок и кешей). При CQRS можно оптимизировать каждую сторону независимо: денормализованные view-таблицы для чтения, нормализованная БД для записи. Часто комбинируется с Event Sourcing.',
                'code_example' => '<?php
// Command - изменяет состояние, не возвращает данных
final class CreateOrderCommand
{
    public function __construct(
        public string $userId,
        public array $items,
    ) {}
}

class CreateOrderHandler
{
    public function handle(CreateOrderCommand $cmd): void { /* пишем */ }
}

// Query - читает данные, не меняет состояние
final class GetUserOrdersQuery
{
    public function __construct(public string $userId) {}
}

class GetUserOrdersHandler
{
    public function handle(GetUserOrdersQuery $q): array { /* читаем */ return []; }
}',
                'code_language' => 'php',
            ],
        ];
    }
}
