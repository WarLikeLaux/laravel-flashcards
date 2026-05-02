<?php

namespace Database\Seeders\Data\Categories\Oop;

class AnemicVsRich
{
    public static function all(): array
    {
        return [
            [
                'category' => 'ООП',
                'topic' => 'oop.anemic_vs_rich',
                'difficulty' => 4,
                'question' => 'Anemic vs Rich domain model - в чём разница?',
                'answer' => 'Anemic Model (анемичная) - объекты домена это просто сумки данных (геттеры/сеттеры), а вся логика в сервисах. Это близко к процедурному стилю и считается анти-паттерном в DDD. Rich Model (богатая) - объекты содержат и данные, и поведение, инкапсулируют бизнес-правила. Пример: вместо $orderService->cancel($order) - сам $order->cancel(), который проверит правила. Rich-модель ближе к ООП, защищает инварианты, более понятна.',
                'code_example' => '<?php
// Anemic - объект-сумка, логика снаружи
class OrderAnemic
{
    public string $status;
    public \DateTime $createdAt;
}
class OrderService
{
    public function cancel(OrderAnemic $o): void
    {
        if ($o->status === \'shipped\') throw new \Exception();
        $o->status = \'cancelled\';
    }
}

// Rich - логика внутри объекта
class Order
{
    private string $status = \'new\';
    public function cancel(): void
    {
        if ($this->status === \'shipped\') {
            throw new \DomainException(\'Нельзя отменить отгруженный\');
        }
        $this->status = \'cancelled\';
    }
}',
                'code_language' => 'php',
            ],
        ];
    }
}
