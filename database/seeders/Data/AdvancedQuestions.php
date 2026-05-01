<?php

namespace Database\Seeders\Data;

class AdvancedQuestions
{
    /**
     * @return array<int, array{
     *     category: string,
     *     question: string,
     *     answer: string,
     *     code_example?: string|null,
     *     code_language?: string|null,
     *     cloze_text?: string|null,
     *     short_answer?: string|null,
     *     assemble_chunks?: array<int, string>|null
     * }>
     */
    public static function all(): array
    {
        return array_merge(
            self::cloze(),
            self::typeIn(),
            self::assemble(),
        );
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private static function cloze(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Заполни команду artisan для создания resource-контроллера UserController.',
                'answer' => 'php artisan make:controller UserController --resource создаёт контроллер с CRUD-методами index/create/store/show/edit/update/destroy.',
                'cloze_text' => 'php artisan {{make:controller}} UserController {{--resource}}',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Заполни Eloquent-определение связи "many-to-many" с пивотом role_user.',
                'answer' => 'belongsToMany определяется на обеих моделях. Пивот-таблица по умолчанию называется в алфавитном порядке singular-имён моделей.',
                'cloze_text' => 'public function roles() {
    return $this->{{belongsToMany}}(Role::class)->{{withTimestamps}}();
}',
                'code_example' => 'Schema::create(\'role_user\', function (Blueprint $table) {
    $table->foreignId(\'user_id\')->constrained()->cascadeOnDelete();
    $table->foreignId(\'role_id\')->constrained()->cascadeOnDelete();
    $table->timestamps();
});',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Заполни вызов очереди с retries и backoff.',
                'answer' => 'public свойства $tries и $backoff на классе Job настраивают количество попыток и задержку между ними.',
                'cloze_text' => 'class ProcessOrder implements ShouldQueue {
    public int ${{tries}} = 5;
    public array ${{backoff}} = [10, 30, 120];
}',
            ],
            [
                'category' => 'Database',
                'question' => 'Заполни SQL для топ-10 пользователей по количеству заказов.',
                'answer' => 'GROUP BY с COUNT и сортировкой DESC, LIMIT — стандартная конструкция top-N.',
                'cloze_text' => 'SELECT u.id, COUNT(o.id) AS orders
FROM users u
{{LEFT JOIN}} orders o ON o.user_id = u.id
{{GROUP BY}} u.id
ORDER BY orders {{DESC}}
LIMIT 10;',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Database',
                'question' => 'Заполни оконную функцию для нумерации заказов внутри пользователя по дате.',
                'answer' => 'ROW_NUMBER() с PARTITION BY раскладывает строки по группам и нумерует внутри каждой согласно ORDER BY.',
                'cloze_text' => 'SELECT id, user_id,
       {{ROW_NUMBER}}() OVER ({{PARTITION BY}} user_id ORDER BY created_at) AS n
FROM orders;',
                'code_language' => 'sql',
            ],
            [
                'category' => 'PHP',
                'question' => 'Заполни сигнатуру readonly value-object Money с конструктором.',
                'answer' => 'final readonly class фиксирует иммутабельность всех нестатических свойств. Promoted parameters позволяют объявить и инициализировать поля одной строкой.',
                'cloze_text' => 'final {{readonly}} class Money {
    public function __construct(
        public {{int}} $amount,
        public string $currency,
    ) {}
}',
            ],
            [
                'category' => 'PHP',
                'question' => 'Заполни match-выражение для типов HTTP-методов.',
                'answer' => 'match сравнивает строго через === и обязан покрывать все ветки, иначе бросит UnhandledMatchError.',
                'cloze_text' => '$cmd = {{match}}($method) {
    "GET", "HEAD" => "read",
    "POST", "PUT", "PATCH" => "write",
    "DELETE" => "delete",
    {{default}} => throw new InvalidArgumentException(),
};',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Заполни scope для активных пользователей и его использование.',
                'answer' => 'Локальный scope — метод scopeXxx, доступный без префикса через query builder.',
                'cloze_text' => 'public function {{scopeActive}}(Builder $q): Builder {
    return $q->where("active", {{true}});
}
// usage:
User::{{active}}()->get();',
            ],
            [
                'category' => 'OOP',
                'question' => 'Заполни декларацию интерфейса и реализации для команды.',
                'answer' => 'interface вводит контракт, implements обязывает класс реализовать все методы.',
                'cloze_text' => '{{interface}} Command {
    public function execute(): void;
}

class SendEmail {{implements}} Command {
    public function execute(): void { /* ... */ }
}',
            ],
            [
                'category' => 'PHP',
                'question' => 'Заполни generator для чтения большого CSV.',
                'answer' => 'yield делает функцию ленивым итератором: на каждой итерации читается одна строка, а не весь файл целиком.',
                'cloze_text' => 'function readCsv(string $path): {{Generator}} {
    $h = fopen($path, "r");
    while (($row = fgetcsv($h)) !== false) {
        {{yield}} $row;
    }
    fclose($h);
}',
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private static function typeIn(): array
    {
        return [
            [
                'category' => 'PHP',
                'question' => 'Функция PHP для разбиения строки на массив по разделителю.',
                'answer' => 'explode($delimiter, $string, $limit = PHP_INT_MAX) — обратная к implode/join.',
                'short_answer' => 'explode',
                'code_example' => '$parts = explode(",", "a,b,c"); // ["a","b","c"]',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Функция, склеивающая массив строк в одну строку.',
                'answer' => 'implode($glue, $array). Алиас — join.',
                'short_answer' => 'implode',
            ],
            [
                'category' => 'PHP',
                'question' => 'Функция, возвращающая количество элементов массива.',
                'answer' => 'count($array, $mode = COUNT_NORMAL). Алиас — sizeof.',
                'short_answer' => 'count',
            ],
            [
                'category' => 'PHP',
                'question' => 'Функция для проверки существования ключа в массиве (не путать с isset).',
                'answer' => 'array_key_exists возвращает true даже если значение под ключом — null, в отличие от isset.',
                'short_answer' => 'array_key_exists',
            ],
            [
                'category' => 'PHP',
                'question' => 'Функция для сортировки ассоциативного массива по значениям с сохранением ключей.',
                'answer' => 'asort сортирует по значению по возрастанию и сохраняет ассоциативные ключи. arsort — то же по убыванию.',
                'short_answer' => 'asort',
            ],
            [
                'category' => 'PHP',
                'question' => 'SPL-класс для очереди FIFO с push/pop в обоих концах.',
                'answer' => 'SplDoublyLinkedList — основа для SplQueue (FIFO) и SplStack (LIFO).',
                'short_answer' => 'SplDoublyLinkedList',
            ],
            [
                'category' => 'PHP',
                'question' => 'Функция для безопасного сравнения строк, устойчивая к timing-атакам.',
                'answer' => 'hash_equals($known, $user) выполняется за константное время и применяется при сравнении токенов/HMAC.',
                'short_answer' => 'hash_equals',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Команда artisan, очищающая весь app-cache (config, route, view, events).',
                'answer' => 'optimize:clear объединяет config:clear, route:clear, view:clear, event:clear, cache:clear.',
                'short_answer' => 'optimize:clear',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Метод query builder для агрегата по выбранному столбцу с округлением вниз.',
                'answer' => 'Метод avg возвращает среднее значение. Похожие: sum, max, min, count.',
                'short_answer' => 'avg',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Хелпер, который возвращает singleton-экземпляр приложения.',
                'answer' => 'app() без аргументов вернёт Illuminate\\Foundation\\Application; с аргументом — резолвит зависимость из контейнера.',
                'short_answer' => 'app',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Метод модели, перезагружающий её атрибуты из БД.',
                'answer' => 'fresh() возвращает новый экземпляр, refresh() перезаписывает текущий и возвращает $this.',
                'short_answer' => 'refresh',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Фасад для отправки события в очередь broadcast.',
                'answer' => 'event(new SomethingHappened(...)) публикует событие; для broadcasting класс реализует ShouldBroadcast.',
                'short_answer' => 'event',
            ],
            [
                'category' => 'Database',
                'question' => 'SQL-команда, объединяющая результаты двух запросов без дубликатов.',
                'answer' => 'UNION удаляет дубликаты, UNION ALL — оставляет.',
                'short_answer' => 'UNION',
            ],
            [
                'category' => 'Database',
                'question' => 'SQL-конструкция для условного выражения, аналог if/then.',
                'answer' => 'CASE WHEN ... THEN ... ELSE ... END — стандартное портируемое выражение.',
                'short_answer' => 'CASE',
            ],
            [
                'category' => 'Database',
                'question' => 'Уровень изоляции, при котором допустимы non-repeatable reads и phantom reads.',
                'answer' => 'READ COMMITTED — компромиссный уровень по умолчанию во многих БД (Postgres, Oracle).',
                'short_answer' => 'READ COMMITTED',
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private static function assemble(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Собери Eloquent-запрос: всех активных юзеров, упорядоченных по имени.',
                'answer' => 'Цепочка scope/where с orderBy и завершающим get возвращает Collection.',
                'assemble_chunks' => ['User::', "where('active', 1)", '->', "orderBy('name')", '->', 'get()'],
                'code_example' => 'User::where(\'active\', 1)->orderBy(\'name\')->get();',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Собери eager load с ограничением relations.',
                'answer' => 'with принимает имя relation или массив. Замыкание доращивает запрос на загружаемом отношении.',
                'assemble_chunks' => [
                    'Post::',
                    "with(['comments' => fn(\$q) => \$q->latest()])",
                    '->',
                    'paginate(20)',
                ],
            ],
            [
                'category' => 'Laravel',
                'question' => 'Собери транзакцию с retry на 3 попытки.',
                'answer' => 'DB::transaction(closure, attempts) сам ретраит на deadlock-исключениях.',
                'assemble_chunks' => [
                    'DB::',
                    'transaction(function () {',
                    '    Account::lockForUpdate()->find($id);',
                    '    // ...',
                    '}, 3)',
                ],
            ],
            [
                'category' => 'Laravel',
                'question' => 'Собери диспатч джобы в очередь high с задержкой 30 секунд.',
                'answer' => 'onQueue выбирает очередь, delay — отложенный запуск.',
                'assemble_chunks' => [
                    'ProcessOrder::',
                    'dispatch($order)',
                    '->',
                    "onQueue('high')",
                    '->',
                    'delay(now()->addSeconds(30))',
                ],
            ],
            [
                'category' => 'Laravel',
                'question' => 'Собери rate-limited маршрут в группе.',
                'answer' => 'middleware throttle принимает имя именованного limiter или формат N,M.',
                'assemble_chunks' => [
                    'Route::',
                    "middleware(['auth', 'throttle:60,1'])",
                    '->',
                    'group(function () {',
                    '    Route::get(\'/profile\', ProfileController::class);',
                    '})',
                ],
            ],
            [
                'category' => 'Database',
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
                'category' => 'Database',
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
            [
                'category' => 'PHP',
                'question' => 'Собери цепочку Collection: уникальные emails из активных юзеров.',
                'answer' => 'Coллекции — fluent. filter, pluck, unique, values образуют ленивую цепочку (на eager при collect).',
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
            ],
            [
                'category' => 'PHP',
                'question' => 'Собери try/catch для нескольких типов исключений.',
                'answer' => 'Multi-catch (PHP 8.0): TypeA|TypeB $e — общий блок для нескольких типов.',
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
            ],
            [
                'category' => 'OOP',
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
