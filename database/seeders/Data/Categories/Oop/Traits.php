<?php

namespace Database\Seeders\Data\Categories\Oop;

class Traits
{
    public static function all(): array
    {
        return [
            [
                'category' => 'ООП',
                'topic' => 'oop.traits',
                'difficulty' => 2,
                'question' => 'Что такое трейты в PHP?',
                'answer' => 'Трейт - механизм горизонтального переиспользования кода в PHP. Это набор методов и свойств, которые можно "подключить" в класс через use. По сути - копирование кода в класс на этапе компиляции. Решает проблему отсутствия множественного наследования: класс может использовать множество трейтов. Минусы: скрытое поведение, конфликты имён, повышенная связность. Хорошее применение - небольшие переиспользуемые куски (например, HasTimestamps, Macroable).',
                'code_example' => '<?php
trait HasTimestamps
{
    public ?\DateTime $createdAt = null;
    public ?\DateTime $updatedAt = null;

    public function touch(): void
    {
        $this->updatedAt = new \DateTime();
    }
}

class Article
{
    use HasTimestamps;

    public string $title;
}

$a = new Article();
$a->touch();',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.traits',
                'difficulty' => 4,
                'question' => 'Как разрешить конфликты имён при использовании нескольких трейтов?',
                'answer' => 'Если два трейта содержат метод с одинаковым именем, при их одновременном использовании возникнет ошибка. Решение - инструкции insteadof (выбрать какой использовать) и as (создать алиас). Также as позволяет изменить видимость метода. Это сложный механизм, и обычно проще не допускать таких конфликтов.',
                'code_example' => '<?php
trait A {
    public function hello(): string { return \'A\'; }
}
trait B {
    public function hello(): string { return \'B\'; }
}

class C
{
    use A, B {
        A::hello insteadof B; // используем версию из A
        B::hello as helloFromB; // алиас для B
    }
}',
                'code_language' => 'php',
            ],
        ];
    }
}
