<?php

namespace Database\Seeders\Data\Categories\Database;

class BasicQa
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Базы данных',
                'question' => 'Что такое индекс и когда он не помогает?',
                'answer' => 'Структура для ускорения поиска по столбцам. Не помогает на маленьких таблицах, при низкой селективности, при функциях/преобразованиях столбца, при LIKE %x%.',
                'difficulty' => 3,
                'topic' => 'database.basic_qa',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Чем отличается INNER JOIN от LEFT JOIN?',
                'answer' => 'INNER возвращает только пары, удовлетворяющие условию. LEFT возвращает все строки слева плюс совпадения справа, отсутствующие справа заполняются NULL.',
                'difficulty' => 2,
                'topic' => 'database.basic_qa',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое нормальные формы и зачем нормализация?',
                'answer' => 'Правила декомпозиции таблиц для устранения избыточности и аномалий. 1НФ - атомарность, 2НФ - зависимость от полного ключа, 3НФ - отсутствие транзитивных зависимостей.',
                'difficulty' => 3,
                'topic' => 'database.basic_qa',
            ],
        ];
    }
}
