<?php

namespace Database\Seeders\Data\Categories\Laravel;

class EloquentBasics
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Что такое Eloquent ORM?',
                'answer' => 'Eloquent - это ORM (Object Relational Mapper) Laravel, реализующий паттерн Active Record. Простыми словами: каждая таблица в БД представлена классом-моделью, а каждая запись в таблице - объектом этого класса. Вместо SQL пишем понятный объектный код.',
                'code_example' => 'class User extends Model {
    protected $fillable = [\'name\', \'email\'];
}

$user = User::create([\'name\' => \'Anna\', \'email\' => \'a@b.c\']);
$user = User::find(1);
$users = User::where(\'active\', true)->get();',
                'code_language' => 'php',
                'difficulty' => 1,
                'topic' => 'laravel.eloquent_basics',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие основные CRUD-методы есть у Eloquent-модели?',
                'answer' => 'create() - создать запись из массива. save() - сохранить экземпляр. update() - обновить. delete() - удалить. find($id), findOrFail($id), first(), firstOrFail(), all(), get(). fresh() - получить актуальную копию из БД (новый экземпляр). refresh() - обновить ТЕКУЩИЙ экземпляр данными из БД.',
                'code_example' => '$user = User::create([\'name\' => \'A\', \'email\' => \'a@b.c\']);
$user->name = \'B\';
$user->save();

$user->update([\'name\' => \'C\']);

$fresh = $user->fresh(); // новый объект
$user->refresh();        // обновляет тот же объект

$user->delete();',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'laravel.eloquent_basics',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое mass assignment и зачем нужны $fillable и $guarded?',
                'answer' => 'Mass assignment - это создание/обновление модели массивом данных (User::create($input)). Это опасно: пользователь может подсунуть лишние поля (например is_admin). Поэтому Laravel требует явно указать разрешённые поля через $fillable (whitelist) или запрещённые через $guarded (blacklist). Можно использовать только одно из двух.',
                'code_example' => 'class User extends Model {
    protected $fillable = [\'name\', \'email\', \'password\'];
    // или
    protected $guarded = [\'is_admin\']; // все поля разрешены кроме is_admin
}',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'laravel.eloquent_basics',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое casts в Eloquent?',
                'answer' => 'Casts - это автоматическое преобразование атрибутов модели при чтении/записи. Например, поле в БД хранится как JSON-строка, а в коде вы работаете с массивом. Стандартные касты: int, bool, array, json, datetime, decimal:2, encrypted, AsArrayObject, AsCollection.',
                'code_example' => 'class User extends Model {
    protected $casts = [
        \'is_admin\' => \'bool\',
        \'options\' => \'array\',
        \'birthday\' => \'datetime\',
        \'salary\' => \'decimal:2\',
    ];
}',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'laravel.eloquent_basics',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как создать кастомный cast?',
                'answer' => 'Кастомный cast - это класс, реализующий CastsAttributes с методами get (как читать) и set (как сохранять). Удобно для Value Objects.',
                'code_example' => 'class MoneyCast implements CastsAttributes {
    public function get($model, $key, $value, $attributes): Money {
        return new Money($value, $attributes[\'currency\'] ?? \'USD\');
    }

    public function set($model, $key, $value, $attributes): array {
        return [
            \'amount\' => $value->amount,
            \'currency\' => $value->currency,
        ];
    }
}

protected $casts = [\'price\' => MoneyCast::class];',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.eloquent_basics',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Accessors и Mutators? Какой современный синтаксис?',
                'answer' => 'Accessor - это метод, который преобразует значение при ЧТЕНИИ атрибута. Mutator - при ЗАПИСИ. Старый синтаксис: getNameAttribute / setNameAttribute. Новый синтаксис (Laravel 9+): метод возвращает Attribute с get и set.',
                'code_example' => '// Старый синтаксис
public function getNameAttribute($value) {
    return ucfirst($value);
}
public function setNameAttribute($value): void {
    $this->attributes[\'name\'] = strtolower($value);
}

// Новый синтаксис
protected function name(): Attribute {
    return Attribute::make(
        get: fn($value) => ucfirst($value),
        set: fn($value) => strtolower($value),
    );
}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_basics',
            ],
            [
                'category' => 'Laravel',
                'question' => 'В чём разница между firstOrCreate, updateOrCreate и upsert?',
                'answer' => 'firstOrCreate - найти запись по условию или создать новую (если нет). updateOrCreate - найти и обновить, либо создать. Оба работают по 1 строке и срабатывают события модели. upsert - массовая операция: вставить/обновить много записей одним запросом, БЕЗ событий моделей.',
                'code_example' => 'User::firstOrCreate(
    [\'email\' => \'a@b.c\'],
    [\'name\' => \'Anna\']
);

User::updateOrCreate(
    [\'email\' => \'a@b.c\'],
    [\'name\' => \'Updated\']
);

User::upsert([
    [\'email\' => \'a@b.c\', \'name\' => \'A\'],
    [\'email\' => \'b@b.c\', \'name\' => \'B\'],
], uniqueBy: [\'email\'], update: [\'name\']);',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_basics',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Query Builder в Laravel?',
                'answer' => 'Query Builder - это инструмент для построения SQL-запросов через PHP-методы, не привязанный к моделям. Простыми словами: альтернатива Eloquent для случаев, когда не нужна модель, или для тяжёлых SQL.',
                'code_example' => 'use Illuminate\Support\Facades\DB;

$users = DB::table(\'users\')
    ->select(\'id\', \'name\')
    ->where(\'active\', true)
    ->whereIn(\'role\', [\'admin\', \'editor\'])
    ->orderBy(\'created_at\', \'desc\')
    ->limit(10)
    ->get();',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'laravel.eloquent_basics',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как делать joins в Query Builder?',
                'answer' => 'Через методы join (INNER), leftJoin, rightJoin, crossJoin. Можно передавать closure для сложных условий. В Eloquent тоже работает.',
                'code_example' => 'DB::table(\'users\')
    ->join(\'posts\', \'users.id\', \'=\', \'posts.user_id\')
    ->leftJoin(\'profiles\', \'users.id\', \'=\', \'profiles.user_id\')
    ->select(\'users.*\', \'posts.title\')
    ->get();',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_basics',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как использовать сырые выражения (raw expressions) в Query Builder?',
                'answer' => 'DB::raw() для сырого SQL внутри select/where. selectRaw, whereRaw, orderByRaw, havingRaw - для удобства. ВАЖНО: при использовании raw нельзя подставлять данные пользователя без bindings - это SQL-injection.',
                'code_example' => 'DB::table(\'users\')
    ->selectRaw(\'COUNT(*) as total, status\')
    ->whereRaw(\'created_at > ?\', [now()->subMonth()])
    ->groupBy(\'status\')
    ->get();',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_basics',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое DB::transaction и как работают вложенные транзакции?',
                'answer' => 'DB::transaction оборачивает код в транзакцию: если внутри callback бросается исключение - rollback, иначе - commit. Поддерживаются deadlock-retries (второй аргумент). Альтернатива: DB::beginTransaction, DB::commit, DB::rollBack вручную. Важный нюанс про вложенные транзакции: в MySQL/Postgres настоящих nested transactions НЕ существует, Laravel эмулирует их через SAVEPOINT. Из этого вытекает несколько ловушек. 1) Если ВНЕШНЯЯ транзакция откатится, откатятся и все ранее "успешно закоммиченные" внутренние - они были лишь RELEASE SAVEPOINT, не самостоятельными коммитами. Поэтому события/уведомления, которые должны сработать только после фактического коммита, оборачивают в DB::afterCommit() или используют свойство $afterCommit. 2) PostgreSQL-специфика: после ЛЮБОЙ ошибки SQL внутри транзакции она переходит в состояние "current transaction is aborted" - все следующие запросы возвращают "current transaction is aborted, commands ignored until end of transaction block", пока не сделать ROLLBACK или ROLLBACK TO SAVEPOINT. Хорошая новость: DB::transaction(callable) АВТОМАТИЧЕСКИ ловит исключение, вызывает $this->rollBack() (= ROLLBACK TO SAVEPOINT для вложенных) и пробрасывает исключение наружу - выловив его во внешнем callback, можно безопасно продолжать (savepoint уже откачен). 3) Опасный паттерн возникает при РУЧНОМ DB::beginTransaction: если вы поймали исключение через try/catch и НЕ вызвали DB::rollBack() сами, в PG транзакция остаётся в aborted state, и все следующие запросы упадут. То же самое если ловить исключение НА УРОВНЕ savepoint, но не в обёртке DB::transaction. Правило: используйте DB::transaction(callable) и не глотайте исключения внутри без явного rollBack.',
                'code_example' => '<?php
// ✅ Закрытая форма - Laravel сам ловит и rollback-ает (включая SAVEPOINT)
DB::transaction(function () {
    User::create([...]);
    Post::create([...]);
}, attempts: 3);

// ✅ Вложенные через DB::transaction - savepoint автоматически откатывается
DB::transaction(function () {
    try {
        DB::transaction(function () {
            User::create([...]);     // SAVEPOINT trans2
            throw new RuntimeException("oops"); // ROLLBACK TO SAVEPOINT trans2
        });
    } catch (RuntimeException) {
        // savepoint уже откачен Laravel-ом, можно продолжать
        Order::create([...]);        // в PG это сработает корректно
    }
});

// ❌ Ручной beginTransaction + проглоченное исключение - в PG ломается
DB::beginTransaction();
try {
    User::query()->insert([...invalid...]);  // SQL error
} catch (Throwable $e) {
    Log::error($e); // НЕ вызвали rollBack!
}
User::create([...]); // ⚠️ PG: "current transaction is aborted"

// ✅ Правильно: всегда rollBack после catch при ручном управлении
DB::beginTransaction();
try {
    /* ... */
    DB::commit();
} catch (Throwable $e) {
    DB::rollBack();
    throw $e;
}

// Ловушка #1: откат внешней транзакции отменит "закоммиченную" внутреннюю
DB::transaction(function () use ($order) {
    DB::transaction(function () use ($order) {
        $order->update(["status" => "paid"]); // SAVEPOINT trans2
    }); // RELEASE SAVEPOINT trans2 - "закоммичено"

    throw new RuntimeException("fail"); // откатит ВСЁ, включая update выше
});

// Поэтому события - через afterCommit
DB::transaction(function () use ($user) {
    $user->save();
    DB::afterCommit(fn () => Mail::send(new WelcomeMail($user)));
    // отправится только после реального коммита самой ВНЕШНЕЙ транзакции
});',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_basics',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое custom cast и чем он отличается от accessor/mutator?',
                'answer' => 'Accessor/mutator - методы getXAttribute/setXAttribute на одной модели, дублируются между моделями. Custom cast (CastsAttributes) - отдельный класс, инкапсулирует пару get/set, переиспользуется на любых моделях. Поддерживает Castable-интерфейс на value object (Money::castUsing()), что даёт чистую интеграцию с DDD. Также есть AsCollection, AsEncryptedCollection, AsArrayObject из коробки.',
                'code_example' => '<?php
final class MoneyCast implements CastsAttributes {
    public function get($model, $key, $value, $attrs) {
        return new Money((int) $attrs["{$key}_amount"], $attrs["{$key}_currency"]);
    }
    public function set($model, $key, $value, $attrs) {
        return ["{$key}_amount" => $value->amount, "{$key}_currency" => $value->currency];
    }
}',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.eloquent_basics',
            ],
            [
                'category' => 'Laravel',
                'question' => 'В чём разница между firstOrCreate, updateOrCreate и upsert?',
                'answer' => 'firstOrCreate ищет по атрибутам и создаёт, если нет; не атомарен - между select и insert возможна гонка, лучше иметь UNIQUE-индекс. updateOrCreate дополнительно обновляет поля у найденного. upsert делает массовый INSERT ... ON DUPLICATE KEY UPDATE (MySQL) или ON CONFLICT (Postgres) и атомарен на уровне БД, обходит каждую строку без N запросов. Используйте upsert для импорта, и uniques + транзакцию для одиночных кейсов.',
                'code_example' => '<?php
User::upsert(
    [["email" => "a@b", "name" => "A"], ["email" => "c@d", "name" => "C"]],
    uniqueBy: ["email"],
    update:   ["name"],
);',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.eloquent_basics',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем ULID лучше UUID v4 в качестве первичного ключа?',
                'answer' => 'UUID v4 - случайные 128 бит. При вставке в B-tree индекс новые ключи попадают в произвольные места дерева - страдает кеш страниц БД, индекс фрагментируется, растёт число page splits и тормозят INSERT при высокой нагрузке. ULID (Universally Unique Lexicographically Sortable Identifier) - те же 128 бит, но первые 48 бит - timestamp в миллисекундах, последние 80 - случайные. Из-за timestamp-префикса ULID лексикографически (и численно) сортируется по времени создания, поэтому новые записи идут в "правый край" B-tree, как обычный auto-increment - индекс не фрагментируется, INSERT-производительность близка к bigint PK. Бонусы: можно сортировать по PK вместо created_at, текстовое представление компактнее (26 символов против 36). Минус: примерное время создания записи утекает через ID, поэтому не использовать в публичных URL для чувствительных ресурсов. В Laravel есть HasUlids trait + helper $table->ulid() в миграциях. Альтернатива - UUID v7 (тот же подход с timestamp-префиксом, стандартизирован в RFC 9562) - в Laravel 11+ доступен через Str::uuid7().',
                'code_example' => '<?php
use Illuminate\\Database\\Eloquent\\Concerns\\HasUlids;

class Order extends Model
{
    use HasUlids; // вместо HasUuids

    // primary key теперь string CHAR(26), сортируемый по времени
}

// миграция
Schema::create("orders", function (Blueprint $table) {
    $table->ulid("id")->primary(); // вместо $table->uuid()->primary()
    $table->timestamps();
});

// результат: 01HRZ8K3M9... - первые символы растут со временем
// → новые ID идут в конец B-tree, без фрагментации',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.eloquent_basics',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем опасен DB::raw() и как делать безопасные подстановки в raw-выражения?',
                'answer' => 'DB::raw() (и его обёртки selectRaw, whereRaw, orderByRaw, havingRaw) вставляет переданную строку прямо в SQL без экранирования - это окно для SQL-injection, если в строке оказались данные пользователя. Классический антипаттерн: ->whereRaw("status = \'{$request->status}\'"). Правильный способ - использовать ВТОРОЙ аргумент с массивом bindings, который проходит через PDO-плейсхолдеры (?) и экранируется драйвером БД: ->whereRaw("status = ?", [$request->status]). У selectRaw, orderByRaw, havingRaw - такой же второй аргумент. Если динамическим является имя столбца или направление сортировки (которые НЕЛЬЗЯ передать через bindings - это часть синтаксиса, а не значение), нужно жёстко валидировать вход через whitelist (in_array($column, $allowed, true)), иначе пользователь сможет передать "; DROP TABLE users;--". Безопасные альтернативы: для огромных списков чисел - whereIntegerInRaw($col, $array) (Laravel приводит каждый элемент к int через (int)$value и склеивает строку без bindings - спасает от лимита PDO в ~65k плейсхолдеров и ускоряет запрос; работает ТОЛЬКО с целыми числами и ТОЛЬКО для одиночных колонок - не подходит для составных ключей и строк, для них whereIn остаётся единственным безопасным вариантом); для динамических колонок - Schema::hasColumn() + whitelist. Также избегайте DB::statement($userInput) - там вообще нет bindings.',
                'code_example' => '<?php
// УЯЗВИМО - SQL-injection
DB::table("users")
    ->whereRaw("email = \'" . request("email") . "\'")
    ->get();

DB::table("users")
    ->orderByRaw(request("sort")) // "; DROP TABLE users;--"
    ->get();

// ПРАВИЛЬНО - bindings через ?
DB::table("orders")
    ->selectRaw("price * ? as price_with_tax", [1.0825])
    ->whereRaw("price > IF(state = ?, ?, ?)", ["TX", 200, 100])
    ->get();

// Динамическая колонка - whitelist, не bindings
$allowed = ["id", "created_at", "name"];
$column  = in_array(request("sort"), $allowed, true) ? request("sort") : "id";
$direction = request("direction") === "desc" ? "desc" : "asc";
User::orderBy($column, $direction)->get();

// Безопасный путь для массива чисел
User::whereIntegerInRaw("id", $userIds)->get();',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.eloquent_basics',
            ],
        ];
    }
}
