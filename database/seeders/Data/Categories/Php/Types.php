<?php

namespace Database\Seeders\Data\Categories\Php;

class Types
{
    public static function all(): array
    {
        return [
            [
                'category' => 'PHP',
                'question' => 'Что такое nullable types и union types?',
                'answer' => 'Nullable type (?Type, PHP 7.1+) - значит может быть Type или null. Union type (Type1|Type2, PHP 8.0+) - может быть любым из перечисленных. Intersection (Type1&Type2, PHP 8.1+) - должен реализовать все. DNF (Disjunctive Normal Form, PHP 8.2+) - комбинация union и intersection с правильным порядком. mixed - любой тип. never - функция никогда не вернётся (выбросит/exit).',
                'code_example' => '<?php
// Nullable
function find(int $id): ?User {
    return $id > 0 ? new User() : null;
}

// Union (PHP 8)
function format(int|float|string $value): string {
    return (string) $value;
}

// Intersection (PHP 8.1)
function process(Countable&Iterator $items): void {
    echo count($items);
    foreach ($items as $item) {}
}

// DNF (PHP 8.2)
function handle((Countable&Iterator)|null $x): void {}

// never
function abort(string $msg): never {
    throw new RuntimeException($msg);
}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'php.types',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое readonly свойства и классы?',
                'answer' => 'readonly свойство (PHP 8.1+) можно записать только один раз - в конструкторе или при инициализации. После этого попытка изменить - Error. Идеально для immutable value objects. readonly класс (PHP 8.2+) - все свойства автоматически readonly. Ограничения: только типизированные свойства, нельзя статические, при клонировании можно создать "обновлённую" копию через withFn pattern с clone.',
                'code_example' => '<?php
class Point {
    public function __construct(
        public readonly float $x,
        public readonly float $y,
    ) {}

    // Immutable update через clone
    public function withX(float $x): self {
        $clone = clone $this;
        // В PHP 8.3 можно изменить readonly при клонировании!
        // (через __clone) - до этого нужен new self()
        return new self($x, $this->y);
    }
}

$p = new Point(1, 2);
// $p->x = 5; // Error: cannot modify readonly

// PHP 8.2 readonly class
readonly class Coordinates {
    public function __construct(
        public float $lat,
        public float $lng,
    ) {}
}',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'php.types',
            ],
        ];
    }
}
