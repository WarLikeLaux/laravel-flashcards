<?php

namespace Database\Seeders\Data\Categories\Php;

class Assemble
{
    public static function all(): array
    {
        return [
            [
                'category' => 'PHP',
                'question' => 'Собери цепочку Collection: уникальные emails из активных юзеров.',
                'answer' => 'Coллекции - fluent. filter, pluck, unique, values образуют ленивую цепочку (на eager при collect).',
                'assemble_chunks' => [
                    'collect($users)',
                    '->',
                    'filter(fn($u) => $u->active)',
                    '->',
                    "pluck('email')",
                    '->',
                    'unique()',
                    '->',
                    'values()',
                    '->',
                    'all()',
                ],
                'difficulty' => 3,
                'topic' => 'php.assemble',
            ],
            [
                'category' => 'PHP',
                'question' => 'Собери try/catch для нескольких типов исключений.',
                'answer' => 'Multi-catch (PHP 8.0): TypeA|TypeB $e - общий блок для нескольких типов.',
                'assemble_chunks' => [
                    'try {',
                    '    $client->send($request);',
                    '} catch (',
                    'NetworkException ',
                    '| ',
                    'TimeoutException ',
                    '$e) {',
                    '    report($e);',
                    '}',
                ],
                'difficulty' => 3,
                'topic' => 'php.assemble',
            ],
        ];
    }
}
