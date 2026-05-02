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
        ];
    }
}
