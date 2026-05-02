<?php

namespace Database\Seeders\Data\Categories;

class DatabaseQuestions
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, cloze_text?: ?string, short_answer?: ?string, assemble_chunks?: ?array<int, string>}>
     */
    public static function all(): array
    {
        return [
            // ===== Базовые понятия =====
            [
                'category' => 'Базы данных',
                'question' => 'Что такое база данных простыми словами?',
                'answer' => 'База данных (БД) - это организованное хранилище данных, к которому удобно обращаться, добавлять, изменять и удалять записи. Простыми словами: представь огромный шкаф с папками, где всё разложено по полочкам и есть быстрый способ найти нужное. СУБД (Система Управления Базами Данных) - это программа, которая управляет этим шкафом: PostgreSQL, MySQL, SQLite, Oracle и т.д.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое таблица, строка и столбец?',
                'answer' => 'Таблица - это набор данных в виде сетки (как Excel-лист). Строка (row, record, кортеж) - одна запись, например один пользователь. Столбец (column, поле, атрибут) - характеристика записи, например имя или email. Каждый столбец имеет тип данных (integer, varchar, timestamp и т.д.).',
                'code_example' => <<<'SQL'
CREATE TABLE users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое реляционная база данных?',
                'answer' => 'Реляционная БД - это БД, основанная на математической модели отношений (relations). Данные хранятся в таблицах, связанных между собой через ключи. Главные принципы: данные структурированы, есть схема, поддерживаются транзакции и SQL. Примеры: PostgreSQL, MySQL, Oracle, SQL Server, SQLite.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое первичный ключ (PRIMARY KEY)?',
                'answer' => 'Первичный ключ - это столбец (или набор столбцов), который уникально идентифицирует каждую строку в таблице. Свойства: значение всегда уникальное, не может быть NULL, в таблице только один PRIMARY KEY. Обычно на первичный ключ автоматически создаётся индекс.',
                'code_example' => <<<'SQL'
-- Простой первичный ключ
CREATE TABLE users (
    id BIGSERIAL PRIMARY KEY,
    email VARCHAR(255)
);

-- Составной первичный ключ
CREATE TABLE order_items (
    order_id BIGINT,
    product_id BIGINT,
    quantity INT,
    PRIMARY KEY (order_id, product_id)
);
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое внешний ключ (FOREIGN KEY)?',
                'answer' => 'Внешний ключ - это столбец, который ссылается на первичный ключ другой таблицы. Он обеспечивает ссылочную целостность: нельзя добавить заказ для несуществующего пользователя. У FK можно настроить ON DELETE и ON UPDATE: CASCADE, SET NULL, RESTRICT, NO ACTION.',
                'code_example' => <<<'SQL'
CREATE TABLE orders (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    total DECIMAL(10,2),
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое UNIQUE constraint?',
                'answer' => 'UNIQUE constraint гарантирует, что во всех строках значения в указанном столбце (или комбинации столбцов) будут уникальны. В отличие от PRIMARY KEY, UNIQUE-столбец может содержать NULL (в большинстве СУБД NULL не считается равным другому NULL). Можно иметь несколько UNIQUE constraints на одной таблице.',
                'code_example' => <<<'SQL'
CREATE TABLE users (
    id BIGSERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(20) UNIQUE
);

-- Составной уникальный constraint
ALTER TABLE memberships
ADD CONSTRAINT uniq_user_team UNIQUE (user_id, team_id);
SQL,
                'code_language' => 'sql',
            ],

            // ===== SQL базовый =====
            [
                'category' => 'Базы данных',
                'question' => 'Что такое SELECT и из чего состоит базовый запрос?',
                'answer' => 'SELECT - это команда выборки данных. Базовая структура: SELECT столбцы FROM таблица WHERE условие ORDER BY столбец LIMIT N OFFSET M. Порядок выполнения логически: FROM -> WHERE -> GROUP BY -> HAVING -> SELECT -> ORDER BY -> LIMIT.',
                'code_example' => <<<'SQL'
SELECT id, name, email
FROM users
WHERE created_at > '2024-01-01'
ORDER BY created_at DESC
LIMIT 10 OFFSET 20;
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Чем отличается WHERE от HAVING?',
                'answer' => 'WHERE фильтрует строки ДО группировки (GROUP BY), HAVING - ПОСЛЕ группировки. В WHERE нельзя использовать агрегатные функции (COUNT, SUM, AVG), а в HAVING - можно. Простыми словами: WHERE отбирает отдельные строки, HAVING отбирает уже посчитанные группы.',
                'code_example' => <<<'SQL'
SELECT user_id, COUNT(*) AS orders_count
FROM orders
WHERE status = 'completed'         -- фильтр строк
GROUP BY user_id
HAVING COUNT(*) > 5;               -- фильтр групп
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое GROUP BY?',
                'answer' => 'GROUP BY группирует строки с одинаковыми значениями указанных столбцов в одну строку. Используется вместе с агрегатными функциями (COUNT, SUM, AVG, MIN, MAX). Все столбцы в SELECT, которых нет в агрегате, должны быть в GROUP BY.',
                'code_example' => <<<'SQL'
SELECT category_id, COUNT(*) AS total, AVG(price) AS avg_price
FROM products
GROUP BY category_id;
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое ORDER BY и как сортировать по нескольким полям?',
                'answer' => 'ORDER BY сортирует результат. ASC - по возрастанию (по умолчанию), DESC - по убыванию. Можно сортировать по нескольким столбцам - сначала по первому, затем по второму при равенстве. Также можно сортировать по выражениям и порядковому номеру столбца в SELECT.',
                'code_example' => <<<'SQL'
SELECT name, age, salary
FROM employees
ORDER BY salary DESC, age ASC, name;
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое LIMIT и OFFSET?',
                'answer' => 'LIMIT N - вернуть не больше N строк. OFFSET M - пропустить первые M строк. Часто используются для постраничной выдачи. Минус OFFSET-пагинации: при больших OFFSET-ах БД всё равно сканирует все пропускаемые строки, поэтому на больших таблицах это медленно.',
                'code_example' => <<<'SQL'
-- 3-я страница по 20 элементов
SELECT * FROM articles
ORDER BY published_at DESC
LIMIT 20 OFFSET 40;
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое DISTINCT?',
                'answer' => 'DISTINCT убирает дубликаты строк в результате запроса. Применяется ко всему набору столбцов в SELECT, а не к одному. DISTINCT может быть медленным на больших данных, потому что требует сортировки или хеширования.',
                'code_example' => <<<'SQL'
SELECT DISTINCT country FROM users;

-- Дубликаты определяются по комбинации всех столбцов
SELECT DISTINCT country, city FROM users;
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Какие есть виды JOIN и чем они отличаются?',
                'answer' => 'INNER JOIN - только совпадающие строки в обеих таблицах. LEFT JOIN - все из левой + совпадающие справа (несовпадения - NULL). RIGHT JOIN - наоборот. FULL OUTER JOIN - все из обеих таблиц, несовпадения - NULL. CROSS JOIN - декартово произведение (каждая с каждой). SELF JOIN - таблица соединяется сама с собой.',
                'code_example' => <<<'SQL'
-- INNER: только пользователи с заказами
SELECT u.name, o.id
FROM users u
INNER JOIN orders o ON o.user_id = u.id;

-- LEFT: все пользователи, заказы если есть
SELECT u.name, o.id
FROM users u
LEFT JOIN orders o ON o.user_id = u.id;

-- FULL OUTER: все строки из обеих таблиц
SELECT u.name, o.id
FROM users u
FULL OUTER JOIN orders o ON o.user_id = u.id;

-- CROSS: каждый с каждым (опасно)
SELECT a.name, b.name FROM colors a CROSS JOIN sizes b;

-- SELF JOIN: иерархия сотрудников
SELECT e.name AS employee, m.name AS manager
FROM employees e
LEFT JOIN employees m ON e.manager_id = m.id;
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'В чём разница между LEFT JOIN и INNER JOIN на практике?',
                'answer' => 'INNER JOIN отбросит строки из левой таблицы, для которых нет совпадений справа. LEFT JOIN сохранит все строки слева, заполнив правую часть NULL-ами. Используй LEFT JOIN, когда важно сохранить все левые записи (например, "все пользователи, даже те, у кого нет заказов").',
                'code_example' => <<<'SQL'
-- Найти пользователей БЕЗ заказов
SELECT u.id, u.name
FROM users u
LEFT JOIN orders o ON o.user_id = u.id
WHERE o.id IS NULL;
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое INSERT, UPDATE, DELETE?',
                'answer' => 'INSERT добавляет новые строки. UPDATE изменяет существующие. DELETE удаляет. UPDATE и DELETE без WHERE применяются ко всей таблице - очень опасно! Всегда сначала пиши SELECT с тем же WHERE, чтобы убедиться, что попал в нужные строки.',
                'code_example' => <<<'SQL'
INSERT INTO users (name, email) VALUES ('Иван', 'ivan@example.com');

INSERT INTO users (name, email) VALUES
    ('Анна', 'anna@example.com'),
    ('Пётр', 'petr@example.com');

UPDATE users SET email = 'new@example.com' WHERE id = 1;

DELETE FROM users WHERE created_at < '2020-01-01';
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Чем отличается UNION от UNION ALL?',
                'answer' => 'UNION объединяет результаты двух запросов и убирает дубликаты (что требует сортировки/хеширования - медленнее). UNION ALL объединяет без удаления дубликатов - значительно быстрее. Используй UNION ALL, если знаешь, что дубликатов нет или они не мешают.',
                'code_example' => <<<'SQL'
-- Без дубликатов (медленнее)
SELECT name FROM customers
UNION
SELECT name FROM suppliers;

-- С дубликатами (быстрее)
SELECT name FROM customers
UNION ALL
SELECT name FROM suppliers;
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое подзапрос (subquery)?',
                'answer' => 'Подзапрос - это запрос внутри другого запроса. Бывает скалярный (возвращает одно значение), однострочный, многострочный. Может использоваться в SELECT, FROM, WHERE. Часто заменяется JOIN-ом или CTE для лучшей читаемости и производительности.',
                'code_example' => <<<'SQL'
-- Скалярный подзапрос
SELECT name, (SELECT COUNT(*) FROM orders WHERE user_id = u.id) AS orders
FROM users u;

-- В WHERE
SELECT * FROM products
WHERE category_id IN (SELECT id FROM categories WHERE active = true);

-- В FROM (производная таблица)
SELECT t.user_id, t.total
FROM (SELECT user_id, SUM(amount) AS total FROM payments GROUP BY user_id) t
WHERE t.total > 1000;
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое CTE (WITH ... AS) и зачем он нужен?',
                'answer' => 'CTE (Common Table Expression) - это именованный временный набор результатов, который существует только в рамках одного запроса. Делает сложные запросы читаемее, разбивая их на логические шаги. Также CTE позволяет рекурсивные запросы (RECURSIVE) для работы с иерархиями.',
                'code_example' => <<<'SQL'
-- Обычный CTE
WITH active_users AS (
    SELECT id, name FROM users WHERE active = true
),
recent_orders AS (
    SELECT user_id, COUNT(*) AS cnt
    FROM orders
    WHERE created_at > NOW() - INTERVAL '30 days'
    GROUP BY user_id
)
SELECT u.name, COALESCE(o.cnt, 0) AS orders
FROM active_users u
LEFT JOIN recent_orders o ON o.user_id = u.id;

-- Рекурсивный CTE: дерево категорий
WITH RECURSIVE tree AS (
    SELECT id, name, parent_id FROM categories WHERE parent_id IS NULL
    UNION ALL
    SELECT c.id, c.name, c.parent_id
    FROM categories c
    JOIN tree t ON c.parent_id = t.id
)
SELECT * FROM tree;
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Какие есть агрегатные функции?',
                'answer' => 'COUNT(*) - количество строк, COUNT(col) - количество ненулевых значений, COUNT(DISTINCT col) - уникальных. SUM - сумма, AVG - среднее, MIN - минимум, MAX - максимум. Также есть STRING_AGG (PG) / GROUP_CONCAT (MySQL) для объединения строк, ARRAY_AGG для массивов.',
                'code_example' => <<<'SQL'
SELECT
    COUNT(*) AS total_rows,
    COUNT(email) AS users_with_email,
    COUNT(DISTINCT country) AS unique_countries,
    SUM(salary) AS sum_salary,
    AVG(salary) AS avg_salary,
    MIN(created_at) AS first,
    MAX(created_at) AS last,
    STRING_AGG(name, ', ') AS all_names
FROM users;
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое NULL и трехзначная логика?',
                'answer' => 'NULL означает "значение неизвестно/отсутствует". В реляционной алгебре любая операция с NULL даёт NULL: NULL = NULL -> NULL (не TRUE!), NULL + 5 -> NULL. Поэтому используется трёхзначная логика: TRUE, FALSE, UNKNOWN. WHERE пропускает только строки, где условие TRUE. Для сравнения с NULL используй IS NULL / IS NOT NULL.',
                'code_example' => <<<'SQL'
-- Это НЕ найдёт строки с NULL
SELECT * FROM users WHERE deleted_at = NULL;  -- неверно

-- Правильно
SELECT * FROM users WHERE deleted_at IS NULL;
SELECT * FROM users WHERE deleted_at IS NOT NULL;

-- NULL в выражениях
SELECT 1 + NULL;       -- NULL
SELECT NULL = NULL;    -- NULL (UNKNOWN)
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что делают COALESCE, NULLIF, NVL?',
                'answer' => 'COALESCE(a, b, c, ...) возвращает первое не-NULL значение из списка. NULLIF(a, b) возвращает NULL, если a = b, иначе возвращает a (удобно избегать деления на ноль). NVL - аналог COALESCE в Oracle (в PostgreSQL/MySQL - COALESCE).',
                'code_example' => <<<'SQL'
-- Замена NULL на дефолт
SELECT COALESCE(nickname, name, 'Аноним') FROM users;

-- Избегаем деления на ноль
SELECT total / NULLIF(count, 0) AS average FROM stats;

-- COALESCE в UPDATE
UPDATE products SET price = COALESCE(new_price, price);
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое CASE WHEN?',
                'answer' => 'CASE WHEN - условное выражение SQL (аналог if/else). Бывает простой (CASE column WHEN value THEN ...) и searched (CASE WHEN condition THEN ...). Можно использовать в SELECT, ORDER BY, WHERE, GROUP BY.',
                'code_example' => <<<'SQL'
SELECT
    name,
    salary,
    CASE
        WHEN salary < 50000 THEN 'low'
        WHEN salary < 100000 THEN 'mid'
        ELSE 'high'
    END AS salary_band
FROM employees;

-- CASE для условной агрегации
SELECT
    COUNT(*) FILTER (WHERE status = 'completed') AS done,
    COUNT(CASE WHEN status = 'pending' THEN 1 END) AS pending
FROM orders;
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'В чём разница между IN и EXISTS?',
                'answer' => 'IN сравнивает значение со списком (или результатом подзапроса). EXISTS проверяет, вернул ли подзапрос хоть одну строку (TRUE/FALSE). На больших данных EXISTS часто быстрее, потому что останавливается на первой найденной строке. Также NOT IN подвержен проблемам с NULL: NOT IN с NULL в списке возвращает UNKNOWN.',
                'code_example' => <<<'SQL'
-- IN
SELECT * FROM users WHERE id IN (SELECT user_id FROM orders);

-- EXISTS - часто эффективнее
SELECT * FROM users u
WHERE EXISTS (SELECT 1 FROM orders o WHERE o.user_id = u.id);

-- NOT EXISTS - безопаснее NOT IN при NULL
SELECT * FROM users u
WHERE NOT EXISTS (SELECT 1 FROM orders o WHERE o.user_id = u.id);
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое BETWEEN, LIKE, ILIKE?',
                'answer' => 'BETWEEN a AND b - значение в диапазоне [a, b] включительно. LIKE - сопоставление с шаблоном: % (любые символы), _ (один символ). ILIKE (PostgreSQL) - LIKE без учёта регистра. В MySQL по умолчанию LIKE регистронезависим (зависит от collation).',
                'code_example' => <<<'SQL'
SELECT * FROM users WHERE age BETWEEN 18 AND 65;

SELECT * FROM products WHERE name LIKE 'iPhone%';     -- начинается с
SELECT * FROM products WHERE name LIKE '%pro%';       -- содержит
SELECT * FROM products WHERE name LIKE 'iPhone_';     -- ровно одна буква в конце

-- PostgreSQL: без учёта регистра
SELECT * FROM products WHERE name ILIKE '%pro%';
SQL,
                'code_language' => 'sql',
            ],

            // ===== Нормализация =====
            [
                'category' => 'Базы данных',
                'question' => 'Что такое нормализация баз данных?',
                'answer' => 'Нормализация - это процесс структурирования таблиц, чтобы устранить избыточность и аномалии (вставки, обновления, удаления). Идёт по нормальным формам: 1НФ, 2НФ, 3НФ, БКНФ, 4НФ, 5НФ. На практике обычно достаточно 3НФ. Цель - каждый факт хранится в одном месте.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое 1НФ (первая нормальная форма)?',
                'answer' => '1НФ требует: все значения атомарны (нельзя хранить список значений в одной ячейке), нет повторяющихся групп столбцов, у каждой строки есть уникальный идентификатор. Пример нарушения: столбец phones со значением "+7-111, +7-222". Решение - вынести в отдельную таблицу phones.',
                'code_example' => <<<'SQL'
-- Нарушение 1НФ
CREATE TABLE users_bad (
    id INT,
    name VARCHAR(100),
    phones VARCHAR(255)  -- "+7-111, +7-222"
);

-- 1НФ
CREATE TABLE users (id INT PRIMARY KEY, name VARCHAR(100));
CREATE TABLE phones (
    id INT PRIMARY KEY,
    user_id INT REFERENCES users(id),
    phone VARCHAR(20)
);
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое 2НФ?',
                'answer' => '2НФ: таблица в 1НФ, и все неключевые атрибуты зависят от ВСЕГО первичного ключа, а не от его части. Актуально для составных ключей. Пример: в таблице (order_id, product_id, product_name) - product_name зависит только от product_id, нарушение 2НФ. Надо вынести в таблицу products.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое 3НФ?',
                'answer' => '3НФ: таблица в 2НФ, и нет транзитивных зависимостей (неключевой атрибут не зависит от другого неключевого). Пример нарушения: users(id, city_id, city_name) - city_name зависит от city_id, не от id. Решение: вынести города в отдельную таблицу.',
                'code_example' => <<<'SQL'
-- Нарушение 3НФ
CREATE TABLE users_bad (
    id INT PRIMARY KEY,
    name VARCHAR(100),
    city_id INT,
    city_name VARCHAR(100)  -- зависит от city_id
);

-- 3НФ
CREATE TABLE cities (id INT PRIMARY KEY, name VARCHAR(100));
CREATE TABLE users (
    id INT PRIMARY KEY,
    name VARCHAR(100),
    city_id INT REFERENCES cities(id)
);
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое БКНФ (Бойса-Кодда)?',
                'answer' => 'БКНФ - усиление 3НФ: каждая нетривиальная функциональная зависимость должна иметь в левой части суперключ. Простыми словами: если X определяет Y, то X должен быть уникальным в таблице. БКНФ часто совпадает с 3НФ, но решает редкие случаи, когда есть несколько перекрывающихся ключей.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое денормализация и когда она уместна?',
                'answer' => 'Денормализация - намеренное добавление избыточности (хранение одних и тех же данных в нескольких местах) ради производительности. Уместна, когда: read-heavy нагрузка, JOIN-ы стали узким местом, нужна аналитика, есть отдельная OLAP-БД. Минусы: данные могут рассинхронизироваться, сложнее обновлять. Примеры: счётчики (likes_count в постах), хранение полного имени вместо JOIN.',
                'code_example' => <<<'SQL'
-- Денормализованный счётчик
CREATE TABLE posts (
    id BIGINT PRIMARY KEY,
    title VARCHAR(255),
    likes_count INT DEFAULT 0,  -- избыточность для скорости
    comments_count INT DEFAULT 0
);
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Какие есть виды связей между таблицами?',
                'answer' => '1-к-1 (один-к-одному): пользователь и его профиль (один на один). Реализуется через UNIQUE FK. 1-ко-многим: пользователь и его заказы. FK на стороне "многих". М-ко-многим: студент и курсы. Реализуется через промежуточную (pivot) таблицу с двумя FK.',
                'code_example' => <<<'SQL'
-- 1-к-1
CREATE TABLE users (id BIGINT PRIMARY KEY);
CREATE TABLE profiles (
    id BIGINT PRIMARY KEY,
    user_id BIGINT UNIQUE REFERENCES users(id)
);

-- 1-ко-многим
CREATE TABLE orders (
    id BIGINT PRIMARY KEY,
    user_id BIGINT REFERENCES users(id)
);

-- M-ко-многим через pivot
CREATE TABLE students (id BIGINT PRIMARY KEY);
CREATE TABLE courses (id BIGINT PRIMARY KEY);
CREATE TABLE student_course (
    student_id BIGINT REFERENCES students(id),
    course_id BIGINT REFERENCES courses(id),
    PRIMARY KEY (student_id, course_id)
);
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое ER-диаграмма?',
                'answer' => 'ER-диаграмма (Entity-Relationship) - визуальная модель данных, показывающая сущности (таблицы), их атрибуты (столбцы) и связи между ними. Бывают разные нотации: Чена, Crow Foot (вороньи лапки) - наиболее популярная. На лапке: одиночная палочка - "один", вилка - "много", кружок - "ноль". Используется на этапе проектирования БД до написания SQL.',
                'code_example' => null,
                'code_language' => null,
            ],

            // ===== Транзакции и ACID =====
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
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое ACID?',
                'answer' => 'ACID - набор свойств транзакций: Atomicity (атомарность), Consistency (согласованность), Isolation (изолированность), Durability (долговечность). Обеспечивает, что транзакции выполняются надёжно. Реляционные БД (PostgreSQL, MySQL/InnoDB) гарантируют ACID, многие NoSQL - нет.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'A в ACID - что такое Atomicity (атомарность)?',
                'answer' => 'Атомарность означает: транзакция выполняется целиком или не выполняется вообще. Промежуточных состояний нет. Если в середине что-то падает, БД откатывает все уже сделанные изменения транзакции. Простыми словами: всё или ничего, как нажатие одной кнопки.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'C в ACID - что такое Consistency (согласованность)?',
                'answer' => 'Согласованность: транзакция переводит БД из одного валидного состояния в другое валидное. Все ограничения (PK, FK, CHECK, NOT NULL, UNIQUE) соблюдаются. Если транзакция нарушит ограничение, она откатится. Это про целостность данных, а не про сохранность.',
                'code_example' => null,
                'code_language' => null,
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
            ],
            [
                'category' => 'Базы данных',
                'question' => 'D в ACID - что такое Durability (долговечность)?',
                'answer' => 'Долговечность: после COMMIT изменения сохранены навсегда, даже если сервер сразу упадёт. БД пишет изменения в журнал (WAL/redo log) на диск перед подтверждением. Простыми словами: COMMIT прошёл - значит, данные точно не пропадут.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Какие бывают уровни изоляции транзакций?',
                'answer' => '4 стандартных уровня по SQL: READ UNCOMMITTED (видны грязные данные других транзакций), READ COMMITTED (видны только закоммиченные), REPEATABLE READ (одни и те же чтения дают одинаковый результат), SERIALIZABLE (полная изоляция, как будто транзакции выполняются последовательно). Чем выше - тем меньше аномалий, но больше блокировок.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Dirty Read (грязное чтение)?',
                'answer' => 'Грязное чтение - транзакция читает данные, изменённые другой ещё незакоммиченной транзакцией. Если та откатится - мы прочитали "несуществующие" данные. Случается на уровне READ UNCOMMITTED. PostgreSQL вообще не допускает грязного чтения, минимальный уровень - READ COMMITTED.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Non-repeatable Read?',
                'answer' => 'Неповторяемое чтение - в рамках одной транзакции мы читаем строку дважды и получаем разные значения, потому что между чтениями другая транзакция её обновила и закоммитила. Случается на READ COMMITTED. Решается уровнем REPEATABLE READ или выше.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Phantom Read (фантомное чтение)?',
                'answer' => 'Фантомное чтение - в одной транзакции мы выполняем один и тот же запрос (SELECT WHERE) дважды и получаем разное количество строк, потому что другая транзакция вставила/удалила подходящие. Решается уровнем SERIALIZABLE. В PostgreSQL REPEATABLE READ уже защищает от фантомов (snapshot-уровень).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Write Skew?',
                'answer' => 'Write Skew - аномалия, когда две транзакции читают одни и те же данные, принимают решения, и пишут разные строки, нарушая бизнес-инвариант. Пример: правило "хотя бы один врач на смене", обе транзакции читают, видят что есть двое, и обе уходят с дежурства. Решается на уровне SERIALIZABLE или явными блокировками SELECT FOR UPDATE.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое блокировки (locks)?',
                'answer' => 'Блокировки - механизм, который не даёт нескольким транзакциям одновременно изменять одни и те же данные. Бывают: shared (S, разделяемая) - для чтения, exclusive (X) - для записи. Гранулярность: row-level (на строку), table-level (на таблицу), page-level. Также бывают advisory (явные пользовательские блокировки по ключу).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Чем отличаются shared lock и exclusive lock?',
                'answer' => 'Shared (S) - "читать можно, писать нельзя". Несколько транзакций могут одновременно держать S на одной строке. Exclusive (X) - "никто другой не может ни читать, ни писать". Захватывается при UPDATE/DELETE. S и X несовместимы. Это базовая модель совместимости блокировок.',
                'code_example' => null,
                'code_language' => null,
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
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Deadlock и как его избегать?',
                'answer' => 'Deadlock (взаимная блокировка) - ситуация, когда транзакция A ждёт ресурс, удерживаемый B, а B ждёт ресурс, удерживаемый A. БД сама обнаруживает deadlock и убивает одну из транзакций (откатывая её). Простыми словами: два человека пытаются разойтись в узком коридоре и не могут. Как избегать: всегда захватывать блокировки в одинаковом порядке, держать транзакции короткими, использовать SELECT FOR UPDATE NOWAIT/SKIP LOCKED, ретраить откатанные транзакции.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое MVCC простыми словами?',
                'answer' => 'MVCC (Multi-Version Concurrency Control) - механизм, при котором при изменении строки в таблице создаётся её новая версия, а старая ещё какое-то время живёт для других транзакций. Простыми словами: вместо того чтобы переписывать строку поверх, БД оставляет старый вариант для тех, кто уже начал читать. Поэтому "читатели не блокируют писателей и наоборот". PostgreSQL и Oracle используют MVCC. Минус: накапливаются мёртвые версии (bloat), нужен VACUUM.',
                'code_example' => null,
                'code_language' => null,
            ],

            // ===== Индексы =====
            [
                'category' => 'Базы данных',
                'question' => 'Зачем нужны индексы и что это такое простыми словами?',
                'answer' => 'Индекс - это вспомогательная структура данных для ускорения поиска по таблице. Простыми словами: представь толстую книгу - чтобы найти главу про пингвинов, ты идёшь не на каждую страницу, а в алфавитный указатель в конце книги, видишь "Пингвины - стр. 524" и сразу открываешь нужную страницу. Индекс - это и есть тот алфавитный указатель в конце. Минусы: индексы занимают место и замедляют INSERT/UPDATE/DELETE.',
                'code_example' => <<<'SQL'
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_orders_user_id ON orders(user_id);
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Как устроен B-tree индекс?',
                'answer' => 'B-tree (balanced tree) - сбалансированное дерево, где данные отсортированы и поиск идёт за O(log n). Каждый узел содержит несколько ключей и указатели на детей; листья связаны для эффективного range-поиска. Это самый универсальный тип индекса по умолчанию: подходит для =, <, >, BETWEEN, ORDER BY, LIKE "pref%". PostgreSQL и MySQL по умолчанию создают именно B-tree.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое hash-индекс?',
                'answer' => 'Hash-индекс хранит хэш ключа и указатель на строку. Поиск по равенству очень быстрый - O(1), но не работает для диапазонов (<, >, BETWEEN) и сортировки. В PostgreSQL hash-индексы есть, но используются редко. В Redis и memcached - основной механизм.',
                'code_example' => <<<'SQL'
-- PostgreSQL
CREATE INDEX idx_users_email ON users USING hash(email);
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое GIN и GiST индексы (PostgreSQL)?',
                'answer' => 'GIN (Generalized Inverted Index) - инвертированный индекс, хорош для значений, содержащих несколько подзначений: массивы, JSONB, full-text search. GiST (Generalized Search Tree) - универсальное дерево, подходит для геоданных (PostGIS), range types, ближайших соседей. GIN быстрее на чтение, GiST на запись.',
                'code_example' => <<<'SQL'
-- GIN для full-text search
CREATE INDEX idx_articles_tsv ON articles USING gin(to_tsvector('russian', body));

-- GIN для JSONB
CREATE INDEX idx_data ON events USING gin(data);

-- GiST для геометрии
CREATE INDEX idx_locations ON places USING gist(geom);
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое composite (составной) индекс?',
                'answer' => 'Composite-индекс - индекс по нескольким столбцам. Порядок столбцов важен! Индекс (a, b, c) ускоряет запросы по a, по (a, b), по (a, b, c), но НЕ по b или по c отдельно. Это правило "leftmost prefix". Используется для частых комбинаций условий.',
                'code_example' => <<<'SQL'
CREATE INDEX idx_orders_user_status ON orders(user_id, status, created_at);

-- Этот запрос использует индекс
SELECT * FROM orders WHERE user_id = 1 AND status = 'paid';

-- А этот - нет (нет user_id впереди)
SELECT * FROM orders WHERE status = 'paid';
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое partial index?',
                'answer' => 'Partial index - индекс по подмножеству строк, удовлетворяющих условию WHERE. Меньше по размеру, быстрее обновляется, применяется только к подходящим запросам. Полезен, когда часто фильтруют по конкретному значению (например, active = true).',
                'code_example' => <<<'SQL'
-- Индексируем только активных пользователей
CREATE INDEX idx_users_active ON users(email) WHERE active = true;

-- Только незавершённые заказы
CREATE INDEX idx_orders_pending ON orders(created_at) WHERE status = 'pending';
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое expression (functional) index?',
                'answer' => 'Expression index - индекс по результату выражения, а не по самому столбцу. Помогает запросам, где в WHERE используется функция от столбца. Без такого индекса БД не может использовать обычный индекс на столбце.',
                'code_example' => <<<'SQL'
-- Чтобы поиск по нижнему регистру использовал индекс
CREATE INDEX idx_users_lower_email ON users(LOWER(email));

SELECT * FROM users WHERE LOWER(email) = 'ivan@mail.ru';
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое covering index и INCLUDE?',
                'answer' => 'Covering index - индекс, который содержит все столбцы, нужные запросу, так что БД отвечает прямо из индекса, не обращаясь к таблице (index-only scan). В PostgreSQL и SQL Server есть синтаксис INCLUDE - дополнительные столбцы хранятся в индексе как payload, не участвуют в сортировке.',
                'code_example' => <<<'SQL'
-- email - ключ индекса, name и age - включенные
CREATE INDEX idx_users_email_inc ON users(email) INCLUDE (name, age);

-- Этот запрос - index-only scan
SELECT name, age FROM users WHERE email = 'ivan@mail.ru';
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Когда индекс не используется?',
                'answer' => 'Индекс не работает, когда: применена функция к столбцу (WHERE LOWER(email) = ...) - нужен expression index; LIKE с ведущим % (WHERE name LIKE "%abc") - нет prefix; столбец в выражении (WHERE age + 1 = 30); неподходящий тип (CAST); очень малая селективность (большая часть таблицы - быстрее seq scan); статистика устарела (нужен ANALYZE).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Index Scan и Sequential Scan?',
                'answer' => 'Sequential Scan (seq scan) - полное сканирование таблицы, чтение строк подряд. Подходит для маленьких таблиц или когда возвращается большая доля строк. Index Scan - чтение через индекс, идёт по нему, потом по указателям к таблице. Бывает Index Only Scan (когда все нужные данные есть в индексе) и Bitmap Index Scan (собирает битмап позиций, потом за один проход читает таблицу). Какой использовать решает планировщик.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое selectivity и cardinality?',
                'answer' => 'Cardinality - количество уникальных значений в столбце. Selectivity - доля строк, удовлетворяющих условию (от 0 до 1). Чем выше cardinality и ниже selectivity (мало строк подходит) - тем эффективнее индекс. Индекс на bool-столбце обычно бесполезен (cardinality = 2). Индекс на email - очень эффективен.',
                'code_example' => null,
                'code_language' => null,
            ],

            // ===== Оптимизация =====
            [
                'category' => 'Базы данных',
                'question' => 'Что такое EXPLAIN и EXPLAIN ANALYZE?',
                'answer' => 'EXPLAIN показывает план выполнения запроса - как БД будет его выполнять (какие индексы, JOIN-ы, сортировки). EXPLAIN ANALYZE дополнительно реально выполняет запрос и показывает фактическое время и количество строк. Главное смотреть: тип scan (Seq/Index), оценочные vs реальные строки, самые дорогие узлы.',
                'code_example' => <<<'SQL'
EXPLAIN SELECT * FROM users WHERE email = 'ivan@mail.ru';

EXPLAIN ANALYZE
SELECT u.name, COUNT(o.id)
FROM users u
LEFT JOIN orders o ON o.user_id = u.id
GROUP BY u.name;
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Nested Loop, Hash Join, Merge Join?',
                'answer' => 'Это три алгоритма JOIN. Nested Loop: для каждой строки слева ищем подходящие справа (хорошо когда слева мало строк и есть индекс справа). Hash Join: строим хэш-таблицу из правой стороны и для каждой левой ищем в хэше O(1) (хорошо для больших таблиц без индексов). Merge Join: обе стороны должны быть отсортированы по ключу JOIN, идём слиянием как при merge sort (хорошо для уже отсортированных данных). Планировщик сам выбирает.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Когда стоит добавлять индекс?',
                'answer' => 'Добавлять индекс стоит, когда: столбец часто в WHERE/JOIN/ORDER BY и таблица большая; запрос медленный, EXPLAIN показывает Seq Scan; столбец имеет высокую cardinality; чтений намного больше записей. НЕ стоит: маленькие таблицы (<1000 строк), очень частые INSERT/UPDATE, низкая селективность фильтра.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Почему слишком много индексов - это плохо?',
                'answer' => 'Каждый индекс: занимает место на диске, замедляет INSERT/UPDATE/DELETE (БД должна обновлять все индексы), увеличивает время бэкапов, может запутать планировщик и привести к выбору не самого быстрого. Правило: индексируй только то, что реально часто запрашивается. Удаляй неиспользуемые индексы (в PG: pg_stat_user_indexes).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'OFFSET vs Keyset (cursor) пагинация - что лучше?',
                'answer' => 'OFFSET-пагинация: LIMIT 20 OFFSET 10000. Минусы: БД сканирует все 10000 пропускаемых строк - очень медленно на больших таблицах. Keyset (cursor) пагинация: запоминаем последний ключ предыдущей страницы и фильтруем WHERE id > last_id. Преимущества: O(1) переход на следующую страницу. Минус: нельзя "перейти на страницу 50".',
                'code_example' => <<<'SQL'
-- OFFSET (медленно на глубине)
SELECT * FROM articles ORDER BY id LIMIT 20 OFFSET 10000;

-- Keyset (быстро всегда)
SELECT * FROM articles
WHERE id > 12345  -- last id с прошлой страницы
ORDER BY id
LIMIT 20;
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое N+1 проблема и как её решать?',
                'answer' => 'N+1 - проблема ORM, когда для получения N записей делается 1 запрос на список + N запросов на связанные данные. Например, 100 пользователей -> 1 + 100 = 101 запрос. Решение: eager loading (Eloquent: with(), JPA: JOIN FETCH), JOIN-ы вручную, dataloader (для GraphQL). В Laravel: User::with("posts")->get() вместо ->get() + загрузка $user->posts по требованию.',
                'code_example' => <<<'PHP'
// Плохо: N+1
$users = User::all();
foreach ($users as $user) {
    echo $user->posts->count(); // отдельный запрос
}

// Хорошо: eager loading
$users = User::with('posts')->get();
foreach ($users as $user) {
    echo $user->posts->count(); // без доп. запроса
}
PHP,
                'code_language' => 'php',
            ],

            // ===== PostgreSQL специфика =====
            [
                'category' => 'Базы данных',
                'question' => 'Чем PostgreSQL отличается от MySQL?',
                'answer' => 'PostgreSQL - объектно-реляционная СУБД с упором на стандарт SQL и расширяемость. Преимущества: продвинутые типы (jsonb, arrays, range, hstore, geo), CTE (включая рекурсивные), оконные функции с самого начала, partial/expression индексы, MVCC. MySQL - проще, исторически быстрее на простых OLTP, но в InnoDB меньше возможностей. PostgreSQL чаще выбирают для сложных приложений, MySQL - для веб (LAMP).',
                'code_example' => null,
                'code_language' => null,
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
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое репликация в PostgreSQL: streaming vs logical?',
                'answer' => 'Streaming replication - физическая репликация, реплика побайтово копирует WAL-журнал мастера. Точная копия. Используется для отказоустойчивости и read-replicas. Logical replication - логическая, реплицируются изменения по таблицам через publication/subscription. Можно реплицировать выборочно (только нужные таблицы), между разными мажорными версиями, делать преобразования.',
                'code_example' => null,
                'code_language' => null,
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
            ],

            // ===== MySQL специфика =====
            [
                'category' => 'Базы данных',
                'question' => 'InnoDB vs MyISAM в MySQL?',
                'answer' => 'InnoDB - современный движок MySQL по умолчанию. Поддерживает: транзакции (ACID), foreign keys, row-level locks, crash recovery, MVCC. MyISAM - старый движок: только table-level locks, нет транзакций и FK, но быстрее на простых SELECT-only нагрузках и full-text. На практике почти всегда используют InnoDB. MyISAM считается устаревшим.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Clustered index в InnoDB?',
                'answer' => 'В InnoDB строки физически хранятся в порядке primary key - это и есть кластерный индекс. Поэтому PK lookup очень быстрый - данные сразу с ним. Все остальные (вторичные) индексы хранят PK как ссылку на строку. Следствия: PK должен быть коротким (он повторяется в каждом вторичном индексе), последовательный PK даёт лучшую локальность записи.',
                'code_example' => null,
                'code_language' => null,
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
            ],
            [
                'category' => 'Базы данных',
                'question' => 'REPEATABLE READ в InnoDB и gap locks?',
                'answer' => 'В стандарте SQL уровень REPEATABLE READ защищает от non-repeatable read, но не от phantoms. В InnoDB же REPEATABLE READ защищает и от phantoms за счёт gap locks - блокировок на "промежутках" между значениями индекса. Поэтому SELECT FOR UPDATE WHERE x BETWEEN 5 AND 10 заблокирует не только существующие строки, но и возможные новые. Это уникальная особенность InnoDB.',
                'code_example' => null,
                'code_language' => null,
            ],

            // ===== NoSQL =====
            [
                'category' => 'Базы данных',
                'question' => 'Что такое NoSQL простыми словами?',
                'answer' => 'NoSQL ("Not Only SQL") - семейство БД, которые отходят от строгой реляционной модели. Часто гибче по схеме, лучше масштабируются горизонтально, но обычно не дают полноценных транзакций. Простыми словами: если SQL - это шкаф с одинаковыми ящиками с метками, то NoSQL - это коробки разной формы, в которые можно класть что угодно.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Какие есть виды NoSQL баз?',
                'answer' => '1) Key-Value: ключ -> значение (Redis, DynamoDB, Memcached). 2) Document: хранит документы (обычно JSON) - MongoDB, CouchDB. 3) Column-family (wide-column): таблицы с динамическими столбцами - Cassandra, HBase. 4) Graph: вершины и рёбра - Neo4j, ArangoDB. Также сюда часто относят поисковые движки (ElasticSearch) и time-series БД (InfluxDB, TimescaleDB).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Redis и его основные структуры данных?',
                'answer' => 'Redis - in-memory key-value БД, чрезвычайно быстрая. Поддерживает структуры: String, List, Hash, Set, Sorted Set (ZSet), Stream, HyperLogLog, Bitmap, Geo. Используется как: кэш, сессии, очереди (LPUSH/BRPOP, Streams), счётчики, лидерборды (ZSet), pub/sub, распределённые блокировки.',
                'code_example' => <<<'BASH'
SET user:1:name "Иван"
GET user:1:name

LPUSH queue "task1"
RPOP queue

ZADD leaderboard 100 "alice" 200 "bob"
ZREVRANGE leaderboard 0 9 WITHSCORES

INCR page:home:views
EXPIRE page:home:views 60
BASH,
                'code_language' => 'bash',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое MongoDB?',
                'answer' => 'MongoDB - документная NoSQL БД. Хранит JSON-подобные документы (BSON) в коллекциях, без жёсткой схемы. Поддерживает богатые запросы по полям документа (включая вложенные), индексы, агрегационный пайплайн, транзакции (с 4.0). Хороша когда схема меняется часто, нет сложных JOIN-ов, нужна гибкость. Минус: транзакции через несколько коллекций медленнее реляционных.',
                'code_example' => <<<'BASH'
db.users.insertOne({ name: "Иван", tags: ["admin", "user"] });

db.users.find({ "tags": "admin" });

db.orders.aggregate([
    { $match: { status: "paid" } },
    { $group: { _id: "$user_id", total: { $sum: "$amount" } } }
]);
BASH,
                'code_language' => 'bash',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Cassandra и для чего она?',
                'answer' => 'Apache Cassandra - распределённая wide-column NoSQL БД с упором на масштабируемость и доступность (AP по CAP). Идеально для записи огромных объёмов данных (логи, телеметрия, IoT, временные ряды). Архитектура без мастера (peer-to-peer), линейно масштабируется добавлением нод. Минусы: ограниченные запросы (нужно проектировать под них), eventual consistency.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое ElasticSearch?',
                'answer' => 'ElasticSearch - поисковый движок поверх Apache Lucene. Документная NoSQL-БД, заточенная под full-text search и аналитику. Хорош в: поиске с relevance scoring, фасетах, агрегациях, гео-поиске, логах (часть стека ELK). Не подходит как primary store для строгой транзакционной нагрузки. Часто используется в паре с реляционной БД.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Когда выбирать SQL, а когда NoSQL?',
                'answer' => 'SQL: когда схема стабильна, нужны сложные запросы и JOIN-ы, важна целостность и ACID-транзакции (финансы, e-commerce, CRM). NoSQL: когда схема меняется часто, нужно горизонтальное масштабирование на терабайты данных, простые запросы по ключу (ленты, чаты, IoT, кэш). Часто в реальных системах используется и то и другое (polyglot persistence).',
                'code_example' => null,
                'code_language' => null,
            ],

            // ===== Распределённые БД =====
            [
                'category' => 'Базы данных',
                'question' => 'Что такое шардирование (sharding) простыми словами?',
                'answer' => 'Шардирование - это разделение одной большой базы данных на несколько маленьких частей (шардов), которые хранятся на разных серверах. Простыми словами: представь огромный торт, который нельзя съесть одному - его разрезают на куски и раздают друзьям. Каждый сервер (кусок торта) хранит свою часть данных. Это позволяет масштабировать БД горизонтально - больше серверов = больше места и пропускной способности. Минусы: сложнее запросы между шардами, ребалансировка, нет глобальных JOIN-ов.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Какие есть стратегии шардирования?',
                'answer' => '1) Range-шардинг: по диапазону ключа (id 1-1M на shard1, 1M-2M на shard2). Просто, но "горячие" диапазоны. 2) Hash: hash(ключ) % N - равномерно, но при добавлении шарда ребалансируется почти всё. 3) Consistent hashing: хеш-кольцо, при добавлении/удалении шарда переезжает только 1/N данных. 4) Directory-based: отдельный сервис-маппер ключ -> шард, гибко но единая точка отказа.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое consistent hashing простыми словами?',
                'answer' => 'Consistent hashing - способ распределять ключи между серверами так, чтобы при добавлении или удалении сервера переезжало только небольшое количество ключей. Представь круг (хеш-кольцо), на нём расставлены сервера и ключи (по их хэшу). Каждый ключ "идёт" по кольцу к ближайшему серверу. Если убрать один сервер, его ключи перейдут к следующему - остальные не двигаются. Используется в DynamoDB, Cassandra, memcached.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое репликация (replication) простыми словами?',
                'answer' => 'Репликация - это копирование данных одной БД на другие серверы (реплики). Простыми словами: одни и те же данные хранятся в нескольких местах, как резервная копия в реальном времени. Зачем: отказоустойчивость (один сервер упал - есть запасной), масштабирование чтения (запросы балансируются по репликам), географическая близость к пользователям. В отличие от шардирования (где данные РАЗДЕЛЕНЫ), при репликации данные ДУБЛИРУЮТСЯ.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Master-slave vs Master-master репликация?',
                'answer' => 'Master-Slave (или primary-replica): один мастер принимает запись, реплики - только чтение. Просто и безопасно от конфликтов. Минус: единая точка записи. Master-Master (multi-master): несколько мастеров принимают запись. Сложнее (конфликты разрешения, eventual consistency), но устойчивее к сбоям и геораспределённый. На практике чаще встречается master-slave с failover-механизмом.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Asynchronous vs Synchronous replication?',
                'answer' => 'Синхронная: мастер ждёт подтверждения от реплики, прежде чем сказать клиенту "ок". Гарантирует, что данные есть на двух нодах, но медленнее и зависит от реплики. Асинхронная: мастер сразу отвечает клиенту и потом пересылает реплике. Быстрее, но при крахе мастера часть транзакций может пропасть. Полусинхронная (semi-sync) - компромисс: ждём хотя бы одну реплику.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое replication lag и как с ним жить?',
                'answer' => 'Replication lag - задержка между записью на мастер и появлением данных на реплике. Возникает при асинхронной репликации. Может приводить к "только что добавил - не вижу в списке" (запрос пошёл на отстающую реплику). Решения: для критичных read-after-write читать с мастера; sticky-сессия пользователя на мастер на короткое время; использовать sync для критичных вещей; мониторить lag (pg_stat_replication).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое CAP-теорема простыми словами?',
                'answer' => 'CAP-теорема: распределённая система в условиях сетевого разделения (Partition) может гарантировать только два свойства из трёх: Consistency (все ноды видят одинаковые данные), Availability (каждый запрос получает ответ), Partition tolerance (система работает при потере связи между нодами). Простыми словами: сеть может рваться - выбирай, что важнее, согласованность или доступность. CP-системы: банковские (HBase, MongoDB по умолчанию). AP: соцсети (Cassandra, DynamoDB). CA - только в системах без сетевого разделения (по сути одна нода).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'BASE vs ACID?',
                'answer' => 'ACID (реляционные): Atomicity, Consistency, Isolation, Durability - строгие гарантии транзакций. BASE (NoSQL): Basically Available (всегда доступна), Soft state (состояние может меняться без ввода), Eventual consistency (рано или поздно станет согласованной). BASE жертвует строгой консистентностью ради доступности и масштабируемости. Это две философии: финансы любят ACID, ленты соцсетей живут с BASE.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое eventual consistency?',
                'answer' => 'Eventual consistency (постепенная согласованность) - модель, при которой если перестать делать обновления, в конце концов все реплики придут к одному состоянию, но в моменте могут расходиться. Простыми словами: подожди немного - и все увидят одно и то же. Используется в DynamoDB, Cassandra, S3. Хорошо для соцсетей, плохо для финансов.',
                'code_example' => null,
                'code_language' => null,
            ],

            // ===== Connection pooling, WAL, Backup =====
            [
                'category' => 'Базы данных',
                'question' => 'Что такое connection pooling и зачем pgbouncer?',
                'answer' => 'Установка соединения с БД дорогая (TLS-handshake, аутентификация, форк процесса в PG). Connection pool - набор уже открытых соединений, которые переиспользуются приложением. pgbouncer - внешний пулер для PostgreSQL: между приложением и БД, мультиплексирует тысячи клиентов на десятки соединений. Режимы: session, transaction, statement (чем агрессивнее - тем меньше PG-ресурсов, но больше ограничений). Без пулера большое приложение легко уроет PG.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое WAL и crash recovery в PostgreSQL?',
                'answer' => 'WAL (Write-Ahead Log) - журнал, в который PG записывает все изменения ПЕРЕД тем как применить их к страницам данных. Это даёт Durability (свойство D в ACID): если сервер упал, при старте PG читает WAL и "доигрывает" непримененные изменения - crash recovery. Также WAL основа репликации (streaming) и point-in-time recovery (PITR).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Какие есть стратегии резервного копирования?',
                'answer' => 'Full backup - полная копия всей БД, простое восстановление, но место и время. Incremental - только изменения с последнего full/incremental, экономно но восстановление длиннее. Differential - изменения с последнего full. Point-in-Time Recovery (PITR) - восстановление на любой момент: full + накат WAL до нужного времени. Логические (pg_dump) vs физические (pg_basebackup) - первое переносимо, второе быстрее. Best practice: регулярные backup-ы, тестировать восстановление, хранить в другом регионе.',
                'code_example' => <<<'BASH'
# PostgreSQL логический бэкап
pg_dump -U user -d mydb -F c -f backup.dump

# Восстановление
pg_restore -U user -d mydb backup.dump

# Физический бэкап
pg_basebackup -D /backup -F tar -X stream -P
BASH,
                'code_language' => 'bash',
            ],

            // ===== Партиционирование =====
            [
                'category' => 'Базы данных',
                'question' => 'Что такое партиционирование (partitioning) простыми словами?',
                'answer' => 'Партиционирование - разделение одной таблицы на несколько физических частей (партиций) внутри одной БД, прозрачно для приложения. Простыми словами: если шкаф переполнен, ты разделяешь содержимое по полкам - "одежда зимняя", "одежда летняя". Приложение видит один шкаф, а БД ищет только в нужной полке. Бывает range, list, hash. Преимущества: быстрее запросы (partition pruning), быстрее удаление старых данных (DROP PARTITION), отдельные индексы. Это НЕ шардирование - всё на одном сервере.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Range vs List vs Hash партиционирование?',
                'answer' => 'Range - по диапазонам значений (часто даты): партиция за каждый месяц. Удобно для time-series данных. List - по списку явных значений (по странам, по статусам). Hash - по хешу ключа, равномерно. Range и List лучше когда данные имеют естественные группы; hash - для равномерного распределения по партициям без логических групп.',
                'code_example' => <<<'SQL'
-- PostgreSQL Range Partitioning
CREATE TABLE events (
    id BIGSERIAL,
    occurred_at TIMESTAMP NOT NULL,
    payload JSONB
) PARTITION BY RANGE (occurred_at);

CREATE TABLE events_2024_01 PARTITION OF events
    FOR VALUES FROM ('2024-01-01') TO ('2024-02-01');

CREATE TABLE events_2024_02 PARTITION OF events
    FOR VALUES FROM ('2024-02-01') TO ('2024-03-01');

-- List
CREATE TABLE users PARTITION BY LIST (country);
CREATE TABLE users_ru PARTITION OF users FOR VALUES IN ('RU', 'BY', 'KZ');
CREATE TABLE users_us PARTITION OF users FOR VALUES IN ('US', 'CA');

-- Hash
CREATE TABLE logs PARTITION BY HASH (user_id);
CREATE TABLE logs_0 PARTITION OF logs FOR VALUES WITH (modulus 4, remainder 0);
SQL,
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Чем B-tree индекс отличается от Hash и от GIN, и в каких случаях выбирать GIN?',
                'answer' => 'B-tree - упорядоченное дерево, поддерживает =, <, >, BETWEEN, ORDER BY, LIKE \'prefix%\'. Hash - только равенство, в Postgres с PG10+ wal-логируется и пригоден для интенсивных = поиска. GIN - обратный индекс: ключ → набор строк; идеален для tsvector (full-text), jsonb (?, @>), массивов и trigram (pg_trgm) для LIKE \'%inside%\'. GIN строится медленнее и больше на диске, но запросы по "содержит" выигрывают на порядки.',
                'code_example' => '-- быстрый поиск по вхождению
CREATE INDEX idx_products_name_trgm ON products USING gin (name gin_trgm_ops);
SELECT * FROM products WHERE name ILIKE \'%phone%\';

-- jsonb-фильтр
CREATE INDEX idx_events_payload ON events USING gin (payload);
SELECT * FROM events WHERE payload @> \'{"type":"click"}\';',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Как читать вывод EXPLAIN ANALYZE в PostgreSQL и какие признаки плохого плана?',
                'answer' => 'EXPLAIN показывает план; ANALYZE реально выполняет запрос и добавляет actual time, rows, loops. Тревожные признаки: Seq Scan по большой таблице с селективным WHERE (нет индекса), резкое расхождение rows-estimate vs actual (плохая статистика, нужен ANALYZE), Nested Loop с большим внешним циклом (надо Hash Join), Sort с внешним диском (work_mem мал), Bitmap Heap Scan + Recheck Cond (lossy). Используют BUFFERS для shared hit/read.',
                'code_example' => 'EXPLAIN (ANALYZE, BUFFERS, VERBOSE)
SELECT u.id, COUNT(o.id)
FROM users u JOIN orders o ON o.user_id = u.id
WHERE u.created_at > NOW() - INTERVAL \'30 days\'
GROUP BY u.id;',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Чем отличаются Nested Loop, Hash Join и Merge Join?',
                'answer' => 'Nested Loop: для каждой строки внешней таблицы ищет совпадения во внутренней; эффективен, если внешняя маленькая, а на внутренней есть индекс по ключу. Hash Join: строит хеш-таблицу по меньшей стороне в памяти, потом сканирует большую и ищет совпадения; хорош для больших равенств без индексов. Merge Join: обе стороны отсортированы по ключу - идёт двусторонний слиянием; быстро, если данные уже отсортированы (или есть подходящий индекс).',
                'code_example' => '-- форсируем тип join для теста
SET enable_hashjoin = off;
SET enable_mergejoin = off;
EXPLAIN ANALYZE SELECT * FROM a JOIN b USING (id);',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Объясните уровни изоляции и какие аномалии каждый предотвращает.',
                'answer' => 'READ UNCOMMITTED - допускает dirty read. READ COMMITTED - нет dirty, но возможны non-repeatable read и phantom. REPEATABLE READ - устраняет non-repeatable; в Postgres также фантомы (snapshot), в MySQL InnoDB - фантомы возможны без gap-locks. SERIALIZABLE - полная сериализуемость, в Postgres через SSI с rollback при конфликте, в InnoDB - через range-locks. Также есть write skew - отлавливается только Serializable.',
                'code_example' => '-- write skew пример
BEGIN ISOLATION LEVEL SERIALIZABLE;
SELECT SUM(on_call) FROM doctors WHERE shift = \'night\';
-- если >=2, можно уйти
UPDATE doctors SET on_call = false WHERE id = 1;
COMMIT; -- может откатиться при serialization_failure',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Как работает MVCC в PostgreSQL и зачем нужен VACUUM?',
                'answer' => 'MVCC: каждое UPDATE/DELETE не меняет строку, а создаёт новую версию с xmin (transaction id создания) и xmax (id удаления). Транзакции видят только версии с подходящим xmin/xmax относительно своего snapshot. Старые tuple остаются в таблице как "мертвые" - bloat. VACUUM маркирует их свободными для переиспользования; VACUUM FULL переписывает таблицу. Autovacuum триггерится по threshold; параметры autovacuum_vacuum_scale_factor нужно тюнить для горячих таблиц.',
                'code_example' => '-- увидеть bloat
SELECT relname, n_dead_tup, n_live_tup, last_autovacuum
FROM pg_stat_user_tables
ORDER BY n_dead_tup DESC LIMIT 10;',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое deadlock и как его диагностировать?',
                'answer' => 'Deadlock - циклическое ожидание блокировок между транзакциями: T1 держит A, ждёт B; T2 держит B, ждёт A. БД детектирует цикл и убивает одну транзакцию (deadlock_timeout). Профилактика: блокировать ресурсы в одинаковом порядке (отсортировать ID), уменьшать длительность транзакций, использовать SELECT ... FOR UPDATE NOWAIT/SKIP LOCKED, индексировать колонки в WHERE при UPDATE. В Postgres логи показывают полные query обоих участников.',
                'code_example' => '-- симметричный порядок блокировок
SELECT * FROM accounts WHERE id IN (:a, :b)
ORDER BY id FOR UPDATE;
-- теперь обе транзакции лочат A раньше B',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое covering index и когда он даёт большой выигрыш?',
                'answer' => 'Covering index содержит все колонки, нужные запросу, либо в ключе, либо в INCLUDE (Postgres 11+) - оптимизатор берёт данные прямо из индекса без обращения к heap (Index Only Scan). Это убирает random IO на табличные страницы для широких таблиц. В MySQL InnoDB primary key всегда кластерный, поэтому secondary index, содержащий PK + selected-columns, тоже covering.',
                'code_example' => 'CREATE INDEX idx_orders_status_created
ON orders (status, created_at) INCLUDE (total);
-- запрос обслуживается Index Only Scan
SELECT total FROM orders
WHERE status = \'paid\' AND created_at > NOW() - INTERVAL \'1 day\';',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Какие виды партиционирования есть в Postgres и какие проблемы они решают?',
                'answer' => 'PARTITION BY RANGE (по диапазону, чаще по дате) - типично для логов и time-series, позволяет быстро дропать старые данные через DROP PARTITION. PARTITION BY LIST - по перечислению (страна, тенант). PARTITION BY HASH - равномерное распределение. Partition pruning - оптимизатор не сканирует партиции, не подходящие под WHERE. Local indexes на каждой партиции; declarative partitioning поддерживает FK между партициями только с PG12+.',
                'code_example' => 'CREATE TABLE events (
    id bigserial, created_at timestamptz NOT NULL, payload jsonb
) PARTITION BY RANGE (created_at);

CREATE TABLE events_2026_05 PARTITION OF events
    FOR VALUES FROM (\'2026-05-01\') TO (\'2026-06-01\');',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое replication lag и как с ним жить в read-heavy приложении?',
                'answer' => 'Async-репликация: реплика отстаёт на величину от ms до секунд. Если сразу после записи прочитать с реплики, можно не увидеть свою же запись (read-your-writes). Лекарства: sticky-сессия на мастер N секунд после записи, использование synchronous_commit=remote_apply (синхронная репликация, дороже), read-your-writes routing по cookie/HEAD-запросу. Также Postgres может вернуть LSN после COMMIT и читать с реплики только когда replay_lsn >= нужного.',
                'code_example' => '-- master
COMMIT;
SELECT pg_current_wal_lsn();
-- replica
SELECT pg_last_wal_replay_lsn() >= :lsn;',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое materialized view и когда она лучше обычного view?',
                'answer' => 'View - сохранённый запрос; разворачивается при каждом обращении. Materialized view физически хранит результат, обновляется явно через REFRESH MATERIALIZED VIEW (CONCURRENTLY - без эксклюзивной блокировки, но требует UNIQUE-индекса). Подходит для тяжёлых аналитических агрегатов, которые можно пересчитывать раз в N минут/часов. Минусы: stale data, нужно расписание обновления, индексы строятся отдельно. Альтернатива - incremental rollup в отдельной таблице с обновлением по триггеру или CDC.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Чем отличаются jsonb и json в Postgres и почему jsonb обычно предпочтительнее?',
                'answer' => 'json хранится текстом as-is, сохраняет порядок ключей и whitespace, медленный для запросов. jsonb парсится в бинарный формат при INSERT, ключи нормализованы, дубли удалены, доступ к полям O(log n), поддерживает GIN-индексы и операторы @>, ?, ?|. jsonb предпочтительнее почти всегда - кроме случаев, когда критичен exact-text round-trip (логирование сырых payload).',
                'code_example' => 'CREATE INDEX idx_users_meta ON users USING gin (meta jsonb_path_ops);
SELECT * FROM users WHERE meta @> \'{"plan":"premium"}\';',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Какие отличия между MySQL InnoDB и PostgreSQL практически важны для разработки?',
                'answer' => 'InnoDB: clustered primary index - данные физически отсортированы по PK, secondary indexes хранят PK как pointer. Postgres: heap-таблица + отдельные индексы, никакого clustering. InnoDB lock на gap для phantom; Postgres использует MVCC снапшоты. UPSERT: MySQL - ON DUPLICATE KEY UPDATE, Postgres - ON CONFLICT. Postgres имеет CTE, оконные с расширенным синтаксисом, jsonb, arrays, partial и expression indexes - MySQL это получил позже и беднее.',
                'code_example' => '-- Postgres: partial index только для активных записей
CREATE INDEX idx_users_active_email ON users(email)
WHERE deleted_at IS NULL;
-- MySQL аналога нет - нужен FULL index',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Как устроен оптимизатор запросов и что такое статистики?',
                'answer' => 'Оптимизатор перебирает планы и оценивает стоимость через cost-based модель. Статистики (pg_statistic, ANALYZE) дают cardinality для столбцов: гистограммы, MCV, n_distinct. На их основе оценивается selectivity предикатов и размер промежуточных наборов. Если статистики устарели или коррелированные предикаты - план кривой. Решения: ANALYZE, увеличить default_statistics_target, CREATE STATISTICS для функциональных зависимостей.',
                'code_example' => '-- multivariate statistics для коррелированных колонок
CREATE STATISTICS orders_corr (dependencies)
ON status, payment_method FROM orders;
ANALYZE orders;',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое CAP-теорема и как она применяется в выборе БД?',
                'answer' => 'CAP: при network partition распределённая система может обеспечить либо Consistency, либо Availability - не оба. Single-leader RDBMS (Postgres, MySQL) - CP: при потере связи с мастером пишущая сторона недоступна. Cassandra/DynamoDB - AP: всегда отвечают, но возможна eventual consistency. Реальные системы тонко настраиваются: Postgres с synchronous_standby даёт сильнее C, ослабляет A; Cassandra QUORUM - компромисс. PACELC расширяет CAP, добавляя trade-off latency vs consistency без partition.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое write skew и приведите пример из реального приложения.',
                'answer' => 'Write skew - две транзакции читают пересекающийся набор строк, принимают решение на основе snapshot и пишут разные строки, нарушая инвариант. Классический пример: дежурство врачей. Две транзакции видят, что дежурят 2 человека, и одновременно "уходят домой" - оба отметят off-call, нарушив правило "минимум один". REPEATABLE READ не ловит write skew, нужен SERIALIZABLE или SELECT FOR UPDATE на конфликтующие строки.',
                'code_example' => '-- защита через SELECT FOR UPDATE
BEGIN;
SELECT count(*) FROM doctors WHERE on_call = true FOR UPDATE;
-- если > 1, можно отключиться
UPDATE doctors SET on_call = false WHERE id = :me;
COMMIT;',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Как реализовать поиск с пагинацией без OFFSET и почему OFFSET плохой?',
                'answer' => 'OFFSET N сканирует и отбрасывает первые N строк - стоимость линейная, на 10-й странице запрос медленнее, чем на 1-й, при том же limit. Keyset (cursor) пагинация использует значение последней увиденной строки в WHERE и ORDER BY: WHERE (created_at, id) < (:last_at, :last_id). Стоимость стабильна и низкая при индексе на (created_at, id). Минус - нельзя прыгнуть на конкретную страницу, только next/prev.',
                'code_example' => '-- keyset pagination
SELECT id, title, created_at FROM posts
WHERE (created_at, id) < (:cursor_at, :cursor_id)
ORDER BY created_at DESC, id DESC
LIMIT 20;',
                'code_language' => 'sql',
            ],

            // ===== Краткие Q/A =====
            [
                'category' => 'Базы данных',
                'question' => 'Что такое индекс и когда он не помогает?',
                'answer' => 'Структура для ускорения поиска по столбцам. Не помогает на маленьких таблицах, при низкой селективности, при функциях/преобразованиях столбца, при LIKE %x%.',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Чем отличается INNER JOIN от LEFT JOIN?',
                'answer' => 'INNER возвращает только пары, удовлетворяющие условию. LEFT возвращает все строки слева плюс совпадения справа, отсутствующие справа заполняются NULL.',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое нормальные формы и зачем нормализация?',
                'answer' => 'Правила декомпозиции таблиц для устранения избыточности и аномалий. 1НФ - атомарность, 2НФ - зависимость от полного ключа, 3НФ - отсутствие транзитивных зависимостей.',
            ],

            // ===== Cloze =====
            [
                'category' => 'Базы данных',
                'question' => 'Заполни SQL для топ-10 пользователей по количеству заказов.',
                'answer' => 'GROUP BY с COUNT и сортировкой DESC, LIMIT - стандартная конструкция top-N.',
                'cloze_text' => 'SELECT u.id, COUNT(o.id) AS orders
FROM users u
{{LEFT JOIN}} orders o ON o.user_id = u.id
{{GROUP BY}} u.id
ORDER BY orders {{DESC}}
LIMIT 10;',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Заполни оконную функцию для нумерации заказов внутри пользователя по дате.',
                'answer' => 'ROW_NUMBER() с PARTITION BY раскладывает строки по группам и нумерует внутри каждой согласно ORDER BY.',
                'cloze_text' => 'SELECT id, user_id,
       {{ROW_NUMBER}}() OVER ({{PARTITION BY}} user_id ORDER BY created_at) AS n
FROM orders;',
                'code_language' => 'sql',
            ],

            // ===== Type-in =====
            [
                'category' => 'Базы данных',
                'question' => 'SQL-команда, объединяющая результаты двух запросов без дубликатов.',
                'answer' => 'UNION удаляет дубликаты, UNION ALL - оставляет.',
                'short_answer' => 'UNION',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'SQL-конструкция для условного выражения, аналог if/then.',
                'answer' => 'CASE WHEN ... THEN ... ELSE ... END - стандартное портируемое выражение.',
                'short_answer' => 'CASE',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Уровень изоляции, при котором допустимы non-repeatable reads и phantom reads.',
                'answer' => 'READ COMMITTED - компромиссный уровень по умолчанию во многих БД (Postgres, Oracle).',
                'short_answer' => 'READ COMMITTED',
            ],

            // ===== Assemble =====
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
            ],
        ];
    }
}
