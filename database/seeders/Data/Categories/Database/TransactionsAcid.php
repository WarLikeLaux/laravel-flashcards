<?php

namespace Database\Seeders\Data\Categories\Database;

class TransactionsAcid
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Базы данных',
                'question' => 'Что такое транзакция?',
                'answer' => 'Транзакция - это группа операций над БД, выполняющаяся как единое целое: либо все операции применяются, либо ни одна (откат). Управляется командами BEGIN/START TRANSACTION, COMMIT, ROLLBACK. Классический пример: перевод денег - надо снять с одного счёта и зачислить на другой; если упадёт между, без транзакции деньги исчезнут.',
                'code_example' => <<<'SQL'
BEGIN;

UPDATE accounts SET balance = balance - 100 WHERE id = 1;
UPDATE accounts SET balance = balance + 100 WHERE id = 2;

-- Если всё ок:
COMMIT;
-- Если ошибка:
-- ROLLBACK;
SQL,
                'code_language' => 'sql',
                'difficulty' => 2,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое ACID?',
                'answer' => 'ACID - набор свойств транзакций: Atomicity (атомарность), Consistency (согласованность), Isolation (изолированность), Durability (долговечность). Обеспечивает, что транзакции выполняются надёжно. Реляционные БД (PostgreSQL, MySQL/InnoDB) гарантируют ACID, многие NoSQL - нет.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'A в ACID - что такое Atomicity (атомарность)?',
                'answer' => 'Атомарность означает: транзакция выполняется целиком или не выполняется вообще. Промежуточных состояний нет. Если в середине что-то падает, БД откатывает все уже сделанные изменения транзакции. Простыми словами: всё или ничего, как нажатие одной кнопки.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'C в ACID - что такое Consistency (согласованность)?',
                'answer' => 'Согласованность: транзакция переводит БД из одного валидного состояния в другое валидное. Все ограничения (PK, FK, CHECK, NOT NULL, UNIQUE) соблюдаются. Если транзакция нарушит ограничение, она откатится. Это про целостность данных, а не про сохранность.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'I в ACID - что такое Isolation (изолированность)?',
                'answer' => 'Изолированность: параллельные транзакции не "мешают" друг другу - результат как будто они выполняются последовательно. Степень изоляции настраивается уровнями (READ COMMITTED, REPEATABLE READ, SERIALIZABLE). Чем строже - тем безопаснее, но медленнее.',
                'code_example' => <<<'SQL'
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;
BEGIN;
-- ...
COMMIT;
SQL,
                'code_language' => 'sql',
                'difficulty' => 3,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'D в ACID - что такое Durability (долговечность)?',
                'answer' => 'Долговечность: после COMMIT изменения сохранены навсегда, даже если сервер сразу упадёт. БД пишет изменения в журнал (WAL/redo log) на диск перед подтверждением. Простыми словами: COMMIT прошёл - значит, данные точно не пропадут.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Какие бывают уровни изоляции транзакций?',
                'answer' => '4 стандартных уровня по SQL и аномалии, которые они допускают: READ UNCOMMITTED - dirty/non-repeatable/phantom; READ COMMITTED - non-repeatable/phantom; REPEATABLE READ - phantom (по стандарту); SERIALIZABLE - ничего. Особенности: PostgreSQL не реализует READ UNCOMMITTED (минимум READ COMMITTED), а в его REPEATABLE READ (snapshot isolation) фантомы тоже не возникают, но возможен write skew. InnoDB на REPEATABLE READ блокирует фантомы через gap-locks. SERIALIZABLE в PG реализован через SSI (Serializable Snapshot Isolation) и может откатывать транзакции с ошибкой serialization_failure.',
                'code_example' => <<<'SQL'
-- Таблица аномалий по стандарту SQL
-- Уровень           | Dirty | NonRepeat | Phantom
-- READ UNCOMMITTED  |   +   |    +      |    +
-- READ COMMITTED    |   -   |    +      |    +
-- REPEATABLE READ   |   -   |    -      |    +
-- SERIALIZABLE      |   -   |    -      |    -
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;
SQL,
                'code_language' => 'sql',
                'difficulty' => 4,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Lost Update (потерянное обновление)?',
                'answer' => 'Lost Update - аномалия, когда две транзакции читают одно значение, обе модифицируют и пишут, и обновление одной перезаписывает другое - изменение "теряется". Пример: T1 и T2 читают balance=100, T1 пишет 90 (-10), T2 пишет 80 (-20), вместо ожидаемых 70. Защита: SERIALIZABLE; SELECT FOR UPDATE перед UPDATE; атомарный UPDATE с выражением (UPDATE accounts SET balance = balance - 10); оптимистическая блокировка через version-столбец.',
                'code_example' => <<<'SQL'
-- Атомарное обновление - безопасно
UPDATE accounts SET balance = balance - 10 WHERE id = 1;

-- Оптимистическая блокировка
UPDATE products
SET price = 99, version = version + 1
WHERE id = 1 AND version = 5;
-- если 0 строк изменено - кто-то опередил, ретраим
SQL,
                'code_language' => 'sql',
                'difficulty' => 4,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Dirty Read (грязное чтение)?',
                'answer' => 'Грязное чтение - транзакция читает данные, изменённые другой ещё незакоммиченной транзакцией. Если та откатится - мы прочитали "несуществующие" данные. Случается на уровне READ UNCOMMITTED. PostgreSQL вообще не допускает грязного чтения, минимальный уровень - READ COMMITTED.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Non-repeatable Read?',
                'answer' => 'Неповторяемое чтение - в рамках одной транзакции мы читаем строку дважды и получаем разные значения, потому что между чтениями другая транзакция её обновила и закоммитила. Случается на READ COMMITTED. Решается уровнем REPEATABLE READ или выше.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Phantom Read (фантомное чтение)?',
                'answer' => 'Фантомное чтение - в одной транзакции мы выполняем один и тот же запрос (SELECT WHERE) дважды и получаем разное количество строк, потому что другая транзакция вставила/удалила подходящие. Решается уровнем SERIALIZABLE. В PostgreSQL REPEATABLE READ уже защищает от фантомов (snapshot-уровень).',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Write Skew?',
                'answer' => 'Write Skew - аномалия, когда две транзакции читают одни и те же данные, принимают решения, и пишут разные строки, нарушая бизнес-инвариант. Пример: правило "хотя бы один врач на смене", обе транзакции читают, видят что есть двое, и обе уходят с дежурства. Решается на уровне SERIALIZABLE или явными блокировками SELECT FOR UPDATE.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 5,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое блокировки (locks)?',
                'answer' => 'Блокировки - механизм, который не даёт нескольким транзакциям одновременно изменять одни и те же данные. Бывают: shared (S, разделяемая) - для чтения, exclusive (X) - для записи. Гранулярность: row-level (на строку), table-level (на таблицу), page-level. Также бывают advisory (явные пользовательские блокировки по ключу).',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Чем отличаются shared lock и exclusive lock?',
                'answer' => 'Shared (S) - "читать можно, писать нельзя". Несколько транзакций могут одновременно держать S на одной строке. Exclusive (X) - блокирует другие S и X на этом ресурсе, захватывается при UPDATE/DELETE. Важный нюанс: в PostgreSQL и других MVCC-СУБД row-level X-lock НЕ блокирует обычные SELECT (читатели видят прежний снапшот) - блокируются только UPDATE/DELETE/SELECT FOR UPDATE/SHARE. S и X между собой несовместимы. Это базовая модель совместимости блокировок.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что делает SELECT FOR UPDATE?',
                'answer' => 'SELECT FOR UPDATE захватывает exclusive-блокировку на выбранные строки до конца транзакции. Другие транзакции, пытающиеся обновить или взять FOR UPDATE те же строки, будут ждать. Используется, когда мы прочитали данные и собираемся обновить, и не хотим, чтобы кто-то изменил их между.',
                'code_example' => <<<'SQL'
BEGIN;
SELECT * FROM accounts WHERE id = 1 FOR UPDATE;
-- никто другой не может изменить эту строку
UPDATE accounts SET balance = balance - 100 WHERE id = 1;
COMMIT;
SQL,
                'code_language' => 'sql',
                'difficulty' => 3,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что делает SELECT FOR SHARE?',
                'answer' => 'SELECT FOR SHARE (или FOR SHARE / LOCK IN SHARE MODE в MySQL) берёт shared-lock на строки. Другие транзакции могут читать (тоже FOR SHARE), но не могут изменять, пока наша транзакция не завершится. Полезно, когда мы хотим гарантировать, что данные не изменятся, пока мы их используем (например, для проверки FK вручную).',
                'code_example' => <<<'SQL'
BEGIN;
SELECT * FROM products WHERE id = 1 FOR SHARE;
-- другие могут читать, но не апдейтить
COMMIT;
SQL,
                'code_language' => 'sql',
                'difficulty' => 3,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое advisory lock?',
                'answer' => 'Advisory lock (рекомендательная блокировка) - блокировка по произвольному ключу (числу), не привязана к строкам. БД не использует её для своей логики - её смысл задаёт приложение. Удобно для распределённых cron-задач, очередей, координации между процессами. В PostgreSQL: pg_advisory_lock(key).',
                'code_example' => <<<'SQL'
-- Заблокировать "что-то" с ключом 42
SELECT pg_advisory_lock(42);
-- ... критическая секция ...
SELECT pg_advisory_unlock(42);

-- Транзакционный вариант, отпустится сам
SELECT pg_advisory_xact_lock(42);
SQL,
                'code_language' => 'sql',
                'difficulty' => 4,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Deadlock и как его избегать?',
                'answer' => 'Deadlock (взаимная блокировка) - ситуация, когда транзакция A ждёт ресурс, удерживаемый B, а B ждёт ресурс, удерживаемый A. БД сама обнаруживает deadlock и убивает одну из транзакций (откатывая её). Простыми словами: два человека пытаются разойтись в узком коридоре и не могут. Как избегать: всегда захватывать блокировки в одинаковом порядке, держать транзакции короткими, использовать SELECT FOR UPDATE NOWAIT/SKIP LOCKED, ретраить откатанные транзакции.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое MVCC простыми словами?',
                'answer' => 'MVCC (Multi-Version Concurrency Control) - механизм, при котором при изменении строки в таблице создаётся её новая версия, а старая ещё какое-то время живёт для других транзакций. Простыми словами: вместо того чтобы переписывать строку поверх, БД оставляет старый вариант для тех, кто уже начал читать. Поэтому "читатели не блокируют писателей и наоборот". PostgreSQL и Oracle используют MVCC. Минус: накапливаются мёртвые версии (bloat), нужен VACUUM.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'database.transactions_acid',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Чем отличаются пессимистичные (FOR UPDATE) и оптимистичные блокировки? Когда какую применять?',
                'answer' => 'Пессимистичная блокировка - "сначала запрещаю, потом меняю": SELECT ... FOR UPDATE ставит row-level X-lock на строки, и другие транзакции, попытавшиеся их прочитать с FOR UPDATE/UPDATE/DELETE, будут ждать (или упадут с lock timeout). Гарантирует отсутствие конфликта, но снижает concurrency и может привести к взаимоблокировкам (deadlock). Оптимистичная блокировка - "сначала меняю, на коммите проверяю": в таблицу добавляется поле version (или updated_at), при UPDATE сравнивается с прочитанной ранее версией; если кто-то успел изменить - 0 affected rows и приложение перезапускает операцию или показывает пользователю конфликт. Никаких блокировок в БД, высокий throughput, но при частых конфликтах теряется работа. Когда что использовать: PESSIMISTIC - короткие критические секции с высокой вероятностью конфликта (списание со счёта, резерв билета, инкремент счётчика); требуется явная транзакция, держать lock как можно меньше. OPTIMISTIC - длительные пользовательские операции (редактирование документа в форме, "вы открыли страницу 10 минут назад"), низкая вероятность одновременного изменения, нельзя удерживать транзакцию через сетевой round-trip. В Laravel: pessimistic - lockForUpdate() / sharedLock(); optimistic - вручную через колонку version и WHERE version = ? в UPDATE.',
                'code_example' => '<?php
// PESSIMISTIC - Laravel
DB::transaction(function () use ($userId, $amount) {
    $account = Account::where("user_id", $userId)
        ->lockForUpdate() // SELECT ... FOR UPDATE
        ->firstOrFail();

    if ($account->balance < $amount) {
        throw new InsufficientFundsException;
    }

    $account->decrement("balance", $amount);
});

// OPTIMISTIC - вручную через version
$post = Post::find($id); // version = 5
$post->title = "new";

$updated = Post::where("id", $id)
    ->where("version", $post->version)
    ->update([
        "title" => $post->title,
        "version" => $post->version + 1,
    ]);

if ($updated === 0) {
    throw new ConcurrentModificationException("Кто-то уже изменил пост");
}

// Альтернатива OPTIMISTIC - атомарное условие в SQL
DB::update("UPDATE accounts SET balance = balance - ?
            WHERE user_id = ? AND balance >= ?", [$amount, $userId, $amount]);',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'database.transactions_acid',
            ],
        ];
    }
}
