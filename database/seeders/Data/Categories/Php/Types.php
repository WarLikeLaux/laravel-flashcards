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
                'answer' => 'readonly свойство (PHP 8.1+) можно записать ровно один раз из области видимости класса (обычно в конструкторе, но не строго только там). После первой записи попытка изменить - Error. Идеально для immutable value objects. readonly класс (PHP 8.2+) - все нестатические свойства автоматически readonly. Ограничения: только типизированные свойства, нельзя статические. До PHP 8.3 для "обновлённой" копии нужен был wither-метод, возвращающий new self(...) (clone не помогал, потому что присваивание новому свойству копии было запрещено). С PHP 8.3 readonly можно переинициализировать ВНУТРИ __clone() - появилось clone with: clone $obj и присвоение через __clone обновляет копию, оставляя оригинал нетронутым.',
                'code_example' => '<?php
class Point {
    public function __construct(
        public readonly float $x,
        public readonly float $y,
    ) {}

    // ✅ Wither-метод - работает на любой версии 8.1+
    public function withX(float $x): self {
        return new self($x, $this->y);
    }
}

$p = new Point(1, 2);
// $p->x = 5; // Error: cannot modify readonly

// ✅ PHP 8.3 - можно переинициализировать readonly в __clone
class Point83 {
    public function __construct(
        public readonly float $x,
        public readonly float $y,
    ) {}

    public function withX(float $x): self {
        $clone = clone $this;
        $clone->x = $x; // OK в __clone-сегменте, разрешено с 8.3
        return $clone;
    }
}

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
