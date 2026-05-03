<?php

namespace Database\Seeders\Data\Categories\Database;

class Mysql
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Базы данных',
                'question' => 'InnoDB vs MyISAM в MySQL?',
                'answer' => 'InnoDB - современный движок MySQL по умолчанию. Поддерживает: транзакции (ACID), foreign keys, row-level locks, crash recovery, MVCC. MyISAM - старый движок: только table-level locks, нет транзакций и FK, но быстрее на простых SELECT-only нагрузках и full-text. На практике почти всегда используют InnoDB. MyISAM считается устаревшим.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'database.mysql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Clustered index в InnoDB?',
                'answer' => 'В InnoDB строки физически хранятся в порядке primary key - это и есть кластерный индекс. Поэтому PK lookup очень быстрый - данные сразу с ним. Все остальные (вторичные) индексы хранят PK как ссылку на строку. Следствия: PK должен быть коротким (он повторяется в каждом вторичном индексе), последовательный PK даёт лучшую локальность записи.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'database.mysql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Как выбрать storage engine в MySQL?',
                'answer' => 'В 99% случаев - InnoDB (он по умолчанию). Используй MyISAM только для ныне редких юзкейсов "много чтения, нет записи". Memory (HEAP) - для временных in-memory таблиц. Archive - для архивных данных только на чтение/append. NDB - для кластерного MySQL Cluster.',
                'code_example' => <<<'SQL'
CREATE TABLE users (
    id INT PRIMARY KEY,
    name VARCHAR(100)
) ENGINE = InnoDB;
SQL,
                'code_language' => 'sql',
                'difficulty' => 3,
                'topic' => 'database.mysql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'REPEATABLE READ в InnoDB и gap locks?',
                'answer' => 'В стандарте SQL уровень REPEATABLE READ защищает от non-repeatable read, но не от phantoms. В InnoDB на REPEATABLE READ механизм ДВОЙНОЙ и зависит от типа чтения. (1) Для CONSISTENT READS (обычный SELECT без FOR UPDATE / LOCK IN SHARE MODE) phantom-ы исключены за счёт MVCC-снимка: транзакция читает на момент первого SELECT, новые строки от других транзакций для неё просто не существуют - блокировки тут ни при чём. (2) Для LOCKING READS (SELECT ... FOR UPDATE / LOCK IN SHARE MODE, UPDATE/DELETE по диапазону) включаются next-key и gap locks - блокировки на "промежутках" между значениями индекса. SELECT * FROM t WHERE x BETWEEN 5 AND 10 FOR UPDATE заблокирует не только существующие строки, но и пустые промежутки - вторая транзакция не сможет вставить x=7. Это и предотвращает фантомы для locking reads. ВАЖНО: gap locks - частая причина неожиданных deadlock-ов под нагрузкой; на READ COMMITTED InnoDB их отключает (только row locks), но тогда фантомы возможны и для locking reads тоже. Уникальная особенность InnoDB - именно сочетание MVCC + gap locks на одном уровне изоляции.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 5,
                'topic' => 'database.mysql',
            ],
        ];
    }
}
