<?php

namespace Database\Seeders\Data\Categories\Php;

class Arrays
{
    public static function all(): array
    {
        return [
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
                'difficulty' => 2,
                'topic' => 'php.arrays',
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
                'difficulty' => 2,
                'topic' => 'php.arrays',
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
                'difficulty' => 3,
                'topic' => 'php.arrays',
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
                'difficulty' => 3,
                'topic' => 'php.arrays',
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
                'difficulty' => 2,
                'topic' => 'php.arrays',
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
                'difficulty' => 2,
                'topic' => 'php.arrays',
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
                'difficulty' => 2,
                'topic' => 'php.arrays',
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
                'difficulty' => 2,
                'topic' => 'php.arrays',
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
                'difficulty' => 2,
                'topic' => 'php.arrays',
            ],
        ];
    }
}
