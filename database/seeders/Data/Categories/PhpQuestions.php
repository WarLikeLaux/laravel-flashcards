<?php

namespace Database\Seeders\Data\Categories;

class PhpQuestions
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example: ?string, code_language: ?string}>
     */
    public static function all(): array
    {
        return [
            // === БАЗОВЫЙ СИНТАКСИС ===
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
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое null в PHP?',
                'answer' => 'null - это специальное значение, обозначающее "ничего", отсутствие значения. Переменная становится null, если ей явно присвоить null, она не была инициализирована, или к ней применили unset(). Проверять на null нужно через is_null($x) или $x === null. Сравнение через == даст true для 0, "" и других "пустых" значений - это часто баг.',
                'code_example' => '<?php
$a = null;
$b;            // не инициализирована, тоже null

var_dump($a === null);   // true
var_dump(is_null($a));   // true
var_dump($a == 0);       // true (опасно!)
var_dump($a === 0);      // false (правильная проверка)

unset($a);
var_dump(isset($a));     // false',
                'code_language' => 'php',
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
            ],

            // === ОПЕРАТОРЫ И ПРИВЕДЕНИЕ ===
            [
                'category' => 'PHP',
                'question' => 'Как привести строку к числу в PHP?',
                'answer' => 'Способов несколько: явное приведение через (int) или (float), функции intval()/floatval(), умножение на 1, или функции преобразования. PHP сам приводит строку к числу при арифметических операциях. Если строка не начинается с числа - получим 0. С PHP 8 нечисловые строки в арифметике дают TypeError или Warning.',
                'code_example' => '<?php
$str = "42abc";

$n1 = (int) $str;        // 42
$n2 = intval($str);      // 42
$n3 = $str * 1;          // 42 (с warning в PHP 8)
$n4 = (int) "abc";       // 0
$n5 = (float) "3.14e2";  // 314.0

// Безопасный парсинг
if (ctype_digit($str)) {
    $num = (int) $str;
}

// filter_var для строгой валидации
$num = filter_var("42", FILTER_VALIDATE_INT); // 42 или false',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Какие операторы сравнения есть в PHP и в чём подвох?',
                'answer' => 'Основные: == (равно с приведением типов), === (строго равно, без приведения), != или <> (не равно), !== (строго не равно), <, >, <=, >=. Оператор <=> (spaceship, PHP 7+) возвращает -1, 0 или 1 - удобен для сортировки. Подвох == в том, что "0" == false, "abc" == 0 (до PHP 8), null == 0. Всегда предпочитай ===.',
                'code_example' => '<?php
var_dump(0 == "abc");   // false (PHP 8+), true до PHP 8
var_dump(0 == "");      // false (PHP 8+), true до PHP 8
var_dump("1" == "01");  // true (оба - 1)
var_dump("10" == "1e1"); // true
var_dump(100 == "1e2");  // true
var_dump(0 === "0");     // false (разные типы)

// Spaceship для сортировки
usort($arr, fn($a, $b) => $a <=> $b);

// Null coalescing
$name = $user["name"] ?? "Guest";',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое оператор ?? и чем отличается от ?: ?',
                'answer' => '?? - null coalescing (PHP 7+), возвращает левый операнд если он не null и определён, иначе правый. ?: - ternary shortcut, возвращает левый если он truthy, иначе правый. Разница: ?? проверяет именно на null/undefined, ?: - на любое falsy значение (0, "", false, []). С PHP 7.4 есть ??= - присваивание с null coalescing.',
                'code_example' => '<?php
$a = null;
$b = "";
$c = 0;

echo $a ?? "default";  // "default"
echo $b ?? "default";  // "" (b не null)
echo $c ?? "default";  // 0  (c не null)

echo $a ?: "default";  // "default"
echo $b ?: "default";  // "default" ("" - falsy)
echo $c ?: "default";  // "default" (0  - falsy)

// ??= оператор
$config["timeout"] ??= 30; // если не задано, поставить 30',
                'code_language' => 'php',
            ],

            // === МАССИВЫ - ФУНКЦИИ ===
            [
                'category' => 'PHP',
                'question' => 'Как работает array_map?',
                'answer' => 'array_map применяет callback к каждому элементу массива и возвращает новый массив с результатами. Не меняет исходный. Может работать с несколькими массивами одновременно - тогда callback получает по элементу из каждого. Ключи сохраняются для одного массива и сбрасываются для нескольких.',
                'code_example' => '<?php
$nums = [1, 2, 3, 4];
$squares = array_map(fn($x) => $x ** 2, $nums);
// [1, 4, 9, 16]

// С несколькими массивами
$a = [1, 2, 3];
$b = [10, 20, 30];
$sums = array_map(fn($x, $y) => $x + $y, $a, $b);
// [11, 22, 33]

// С null callback - "склеивание"
$result = array_map(null, $a, $b);
// [[1,10], [2,20], [3,30]]',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем отличаются array_filter и array_map?',
                'answer' => 'array_filter оставляет только элементы, для которых callback вернул truthy. array_map - преобразует каждый элемент. filter сохраняет ключи (после него часто нужен array_values), map тоже сохраняет ключи. Без callback array_filter удаляет все falsy значения (0, "", null, false, []).',
                'code_example' => '<?php
$nums = [1, 2, 3, 4, 5];

// filter - оставить чётные
$even = array_filter($nums, fn($x) => $x % 2 === 0);
// [1 => 2, 3 => 4] - ключи сохранены!

// Сбросить ключи
$even = array_values($even);

// filter без callback - убрать falsy
$cleaned = array_filter([1, 0, "", "a", null, false]);
// [0 => 1, 3 => "a"]

// map - преобразовать
$doubled = array_map(fn($x) => $x * 2, $nums);
// [2, 4, 6, 8, 10]',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работает array_reduce?',
                'answer' => 'array_reduce сворачивает массив в одно значение, применяя callback пошагово. Callback принимает аккумулятор и текущий элемент, возвращает новое значение аккумулятора. Третий параметр - начальное значение (по умолчанию null). Используется для сумм, конкатенаций, поиска макс/мин, построения деревьев.',
                'code_example' => '<?php
$nums = [1, 2, 3, 4, 5];

// Сумма
$sum = array_reduce($nums, fn($carry, $x) => $carry + $x, 0);
// 15

// Произведение
$prod = array_reduce($nums, fn($c, $x) => $c * $x, 1);
// 120

// Объединение объектов
$users = [["age" => 20], ["age" => 30], ["age" => 25]];
$totalAge = array_reduce($users, fn($c, $u) => $c + $u["age"], 0);
// 75',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем отличается array_merge от оператора + для массивов?',
                'answer' => 'array_merge: для строковых ключей второй массив перезаписывает первый, для числовых - элементы добавляются и перенумеровываются. Оператор +: для любых ключей берётся значение из ЛЕВОГО массива (если ключ совпадает), числовые ключи НЕ перенумеровываются. То есть + объединяет с приоритетом левого, merge - с приоритетом правого для строк и склеиванием для чисел.',
                'code_example' => '<?php
$a = ["a" => 1, "b" => 2, 0 => "x"];
$b = ["b" => 3, "c" => 4, 0 => "y"];

print_r(array_merge($a, $b));
// ["a" => 1, "b" => 3, "c" => 4, 0 => "x", 1 => "y"]
// числовой ключ перенумерован, "b" взято из $b

print_r($a + $b);
// ["a" => 1, "b" => 2, 0 => "x", "c" => 4]
// "b" из $a, ключ 0 из $a, "c" добавлен из $b

// Spread (PHP 7.4+, с PHP 8.1 со строковыми ключами)
$merged = [...$a, ...$b];',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как проверить наличие элемента в массиве?',
                'answer' => 'in_array($needle, $haystack) - проверяет значение, без третьего параметра делает нестрогое сравнение (опасно!). Третий параметр true - строгое сравнение. array_search - возвращает ключ найденного значения или false. isset($arr[$key]) - проверяет наличие ключа (но false если значение null). array_key_exists - проверяет ключ даже если значение null. Для больших массивов в горячем пути лучше делать массив "ключ => true".',
                'code_example' => '<?php
$users = ["Иван", "Аня", "Петя"];

var_dump(in_array("Аня", $users));      // true
var_dump(in_array("0", $users, true));  // false (строго)

$key = array_search("Петя", $users);     // 2
$key = array_search("X", $users);        // false

$data = ["name" => null];
isset($data["name"]);              // false (null!)
array_key_exists("name", $data);   // true

// Быстрая проверка для большого набора
$set = array_flip(["a", "b", "c"]); // ["a"=>0, "b"=>1, "c"=>2]
isset($set["a"]); // O(1)',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем отличаются array_keys и array_values?',
                'answer' => 'array_keys возвращает все ключи массива в виде нового индексированного массива. Можно вторым аргументом задать значение, чтобы вернулись только ключи с этим значением. array_values возвращает только значения, перенумеровывая ключи в 0, 1, 2...',
                'code_example' => '<?php
$user = ["name" => "Иван", "age" => 30, "role" => "admin"];

print_r(array_keys($user));
// [0 => "name", 1 => "age", 2 => "role"]

print_r(array_values($user));
// [0 => "Иван", 1 => 30, 2 => "admin"]

// Ключи с конкретным значением
$status = ["a" => "ok", "b" => "fail", "c" => "ok"];
print_r(array_keys($status, "ok"));
// [0 => "a", 1 => "c"]

// Сброс ключей после filter
$clean = array_values(array_filter($items));',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что делает array_diff и чем отличается от array_intersect?',
                'answer' => 'array_diff возвращает значения первого массива, которых нет в остальных. array_intersect - возвращает значения, присутствующие во всех массивах. Сравнение нестрогое (через ==). Версии _key - сравнивают ключи, _assoc - и ключи, и значения. Для строгого сравнения есть _strict-варианты, для объектов - с callback (_uassoc).',
                'code_example' => '<?php
$a = [1, 2, 3, 4, 5];
$b = [3, 4, 5, 6, 7];

print_r(array_diff($a, $b));
// [0 => 1, 1 => 2] - что есть в $a, но нет в $b

print_r(array_intersect($a, $b));
// [2 => 3, 3 => 4, 4 => 5] - общие

// По ключам
$x = ["a" => 1, "b" => 2];
$y = ["a" => 5, "c" => 3];
print_r(array_diff_key($x, $y));   // ["b" => 2]
print_r(array_diff_assoc($x, $y)); // ["a" => 1, "b" => 2]',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как отсортировать массив в PHP?',
                'answer' => 'Семейство функций сортировки: sort/rsort - по значениям, теряют ключи. asort/arsort - по значениям, СОХРАНЯЮТ ключи. ksort/krsort - по ключам. usort/uasort/uksort - с пользовательским callback. natsort - "натуральная" сортировка (file2 < file10). Все они МУТИРУЮТ исходный массив! Возвращают true/false.',
                'code_example' => '<?php
$nums = [3, 1, 4, 1, 5, 9, 2, 6];

sort($nums);  // мутирует! [1, 1, 2, 3, 4, 5, 6, 9]
rsort($nums); // по убыванию

$users = ["c" => 3, "a" => 1, "b" => 2];
asort($users); // сохраняет ключи: ["a"=>1, "b"=>2, "c"=>3]
ksort($users); // сортирует по ключам

// Кастомная
$products = [
    ["name" => "B", "price" => 100],
    ["name" => "A", "price" => 50],
];
usort($products, fn($x, $y) => $x["price"] <=> $y["price"]);

// Натуральная
$files = ["img10", "img2", "img1"];
natsort($files); // img1, img2, img10',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как объединить массив в строку и обратно?',
                'answer' => 'implode($glue, $array) или join() - склеивает элементы через разделитель. explode($delimiter, $string, $limit) - разбивает строку на массив. Третий параметр explode ограничивает число частей: положительное - максимум кусков, отрицательное - сколько отбросить с конца. str_split разбивает на части фиксированной длины. preg_split - разбивает по регулярке.',
                'code_example' => '<?php
$arr = ["apple", "banana", "cherry"];
echo implode(", ", $arr); // "apple, banana, cherry"

$str = "one,two,three,four";
print_r(explode(",", $str));
// ["one", "two", "three", "four"]

// Ограничение
print_r(explode(",", $str, 2));
// ["one", "two,three,four"]

print_r(explode(",", $str, -1));
// ["one", "two", "three"] - отбросили последний

// На фиксированные части
print_r(str_split("abcdef", 2));
// ["ab", "cd", "ef"]',
                'code_language' => 'php',
            ],

            // === СТРОКИ ===
            [
                'category' => 'PHP',
                'question' => 'Как заменить подстроку в строке?',
                'answer' => 'str_replace($search, $replace, $subject) - простая замена, можно передать массивы (массив искомых в массив заменяемых поэлементно). str_ireplace - регистронезависимая. substr_replace - замена по позиции и длине. preg_replace - по регулярному выражению. strtr - перевод символов или подстрок по карте.',
                'code_example' => '<?php
echo str_replace("мир", "PHP", "Привет, мир!");
// "Привет, PHP!"

// Массивы
echo str_replace(
    ["a", "e"],
    ["@", "3"],
    "apple"
); // "@ppl3"

// По позиции (заменить с 7 длиной 3)
echo substr_replace("Hello, World!", "PHP", 7, 5);
// "Hello, PHP!"

// Карта замен
echo strtr("test", ["t" => "T", "e" => "3"]);
// "T3sT"',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем mb_strlen отличается от strlen?',
                'answer' => 'strlen возвращает количество БАЙТ в строке, а не символов. Для ASCII это одно и то же. Для UTF-8 кириллический символ занимает 2 байта, эмодзи - 4. mb_strlen возвращает реальное количество СИМВОЛОВ с учётом кодировки. Если работаешь с многобайтными строками - всегда используй mb_* функции (mb_substr, mb_strtolower, mb_str_split, mb_strpos).',
                'code_example' => '<?php
$str = "Привет";

echo strlen($str);    // 12 (по 2 байта на букву в UTF-8)
echo mb_strlen($str); // 6  (реальная длина)

// Эмодзи занимают 4 байта
echo strlen("🚀");    // 4
echo mb_strlen("🚀"); // 1

// Аналогично для substr
echo substr("Привет", 0, 2);    // "?" - порча данных!
echo mb_substr("Привет", 0, 2); // "Пр"

// Регистр
echo strtolower("ПРИВЕТ");    // ПРИВЕТ - не работает!
echo mb_strtolower("ПРИВЕТ"); // привет',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как форматировать строку в PHP?',
                'answer' => 'sprintf($format, ...$args) форматирует и возвращает строку, printf - сразу выводит. number_format форматирует числа с разделителями. Спецификаторы: %s - строка, %d - int, %f - float, %x - hex, %b - binary. Можно задать ширину, точность, выравнивание. Для интерполяции в шаблонах часто проще использовать обычные двойные кавычки или heredoc.',
                'code_example' => '<?php
$price = 19.5;
$name = "Книга";

echo sprintf("Товар: %s, цена: %.2f", $name, $price);
// "Товар: Книга, цена: 19.50"

// Ширина и выравнивание
echo sprintf("|%-10s|%10s|", "left", "right");
// "|left      |     right|"

// Числа с разделителями
echo number_format(1234567.891, 2, ".", " ");
// "1 234 567.89"

// Padding
echo str_pad("5", 3, "0", STR_PAD_LEFT); // "005"',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как найти подстроку в строке в PHP?',
                'answer' => 'strpos($haystack, $needle) - первое вхождение, возвращает позицию или FALSE. ВАЖНО: используй === false, потому что 0 == false! stripos - регистронезависимый. strrpos - последнее вхождение. С PHP 8 появились str_contains/str_starts_with/str_ends_with - проще и безопаснее. Для регулярок - preg_match.',
                'code_example' => '<?php
$str = "Hello, World!";

// Старый способ
$pos = strpos($str, "World");
if ($pos !== false) {        // строго!
    echo "Найдено на $pos";  // 7
}

// PHP 8+
if (str_contains($str, "World")) { /* ... */ }
if (str_starts_with($str, "Hello")) { /* ... */ }
if (str_ends_with($str, "!")) { /* ... */ }

// Ловушка с == false
if (strpos("0123", "0") == false) {
    echo "Не найдено"; // НО ОНО НАЙДЕНО на позиции 0!
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как обрезать пробелы и спецсимволы в строке?',
                'answer' => 'trim - обрезает с обеих сторон, ltrim - слева, rtrim - справа. По умолчанию обрезают пробелы, табы, переводы строк, \r, \0, \v. Вторым параметром можно указать свой набор символов (это набор, не подстрока!). Для обрезки конкретной подстроки используй preg_replace или substr.',
                'code_example' => '<?php
echo trim("  hello  ");           // "hello"
echo ltrim("---test", "-");        // "test"
echo rtrim("file.txt", ".txt");    // "file" (поштучно убирает символы!)

// Символьный набор - это НЕ подстрока
echo rtrim("test.txt", "txt.");    // "tes" - убрало все t,x,t,.

// Обрезать конкретный суффикс
$path = "/var/www/";
$path = rtrim($path, "/");         // "/var/www"

// PHP 8: убрать конкретный префикс/суффикс
function stripPrefix(string $s, string $p): string {
    return str_starts_with($s, $p) ? substr($s, strlen($p)) : $s;
}',
                'code_language' => 'php',
            ],

            // === РЕГУЛЯРНЫЕ ВЫРАЖЕНИЯ ===
            [
                'category' => 'PHP',
                'question' => 'Как использовать регулярные выражения в PHP?',
                'answer' => 'PHP использует PCRE (Perl-совместимые регулярки) через функции preg_*. Шаблон оборачивается в разделитель (обычно /, но может быть #, ~). Флаги после: i (без учёта регистра), m (многострочный), s (точка матчит \n), u (UTF-8), x (extended). Основные функции: preg_match - найти первое, preg_match_all - все, preg_replace - заменить, preg_split - разбить, preg_replace_callback - замена через callback.',
                'code_example' => '<?php
// preg_match - первое совпадение
if (preg_match("/(\d+)-(\d+)/", "abc 123-456 xyz", $m)) {
    print_r($m);
    // [0 => "123-456", 1 => "123", 2 => "456"]
}

// preg_match_all - все
preg_match_all("/\w+/", "one two three", $m);
print_r($m[0]); // ["one", "two", "three"]

// Замена с callback
$result = preg_replace_callback(
    "/\d+/",
    fn($m) => $m[0] * 2,
    "a1 b2 c3"
);
// "a2 b4 c6"

// Именованные группы
preg_match("/(?<year>\d{4})-(?<month>\d{2})/", "2026-05", $m);
echo $m["year"]; // 2026',
                'code_language' => 'php',
            ],

            // === ООП ===
            [
                'category' => 'PHP',
                'question' => 'Что такое класс и объект в PHP?',
                'answer' => 'Класс - это шаблон, описание структуры данных и поведения (свойства и методы). Объект - конкретный экземпляр класса, созданный через new. Все объекты в PHP передаются по ссылке-указателю (точнее, переменная содержит идентификатор объекта). $this внутри метода - ссылка на текущий объект. Свойства объявляются с указанием видимости.',
                'code_example' => '<?php
class User {
    public string $name;
    private int $age;

    public function __construct(string $name, int $age) {
        $this->name = $name;
        $this->age = $age;
    }

    public function greet(): string {
        return "Привет, я {$this->name}";
    }
}

$user = new User("Иван", 30);
echo $user->greet();   // Привет, я Иван
echo $user->name;      // Иван (public)
// echo $user->age;    // Fatal error (private)

// Объект - по ссылке-идентификатору
$user2 = $user;
$user2->name = "Аня";
echo $user->name;      // Аня !',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Какие модификаторы видимости есть в PHP?',
                'answer' => 'public - доступно отовсюду. protected - доступно из самого класса и наследников. private - только из самого класса (не из наследников!). С PHP 8.1 для констант появилась видимость final. С PHP 8.4 готовится asymmetric visibility (public read / private write). Хорошая практика: по умолчанию private, повышать видимость только по необходимости.',
                'code_example' => '<?php
class Animal {
    public string $name;
    protected int $age;
    private string $secret = "shh";

    private function privateMethod() {}
    protected function protectedMethod() {}
}

class Dog extends Animal {
    public function showAge() {
        return $this->age;     // OK (protected)
        // return $this->secret; // Error (private)
    }
}

$dog = new Dog();
echo $dog->name;     // OK
// echo $dog->age;   // Error
// echo $dog->secret;// Error',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое наследование и как использовать?',
                'answer' => 'Наследование позволяет создать класс на базе другого, переиспользуя его свойства и методы. Используется ключевое слово extends. PHP поддерживает только одиночное наследование (один родитель). Метод родителя можно вызвать через parent::method(). Конструктор родителя НЕ вызывается автоматически - нужно явно parent::__construct(). Для запрета переопределения используется final.',
                'code_example' => '<?php
class Animal {
    public function __construct(protected string $name) {}

    public function describe(): string {
        return "Я животное по имени {$this->name}";
    }
}

class Dog extends Animal {
    public function __construct(string $name, private string $breed) {
        parent::__construct($name);
    }

    public function describe(): string {
        return parent::describe() . " породы {$this->breed}";
    }
}

$dog = new Dog("Рекс", "лабрадор");
echo $dog->describe();
// "Я животное по имени Рекс породы лабрадор"

final class Cat extends Animal {} // нельзя наследовать дальше',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое интерфейс и зачем он нужен?',
                'answer' => 'Интерфейс - это контракт, описывающий, какие методы должен реализовать класс, без указания, КАК они работают. Все методы публичные и абстрактные. Класс может реализовать НЕСКОЛЬКО интерфейсов. Интерфейсы могут содержать константы. Используется для полиморфизма, тестирования (моки), Dependency Inversion. С PHP 8.0+ можно объявлять private/public final константы.',
                'code_example' => '<?php
interface Logger {
    public function log(string $message): void;
    public function error(string $message): void;
}

interface Formatter {
    public function format(string $message): string;
}

// Множественная реализация
class FileLogger implements Logger, Formatter {
    public function log(string $message): void {
        file_put_contents("log.txt", $this->format($message), FILE_APPEND);
    }
    public function error(string $message): void {
        $this->log("[ERROR] $message");
    }
    public function format(string $message): string {
        return "[" . date("Y-m-d") . "] $message\n";
    }
}

function process(Logger $logger) {
    $logger->log("test"); // полиморфизм
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое абстрактный класс и чем отличается от интерфейса?',
                'answer' => 'Абстрактный класс - класс, объявленный с abstract, который нельзя инстанцировать напрямую. Может содержать как реализованные, так и абстрактные методы (без тела). От интерфейса отличается тем, что: может иметь свойства и реализованные методы, можно унаследовать только ОДИН абстрактный класс, методы могут быть с любой видимостью. Используется когда есть общая логика и общие данные у наследников.',
                'code_example' => '<?php
abstract class Shape {
    public function __construct(public string $color) {}

    // Абстрактный - наследник должен реализовать
    abstract public function area(): float;

    // Готовый метод
    public function describe(): string {
        return "Это {$this->color} фигура площадью {$this->area()}";
    }
}

class Circle extends Shape {
    public function __construct(string $color, private float $radius) {
        parent::__construct($color);
    }

    public function area(): float {
        return M_PI * $this->radius ** 2;
    }
}

// $s = new Shape("red"); // Fatal error
$c = new Circle("красная", 5);
echo $c->describe();',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое трейт (trait) и когда его использовать?',
                'answer' => 'Трейт - это механизм горизонтального переиспользования кода в PHP. Простыми словами: это набор методов и свойств, которые можно "впихнуть" в класс через use. Решает проблему отсутствия множественного наследования. Не является типом, нельзя инстанцировать. Если возникает конфликт имён - используется insteadof и as. Подходит для cross-cutting concerns: логирование, кэширование, soft deletes.',
                'code_example' => '<?php
trait Timestampable {
    private ?int $createdAt = null;
    private ?int $updatedAt = null;

    public function touch(): void {
        $this->updatedAt = time();
        $this->createdAt ??= time();
    }
}

trait Loggable {
    public function log(string $msg): void {
        echo "[" . static::class . "] $msg\n";
    }
}

class Post {
    use Timestampable, Loggable;
}

$post = new Post();
$post->touch();
$post->log("created");

// Конфликт имён
trait A { public function hello() { echo "A"; } }
trait B { public function hello() { echo "B"; } }
class C {
    use A, B {
        A::hello insteadof B;
        B::hello as helloB;
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое статические свойства и методы?',
                'answer' => 'static - модификатор, делающий свойство или метод принадлежащим КЛАССУ, а не экземпляру. Доступ через ClassName::method() или self::method() / static::method() внутри класса. Статический метод не имеет $this. Статические свойства разделяются между всеми экземплярами. Часто применяется для фабричных методов, утилит, синглтонов. Минус: статика плохо тестируется и моделируется через DI.',
                'code_example' => '<?php
class Counter {
    private static int $count = 0;

    public static function increment(): int {
        return ++self::$count;
    }

    public static function reset(): void {
        self::$count = 0;
    }
}

echo Counter::increment(); // 1
echo Counter::increment(); // 2

// Фабричный метод
class User {
    public static function fromArray(array $data): self {
        return new self($data["name"], $data["age"]);
    }
    public function __construct(public string $name, public int $age) {}
}

$user = User::fromArray(["name" => "Иван", "age" => 30]);',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое constructor property promotion в PHP 8?',
                'answer' => 'Constructor property promotion (PHP 8.0+) - это сокращённый синтаксис, позволяющий объявлять свойства класса прямо в параметрах конструктора через указание модификатора видимости. Простыми словами: одна строка вместо трёх (объявить, передать, присвоить). Можно комбинировать с readonly (PHP 8.1+) для immutable объектов.',
                'code_example' => '<?php
// Старый способ
class UserOld {
    private string $name;
    private int $age;

    public function __construct(string $name, int $age) {
        $this->name = $name;
        $this->age = $age;
    }
}

// PHP 8+
class User {
    public function __construct(
        private string $name,
        private int $age,
        public readonly string $email = "",
    ) {}
}

$user = new User("Иван", 30, "i@i.ru");
echo $user->email; // Иван',
                'code_language' => 'php',
            ],

            // === МАГИЧЕСКИЕ МЕТОДЫ ===
            [
                'category' => 'PHP',
                'question' => 'Какие магические методы есть в PHP?',
                'answer' => 'Магические методы вызываются автоматически в специальных ситуациях, имеют префикс __. Основные: __construct/__destruct, __get/__set/__isset/__unset (для несуществующих свойств), __call/__callStatic (для несуществующих методов), __toString (приведение к строке), __invoke (вызов объекта как функции), __clone (после клонирования), __serialize/__unserialize, __debugInfo (для var_dump). Минус: непрозрачны, тяжелее анализировать.',
                'code_example' => '<?php
class Container {
    private array $data = [];

    public function __get(string $name) {
        return $this->data[$name] ?? null;
    }

    public function __set(string $name, $value): void {
        $this->data[$name] = $value;
    }

    public function __isset(string $name): bool {
        return isset($this->data[$name]);
    }

    public function __call(string $method, array $args) {
        echo "Вызван несуществующий: $method";
    }

    public function __toString(): string {
        return json_encode($this->data);
    }

    public function __invoke(string $key) {
        return $this->data[$key] ?? null;
    }
}

$c = new Container();
$c->name = "Иван";    // __set
echo $c->name;        // __get
echo $c;              // __toString
echo $c("name");      // __invoke',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работает __invoke и зачем он нужен?',
                'answer' => '__invoke позволяет вызывать объект как функцию. Простыми словами: добавляешь метод __invoke - и можно писать $obj() вместо $obj->method(). Полезно для callable-объектов: handlers, action-классы, single-action invokables в Laravel, middleware. Объект с __invoke считается callable, его можно передавать туда, где ожидается функция.',
                'code_example' => '<?php
class Multiplier {
    public function __construct(private int $factor) {}

    public function __invoke(int $x): int {
        return $x * $this->factor;
    }
}

$double = new Multiplier(2);
echo $double(5);  // 10 - вызвали как функцию

// Передача в функции, ожидающие callable
$nums = [1, 2, 3, 4];
$result = array_map($double, $nums);
// [2, 4, 6, 8]

// Паттерн Single Action в Laravel
class CreateUserAction {
    public function __invoke(array $data): User {
        return User::create($data);
    }
}',
                'code_language' => 'php',
            ],

            // === ЗАМЫКАНИЯ И АНОНИМНЫЕ ===
            [
                'category' => 'PHP',
                'question' => 'Что такое замыкание (closure) в PHP?',
                'answer' => 'Замыкание - это анонимная функция, которая может "захватывать" переменные из окружения. В PHP в отличие от JS захват ЯВНЫЙ через use. По умолчанию переменные захватываются по значению (копия), для захвата по ссылке - use (&$var). $this автоматически биндится если closure создан в методе. Можно перепривязать через bindTo/Closure::bind или Closure::fromCallable.',
                'code_example' => '<?php
$multiplier = 3;

// По значению
$fn = function($x) use ($multiplier) {
    return $x * $multiplier;
};
echo $fn(5); // 15

$multiplier = 10;
echo $fn(5); // 15 (захватили старое!)

// По ссылке
$counter = 0;
$inc = function() use (&$counter) {
    $counter++;
};
$inc(); $inc(); $inc();
echo $counter; // 3

// Closure::bind - перепривязка $this
$closure = function() { return $this->name; };
class User { public string $name = "Иван"; }
$bound = Closure::bind($closure, new User(), User::class);
echo $bound(); // Иван',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое arrow functions в PHP?',
                'answer' => 'Arrow functions (PHP 7.4+) - это краткий синтаксис анонимных функций через fn() => expr. Главное отличие: автоматически захватывают переменные из родительской области по ЗНАЧЕНИЮ (без use). Тело - одно выражение, которое неявно возвращается. Не могут содержать несколько инструкций. Идеальны для маленьких callback в array_map/filter/reduce.',
                'code_example' => '<?php
$factor = 3;

// Старый стиль
$fn1 = function($x) use ($factor) {
    return $x * $factor;
};

// PHP 7.4+
$fn2 = fn($x) => $x * $factor;

echo $fn2(5); // 15

// В array_map
$nums = [1, 2, 3, 4];
$squared = array_map(fn($x) => $x ** 2, $nums);
// [1, 4, 9, 16]

// Несколько параметров
$add = fn(int $a, int $b): int => $a + $b;

// Ограничение: только одно выражение
// $bad = fn($x) => { $y = $x * 2; return $y; }; // нельзя!',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое анонимный класс в PHP?',
                'answer' => 'Анонимный класс (PHP 7+) - это класс без имени, объявляемый и инстанцируемый одновременно через new class. Полезен для одноразовых объектов: моков в тестах, простых implementations интерфейсов, передачи как параметра. Каждый new class создаёт ОТДЕЛЬНЫЙ класс, даже с одинаковым кодом. Может реализовывать интерфейсы, наследовать класс, использовать трейты.',
                'code_example' => '<?php
interface Logger {
    public function log(string $msg): void;
}

function processData(Logger $logger) {
    $logger->log("processing");
}

// Передаём анонимный класс
processData(new class implements Logger {
    public function log(string $msg): void {
        echo "LOG: $msg\n";
    }
});

// С аргументами конструктора
$obj = new class("test") {
    public function __construct(public string $name) {}
};

// Наследование + интерфейс
$mock = new class extends BaseRepo implements Storable {
    public function save(): void { /* мок */ }
};',
                'code_language' => 'php',
            ],

            // === ГЕНЕРАТОРЫ ===
            [
                'category' => 'PHP',
                'question' => 'Что такое yield и для чего он нужен?',
                'answer' => 'yield - ключевое слово, превращающее функцию в генератор. Простыми словами: вместо того чтобы построить весь массив в памяти и вернуть, генератор отдаёт значения по одному, "лениво". Огромная экономия памяти при работе с большими наборами данных. Между вызовами генератор сохраняет состояние. Можно yield-ить ключ => значение. yield from - делегирует другому генератору или iterable.',
                'code_example' => '<?php
function range_gen(int $start, int $end) {
    for ($i = $start; $i <= $end; $i++) {
        yield $i;
    }
}

// Не строит массив на 1млн элементов
foreach (range_gen(1, 1_000_000) as $num) {
    if ($num > 5) break;
    echo $num;
}

// Чтение большого файла построчно
function readLines(string $file) {
    $fh = fopen($file, "r");
    while (($line = fgets($fh)) !== false) {
        yield $line;
    }
    fclose($fh);
}

foreach (readLines("huge.log") as $line) {
    if (str_contains($line, "ERROR")) echo $line;
}

// yield from
function combined() {
    yield 1;
    yield from [2, 3, 4];
    yield from range_gen(5, 7);
}',
                'code_language' => 'php',
            ],

            // === ИСКЛЮЧЕНИЯ ===
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
            ],

            // === ТИПЫ ===
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
            ],

            // === PHP 8 ФИЧИ ===
            [
                'category' => 'PHP',
                'question' => 'Что такое именованные аргументы (named arguments)?',
                'answer' => 'Named arguments (PHP 8.0+) позволяют передавать аргументы в функцию по имени параметра, а не позиции. Синтаксис: name: value. Полезно когда много опциональных параметров - не нужно помнить порядок и пропускать промежуточные. Можно смешивать с позиционными, но именованные строго после позиционных. С PHP 8.1 - в аттрибутах и enum.',
                'code_example' => '<?php
function createUser(
    string $name,
    int $age = 18,
    bool $isAdmin = false,
    string $role = "user",
) {}

// Старый способ - пришлось бы передавать всё
createUser("Иван", 30, false, "manager");

// Named arguments - только нужное
createUser(name: "Иван", role: "manager");

// Можно в любом порядке
createUser(role: "admin", name: "Аня");

// Смешанно
createUser("Петя", isAdmin: true);

// В сложных функциях очень помогает
str_replace(
    search: ["a", "b"],
    replace: ["1", "2"],
    subject: $text,
);',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работает match-выражение в PHP 8?',
                'answer' => 'match (PHP 8.0+) - выражение для сопоставления значений, аналог switch, но: 1) использует строгое сравнение ===, 2) возвращает значение, 3) не нуждается в break, 4) выбрасывает UnhandledMatchError если ни одна ветка не подошла, 5) может объединять несколько значений через запятую. Намного безопаснее и лаконичнее switch.',
                'code_example' => '<?php
$status = "active";

// match - выражение
$label = match($status) {
    "active", "online" => "Активен",
    "inactive" => "Неактивен",
    "banned" => "Заблокирован",
    default => "Неизвестно",
};

// switch требует break и не возвращает значение
switch ($status) {
    case "active":
    case "online":
        $label = "Активен";
        break;
    // ...
}

// match со строгим сравнением
$result = match(1) {
    "1" => "string",  // не совпадёт!
    1 => "int",       // совпадёт
};

// Без default - UnhandledMatchError при отсутствии
$x = match($y) { 1 => "a" };',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое enum в PHP 8.1?',
                'answer' => 'Enum (PHP 8.1+) - тип-перечисление с фиксированным набором значений. Бывает: pure (просто кейсы) и backed (каждый кейс - значение типа int или string). Поддерживает методы, интерфейсы, статические методы. Кейс - синглтон, сравнение через ===. Backed enum имеет from() (выбросит ошибку) и tryFrom() (вернёт null). Cases() возвращает все варианты.',
                'code_example' => '<?php
// Pure enum
enum Status {
    case Active;
    case Inactive;
    case Banned;
}

$s = Status::Active;
var_dump($s === Status::Active); // true

// Backed enum
enum Role: string {
    case Admin = "admin";
    case User = "user";
    case Guest = "guest";

    public function label(): string {
        return match($this) {
            Role::Admin => "Администратор",
            Role::User => "Пользователь",
            Role::Guest => "Гость",
        };
    }
}

$role = Role::from("admin");          // Role::Admin
$role = Role::tryFrom("xxx");         // null
echo Role::Admin->value;              // "admin"
echo Role::Admin->label();            // "Администратор"
print_r(Role::cases());               // все варианты',
                'code_language' => 'php',
            ],

            // === COMPOSER И АВТОЗАГРУЗКА ===
            [
                'category' => 'PHP',
                'question' => 'Что такое Composer и зачем он нужен?',
                'answer' => 'Composer - менеджер зависимостей для PHP (как npm для Node, pip для Python). Управляет пакетами проекта через composer.json. composer.lock фиксирует точные версии для воспроизводимых сборок. composer install ставит из lock, composer update обновляет. Поддерживает автозагрузку (PSR-4, PSR-0, classmap, files). Пакеты публикуются на packagist.org.',
                'code_example' => '{
    "name": "my/project",
    "require": {
        "php": "^8.2",
        "guzzlehttp/guzzle": "^7.0"
    },
    "require-dev": {
        "phpunit/phpunit": "^10.0"
    },
    "autoload": {
        "psr-4": {
            "App\\\\": "src/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\\\": "tests/"
        }
    }
}',
                'code_language' => 'bash',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое PSR-4 автозагрузка?',
                'answer' => 'PSR-4 - стандарт автозагрузки классов. Простыми словами: имя класса с namespace однозначно отображается в путь к файлу. App\\Models\\User -> src/Models/User.php. Composer генерирует автозагрузчик по правилам в composer.json. Заменяет require_once для каждого файла. Старый стандарт PSR-0 заменял _ на / - устарел.',
                'code_example' => '<?php
// composer.json: "autoload": { "psr-4": { "App\\\\": "src/" } }

// src/Models/User.php
namespace App\Models;
class User {}

// public/index.php
require __DIR__ . "/../vendor/autoload.php";

use App\Models\User;
$user = new User(); // автоматически подгрузится файл

// composer dump-autoload -o    // оптимизированный для прода',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем отличаются include, require, include_once и require_once?',
                'answer' => 'include - подключает файл, при ошибке - Warning, выполнение продолжается. require - при ошибке Fatal Error и остановка. include_once / require_once - то же самое, но если файл уже подключался - не подключают повторно. На современных проектах эти конструкции почти не используют - всё через Composer autoload (PSR-4).',
                'code_example' => '<?php
// При отсутствии файла - warning, идём дальше
include "optional.php";

// При отсутствии - fatal error
require "config.php";

// Не подключит повторно
require_once "helper.php";
require_once "helper.php"; // ничего не делает

// Современный подход
require __DIR__ . "/vendor/autoload.php";',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работают сессии в PHP?',
                'answer' => 'Сессия - механизм хранения данных пользователя между запросами. session_start() инициализирует/восстанавливает сессию. Данные хранятся в $_SESSION (суперглобальный массив). PHP создаёт уникальный session_id и сохраняет его в куку (PHPSESSID). Сами данные хранятся на сервере (по умолчанию в файлах /tmp). Можно настроить хранилище: Redis, Memcached, БД.',
                'code_example' => '<?php
session_start();

$_SESSION["user_id"] = 42;
$_SESSION["cart"] = ["item1", "item2"];

// В другом запросе
session_start();
echo $_SESSION["user_id"]; // 42

unset($_SESSION["cart"]);
session_destroy();

// Регенерация ID при логине - защита от fixation
session_regenerate_id(true);',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работают cookies в PHP?',
                'answer' => 'Cookie - небольшие данные, хранимые в браузере и посылаемые с каждым запросом. Установка через setcookie() ДО любого вывода (это HTTP-заголовок). Чтение через $_COOKIE. Параметры: expires, path, domain, secure (только HTTPS), httponly (недоступен JS), samesite (Strict/Lax/None - защита от CSRF). С PHP 7.3 принимает массив опций.',
                'code_example' => '<?php
setcookie("user", "Иван", [
    "expires" => time() + 3600,
    "path" => "/",
    "domain" => "example.com",
    "secure" => true,
    "httponly" => true,
    "samesite" => "Strict",
]);

echo $_COOKIE["user"] ?? "guest";

// Удалить
setcookie("user", "", time() - 3600);',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работать с DateTime и DateTimeImmutable?',
                'answer' => 'DateTime - изменяемый объект даты, методы modify/add/sub МУТИРУЮТ объект. DateTimeImmutable - неизменяемый, методы возвращают НОВЫЙ объект. Всегда предпочитай Immutable - мутабельность дат причина множества багов. Форматирование через format(). Парсинг через createFromFormat. Разница через diff(). Часовые пояса через DateTimeZone.',
                'code_example' => '<?php
$dt = new DateTime("2026-05-01");
$dt->modify("+1 day");
echo $dt->format("Y-m-d"); // 2026-05-02 - изменился!

$dti = new DateTimeImmutable("2026-05-01");
$dti2 = $dti->modify("+1 day");
echo $dti->format("Y-m-d");  // 2026-05-01
echo $dti2->format("Y-m-d"); // 2026-05-02

// Парсинг
$dt = DateTimeImmutable::createFromFormat("d.m.Y", "01.05.2026");

// Разница
$diff = $dti->diff($dti2);
echo $diff->days; // 1

// Часовой пояс
$tz = new DateTimeZone("Europe/Moscow");
$dt = new DateTimeImmutable("now", $tz);',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работать с JSON в PHP?',
                'answer' => 'json_encode превращает PHP-структуру в JSON-строку. json_decode парсит JSON. По умолчанию json_decode возвращает объект stdClass, передай true вторым аргументом для массива. Полезные флаги: JSON_THROW_ON_ERROR (PHP 7.3+, выбросит исключение вместо false), JSON_UNESCAPED_UNICODE (не экранировать кириллицу), JSON_PRETTY_PRINT, JSON_UNESCAPED_SLASHES.',
                'code_example' => '<?php
$data = ["name" => "Иван", "age" => 30];

$json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// Парсинг в массив
$arr = json_decode($json, true);

// Парсинг в объект
$obj = json_decode($json);
echo $obj->name;

// С исключением
try {
    $data = json_decode($invalid, true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    echo $e->getMessage();
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как читать и писать файлы в PHP?',
                'answer' => 'Простые функции: file_get_contents (всё в строку), file_put_contents (записать). file() - читает в массив строк. fopen/fread/fwrite/fclose - для потоковой работы. fgets - построчно. file_put_contents с FILE_APPEND - дописывает. LOCK_EX - блокировка от конкурентной записи. Для больших файлов используй fopen + fgets, чтобы не загружать всё в память.',
                'code_example' => '<?php
// Простое чтение
$content = file_get_contents("file.txt");

// Простая запись
file_put_contents("file.txt", "data");

// Дописать с блокировкой
file_put_contents("log.txt", "line\n", FILE_APPEND | LOCK_EX);

// Чтение в массив строк
$lines = file("file.txt", FILE_IGNORE_NEW_LINES);

// Большой файл построчно
$fh = fopen("big.log", "r");
while (($line = fgets($fh)) !== false) {
    if (str_contains($line, "ERROR")) {
        echo $line;
    }
}
fclose($fh);',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое передача по ссылке и по значению в PHP?',
                'answer' => 'По умолчанию переменные передаются по ЗНАЧЕНИЮ - функция получает копию. Чтобы изменения отражались на оригинале - используй & в сигнатуре (передача по ссылке). Объекты особый случай: переменная содержит ИДЕНТИФИКАТОР объекта, копируется он, но указывает на тот же объект. Поэтому изменения свойств видны вне функции, но переприсвоение - нет.',
                'code_example' => '<?php
function byValue($x) { $x = 100; }
function byRef(&$x) { $x = 100; }

$a = 5;
byValue($a);
echo $a; // 5

$b = 5;
byRef($b);
echo $b; // 100

// Объекты
function modify($obj) { $obj->name = "New"; }
function reassign($obj) { $obj = new stdClass(); }

$user = new stdClass();
$user->name = "Иван";
modify($user);
echo $user->name; // "New" - свойство изменилось

reassign($user);
echo $user->name; // "New" - переприсвоение НЕ работает',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое WeakMap и WeakReference?',
                'answer' => 'WeakReference (PHP 7.4+) и WeakMap (PHP 8.0+) - механизм слабых ссылок. Простыми словами: ссылка, которая НЕ удерживает объект в памяти. Если других сильных ссылок нет - GC может уничтожить объект, и weak-ссылка вернёт null. WeakMap - словарь объект -> данные, не препятствующий уничтожению ключа. Полезно для кэшей, метаданных, observer-паттерна без утечек памяти.',
                'code_example' => '<?php
// WeakReference
$obj = new stdClass();
$weak = WeakReference::create($obj);
var_dump($weak->get()); // object
unset($obj);
var_dump($weak->get()); // NULL - объект собран GC

// WeakMap - кэш метаданных
$cache = new WeakMap();
$user = new User();
$cache[$user] = ["computed" => "data"];

unset($user); // удалит и запись из WeakMap
echo count($cache); // 0',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое Fiber в PHP 8.1?',
                'answer' => 'Fiber - механизм PHP 8.1+, позволяющий приостанавливать и возобновлять выполнение функции в любой точке. Простыми словами: это как пауза в видео - можешь остановить выполнение, отдать управление, потом вернуться. Полезно для асинхронного кода. Главное отличие от generator - можно приостановить из любой ВЛОЖЕННОЙ функции, а не только на yield в самой функции. Используется в ReactPHP, AMPHP, Laravel Octane.',
                'code_example' => '<?php
$fiber = new Fiber(function() {
    echo "start\n";
    $value = Fiber::suspend("paused");
    echo "resumed with $value\n";
    return "done";
});

$result = $fiber->start();
echo "got: $result\n";  // "paused"

$result = $fiber->resume("hello");
echo "got: $result\n";  // "done"

var_dump($fiber->isTerminated()); // true',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как безопасно хешировать пароли в PHP?',
                'answer' => 'Используй password_hash($password, PASSWORD_DEFAULT) - функция автоматически генерирует соль и использует современный алгоритм (bcrypt, в будущем argon2). Никогда не используй md5/sha1/sha256 для паролей - они быстрые, что плохо. password_verify($password, $hash) - проверка. password_needs_rehash проверяет нужен ли rehash при смене дефолта.',
                'code_example' => '<?php
// При регистрации
$password = "secret123";
$hash = password_hash($password, PASSWORD_DEFAULT);
// сохранить $hash в БД

// При логине
if (password_verify($password, $hashFromDb)) {
    echo "OK";

    if (password_needs_rehash($hashFromDb, PASSWORD_DEFAULT)) {
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        // обновить в БД
    }
}

// С опциями
$hash = password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как защититься от SQL-инъекций в PHP?',
                'answer' => 'Главное правило: НИКОГДА не подставляй пользовательский ввод в SQL через конкатенацию или интерполяцию. Используй prepared statements (PDO или mysqli) - параметры передаются отдельно от SQL, БД сама их экранирует. С PDO - bindParam/bindValue или массив в execute(). Для динамических имён колонок/таблиц используй белый список allowed-значений.',
                'code_example' => '<?php
// ПЛОХО - SQL-инъекция!
$name = $_GET["name"];
$pdo->query("SELECT * FROM users WHERE name = \'$name\'");

// ХОРОШО - prepared
$stmt = $pdo->prepare("SELECT * FROM users WHERE name = ?");
$stmt->execute([$_GET["name"]]);

// С именованными параметрами
$stmt = $pdo->prepare("SELECT * FROM users WHERE age > :age AND role = :role");
$stmt->execute(["age" => 18, "role" => "admin"]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Динамическая колонка - белый список
$allowed = ["name", "email", "created_at"];
$col = in_array($_GET["sort"], $allowed) ? $_GET["sort"] : "name";
$pdo->query("SELECT * FROM users ORDER BY $col");',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как защититься от XSS в PHP?',
                'answer' => 'XSS (Cross-Site Scripting) - внедрение JS-кода через пользовательский ввод. Защита: всегда экранировать вывод через htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8"). В шаблонах Blade {{ $var }} экранирует автоматически, {!! $var !!} - НЕ экранирует (опасно). Для JSON в JS - json_encode с JSON_HEX_TAG. CSP-заголовки добавляют второй слой защиты.',
                'code_example' => '<?php
$userInput = "<script>alert(1)</script>";

// ПЛОХО
echo "<div>$userInput</div>";

// ХОРОШО
echo "<div>" . htmlspecialchars($userInput, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") . "</div>";

// В JS-коде
$data = ["name" => $userInput];
echo "<script>const data = " . json_encode($data, JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS) . ";</script>";

// CSP-заголовок
header("Content-Security-Policy: default-src \'self\'");',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое CSRF и как от него защититься?',
                'answer' => 'CSRF (Cross-Site Request Forgery) - атака, когда пользователь, авторизованный на сайте A, заходит на сайт B, и B заставляет его браузер сделать запрос на A с куками. Защита: CSRF-токен, генерируемый сервером и проверяемый при отправке форм. Токен кладут в форму и сессию, при сабмите сравнивают через hash_equals (защита от timing-атак). SameSite=Strict/Lax cookie тоже защищает.',
                'code_example' => '<?php
session_start();

// Генерация при показе формы
if (empty($_SESSION["csrf"])) {
    $_SESSION["csrf"] = bin2hex(random_bytes(32));
}

// В форме
// <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION["csrf"]) ?>">

// Проверка при обработке
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["csrf"]) || !hash_equals($_SESSION["csrf"], $_POST["csrf"])) {
        http_response_code(403);
        die("CSRF токен неверный");
    }
    // обработка
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое Reflection в PHP?',
                'answer' => 'Reflection - API для интроспекции кода в рантайме: получить информацию о классах, методах, свойствах, параметрах. Простыми словами: код, который анализирует другой код. Используется фреймворками для DI-контейнеров, ORM, сериализаторов, тестов. Основные классы: ReflectionClass, ReflectionMethod, ReflectionProperty, ReflectionParameter, ReflectionAttribute (PHP 8). Минус - медленнее прямых вызовов.',
                'code_example' => '<?php
class User {
    public function __construct(
        public string $name,
        private int $age,
    ) {}
    public function greet(): string { return "Hi, $this->name"; }
}

$ref = new ReflectionClass(User::class);
echo $ref->getName(); // "User"

foreach ($ref->getProperties() as $prop) {
    echo $prop->getName() . "\n";
}

$ctor = $ref->getConstructor();
foreach ($ctor->getParameters() as $p) {
    echo $p->getName() . ": " . $p->getType() . "\n";
}

// Создать через рефлексию
$user = $ref->newInstance("Иван", 30);

// Доступ к private
$ageProp = $ref->getProperty("age");
echo $ageProp->getValue($user);',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое атрибуты PHP 8 (Attributes)?',
                'answer' => 'Атрибуты PHP 8 - метаданные, прикрепляемые к классам, методам, свойствам через синтаксис #[AttrName(args)]. Простыми словами: "теги" для кода, читаемые через Reflection. До PHP 8 использовались PHPDoc-аннотации (Doctrine, Symfony) - те парсились как комментарии. Атрибуты - часть языка, проверяются на этапе компиляции, доступны через ReflectionClass::getAttributes().',
                'code_example' => '<?php
#[Attribute(Attribute::TARGET_METHOD)]
class Route {
    public function __construct(
        public string $path,
        public string $method = "GET",
    ) {}
}

class UserController {
    #[Route("/users", method: "GET")]
    public function index() {}

    #[Route("/users/{id}", method: "POST")]
    public function update(int $id) {}
}

// Чтение
$ref = new ReflectionClass(UserController::class);
foreach ($ref->getMethods() as $method) {
    foreach ($method->getAttributes(Route::class) as $attr) {
        $route = $attr->newInstance();
        echo "$route->method $route->path\n";
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое сериализация в PHP?',
                'answer' => 'Сериализация - превращение PHP-объекта или структуры в строку, из которой потом можно восстановить. serialize() / unserialize() - бинарный PHP-формат, сохраняет тип. json_encode() / json_decode() - текстовый, межъязыковой. С PHP 7.4 есть __serialize / __unserialize - современная замена устаревших Serializable. ВАЖНО: unserialize небезопасен с недоверенными данными - может выполнить код через __wakeup/__destruct (POP-цепочки).',
                'code_example' => '<?php
class User {
    public function __construct(
        public string $name,
        private string $secret,
    ) {}

    public function __serialize(): array {
        return ["name" => $this->name];
    }

    public function __unserialize(array $data): void {
        $this->name = $data["name"];
        $this->secret = "";
    }
}

$user = new User("Иван", "pwd");
$str = serialize($user);

$user2 = unserialize($str);

// Безопасный режим
$obj = unserialize($str, ["allowed_classes" => [User::class]]);',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Какие структуры данных есть в SPL?',
                'answer' => 'SPL (Standard PHP Library) - встроенные структуры данных и интерфейсы. Полезные классы: SplStack (LIFO), SplQueue (FIFO), SplDoublyLinkedList, SplFixedArray (массив фиксированного размера, экономит память), SplPriorityQueue (очередь с приоритетом), SplObjectStorage (хеш-таблица с объектами в ключах), SplHeap (куча). Интерфейсы: Iterator, IteratorAggregate, Countable, ArrayAccess.',
                'code_example' => '<?php
// Stack
$stack = new SplStack();
$stack->push(1);
$stack->push(2);
echo $stack->pop(); // 2

// Queue
$q = new SplQueue();
$q->enqueue("a");
$q->enqueue("b");
echo $q->dequeue(); // "a"

// Priority Queue
$pq = new SplPriorityQueue();
$pq->insert("task1", 1);
$pq->insert("task2", 5); // выше приоритет
echo $pq->extract(); // "task2"

// FixedArray
$arr = new SplFixedArray(1000);
$arr[0] = "val";

// ObjectStorage
$storage = new SplObjectStorage();
$storage[$obj] = "data";',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое OPcache в PHP?',
                'answer' => 'OPcache - встроенный байт-код кэш PHP. Простыми словами: PHP компилирует .php файлы в опкоды (промежуточный байт-код) при каждом запросе - OPcache сохраняет результат компиляции в shared memory, чтобы не пересобирать заново. Огромный буст в проде. Главные настройки: opcache.memory_consumption, opcache.max_accelerated_files, opcache.validate_timestamps (на проде = 0 для скорости, требует рестарта при деплое).',
                'code_example' => '; php.ini
opcache.enable=1
opcache.enable_cli=0
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
opcache.validate_timestamps=0  ; в проде
opcache.revalidate_freq=0
opcache.save_comments=1        ; нужно для аннотаций

; opcache_get_status() - получить статус
; opcache_reset() - сбросить кэш',
                'code_language' => 'bash',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое JIT в PHP 8?',
                'answer' => 'JIT (Just-In-Time компиляция) - функция PHP 8+, которая компилирует "горячий" опкод в нативный машинный код прямо во время выполнения. Простыми словами: вместо интерпретации байт-кода - выполняется напрямую процессором. Включается через opcache.jit. Реально ускоряет CPU-bound задачи (математика, обработка изображений, шифры). Для типичных веб-приложений (БД, сеть) ускорения почти не даёт - там бутылочное горло не CPU.',
                'code_example' => '; php.ini для JIT
opcache.enable=1
opcache.jit_buffer_size=256M
opcache.jit=tracing  ; или 1255 (числовой)

; Режимы:
; tracing - анализирует частые пути
; function - на уровне функций
; disable - выключен

; Проверка через opcache_get_status()["jit"]',
                'code_language' => 'bash',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое сборщик мусора (GC) в PHP?',
                'answer' => 'GC (Garbage Collector) - механизм освобождения памяти от объектов, которые больше не используются. PHP использует подсчёт ссылок (refcount) - когда счётчик становится 0, память освобождается сразу. Но есть проблема ЦИКЛИЧЕСКИХ ссылок (A ссылается на B, B на A) - тут refcount не доходит до 0. Для них есть отдельный циклический GC, запускающийся периодически. gc_collect_cycles() - запустить вручную.',
                'code_example' => '<?php
class Node {
    public ?Node $next = null;
}

$a = new Node();
$b = new Node();
$a->next = $b;
$b->next = $a;  // циклическая ссылка

unset($a, $b);
// Refcount не = 0, объекты остаются в памяти!

gc_collect_cycles(); // запустить циклический GC

var_dump(gc_enabled()); // true
var_dump(gc_status());
gc_disable(); // отключить',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое PHP-FPM?',
                'answer' => 'PHP-FPM (FastCGI Process Manager) - менеджер процессов PHP для работы за веб-сервером (Nginx). Простыми словами: пул долгоживущих PHP-процессов, обрабатывающих запросы по протоколу FastCGI. Альтернатива mod_php (Apache) - быстрее, гибче. Настраиваются пулы: pm.max_children (макс процессов), pm.start_servers, pm = dynamic/static/ondemand. На запрос выделяется один воркер, после ответа PHP сбрасывает состояние.',
                'code_example' => '; /etc/php/8.2/fpm/pool.d/www.conf
[www]
user = www-data
listen = /run/php/php8.2-fpm.sock

pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 10
pm.max_requests = 500   ; рестарт воркера каждые N запросов

pm.status_path = /status
ping.path = /ping',
                'code_language' => 'bash',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое late static binding и зачем нужен static вместо self?',
                'answer' => 'Late static binding (LSB) - механизм, когда static:: ссылается на класс, в котором был ВЫЗВАН метод, а не на тот, где он объявлен. self:: всегда ссылается на класс объявления. Простыми словами: static подстраивается под наследников, self - нет. Критично для фабричных методов в родительских классах: с static новые подклассы автоматически получают правильное поведение.',
                'code_example' => '<?php
class Model {
    public static function create(): self {
        return new self();   // всегда Model
    }
    public static function createStatic(): static {
        return new static(); // тот класс, что вызвал
    }
}

class User extends Model {}

$a = User::create();        // Model!
$b = User::createStatic();  // User

var_dump($a instanceof User); // false
var_dump($b instanceof User); // true',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое Dependency Injection в PHP?',
                'answer' => 'DI (внедрение зависимостей) - паттерн, когда зависимости класса передаются ему ИЗВНЕ (через конструктор/сеттер), а не создаются внутри. Простыми словами: класс не сам делает new Logger(), а получает готовый Logger через параметр. Плюсы: легче тестировать (подменить мок), легче менять реализации, явные зависимости. DI-контейнер автоматизирует создание объектов с зависимостями.',
                'code_example' => '<?php
// ПЛОХО - hard-coded зависимость
class UserService {
    private Logger $logger;
    public function __construct() {
        $this->logger = new FileLogger(); // нельзя подменить!
    }
}

// ХОРОШО - DI через конструктор
class UserService {
    public function __construct(
        private LoggerInterface $logger,
        private UserRepository $repo,
    ) {}

    public function create(string $name): User {
        $user = $this->repo->create($name);
        $this->logger->log("created $name");
        return $user;
    }
}

// В тестах легко подменить
$service = new UserService($mockLogger, $mockRepo);',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Расскажи о принципах SOLID в PHP-контексте.',
                'answer' => 'S - Single Responsibility: один класс - одна причина для изменения. O - Open/Closed: класс открыт для расширения (через композицию, наследование, стратегию), закрыт для модификации. L - Liskov: подклассы должны быть взаимозаменяемы с родителем. I - Interface Segregation: лучше много мелких интерфейсов, чем один "толстый". D - Dependency Inversion: завись от абстракций (интерфейсов), не от конкретных классов. Все принципы про управление сложностью и переиспользование.',
                'code_example' => '<?php
// SRP - класс User не должен сам себя в БД сохранять
class User { /* данные */ }
class UserRepository {
    public function save(User $user): void {}
}

// OCP - расширяем через стратегию, не правим класс
interface Discount {
    public function calc(float $price): float;
}
class NewYearDiscount implements Discount {}
class BlackFridayDiscount implements Discount {}

// DIP - зависим от интерфейса
class Order {
    public function __construct(
        private PaymentGateway $gateway, // интерфейс!
    ) {}
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работают namespaces в PHP?',
                'answer' => 'Namespace - механизм группировки классов, функций, констант для избежания конфликтов имён. Объявляется namespace App\\Models; в начале файла. Используется через use App\\Models\\User;. Один файл - один namespace. Полное имя начинается с \\ (FQCN). Поддерживает алиасы (use X as Y), групповые импорты (PHP 7+).',
                'code_example' => '<?php
// src/Models/User.php
namespace App\Models;

class User {}

// src/Services/UserService.php
namespace App\Services;

use App\Models\User;
use App\Models\Post as PostModel;

// Групповой импорт (PHP 7+)
use App\Models\{User as U, Post, Comment};

class UserService {
    public function find(): U {
        return new U();
    }
}

// FQCN
$cls = \App\Models\User::class;',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое callable и как передать функцию как параметр?',
                'answer' => 'callable - тип, обозначающий "вызываемое". Может быть: имя функции (строка), массив [$obj, "method"] или ["Class", "staticMethod"], замыкание (Closure), объект с __invoke, first-class callable PHP 8.1 (function(...)). Часто используется в array_map, usort. Можно типизировать параметр как callable или Closure.',
                'code_example' => '<?php
function process(callable $fn, array $data): array {
    return array_map($fn, $data);
}

// Имя функции
process("strtoupper", ["a", "b"]);

// Замыкание
process(fn($x) => $x * 2, [1, 2, 3]);

// Метод объекта
class Doubler {
    public function double($x) { return $x * 2; }
}
$d = new Doubler();
process([$d, "double"], [1, 2]);

// Статический метод
process(["Math", "square"], [1, 2]);

// First-class callable (PHP 8.1)
process(strtoupper(...), ["a", "b"]);
process($d->double(...), [1, 2]);',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое spread-оператор в PHP?',
                'answer' => 'Spread-оператор ... распаковывает массив в аргументы функции (PHP 5.6+) или в другой массив (PHP 7.4+). С PHP 8.1 поддерживает строковые ключи. В сигнатуре функции ...$args собирает все аргументы в массив (variadic). Альтернатива call_user_func_array.',
                'code_example' => '<?php
// Variadic - собирает аргументы
function sum(int ...$nums): int {
    return array_sum($nums);
}
echo sum(1, 2, 3, 4); // 10

// Распаковка в вызов
$args = [1, 2, 3];
echo sum(...$args); // 6

// Распаковка в массив (PHP 7.4)
$first = [1, 2, 3];
$second = [...$first, 4, 5]; // [1,2,3,4,5]

// Со строковыми ключами (PHP 8.1)
$a = ["name" => "Иван"];
$b = ["age" => 30];
$user = [...$a, ...$b];

// Spread в named arguments
$params = ["name" => "Иван", "age" => 30];
createUser(...$params);',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое clone и как работает магический __clone?',
                'answer' => 'clone создаёт ПОВЕРХНОСТНУЮ копию объекта - все свойства копируются. НО: вложенные объекты копируются по ссылке-идентификатору (то есть указывают на тот же объект). Для глубокой копии нужно реализовать __clone и в нём вручную клонировать вложенные объекты. __clone вызывается автоматически после копирования свойств.',
                'code_example' => '<?php
class Address {
    public string $city = "Moscow";
}

class User {
    public Address $address;
    public function __construct() {
        $this->address = new Address();
    }
}

$a = new User();
$b = clone $a;
$b->address->city = "SPB";
echo $a->address->city; // "SPB"! - тот же объект

// Глубокая копия
class UserDeep {
    public Address $address;
    public function __clone(): void {
        $this->address = clone $this->address;
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое строгая типизация (strict_types) в PHP?',
                'answer' => 'declare(strict_types=1) в начале файла включает строгую типизацию для ВЫЗОВОВ функций из этого файла. Без неё PHP пытается приводить типы (coercive mode): передал "5" в int-параметр - сработает. Со strict_types - TypeError. Действует только на месте вызова, не объявления. Лучшая практика - всегда включать strict_types в начале каждого файла.',
                'code_example' => '<?php
declare(strict_types=1);

function add(int $a, int $b): int {
    return $a + $b;
}

add(5, 10);    // 15 - OK
// add("5", 10);  // TypeError со strict_types
// add(5.5, 10);  // TypeError - float не int

// Без strict_types это сработало бы:
// "5" -> 5, 5.5 -> 5',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем отличается isset, empty и is_null?',
                'answer' => 'isset($x) - true если переменная существует и не null. empty($x) - true если переменной нет или её значение falsy ("", 0, "0", null, [], false). is_null($x) - true только если значение === null (но даст Warning если переменной нет вообще). Для проверки массива: isset($arr["key"]) НЕ даст true если значение null - тогда нужен array_key_exists.',
                'code_example' => '<?php
$a = null;
$b = "";
$c = 0;
$d = "0";
$e = "hello";

var_dump(isset($a)); // false (null)
var_dump(isset($b)); // true ("")

var_dump(empty($a)); // true
var_dump(empty($b)); // true ("")
var_dump(empty($c)); // true (0)
var_dump(empty($d)); // true ("0" - тоже falsy!)
var_dump(empty($e)); // false

var_dump(is_null($a)); // true

// Массив с null
$arr = ["key" => null];
var_dump(isset($arr["key"]));            // false
var_dump(array_key_exists("key", $arr)); // true',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое суперглобальные переменные в PHP?',
                'answer' => 'Суперглобальные переменные - встроенные массивы, доступные везде без global. $_GET - параметры из URL. $_POST - тело POST-запроса. $_REQUEST - объединение GET, POST, COOKIE. $_SERVER - данные сервера и заголовки. $_FILES - загруженные файлы. $_COOKIE - cookies. $_SESSION - данные сессии. $_ENV - переменные окружения. $GLOBALS - все глобальные переменные.',
                'code_example' => '<?php
// URL: /search?q=php&page=2
$query = $_GET["q"] ?? "";     // "php"
$page = (int) ($_GET["page"] ?? 1);

// POST форма
$email = $_POST["email"] ?? "";

// Заголовки и сервер
$method = $_SERVER["REQUEST_METHOD"];
$ip = $_SERVER["REMOTE_ADDR"];

// Загруженный файл
if ($_FILES["avatar"]["error"] === UPLOAD_ERR_OK) {
    move_uploaded_file(
        $_FILES["avatar"]["tmp_name"],
        "uploads/" . $_FILES["avatar"]["name"]
    );
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работает copy-on-write в PHP?',
                'answer' => 'Copy-on-write (COW) - оптимизация, при которой PHP не копирует данные сразу при присваивании, а только когда одна из переменных МОДИФИЦИРУЕТСЯ. Простыми словами: $b = $a не копирует - просто увеличивает refcount. Реальная копия делается при первой записи. Для массивов и строк работает прозрачно. Для ОБЪЕКТОВ COW не работает - там handle-семантика.',
                'code_example' => '<?php
$a = range(1, 1_000_000); // большой массив
$b = $a;  // НЕ копирование, просто refcount++
// memory_get_usage() показывает, что память не выросла

$b[0] = "new"; // ВОТ ТУТ копия!
// Теперь $b - отдельный массив

// Объекты - НЕ COW, всегда handle
$obj1 = new User();
$obj2 = $obj1;
$obj2->name = "X";
echo $obj1->name; // "X" - тот же объект

// Передача в функцию - тоже COW для массивов
function process(array $data) { /* ... */ }
process($bigArray); // не копируется до изменения',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое Iterator и IteratorAggregate?',
                'answer' => 'Iterator - интерфейс, который надо реализовать чтобы объект работал в foreach. Методы: rewind, valid, current, key, next. IteratorAggregate проще - нужно только реализовать getIterator(), возвращающий любой Iterator (часто - ArrayIterator). Plus Generator: метод getIterator() может быть генератором (yield). Это делает обход коллекций ленивым и кастомным.',
                'code_example' => '<?php
// Через IteratorAggregate + Generator
class Collection implements IteratorAggregate {
    public function __construct(private array $items) {}

    public function getIterator(): Generator {
        foreach ($this->items as $key => $value) {
            yield $key => $value;
        }
    }
}

$c = new Collection(["a", "b", "c"]);
foreach ($c as $item) {
    echo $item;
}

// Полный Iterator
class Range implements Iterator {
    private int $current;
    public function __construct(private int $start, private int $end) {
        $this->current = $start;
    }
    public function rewind(): void { $this->current = $this->start; }
    public function valid(): bool { return $this->current <= $this->end; }
    public function current(): int { return $this->current; }
    public function key(): int { return $this->current - $this->start; }
    public function next(): void { $this->current++; }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое ArrayAccess и Countable?',
                'answer' => 'ArrayAccess - интерфейс позволяющий обращаться с объектом как с массивом через []. Методы: offsetExists, offsetGet, offsetSet, offsetUnset. Countable - чтобы count($obj) работал, реализуй метод count(). Вместе с Iterator/IteratorAggregate позволяют создать класс-коллекцию, неотличимый от массива в использовании. Laravel Collection - яркий пример.',
                'code_example' => '<?php
class Bag implements ArrayAccess, Countable, IteratorAggregate {
    public function __construct(private array $items = []) {}

    public function offsetExists(mixed $offset): bool {
        return isset($this->items[$offset]);
    }
    public function offsetGet(mixed $offset): mixed {
        return $this->items[$offset] ?? null;
    }
    public function offsetSet(mixed $offset, mixed $value): void {
        if ($offset === null) $this->items[] = $value;
        else $this->items[$offset] = $value;
    }
    public function offsetUnset(mixed $offset): void {
        unset($this->items[$offset]);
    }
    public function count(): int {
        return count($this->items);
    }
    public function getIterator(): ArrayIterator {
        return new ArrayIterator($this->items);
    }
}

$bag = new Bag(["a", "b"]);
$bag[] = "c";
echo count($bag);   // 3
echo $bag[0];       // "a"',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как генерировать криптостойкие случайные числа в PHP?',
                'answer' => 'rand() и mt_rand() - НЕ криптографически безопасны. Для безопасности (токены, пароли, CSRF) используй random_bytes() и random_int() (PHP 7+) - они дают криптостойкую случайность. random_int($min, $max) для целых, random_bytes($n) для бинарных данных. С PHP 8.2 появился новый объектный API через класс Random\\Engine.',
                'code_example' => '<?php
// ПЛОХО - предсказуемо
$token = md5(rand());

// ХОРОШО - криптостойко
$token = bin2hex(random_bytes(16));
// 32 hex-символа

$pin = random_int(1000, 9999);

// PHP 8.2+ объектный API
$randomizer = new Random\Randomizer();
$bytes = $randomizer->getBytes(16);
$num = $randomizer->getInt(1, 100);

// Перемешивание массива
$shuffled = $randomizer->shuffleArray([1, 2, 3, 4]);',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое stream wrappers и как использовать php://?',
                'answer' => 'Stream wrappers - механизм PHP для работы с разными источниками данных через единый файловый API (fopen, file_get_contents). Встроенные: php://stdin, php://stdout, php://memory (в памяти), php://temp (диск, если переполнило), php://input (тело запроса), php://output. file:// - локальные файлы (по умолчанию). http://, https://, ftp:// - сеть. Можно регистрировать свои через stream_wrapper_register.',
                'code_example' => '<?php
// Тело POST-запроса
$body = file_get_contents("php://input");
$data = json_decode($body, true);

// В память (быстро)
$mem = fopen("php://memory", "r+");
fwrite($mem, "data");
rewind($mem);
echo stream_get_contents($mem);

// Чтение из stdin (CLI)
$line = trim(fgets(STDIN));

// HTTP с context
$context = stream_context_create([
    "http" => ["method" => "POST", "content" => "data"],
]);
$res = file_get_contents($url, false, $context);',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем отличается print_r от var_dump и var_export?',
                'answer' => 'var_dump показывает тип и значение, удобен для отладки сложных вложенных структур. print_r выводит в "читаемом" виде, без типов. var_export выводит в виде ВАЛИДНОГО PHP-кода (подходит для генерации файлов конфигурации). Все три могут вернуть строку вместо вывода (вторым параметром true). На проде используй логирование, не вывод в браузер.',
                'code_example' => '<?php
$data = ["name" => "Иван", "age" => 30, "admin" => true];

var_dump($data);
// array(3) {
//   ["name"]=> string(4) "Иван"
//   ["age"]=> int(30)
//   ["admin"]=> bool(true)
// }

print_r($data);
// Array (
//     [name] => Иван
//     [age] => 30
//     [admin] => 1
// )

var_export($data);
// array (
//   "name" => "Иван",
//   "age" => 30,
//   "admin" => true,
// )

// Получить как строку
$str = print_r($data, true);
$str = var_export($data, true);',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое stdClass в PHP?',
                'answer' => 'stdClass - встроенный пустой класс PHP. Используется как контейнер для произвольных свойств. Когда json_decode без второго параметра возвращает объект - это stdClass. Также получается при касте массива в (object). Полей и методов своих нет, можно динамически добавлять любые свойства. Не путать с (object) или ArrayObject.',
                'code_example' => '<?php
// Создание
$obj = new stdClass();
$obj->name = "Иван";
$obj->age = 30;

// Из массива
$obj = (object) ["name" => "Иван", "age" => 30];
echo $obj->name;

// Из JSON
$obj = json_decode("{\"name\":\"Иван\"}");
echo $obj->name;

// Обратно в массив
$arr = (array) $obj;
print_r($arr); // ["name" => "Иван"]',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как сравнивать объекты в PHP?',
                'answer' => 'Оператор == (нестрогое): объекты равны если они одного класса и все свойства равны (рекурсивно). Оператор === (строгое): должны быть тот же экземпляр (один объект, не разные с одинаковыми свойствами). Для кастомного сравнения - реализуй метод equals() в классе. Не путать с clone - там создаётся новый объект.',
                'code_example' => '<?php
class Point {
    public function __construct(
        public int $x,
        public int $y,
    ) {}

    public function equals(Point $other): bool {
        return $this->x === $other->x && $this->y === $other->y;
    }
}

$a = new Point(1, 2);
$b = new Point(1, 2);
$c = $a;

var_dump($a == $b);   // true (поля равны)
var_dump($a === $b);  // false (разные экземпляры)
var_dump($a === $c);  // true (тот же экземпляр)

var_dump($a->equals($b)); // true',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работает copy-on-write для массивов и строк в PHP и когда он перестаёт работать?',
                'answer' => 'PHP хранит значения в zval со счётчиком ссылок refcount. При присваивании увеличивается refcount, а сам zval не копируется. Глубокое копирование (separation) происходит только при первой записи в одну из связанных переменных. CoW ломается, если переменная передана по ссылке (&$var) или захвачена в замыкание по ссылке - тогда копия делается сразу или вообще не делается.',
                'code_example' => '<?php
$a = range(1, 1_000_000); // 1 zval
$b = $a;                  // refcount=2, копии нет
$b[0] = 0;                // separation: копируется массив
$c = &$a;                 // CoW отключён для пары $a/$c',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем generator отличается от обычной функции и почему он экономит память?',
                'answer' => 'Generator - это функция с yield, возвращающая объект Generator, реализующий Iterator. Тело функции выполняется лениво: на каждой итерации до следующего yield, после чего стек замораживается. В памяти живёт только текущее значение и состояние корутины, а не весь набор данных. Это позволяет обрабатывать потоки данных любого размера в O(1) памяти. Дополнительно поддерживаются send() (двусторонняя коммуникация) и yield from (делегирование).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое Fiber в PHP 8.1 и чем он отличается от generator и от корутины Go?',
                'answer' => 'Fiber - примитив пользовательских стеков: можно приостановить (Fiber::suspend) и возобновить (resume) выполнение в произвольной точке, не только на yield. Generator кооперативен и тесно связан с iterator-протоколом, fiber же универсальнее и используется в ReactPHP/AMPHP для скрытия await. В отличие от горутин, fibers однопоточные, не имеют шедулера в ядре языка и не дают параллелизма - только конкурентность.',
                'code_example' => '<?php
$fiber = new Fiber(function (): void {
    $x = Fiber::suspend("ready");
    echo "got $x\\n";
});
$msg = $fiber->start();   // "ready"
$fiber->resume("hello");  // печатает "got hello"',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Зачем нужны readonly-свойства и readonly-классы (PHP 8.2) и какие у них ограничения?',
                'answer' => 'readonly-свойство можно инициализировать один раз изнутри объявившего класса (обычно в конструкторе) и нельзя переписать снаружи или из наследника. readonly-класс делает все нестатические свойства readonly автоматически. Это даёт иммутабельные DTO/value objects без бойлерплейта геттеров. Ограничения: нельзя иметь типизированные default-значения, нельзя клонировать с изменением (нужен __clone с reflection или wither-методы), невозможно использовать с static-свойствами.',
                'code_example' => '<?php
final readonly class Money {
    public function __construct(
        public int $amount,
        public string $currency,
    ) {}
}
$m = new Money(100, "USD");
// $m->amount = 200; // Error',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что делает OPcache и почему важна opcache.validate_timestamps в проде?',
                'answer' => 'OPcache кэширует скомпилированный байткод PHP в shared memory, избавляя от парсинга и компиляции на каждый запрос. validate_timestamps=1 заставляет PHP проверять mtime файлов; в проде её ставят в 0 для скорости и сбрасывают кэш во время деплоя через opcache_reset() или перезапуск FPM. Также важны opcache.memory_consumption, max_accelerated_files и preloading (PHP 7.4+) для разогрева классов до старта воркеров.',
                'code_example' => '; production php.ini
opcache.enable=1
opcache.validate_timestamps=0
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
opcache.preload=/var/www/preload.php',
                'code_language' => 'bash',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работает JIT в PHP 8 и в каких задачах он реально ускоряет?',
                'answer' => 'JIT (tracing/function режимы) компилирует горячий байткод в машинный код через DynASM. Для типичных веб-приложений выигрыш скромный, потому что бутылочное горлышко - IO/база, а не CPU. Реальный профит - на CPU-bound задачах: вычислениях, image-processing, парсерах, ML-инференсе. Включается через opcache.jit_buffer_size и opcache.jit=tracing в php.ini.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Как устроен сборщик циклических ссылок в PHP и когда он включается?',
                'answer' => 'Базовый GC - это refcounting. Когда refcount достигает 0, zval освобождается. Циклы (a→b→a) refcount не сбрасывают, поэтому существует второй уровень - буфер «возможных корней» (gc_collect_cycles). Когда буфер заполняется (по умолчанию 10000 узлов), запускается алгоритм Bacon-Rajan: помечает потомков и удаляет недостижимые. Принудительно вызывается gc_collect_cycles().',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'В чём разница между WeakMap, WeakReference и SplObjectStorage?',
                'answer' => 'SplObjectStorage хранит сильные ссылки - объект-ключ не освободится, пока хранилище живёт. WeakReference (PHP 7.4) - обёртка, не препятствующая GC, get() вернёт null после уборки. WeakMap (PHP 8.0) - ассоциативный массив со слабыми ключами: при удалении объекта запись исчезает автоматически. Используется для кэшей и метаданных, привязанных к объекту, без утечек.',
                'code_example' => '<?php
$cache = new WeakMap();
$user = new User(1);
$cache[$user] = "expensive_payload";
unset($user);             // запись из WeakMap уйдёт',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем отличается == от === и какие сюрпризы бывают на нестрогом сравнении в PHP 8+?',
                'answer' => '=== сравнивает тип и значение, == выполняет приведение типов. В PHP 8 поведение string vs number стало строже: "abc" == 0 теперь false (раньше true). Но "1abc" == 1 всё ещё true; "10" == "1e1" тоже true (оба числовые строки). Для null-safety и иммутабельности используйте ===, а для чисел - int-cast или явное приведение. Сравнение объектов по == проверяет класс и поля, а === - идентичность ссылки.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что произойдёт при new ClassName(...) для класса с конструктором, объявленным как private?',
                'answer' => 'Получите Error: Call to private ClassName::__construct(). Такой паттерн используется для именованных конструкторов и Singleton: класс предоставляет статические фабричные методы (fromArray, fromString), которые внутри вызывают new self(). Это позволяет инкапсулировать инвариант построения и иметь несколько способов создания с осмысленными именами.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работают атрибуты PHP 8 и чем они лучше PHPDoc-аннотаций?',
                'answer' => 'Атрибуты - это нативный синтаксис #[Attr(args)], который парсится компилятором и доступен через Reflection API без сторонних парсеров. У них есть таргеты (TARGET_CLASS, TARGET_METHOD), флаг IS_REPEATABLE и валидация аргументов, как у обычных классов. По сравнению с docblock-аннотациями: быстрее, безопаснее (нет регуляркой парсинга), IDE даёт автокомплит, типобезопасны.',
                'code_example' => '<?php
#[Attribute(Attribute::TARGET_METHOD)]
final class Route {
    public function __construct(public string $path, public string $method = "GET") {}
}
class Controller {
    #[Route("/users/{id}")]
    public function show(int $id) {}
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'В чём разница между abstract, interface и trait и когда выбирать что?',
                'answer' => 'Interface задаёт контракт без реализации, поддерживает множественную реализацию, не имеет состояния. Abstract class - частичная реализация плюс контракт, одиночное наследование, может иметь свойства. Trait - горизонтальное переиспользование кода (mixin), копируется в класс при компиляции, не образует тип. Интерфейс - для polymorphism, abstract - для шаблонного метода с общим состоянием, trait - для дублирующейся логики между несвязанными классами.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое late static binding и зачем нужен static вместо self?',
                'answer' => 'self ссылается на класс, в котором написана строка - связывание раннее, на этапе компиляции. static связывается поздно, по фактическому классу вызова. Это критично для фабричных методов и наследования: new self() вернёт родителя даже из дочернего класса, new static() - нужный потомок. Также static используется для возвращаемого типа методов вроде fluent API.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что выведет код с замыканием, захватившим переменную по значению, если её изменить после создания замыкания?',
                'answer' => 'use ($var) копирует значение в момент создания closure - последующие изменения снаружи не видны внутри. use (&$var) захватывает по ссылке: видны изменения в обе стороны. PHP 7.4+ поддерживает arrow functions (fn() =>), которые автоматически захватывают by value все используемые переменные внешнего скоупа.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Как реализованы enum в PHP 8.1 и чем backed-enum отличается от pure?',
                'answer' => 'Enum - это специальный объектный тип; кейсы - синглтоны, сравнение по === безопасно. Pure enum просто перечисление; backed enum имеет скалярный backing-тип (int|string), что даёт ::from()/::tryFrom() и автосериализацию. Enum может реализовывать интерфейсы, иметь методы и константы, но не имеет состояния (свойств). cases() возвращает все варианты в порядке объявления.',
                'code_example' => '<?php
enum Status: string {
    case Active = "active";
    case Banned = "banned";
    public function label(): string {
        return match($this) {
            self::Active => "Активен",
            self::Banned => "Забанен",
        };
    }
}
Status::from("active");',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое match-выражение и чем оно лучше switch?',
                'answer' => 'match сравнивает строго (===), возвращает значение, требует исчерпывающего покрытия (бросает UnhandledMatchError), не имеет fallthrough - каждая ветка завершается неявно. switch использует == и требует break, легко поймать баг с числовым строковым ключом. match - выражение, поэтому удобно присваивать в переменную или возвращать.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем PHP-FPM отличается от mod_php и как настраиваются пулы?',
                'answer' => 'mod_php встраивает интерпретатор в Apache-процесс, делая воркер тяжёлым и завязанным на веб-сервер. PHP-FPM - отдельный демон с FastCGI, общается с nginx/Apache по сокету, держит пулы воркеров. Стратегии pm: static (фиксированный пул), dynamic (масштабирует от min до max), ondemand (форкает по запросу, экономит память). pm.max_requests перезапускает воркер, чтобы избежать утечек.',
                'code_example' => '; pool.conf
pm = dynamic
pm.max_children = 50
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 20
pm.max_requests = 1000',
                'code_language' => 'bash',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем отличается include от require и от autoload, и почему autoload предпочтительнее?',
                'answer' => 'include выдаёт warning при отсутствии файла и продолжает выполнение, require - fatal error. _once делает идемпотентным. Autoload (spl_autoload_register / Composer PSR-4) загружает классы лениво: только когда они впервые упоминаются. Это снижает время загрузки, поддерживает namespaces и работает с opcache. В современных проектах ручные include использовать не нужно - только bootstrap.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое SPL и какие структуры из неё реально полезны на собеседованиях?',
                'answer' => 'Standard PHP Library предоставляет специализированные структуры данных и итераторы. SplQueue/SplStack/SplDoublyLinkedList - связные списки с O(1) на голову/хвост. SplPriorityQueue - куча. SplObjectStorage - set/map для объектов. SplFixedArray - массив с числовыми индексами и фиксированным размером, экономит память по сравнению с обычным array (~3-5x). Итераторы (RecursiveIteratorIterator, FilterIterator) дают компонуемые потоки.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работают типы never и void и в чём практическая разница?',
                'answer' => 'void - функция не возвращает ничего полезного, но завершается нормально. never (PHP 8.1) - функция никогда не возвращает: либо бросает исключение, либо вызывает exit/die/бесконечный цикл. Тип never используется анализаторами для exhaustiveness checking: компилятор знает, что код после вызова never-функции недостижим. Это чище, чем void для guard-функций вроде throwIfInvalid() и помогает type narrowing после ранних возвратов.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'В чём разница между __get/__set и реальными свойствами и какие подводные камни?',
                'answer' => 'Магические методы вызываются, когда обращение к свойству невозможно (отсутствует или недоступно по видимости). Они в разы медленнее прямых обращений, ломают статический анализ, IDE-автодополнение и type inference. На каждом __get создаётся фрейм. Их используют для прокси-объектов и lazy-loading, но в DDD предпочтительнее явные геттеры или public readonly. С isset() работают только если определён __isset().',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работает spread-оператор для массивов и именованных аргументов в PHP 8?',
                'answer' => '... разворачивает iterable в позиционные аргументы или элементы массива. PHP 8.1 разрешает разворачивать массивы со строковыми ключами - они становятся именованными аргументами. Это удобно для proxy/decorator: принять args, добавить/изменить и пробросить дальше. Также именованные аргументы делают вызовы с длинными сигнатурами читаемыми и устойчивыми к перестановке.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое first-class callable syntax (PHP 8.1) и зачем он нужен?',
                'answer' => 'Синтаксис $fn = strlen(...) или $obj->method(...) создаёт Closure из функции/метода без строкового имени. По сравнению со старым [$obj, "method"] и "strlen" - типобезопасно, поддерживает рефакторинг IDE, и, что важно, ловит ошибки опечаток на этапе компиляции. Удобно для array_map, pipeline и DI-резолверов.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем mb_* функции отличаются от обычных строковых и когда это критично?',
                'answer' => 'strlen, substr, strtolower работают побайтово. Для UTF-8 один кириллический символ - 2 байта, эмодзи - 4. mb_* функции учитывают кодировку и возвращают длину/срез в символах. Использование strlen для валидации длины пароля или substr для превью текста - частый источник багов и mojibake. Дефолтную кодировку задаёт mbstring.internal_encoding=UTF-8.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Как защититься от инъекций при сборке SQL вручную и почему prepared statements решают проблему?',
                'answer' => 'Prepared statements отделяют шаблон запроса от данных: драйвер парсит SQL один раз и подставляет значения как параметры на стороне сервера. Это исключает интерпретацию пользовательского ввода как кода. Эмулированные prepares (PDO::ATTR_EMULATE_PREPARES=true) на самом деле подставляют значения в шаблон на стороне клиента - безопасно, но теряются проверки типов и planning-cache. В проде включайте настоящие prepares.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое stream wrappers и как с их помощью читать gzip "на лету"?',
                'answer' => 'Stream wrapper - абстракция над источником данных с единым API fopen/fread/fwrite. PHP включает file://, http://, php://memory, а также compression-фильтры compress.zlib://, php://filter. Можно регистрировать свои через stream_wrapper_register. Это позволяет читать удалённые файлы, шифровать на лету и обрабатывать большие архивы потоково.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое preloading в PHP 7.4+ и какие у него ограничения?',
                'answer' => 'Preloading загружает указанные файлы в opcache при старте PHP-FPM master-процесса и навсегда держит их в памяти. Эти классы доступны во всех воркерах без файловой проверки, что даёт +5-15% к скорости старта запроса. Ограничения: при изменении preloaded-файла нужен полный рестарт FPM, нельзя использовать с runtime-кодом, скрипт исполняется в контексте master.',
                'code_example' => null,
                'code_language' => null,
            ],
        ];
    }
}
