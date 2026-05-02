<?php

namespace Database\Seeders\Data\Categories\Php;

class Regex
{
    public static function all(): array
    {
        return [
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
                'difficulty' => 3,
                'topic' => 'php.regex',
            ],
        ];
    }
}
