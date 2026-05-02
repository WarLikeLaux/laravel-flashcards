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
        ];
    }
}
