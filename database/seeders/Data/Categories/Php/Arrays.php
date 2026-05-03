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
                'answer' => 'in_array($needle, $haystack) - проверяет значение, без третьего параметра делает нестрогое сравнение (опасно!). Третий параметр true - строгое сравнение. array_search - возвращает ключ найденного значения или false. ⚠️ Классическая ловушка: array_search для первого элемента вернёт ключ 0, а 0 == false → true, поэтому ВСЕГДА сравнивайте через !== false, а не через == false / !$result. Та же проблема у strpos. isset($arr[$key]) - проверяет наличие ключа (но false если значение null). array_key_exists - проверяет ключ даже если значение null. Для МНОЖЕСТВЕННЫХ проверок по одному большому массиву (M проверок по N-элементному массиву внутри цикла) лучше один раз сделать array_flip - получится O(N) на flip + O(1) на каждую проверку = O(N+M) вместо O(N*M) у наивного in_array. Но если проверка ровно одна - in_array($val, $arr, true) дешевле: array_flip аллоцирует целый новый хэш-массив (доп. память O(N) и проход по всему оригиналу). Правило: flip-трюк оправдан только когда множественные lookup-ы в горячем пути; разовая проверка - in_array. С PHP 8.4 для коротких сценариев есть array_any / array_all / array_find / array_find_key - возвращают bool/значение и останавливаются на первом совпадении.',
                'code_example' => '<?php
$users = ["Иван", "Аня", "Петя"];

var_dump(in_array("Аня", $users));      // true
var_dump(in_array("0", $users, true));  // false (строго)

$key = array_search("Иван", $users);    // int(0) - первый элемент!

// ❌ Опасно - 0 == false → true, считаем "не найдено"
if ($key == false) { echo "not found"; } // НЕВЕРНО для первого элемента

// ✅ Правильно - строгое сравнение
if ($key === false) { echo "not found"; }
if (($key = array_search("X", $users)) !== false) { /* нашли */ }

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
                'answer' => 'array_diff возвращает значения первого массива, которых нет в остальных. array_intersect - возвращает значения, присутствующие во всех массивах. ВАЖНО про сравнение: array_diff/array_intersect внутри сравнивают через (string)$a !== (string)$b (а не == и не ===) - это ломается на объектах без __toString и даёт сюрпризы с float. Версии: _key - сравнивают только ключи, _assoc - и ключи, и значения. ОТДЕЛЬНЫХ _strict-вариантов В PHP НЕТ (это часто путают): для кастомного / строгого сравнения используйте callback-варианты array_udiff, array_uintersect, array_udiff_assoc, array_uintersect_uassoc - туда передаётся compare-функция, в которой можно использовать ===, spaceship-оператор или любую свою логику (например, сравнение объектов по equals()).',
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
            [
                'category' => 'PHP',
                'question' => 'Какая алгоритмическая сложность у популярных операций над массивами в PHP?',
                'answer' => 'PHP-массив - это упорядоченная hashtable (HashTable из ext/standard), а не классический индексный массив, как в C. Это даёт ровную картину сложностей. O(1) - амортизированно: array_push / $a[] = (вставка в конец), array_pop, isset($a[$k]), array_key_exists($k, $a), unset($a[$k]) (но не пересчитывает индексы), count() (хранится отдельно). O(N): array_unshift, array_shift - сдвигают все integer-ключи на 1, поэтому линейные; in_array, array_search - линейный поиск по значениям; array_values, array_keys, array_flip, array_merge, array_filter, array_map - проходят весь массив. O(N log N): sort, asort, ksort, usort и компания (quicksort/mergesort внутри). Практический Senior-приём: для частых проверок "есть ли элемент" не используй in_array(O(N)) - сделай array_flip один раз и потом isset (O(1)). Для очереди FIFO с большим N используй SplDoublyLinkedList или SplQueue вместо array_shift - последний O(N) на каждом вызове. Учти расход памяти: PHP-массив тяжёлый (один элемент ~100+ байт из-за hashtable + zval); для больших данных используй SplFixedArray или объекты с типизированными свойствами.',
                'code_example' => '<?php
// ❌ Плохо: O(N²) - линейный поиск внутри цикла
$ids = range(1, 100_000);
$lookup = [42, 7, 99_999];
foreach ($lookup as $id) {
    if (in_array($id, $ids)) { /* O(N) на каждой итерации */ }
}

// ✅ Хорошо: O(N) на flip + O(1) на проверку
$flipped = array_flip($ids); // [1=>0, 2=>1, ...]
foreach ($lookup as $id) {
    if (isset($flipped[$id])) { /* O(1) */ }
}

// ❌ Плохо: O(N²) на разворот через unshift в цикле
$result = [];
foreach ($items as $item) {
    array_unshift($result, $item); // сдвиг всех элементов
}

// ✅ Хорошо: O(N) push + reverse
$result = [];
foreach ($items as $item) {
    $result[] = $item;     // O(1)
}
$result = array_reverse($result); // O(N)

// Очередь FIFO
$q = new SplQueue();
$q->enqueue("a"); $q->dequeue(); // обе O(1), без сдвигов',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'php.arrays',
            ],
            [
                'category' => 'PHP',
                'question' => 'В чём разница между array_slice и array_splice?',
                'answer' => 'Похожие имена - совершенно разное поведение, классический вопрос-ловушка. array_slice($arr, $offset, $length) - ИММУТАБЕЛЕН: возвращает новый массив с куском исходного, оригинал не трогает. По умолчанию пере-индексирует целочисленные ключи (пере-нумерация), строковые сохраняет; чтобы сохранить и числовые - четвёртый аргумент preserve_keys=true. array_splice(&$arr, $offset, $length, $replacement) - МУТИРУЕТ: вырезает из исходного массива указанный кусок (через ссылку), возвращает вырезанные элементы, и опционально вставляет на их место $replacement (массив или одно значение). Целочисленные ключи всегда пере-нумеруются, строковые сохраняются. Удобно для "удалить элемент по индексу", "заменить кусок". Senior-приём: array_splice через ссылку - редкий случай, когда стандартная функция мутирует аргумент; легко не заметить, что массив изменился. Для иммутабельного "удалить элемент" используй array_diff_key + array_values или array_filter.',
                'code_example' => '<?php
$arr = [10, 20, 30, 40, 50];

// array_slice - копия
$piece = array_slice($arr, 1, 2);
// $piece = [20, 30]
// $arr   = [10, 20, 30, 40, 50] - не изменился

// array_splice - мутирует, возвращает вырезанное
$cut = array_splice($arr, 1, 2);
// $cut = [20, 30]
// $arr = [10, 40, 50] - элементы удалены, ключи пере-нумерованы

// array_splice + замена
$arr = [10, 20, 30, 40, 50];
array_splice($arr, 1, 2, ["a", "b", "c"]);
// $arr = [10, "a", "b", "c", 40, 50]

// preserve_keys для slice
$assoc = ["x" => 1, 5 => "z", "y" => 2];
print_r(array_slice($assoc, 1, 2));
// ["x"=>... убрано, числовой ключ пере-нумерован]
print_r(array_slice($assoc, 1, 2, preserve_keys: true));
// числовые ключи сохранены

// "Удалить элемент по индексу" - частый use case
unset($arr[2]);                    // оставит "дыру" в индексах [0,1,3,4]
array_splice($arr, 2, 1);          // переиндексирует, удалит элемент
$arr = array_values(array_filter($arr, fn($_, $i) => $i !== 2,
                                  ARRAY_FILTER_USE_BOTH)); // immutable',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'php.arrays',
            ],
        ];
    }
}
