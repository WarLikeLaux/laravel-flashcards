<?php

namespace Database\Seeders\Data\Categories\Php;

class BasicSyntax
{
    public static function all(): array
    {
        return [
            [
                'category' => 'PHP',
                'question' => 'Что такое переменная в PHP и как её объявить?',
                'answer' => 'Переменная - это именованная ячейка в памяти, в которой хранится значение. В PHP переменные начинаются со знака доллара $, тип не указывается явно, он определяется по присвоенному значению. Имя чувствительно к регистру: $name и $Name - разные переменные. Имя должно начинаться с буквы или подчёркивания, дальше можно цифры.',
                'code_example' => '<?php
$name = "Иван";      // строка
$age = 30;            // целое число
$price = 19.99;       // float
$isAdmin = true;      // bool
$items = [];          // массив
$user = null;         // null

echo $name; // Иван',
                'code_language' => 'php',
                'difficulty' => 1,
                'topic' => 'php.basic_syntax',
            ],
            [
                'category' => 'PHP',
                'question' => 'Какие основные типы данных есть в PHP?',
                'answer' => 'В PHP есть скалярные типы: int (целые), float (дробные), string (строки), bool (true/false). Составные типы: array (массив), object (объект), callable (вызываемое). Специальные: null (отсутствие значения), resource (ресурс, например, файловый дескриптор). С PHP 8 добавили mixed (любой тип) и never (функция никогда не возвращает значение).',
                'code_example' => '<?php
var_dump(42);           // int(42)
var_dump(3.14);         // float(3.14)
var_dump("hello");      // string(5) "hello"
var_dump(true);         // bool(true)
var_dump([1, 2, 3]);    // array(3)
var_dump(null);         // NULL
var_dump(new stdClass); // object(stdClass)',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'php.basic_syntax',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое null в PHP?',
                'answer' => 'null - это специальное значение, обозначающее "ничего", отсутствие значения. Переменная имеет значение null, если ей явно присвоили null или к ней применили unset(). Обращение к необъявленной переменной в PHP 8+ выдаёт Warning, но вернёт null в выражении. Проверять на null нужно через is_null($x) или $x === null. Сравнение через == даст true для 0 / "" / [] - это часто баг, поэтому используй ===.',
                'code_example' => '<?php
$a = null;

var_dump($a === null);   // true
var_dump(is_null($a));   // true
var_dump($a == 0);       // true (опасно!)
var_dump($a === 0);      // false (правильная проверка)

// Необъявленная переменная: Warning + null
// var_dump($undefined); // Warning: Undefined variable

unset($a);
var_dump(isset($a));     // false',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'php.basic_syntax',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как создать массив в PHP?',
                'answer' => 'Массив создаётся через короткий синтаксис [] (с PHP 5.4) или через array(). PHP массивы - это ассоциативные массивы под капотом (упорядоченные карты). Они могут быть индексированными (ключи 0, 1, 2...) или ассоциативными (произвольные строковые ключи), либо смешанными.',
                'code_example' => '<?php
// Индексированный
$nums = [1, 2, 3];
echo $nums[0]; // 1

// Ассоциативный
$user = [
    "name" => "Иван",
    "age" => 30,
];
echo $user["name"]; // Иван

// Многомерный
$matrix = [
    [1, 2],
    [3, 4],
];
echo $matrix[1][0]; // 3',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'php.basic_syntax',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое функция и как её объявить в PHP?',
                'answer' => 'Функция - это блок кода с именем, который можно вызвать многократно. Объявляется через ключевое слово function. Может принимать аргументы и возвращать значение через return. С PHP 7+ можно указывать типы параметров и возвращаемого значения. Если return не указан, функция возвращает null.',
                'code_example' => '<?php
function greet(string $name): string {
    return "Привет, " . $name;
}

echo greet("Аня"); // Привет, Аня

// Значение по умолчанию
function pow(int $x, int $n = 2): int {
    return $x ** $n;
}

echo pow(3);    // 9
echo pow(2, 8); // 256',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'php.basic_syntax',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работает foreach в PHP?',
                'answer' => 'foreach - цикл для перебора массивов и объектов, реализующих Iterator/IteratorAggregate. Есть две формы: только значения, и ключ-значение. Внутри foreach создаётся копия массива (благодаря copy-on-write это дёшево). Если нужно изменять элементы исходного массива, используют & для передачи по ссылке - но после цикла обязательно делать unset() для переменной.',
                'code_example' => '<?php
$users = ["Иван", "Аня", "Петя"];

// Только значения
foreach ($users as $user) {
    echo $user . "\n";
}

// Ключ и значение
foreach ($users as $i => $user) {
    echo "$i: $user\n";
}

// По ссылке (для изменения)
foreach ($users as &$user) {
    $user = strtoupper($user);
}
unset($user); // ВАЖНО! иначе будут баги

print_r($users); // ["ИВАН", "АНЯ", "ПЕТЯ"]',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'php.basic_syntax',
            ],
            [
                'category' => 'PHP',
                'question' => 'Какие циклы есть в PHP кроме foreach?',
                'answer' => 'Помимо foreach есть: for - классический цикл с инициализацией, условием и шагом; while - выполняется пока условие истинно; do-while - сначала выполняет тело, потом проверяет условие (минимум один проход). Есть break (выйти из цикла), continue (перейти к следующей итерации), оба принимают число уровней: break 2 выходит из двух циклов сразу.',
                'code_example' => '<?php
// for
for ($i = 0; $i < 5; $i++) {
    echo $i;
}

// while
$i = 0;
while ($i < 5) {
    echo $i++;
}

// do-while
$i = 0;
do {
    echo $i++;
} while ($i < 5);

// break/continue с уровнем
for ($i = 0; $i < 3; $i++) {
    for ($j = 0; $j < 3; $j++) {
        if ($j == 2) break 2;
        echo "$i,$j ";
    }
}',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'php.basic_syntax',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем отличаются одинарные и двойные кавычки в PHP?',
                'answer' => 'Двойные кавычки интерполируют переменные и обрабатывают escape-последовательности (\n, \t, \\). Одинарные - буквальная строка, переменные не подставляются, обрабатываются только \\ и \\\'. Одинарные кавычки чуть быстрее, но разница незаметна. Для сложной интерполяции в "" используют фигурные скобки {$obj->prop}.',
                'code_example' => '<?php
$name = "Иван";

echo "Привет, $name\n";   // Привет, Иван (с переводом строки)
echo \'Привет, $name\\n\'; // Привет, $name\n (буквально)

// Сложная интерполяция
$user = ["name" => "Аня"];
echo "Имя: {$user[\'name\']}";  // Имя: Аня

// Heredoc - как двойные
$text = <<<EOT
Привет, $name
EOT;

// Nowdoc - как одинарные
$text = <<<\'EOT\'
Привет, $name
EOT;',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'php.basic_syntax',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое константы в PHP и как их объявлять?',
                'answer' => 'Константа - это значение, которое нельзя изменить после объявления. Объявляется через define() или ключевое слово const. const работает на этапе компиляции, define() - в рантайме. const можно использовать в классах, define нельзя. По соглашению имена констант пишут в UPPER_CASE. Доступ без знака доллара.',
                'code_example' => '<?php
// Глобальные константы
define("MAX_USERS", 100);
const APP_NAME = "MyApp";

echo MAX_USERS;  // 100
echo APP_NAME;   // MyApp

// Константы класса
class Config {
    const VERSION = "1.0";
    final const SECRET = "abc"; // PHP 8.1+
}

echo Config::VERSION;

// Константы-выражения (PHP 5.6+)
const HOUR = 60 * 60;',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'php.basic_syntax',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что выводит echo и чем отличается от print?',
                'answer' => 'echo - конструкция языка, выводит одну или несколько строк через запятую, ничего не возвращает, чуть быстрее. print - тоже конструкция, но принимает только один аргумент и возвращает 1 (поэтому работает в выражениях). На практике используют echo. Для отладки лучше var_dump() или print_r().',
                'code_example' => '<?php
echo "Hello", " ", "World"; // Hello World (несколько аргументов)
print "Hello"; // Hello (только один аргумент)

// print можно использовать как выражение
$result = print "test"; // $result = 1

// Для отладки
var_dump([1, 2, "three"]);
print_r(["a" => 1, "b" => 2]);',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'php.basic_syntax',
            ],
        ];
    }
}
