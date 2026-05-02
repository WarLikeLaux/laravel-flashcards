<?php

namespace Database\Seeders\Data\Categories\Oop;

class BasicQa
{
    public static function all(): array
    {
        return [
            [
                'category' => 'ООП',
                'topic' => 'oop.basic_qa',
                'difficulty' => 1,
                'question' => 'Перечислите принципы SOLID.',
                'answer' => 'Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, Dependency Inversion.',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.basic_qa',
                'difficulty' => 1,
                'question' => 'Чем абстрактный класс отличается от интерфейса?',
                'answer' => 'Абстрактный класс может содержать реализацию и состояние, поддерживает единичное наследование. Интерфейс - только контракт без состояния, поддерживает множественную реализацию.',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.basic_qa',
                'difficulty' => 1,
                'question' => 'Чем композиция лучше наследования?',
                'answer' => 'Композиция гибче: поведение собирается из независимых объектов в рантайме, нет жёсткой иерархии, проще менять и тестировать. Принцип "favor composition over inheritance".',
            ],
        ];
    }
}
