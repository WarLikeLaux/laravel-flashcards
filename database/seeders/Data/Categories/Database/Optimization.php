<?php

namespace Database\Seeders\Data\Categories\Database;

class Optimization
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
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
                'difficulty' => 4,
                'topic' => 'database.optimization',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Nested Loop, Hash Join, Merge Join?',
                'answer' => 'Это три алгоритма JOIN. Nested Loop: для каждой строки слева ищем подходящие справа (хорошо когда слева мало строк и есть индекс справа). Hash Join: строим хэш-таблицу из правой стороны и для каждой левой ищем в хэше O(1) (хорошо для больших таблиц без индексов). Merge Join: обе стороны должны быть отсортированы по ключу JOIN, идём слиянием как при merge sort (хорошо для уже отсортированных данных). Планировщик сам выбирает.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'database.optimization',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Когда стоит добавлять индекс?',
                'answer' => 'Добавлять индекс стоит, когда: столбец часто в WHERE/JOIN/ORDER BY и таблица большая; запрос медленный, EXPLAIN показывает Seq Scan; столбец имеет высокую cardinality; чтений намного больше записей. НЕ стоит: маленькие таблицы (<1000 строк), очень частые INSERT/UPDATE, низкая селективность фильтра.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'database.optimization',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Почему слишком много индексов - это плохо?',
                'answer' => 'Каждый индекс: занимает место на диске, замедляет INSERT/UPDATE/DELETE (БД должна обновлять все индексы), увеличивает время бэкапов, может запутать планировщик и привести к выбору не самого быстрого. Правило: индексируй только то, что реально часто запрашивается. Удаляй неиспользуемые индексы (в PG: pg_stat_user_indexes).',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'database.optimization',
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
                'difficulty' => 3,
                'topic' => 'database.optimization',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое N+1 проблема и как её решать?',
                'answer' => 'N+1 - проблема ORM, когда для получения N записей делается 1 запрос на список + N запросов на связанные данные. Например, 100 пользователей -> 1 + 100 = 101 запрос. Решение: eager loading (Eloquent: with(), JPA: JOIN FETCH), JOIN-ы вручную, dataloader (для GraphQL). В Laravel: User::with("posts")->get() вместо ->get() + загрузка $user->posts по требованию.',
                'code_example' => <<<'PHP'
// Плохо: N+1 (1 запрос users + N запросов posts)
$users = User::all();
foreach ($users as $user) {
    echo $user->posts->count(); // ленивая загрузка posts на каждой итерации
}

// Хорошо: eager loading (всего 2 запроса)
$users = User::with('posts')->get();
foreach ($users as $user) {
    echo $user->posts->count(); // posts уже загружены, count() по коллекции
}

// Ещё лучше для счётчиков: withCount (один запрос с подзапросом)
$users = User::withCount('posts')->get();
foreach ($users as $user) {
    echo $user->posts_count;
}
PHP,
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'database.optimization',
            ],
        ];
    }
}
