<?php

namespace Database\Seeders\Data\Categories\Database;

class Assemble
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, assemble_chunks?: array<int, string>, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Базы данных',
                'question' => 'Собери SQL: 5 самых дорогих заказов с email клиента.',
                'answer' => 'JOIN по внешнему ключу + ORDER BY DESC + LIMIT.',
                'assemble_chunks' => [
                    'SELECT o.id, o.total, u.email',
                    "\nFROM orders o",
                    "\nJOIN users u ON u.id = o.user_id",
                    "\nORDER BY o.total DESC",
                    "\nLIMIT 5",
                    ';',
                ],
                'code_language' => 'sql',
                'difficulty' => 2,
                'topic' => 'database.assemble',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Собери UPDATE с подзапросом на максимум.',
                'answer' => 'Можно использовать коррелированный подзапрос или CTE для денормализованного поля.',
                'assemble_chunks' => [
                    'UPDATE users u',
                    "\nSET last_order_at = (SELECT MAX(created_at) FROM orders o WHERE o.user_id = u.id)",
                    "\nWHERE EXISTS (SELECT 1 FROM orders o WHERE o.user_id = u.id)",
                    ';',
                ],
                'code_language' => 'sql',
                'difficulty' => 3,
                'topic' => 'database.assemble',
            ],
        ];
    }
}
