<?php

namespace Database\Seeders\Data\Categories\Php;

class Generators
{
    public static function all(): array
    {
        return [
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
                'difficulty' => 4,
                'topic' => 'php.generators',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что делает yield from и как получить return-значение из генератора через getReturn()?',
                'answer' => 'yield from делегирует итерацию другому iterable (генератору, массиву, Traversable): родительский генератор пробрасывает все значения дочернего, как будто это его собственные. Главный нюанс - yield from возвращает результат вложенного генератора. Если внутри generator-функции есть return $value (без операнда тоже допустимо), то это НЕ обычный return массива (генератор всегда возвращает Generator-объект), а финальное значение, доступное через $generator->getReturn() ПОСЛЕ окончания итерации. Это позволяет писать рекурсивные генераторы, которые накапливают результат, и компонуемые корутины. Если вызвать getReturn() до завершения генератора - Exception. Если генератор не вернул значения через return - вернётся null.',
                'code_example' => '<?php
// Вложенный генератор + getReturn
function inner(): Generator
{
    yield 1;
    yield 2;
    return "done"; // финальное значение
}

function outer(): Generator
{
    yield 0;
    $result = yield from inner(); // 1, 2 пробрасываются наружу
    yield "inner result: $result";
}

foreach (outer() as $v) echo $v . " "; // 0 1 2 inner result: done

// getReturn после завершения
$gen = inner();
foreach ($gen as $v) { /* итерируем до конца */ }
echo $gen->getReturn(); // "done"

// Рекурсивный обход дерева
function walk(array $node): Generator
{
    yield $node["name"];
    foreach ($node["children"] ?? [] as $child) {
        yield from walk($child);
    }
}

// Корутина-аккумулятор
function sum(): Generator
{
    $total = 0;
    while (($x = yield) !== null) $total += $x;
    return $total;
}

$g = sum();
$g->current(); // запуск
$g->send(10);
$g->send(20);
$g->send(null); // завершить
echo $g->getReturn(); // 30',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'php.generators',
            ],
        ];
    }
}
