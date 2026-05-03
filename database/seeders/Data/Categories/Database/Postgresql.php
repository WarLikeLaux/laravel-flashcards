<?php

namespace Database\Seeders\Data\Categories\Database;

class Postgresql
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Базы данных',
                'question' => 'Чем PostgreSQL отличается от MySQL?',
                'answer' => 'PostgreSQL - объектно-реляционная СУБД с упором на стандарт SQL и расширяемость. Преимущества: продвинутые типы (jsonb, arrays, range, hstore, geo), CTE (включая рекурсивные), оконные функции с самого начала, partial/expression индексы, MVCC. MySQL - проще, исторически быстрее на простых OLTP, но в InnoDB меньше возможностей. PostgreSQL чаще выбирают для сложных приложений, MySQL - для веб (LAMP).',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'database.postgresql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'jsonb vs json в PostgreSQL?',
                'answer' => 'json - хранит JSON как текст, сохраняя пробелы и порядок ключей. Парсится при каждом обращении. jsonb - бинарный формат, преобразуется при вставке. Минус: чуть медленнее запись, есть преобразование. Плюсы: быстрее операции, поддержка GIN-индекса, операторы @>, ?, #>>. На практике: используй jsonb всегда, если не нужно сохранить сырое представление.',
                'code_example' => <<<'SQL'
CREATE TABLE events (id BIGSERIAL PRIMARY KEY, data JSONB);

CREATE INDEX idx_events_data ON events USING gin(data);

SELECT * FROM events WHERE data @> '{"type": "click"}';
SELECT data->>'user_id' FROM events;
SQL,
                'code_language' => 'sql',
                'difficulty' => 3,
                'topic' => 'database.postgresql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое массивы (arrays) в PostgreSQL?',
                'answer' => 'PostgreSQL поддерживает массивы любых типов как нативные значения столбцов. Можно хранить, индексировать (GIN), искать. Полезно для тегов, ролей и т.п. без отдельной таблицы. Однако, если связи нужно расширять или фильтровать сложно, лучше нормализованная таблица.',
                'code_example' => <<<'SQL'
CREATE TABLE posts (
    id BIGSERIAL PRIMARY KEY,
    title TEXT,
    tags TEXT[]
);

INSERT INTO posts (title, tags) VALUES ('Hello', ARRAY['php', 'laravel', 'sql']);

SELECT * FROM posts WHERE 'php' = ANY(tags);
SELECT * FROM posts WHERE tags @> ARRAY['laravel'];

CREATE INDEX idx_posts_tags ON posts USING gin(tags);
SQL,
                'code_language' => 'sql',
                'difficulty' => 3,
                'topic' => 'database.postgresql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое VACUUM, autovacuum и bloat?',
                'answer' => 'В PostgreSQL из-за MVCC при UPDATE/DELETE строки не удаляются физически, а помечаются - получаются "мёртвые" версии (dead tuples). VACUUM очищает их, освобождая место в страницах. Autovacuum - демон, который запускает VACUUM автоматически по порогам. Bloat - распухание таблицы/индекса от мёртвых версий, замедляет всё. Простыми словами: VACUUM - это уборщик, который выкидывает мусор; bloat - это гора мусора, которая копится, если уборщик не справляется.',
                'code_example' => <<<'SQL'
-- Ручной запуск
VACUUM users;
VACUUM ANALYZE users;       -- + обновить статистику
VACUUM FULL users;          -- агрессивный, переписывает таблицу (lock!)

-- Посмотреть мёртвые строки
SELECT relname, n_dead_tup FROM pg_stat_user_tables;
SQL,
                'code_language' => 'sql',
                'difficulty' => 4,
                'topic' => 'database.postgresql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Materialized View?',
                'answer' => 'Materialized View - это представление, чей результат физически сохранён на диске, в отличие от обычного VIEW (вычисляется при каждом обращении). Полезно для тяжёлых аналитических запросов: считаешь раз - читаешь много раз быстро. Минус: данные могут устареть, нужно обновлять вручную (REFRESH).',
                'code_example' => <<<'SQL'
CREATE MATERIALIZED VIEW daily_sales AS
SELECT DATE(created_at) AS day, SUM(amount) AS total
FROM orders
GROUP BY DATE(created_at);

CREATE INDEX ON daily_sales(day);

-- Обновление данных
REFRESH MATERIALIZED VIEW daily_sales;
REFRESH MATERIALIZED VIEW CONCURRENTLY daily_sales;  -- без локa
SQL,
                'code_language' => 'sql',
                'difficulty' => 3,
                'topic' => 'database.postgresql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое оконные функции (window functions)?',
                'answer' => 'Оконные функции - вычисления над набором строк "окна", связанных с текущей, БЕЗ группировки. В отличие от GROUP BY, не схлопывают строки. Используются с OVER(...). Самые популярные: ROW_NUMBER, RANK, DENSE_RANK, LAG, LEAD, SUM/AVG OVER. Можно делить на группы через PARTITION BY и сортировать через ORDER BY.',
                'code_example' => <<<'SQL'
-- Топ-3 заказа в каждом городе
SELECT *
FROM (
    SELECT
        city,
        user_id,
        amount,
        ROW_NUMBER() OVER (PARTITION BY city ORDER BY amount DESC) AS rn
    FROM orders
) t
WHERE rn <= 3;

-- Скользящая сумма
SELECT
    day,
    sales,
    SUM(sales) OVER (ORDER BY day ROWS BETWEEN 6 PRECEDING AND CURRENT ROW) AS rolling_7d
FROM daily_sales;
SQL,
                'code_language' => 'sql',
                'difficulty' => 4,
                'topic' => 'database.postgresql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Чем отличаются ROW_NUMBER, RANK, DENSE_RANK?',
                'answer' => 'Все нумеруют строки по сортировке внутри окна. ROW_NUMBER - всегда уникальные номера 1, 2, 3, 4 (даже при равных значениях). RANK - при равных значениях даёт одинаковый ранг и пропускает: 1, 2, 2, 4. DENSE_RANK - даёт одинаковый ранг, но не пропускает: 1, 2, 2, 3.',
                'code_example' => <<<'SQL'
SELECT
    name,
    salary,
    ROW_NUMBER() OVER (ORDER BY salary DESC) AS rn,
    RANK() OVER (ORDER BY salary DESC) AS rnk,
    DENSE_RANK() OVER (ORDER BY salary DESC) AS dense_rnk
FROM employees;
SQL,
                'code_language' => 'sql',
                'difficulty' => 4,
                'topic' => 'database.postgresql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что делают LAG и LEAD?',
                'answer' => 'LAG(col, n) возвращает значение col в строке на n позиций РАНЬШЕ (по ORDER BY окна). LEAD - на n позиций ПОЗЖЕ. Полезны для сравнения с предыдущей/следующей строкой - например, рассчитать дельту продаж по дням.',
                'code_example' => <<<'SQL'
SELECT
    day,
    sales,
    LAG(sales) OVER (ORDER BY day) AS prev_day,
    sales - LAG(sales) OVER (ORDER BY day) AS delta
FROM daily_sales;
SQL,
                'code_language' => 'sql',
                'difficulty' => 4,
                'topic' => 'database.postgresql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое GROUPING SETS, ROLLUP, CUBE?',
                'answer' => 'Расширения GROUP BY для агрегации по нескольким уровням за один запрос. GROUPING SETS - явные комбинации группировки. ROLLUP(a, b) - иерархические подытоги: (a,b), (a), (). CUBE(a, b) - все комбинации: (a,b), (a), (b), (). Часто используется в OLAP/аналитике.',
                'code_example' => <<<'SQL'
-- Подытоги по году, месяцу и общий
SELECT year, month, SUM(amount)
FROM sales
GROUP BY ROLLUP (year, month);

-- Все комбинации измерений
SELECT country, product, SUM(amount)
FROM sales
GROUP BY CUBE (country, product);
SQL,
                'code_language' => 'sql',
                'difficulty' => 4,
                'topic' => 'database.postgresql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое репликация в PostgreSQL: streaming vs logical?',
                'answer' => 'Streaming replication - физическая репликация, реплика побайтово копирует WAL-журнал мастера. Точная копия. Используется для отказоустойчивости и read-replicas. Logical replication - логическая, реплицируются изменения по таблицам через publication/subscription. Можно реплицировать выборочно (только нужные таблицы), между разными мажорными версиями, делать преобразования.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 5,
                'topic' => 'database.postgresql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Full-Text Search в PostgreSQL?',
                'answer' => 'Full-text search в PG - встроенный полнотекстовый поиск через типы tsvector (предобработанный документ) и tsquery (запрос). Поддерживает стемминг (приведение слов к основе), стоп-слова, ранжирование, разные языки. Индексируется через GIN. Для базовых задач хватает; для сложного - ElasticSearch.',
                'code_example' => <<<'SQL'
SELECT * FROM articles
WHERE to_tsvector('russian', body) @@ to_tsquery('russian', 'лошадь & белая');

CREATE INDEX idx_articles_tsv
ON articles USING gin(to_tsvector('russian', body));

-- С ранжированием
SELECT title, ts_rank(to_tsvector('russian', body), q) AS rank
FROM articles, to_tsquery('russian', 'лошадь') q
WHERE to_tsvector('russian', body) @@ q
ORDER BY rank DESC;
SQL,
                'code_language' => 'sql',
                'difficulty' => 4,
                'topic' => 'database.postgresql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Как искать медленные запросы в PostgreSQL без APM? Что такое pg_stat_statements?',
                'answer' => 'pg_stat_statements - стандартное расширение PostgreSQL, накапливающее агрегированную статистику по нормализованным запросам (литералы заменяются на $1, $2 - запросы с разными значениями группируются вместе). Для каждого запроса хранит: число вызовов (calls), общее и среднее время (total_exec_time, mean_exec_time), число прочитанных/записанных строк (rows), shared/local block hits/reads (попадания/промахи в shared buffers), стандартное отклонение времени (stddev_exec_time). Это позволяет в проде найти "топ-10 запросов по суммарному времени" - именно они дают основную нагрузку, даже если каждый отдельный запрос быстрый. Включается через shared_preload_libraries = pg_stat_statements в postgresql.conf + CREATE EXTENSION. Сброс статистики - SELECT pg_stat_statements_reset(). Альтернативы и дополнения: 1) auto_explain - логирует EXPLAIN ANALYZE для запросов дольше N мс. 2) pg_stat_activity - текущие выполняющиеся запросы, поиск висящих транзакций (state="idle in transaction" - типичная проблема). 3) log_min_duration_statement в postgresql.conf - пишет в лог запросы дольше порога. Связка pg_stat_statements + auto_explain даёт почти полноценный self-hosted APM для PG.',
                'code_example' => '-- Установка
-- 1) postgresql.conf:
--    shared_preload_libraries = \'pg_stat_statements\'
--    pg_stat_statements.track = all
-- 2) рестарт PG
-- 3) CREATE EXTENSION pg_stat_statements;

-- Топ-10 запросов по суммарному времени
SELECT
    query,
    calls,
    round(total_exec_time::numeric, 2)         AS total_ms,
    round(mean_exec_time::numeric, 2)          AS mean_ms,
    round((total_exec_time/sum(total_exec_time) OVER ())::numeric * 100, 2) AS pct,
    rows
FROM pg_stat_statements
ORDER BY total_exec_time DESC
LIMIT 10;

-- Запросы с самым большим разбросом времени (нестабильные)
SELECT query, calls, mean_exec_time, stddev_exec_time
FROM pg_stat_statements
WHERE calls > 100
ORDER BY stddev_exec_time DESC
LIMIT 10;

-- Найти зависшие транзакции
SELECT pid, state, age(now(), xact_start) AS age, query
FROM pg_stat_activity
WHERE state = \'idle in transaction\'
ORDER BY age DESC;

-- Сброс статистики
SELECT pg_stat_statements_reset();',
                'code_language' => 'sql',
                'difficulty' => 4,
                'topic' => 'database.postgresql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Почему в PgBouncer transaction pooling ломаются Prepared Statements в Laravel/PDO и как это починить?',
                'answer' => 'PgBouncer - популярный пулер соединений для Postgres. Имеет три режима. Session pooling: одна клиентская сессия = одно физическое соединение на всё время до отключения клиента (поведение как без pooler). Transaction pooling (самый распространённый в проде): физическое соединение выдаётся клиенту только на ВРЕМЯ ОДНОЙ ТРАНЗАКЦИИ, после COMMIT/ROLLBACK возвращается в пул и может быть отдано другому клиенту. Statement pooling: ещё агрессивнее, на одну statement. ПРОБЛЕМА: Prepared Statements (PG-команды PREPARE name AS ... + EXECUTE name) - это server-side объект, привязанный к ФИЗИЧЕСКОМУ соединению. PDO в эмулирующем режиме делает PREPARE при первом вызове $stmt = $pdo->prepare() и кеширует имя; при последующих вызовах шлёт EXECUTE. В transaction pooling между PREPARE и EXECUTE PgBouncer может выдать соединение другому клиенту, и при возврате - на этом соединении уже не будет нашего PREPARE, выскочит "prepared statement does not exist". В Laravel это ловится как PDOException или QueryException в самых неожиданных местах под нагрузкой. Решения: 1) PDO::ATTR_EMULATE_PREPARES => true (в config/database.php в options) - PDO сам подставляет параметры в PHP, на сервер уходит уже готовая SQL-строка без PREPARE/EXECUTE. Минус: меньше защита от типов на стороне БД, но безопасность от инъекций сохраняется (PDO правильно экранирует). 2) В PgBouncer 1.21+ (выпущен в 2023) появился experimental support для protocol-level prepared statements - max_prepared_statements > 0 в pgbouncer.ini, тогда PgBouncer сам реплицирует PREPARE на каждое физ-соединение, на которое попадает клиент. Стабильно с 1.22+. 3) Использовать session pooling вместо transaction - но это убивает преимущество пула (меньше effective connections). 4) В Laravel - php artisan queue:work обычно использует transaction pooling и страдает от этого; решение - emulate prepares на queue connection. Симптомы: спорадические ошибки "prepared statement \\"pdo_stmt_00000123\\" does not exist" под нагрузкой, особенно когда несколько воркеров одновременно. Связанные подводные камни transaction pooling: нельзя использовать SET (настройки сессии теряются между транзакциями), LISTEN/NOTIFY не работает, advisory locks на уровне сессии тоже.',
                'code_example' => '<?php
// config/database.php
\'pgsql\' => [
    \'driver\' => \'pgsql\',
    \'host\' => env(\'DB_HOST\', \'pgbouncer.internal\'),
    \'port\' => env(\'DB_PORT\', 6432), // PgBouncer порт
    // ...
    \'options\' => [
        // КРИТИЧНО при transaction pooling без max_prepared_statements
        PDO::ATTR_EMULATE_PREPARES => true,
    ],
],

// Альтернатива - PgBouncer 1.22+ с поддержкой prepared statements
// /etc/pgbouncer/pgbouncer.ini:
// pool_mode = transaction
// max_prepared_statements = 100  ; 0 по умолчанию = выключено
// после этого PDO::ATTR_EMULATE_PREPARES можно НЕ ставить

// Симптом проблемы в логах:
// SQLSTATE[26000]: Invalid sql statement name:
// 7 ERROR: prepared statement "pdo_stmt_00000abc" does not exist

// Проверка какой режим pooling у вашего PgBouncer
// $ psql -h pgbouncer -p 6432 -U user pgbouncer
// SHOW POOLS;
// SHOW CONFIG; // pool_mode = transaction|session|statement

// Прочие подводные камни transaction pooling
DB::statement("SET search_path TO custom_schema"); // НЕ сохраняется
DB::listen(...); // LISTEN/NOTIFY не работает между транзакциями
DB::raw("SELECT pg_advisory_lock(?)"); // session-level lock протекает на чужого клиента!
// Используйте pg_advisory_xact_lock - живёт только до конца транзакции',
                'code_language' => 'php',
                'difficulty' => 5,
                'topic' => 'database.postgresql',
            ],
        ];
    }
}
