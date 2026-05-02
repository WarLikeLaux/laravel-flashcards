<?php

namespace Database\Seeders\Data\Categories\Php;

class Exceptions
{
    public static function all(): array
    {
        return [
            [
                'category' => 'PHP',
                'question' => 'Как работают исключения в PHP?',
                'answer' => 'Исключение - объект, выбрасываемый через throw. Перехватывается через try/catch. finally выполняется всегда (даже при return/throw). Иерархия: Throwable - корень, его наследуют Exception (можно ловить) и Error (внутренние ошибки PHP). Можно ловить несколько типов через | (PHP 8). С PHP 8 throw - выражение, можно использовать в ?: и ??.',
                'code_example' => '<?php
try {
    if ($x < 0) {
        throw new InvalidArgumentException("отрицательное");
    }
} catch (InvalidArgumentException | TypeError $e) {
    // multi-catch (PHP 8)
    echo $e->getMessage();
} catch (Exception $e) {
    echo "Общая ошибка: " . $e->getMessage();
} finally {
    echo "Выполнится всегда";
}

// Кастомное исключение
class NotFoundException extends Exception {}

// throw как выражение (PHP 8)
$user = $repo->find($id) ?? throw new NotFoundException();

// Цепочка исключений
try {
    /* ... */
} catch (PDOException $e) {
    throw new DatabaseException("DB error", 0, $e); // 3й - предыдущее
}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'php.exceptions',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем Exception отличается от Error?',
                'answer' => 'И Exception, и Error реализуют интерфейс Throwable. Exception - для условий, которые программа может ожидать и обработать (валидация, бизнес-логика). Error - для серьёзных проблем рантайма: TypeError, ValueError (PHP 8), DivisionByZeroError, OutOfMemoryError, ParseError. Их тоже можно ловить, но обычно не стоит. catch (Throwable) поймает оба.',
                'code_example' => '<?php
try {
    intdiv(10, 0);  // DivisionByZeroError (наследник Error)
} catch (DivisionByZeroError $e) {
    echo "ошибка деления";
}

try {
    $x = "abc";
    $x();  // вызов несуществующей функции - Error
} catch (Error $e) {
    echo "Error: " . $e->getMessage();
}

// Поймать всё
try {
    riskyOperation();
} catch (Throwable $t) {
    logError($t);
    throw $t;
}

// PHP 8: TypeError при несовпадении типа
function add(int $a, int $b): int {
    return $a + $b;
}
add("abc", 5); // TypeError',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'php.exceptions',
            ],
        ];
    }
}
