<?php

namespace Database\Seeders\Data\Categories\Oop;

class CompositionVsInheritance
{
    public static function all(): array
    {
        return [
            [
                'category' => 'ООП',
                'topic' => 'oop.composition_vs_inheritance',
                'difficulty' => 3,
                'question' => 'Композиция vs наследование - что выбрать?',
                'answer' => 'Композиция - объект содержит другие объекты как поля и делегирует им работу. Наследование - класс получает функциональность от родителя через extends. Принцип "Composition over Inheritance" говорит: предпочитайте композицию. Наследование жёстко связывает классы, нарушает инкапсуляцию (потомок зависит от деталей родителя), не подходит для отношений "имеет" (has-a). Используйте наследование для "является" (is-a) и при настоящей иерархии типов.',
                'code_example' => '<?php
// Плохо: наследование там, где нужно владение
class CarBad extends Engine {}

// Хорошо: композиция
class Car
{
    public function __construct(private Engine $engine) {}

    public function start(): void
    {
        $this->engine->run();
    }
}

class Engine
{
    public function run(): void {}
}',
                'code_language' => 'php',
            ],
        ];
    }
}
