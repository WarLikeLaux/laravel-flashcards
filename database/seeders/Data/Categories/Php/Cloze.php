<?php

namespace Database\Seeders\Data\Categories\Php;

class Cloze
{
    public static function all(): array
    {
        return [
            [
                'category' => 'PHP',
                'question' => 'Заполни сигнатуру readonly value-object Money с конструктором.',
                'answer' => 'final readonly class фиксирует иммутабельность всех нестатических свойств. Promoted parameters позволяют объявить и инициализировать поля одной строкой.',
                'cloze_text' => 'final {{readonly}} class Money {
    public function __construct(
        public {{int}} $amount,
        public string $currency,
    ) {}
}',
                'difficulty' => 3,
                'topic' => 'php.cloze',
            ],
            [
                'category' => 'PHP',
                'question' => 'Заполни match-выражение для типов HTTP-методов.',
                'answer' => 'match сравнивает строго через === и обязан покрывать все ветки, иначе бросит UnhandledMatchError.',
                'cloze_text' => '$cmd = {{match}}($method) {
    "GET", "HEAD" => "read",
    "POST", "PUT", "PATCH" => "write",
    "DELETE" => "delete",
    {{default}} => throw new InvalidArgumentException(),
};',
                'difficulty' => 3,
                'topic' => 'php.cloze',
            ],
            [
                'category' => 'PHP',
                'question' => 'Заполни generator для чтения большого CSV.',
                'answer' => 'yield делает функцию ленивым итератором: на каждой итерации читается одна строка, а не весь файл целиком.',
                'cloze_text' => 'function readCsv(string $path): {{Generator}} {
    $h = fopen($path, "r");
    while (($row = fgetcsv($h)) !== false) {
        {{yield}} $row;
    }
    fclose($h);
}',
                'difficulty' => 3,
                'topic' => 'php.cloze',
            ],
        ];
    }
}
