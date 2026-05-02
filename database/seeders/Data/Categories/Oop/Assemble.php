<?php

namespace Database\Seeders\Data\Categories\Oop;

class Assemble
{
    public static function all(): array
    {
        return [
            [
                'category' => 'ООП',
                'topic' => 'oop.assemble',
                'difficulty' => 2,
                'question' => 'Собери класс с конструктором и приватным свойством.',
                'answer' => 'Constructor property promotion (PHP 8) объявляет и инициализирует свойство одной строкой.',
                'assemble_chunks' => [
                    'final class OrderTotal {',
                    '    public function __construct(',
                    '        private readonly Money $amount,',
                    '    ) {}',
                    '}',
                ],
            ],
        ];
    }
}
