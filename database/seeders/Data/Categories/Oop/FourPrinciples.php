<?php

namespace Database\Seeders\Data\Categories\Oop;

class FourPrinciples
{
    public static function all(): array
    {
        return [
            [
                'category' => 'ООП',
                'topic' => 'oop.four_principles',
                'difficulty' => 2,
                'question' => 'Какие 4 основных принципа ООП?',
                'answer' => '4 столпа ООП: 1) Инкапсуляция - сокрытие внутреннего состояния и предоставление контролируемого доступа через методы. 2) Наследование - создание новых классов на основе существующих, переиспользуя их код. 3) Полиморфизм - возможность объектов разных классов реагировать на одинаковые вызовы по-разному. 4) Абстракция - выделение существенных характеристик объекта и сокрытие несущественных деталей.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.four_principles',
                'difficulty' => 2,
                'question' => 'Что такое инкапсуляция?',
                'answer' => 'Инкапсуляция - это объединение данных и методов работы с ними в одном классе плюс ограничение прямого доступа к внутреннему состоянию объекта. Внешний код не видит "внутренностей" и работает только через публичный интерфейс. Это защищает данные от некорректного использования и позволяет менять реализацию без поломки клиентов. В PHP реализуется через модификаторы public/protected/private.',
                'code_example' => '<?php
class BankAccount
{
    private float $balance = 0;

    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException(\'Сумма должна быть положительной\');
        }
        $this->balance += $amount;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }
}
// Напрямую $balance изменить нельзя - только через deposit()',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.four_principles',
                'difficulty' => 2,
                'question' => 'Что такое наследование?',
                'answer' => 'Наследование - механизм, позволяющий создать новый класс (потомок, дочерний) на основе существующего (родительского). Потомок получает все public/protected свойства и методы родителя и может добавлять свои или переопределять родительские. В PHP наследование одиночное (один класс может наследовать только один родительский класс), но можно реализовывать множество интерфейсов и подключать множество трейтов.',
                'code_example' => '<?php
class Animal
{
    public function eat(): string
    {
        return \'ест\';
    }
}

class Dog extends Animal
{
    public function bark(): string
    {
        return \'гав!\';
    }
}

$dog = new Dog();
echo $dog->eat();  // ест (унаследовано)
echo $dog->bark(); // гав!',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.four_principles',
                'difficulty' => 2,
                'question' => 'Что такое полиморфизм?',
                'answer' => 'Полиморфизм (от греч. "много форм") - возможность объектов разных классов обрабатываться единообразно через общий интерфейс. Простыми словами: один и тот же вызов метода может приводить к разному поведению в зависимости от конкретного класса объекта. В PHP реализуется через наследование и интерфейсы. Это даёт расширяемость: можно добавлять новые типы без изменения старого кода.',
                'code_example' => '<?php
interface Shape
{
    public function area(): float;
}

class Circle implements Shape
{
    public function __construct(private float $r) {}
    public function area(): float
    {
        return M_PI * $this->r ** 2;
    }
}

class Square implements Shape
{
    public function __construct(private float $side) {}
    public function area(): float
    {
        return $this->side ** 2;
    }
}

function printArea(Shape $s): void
{
    echo $s->area(); // вызов один, поведение разное
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.four_principles',
                'difficulty' => 2,
                'question' => 'Что такое абстракция?',
                'answer' => 'Абстракция - выделение в объекте только существенных для решаемой задачи свойств и поведения, игнорируя несущественные детали. Простыми словами: вы пользуетесь автомобилем через руль, педали и КПП, не зная, как устроен двигатель внутри. В коде абстракция реализуется через классы, абстрактные классы и интерфейсы, которые описывают "что делает объект", скрывая "как он это делает".',
                'code_example' => '<?php
// Абстракция: интерфейс описывает контракт без деталей
interface PaymentGateway
{
    public function pay(float $amount): bool;
}

// Конкретные реализации скрывают детали
class StripeGateway implements PaymentGateway
{
    public function pay(float $amount): bool
    {
        // вся сложная логика Stripe API скрыта
        return true;
    }
}',
                'code_language' => 'php',
            ],
        ];
    }
}
