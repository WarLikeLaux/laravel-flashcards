<?php

namespace Database\Seeders\Data\Categories\Laravel;

class EloquentAdvanced
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Что такое Eager Loading и зачем он нужен?',
                'answer' => 'Eager loading - это предварительная загрузка связей одним или несколькими запросами вместо ленивой загрузки на каждом обращении. Простыми словами: вместо N+1 запросов делается всего 2. Используется метод with() при запросе или load() уже после получения коллекции.',
                'code_example' => '// плохо (N+1)
foreach (Post::all() as $post) {
    echo $post->user->name; // запрос к БД на каждом посте
}

// хорошо (eager loading)
foreach (Post::with(\'user\')->get() as $post) {
    echo $post->user->name; // 0 доп. запросов
}

// load - после получения
$posts = Post::all();
$posts->load(\'comments\');',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое проблема N+1 и как её обнаружить?',
                'answer' => 'N+1 - это антипаттерн, при котором делается 1 запрос для основной выборки и ещё N запросов для связей. На 100 постов получится 101 запрос вместо 2. Решение: eager loading (with). Обнаружить можно через Laravel Debugbar, Telescope, либо включить Model::preventLazyLoading() в AppServiceProvider - тогда будет ошибка при попытке lazy load.',
                'code_example' => '// в AppServiceProvider::boot()
Model::preventLazyLoading(! app()->isProduction());

// или одноразово
Post::preventLazyLoading();',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что делает Model::shouldBeStrict() и зачем он нужен?',
                'answer' => 'shouldBeStrict() (Laravel 9.3+) - один вызов, включающий три защитных режима для Eloquent: 1) preventLazyLoading() - бросает LazyLoadingViolationException при попытке lazy load связи (ловит N+1 на этапе разработки). 2) preventSilentlyDiscardingAttributes() - бросает MassAssignmentException, если в fill() / create() передан атрибут, не указанный в $fillable, вместо тихого игнорирования. 3) preventAccessingMissingAttributes() - бросает MissingAttributeException при обращении к полю, которого нет в загруженной модели (например, забыли select() нужное поле). Стандартная практика: вызывать в AppServiceProvider::boot() с условием !isProduction(), чтобы не уронить прод неожиданным исключением.',
                'code_example' => '<?php
// AppServiceProvider::boot()
use Illuminate\\Database\\Eloquent\\Model;

public function boot(): void
{
    Model::shouldBeStrict(! $this->app->isProduction());
}

// эквивалентно:
Model::preventLazyLoading(! $this->app->isProduction());
Model::preventSilentlyDiscardingAttributes(! $this->app->isProduction());
Model::preventAccessingMissingAttributes(! $this->app->isProduction());

// теперь это упадёт с исключением в dev:
$user = User::select(\'id\')->first();
$user->email; // MissingAttributeException

User::create([\'name\' => \'Tom\', \'admin\' => true]); // MassAssignmentException если admin не в $fillable',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое withCount?',
                'answer' => 'withCount - подсчитывает количество связанных записей одним SQL-запросом без их загрузки. Возвращает атрибут вида posts_count. Также есть withSum, withAvg, withMin, withMax.',
                'code_example' => '$users = User::withCount(\'posts\', \'comments\')->get();
foreach ($users as $user) {
    echo $user->posts_count;
    echo $user->comments_count;
}

// с условием
User::withCount([\'posts as published_posts_count\' => fn($q) => $q->where(\'published\', true)])->get();',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Local и Global scopes в Eloquent?',
                'answer' => 'Local scope - метод модели с префиксом scope, добавляющий условие к запросу (вызывается опционально). Global scope - класс, реализующий Scope, который автоматически применяется ко ВСЕМ запросам модели. Полезно для soft delete или multi-tenancy.',
                'code_example' => '// Local
public function scopeActive($query) {
    return $query->where(\'active\', true);
}
User::active()->get();

// Global
class TenantScope implements Scope {
    public function apply(Builder $b, Model $m): void {
        $b->where(\'tenant_id\', auth()->user()->tenant_id);
    }
}

class Post extends Model {
    protected static function booted(): void {
        static::addGlobalScope(new TenantScope);
    }
}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Observers в Laravel?',
                'answer' => 'Observer - это класс, который слушает события модели (creating, created, updating, updated, deleting, deleted, restoring, restored). Простыми словами: когда что-то происходит с моделью, observer выполняет код. Регистрируется в EventServiceProvider или через атрибут #[ObservedBy].',
                'code_example' => '#[ObservedBy(UserObserver::class)]
class User extends Model {}

class UserObserver {
    public function creating(User $user): void {
        $user->slug = Str::slug($user->name);
    }
    public function deleted(User $user): void {
        Mail::to($user)->send(new GoodbyeMail());
    }
}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие события генерируют Eloquent-модели?',
                'answer' => 'retrieved, creating, created, updating, updated, saving, saved, deleting, deleted, restoring, restored, replicating, trashed, forceDeleting, forceDeleted. saving и saved срабатывают и при create, и при update.',
                'code_example' => 'protected static function booted(): void {
    static::creating(function (User $user) {
        $user->uuid = Str::uuid();
    });

    static::deleted(function (User $user) {
        Cache::forget("user.{$user->id}");
    });
}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Soft Deletes?',
                'answer' => 'Soft Delete - это "мягкое удаление": запись не удаляется физически, а в столбце deleted_at ставится текущая дата. Простыми словами: запись помечается удалённой, но остаётся в БД. По умолчанию такие записи скрыты в выборках. Подключается трейтом SoftDeletes.',
                'code_example' => 'use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {
    use SoftDeletes;
}

$post->delete();           // soft delete
$post->forceDelete();      // hard delete
$post->restore();          // восстановить

Post::withTrashed()->get();   // включая удалённые
Post::onlyTrashed()->get();   // только удалённые',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как управлять timestamps в Eloquent?',
                'answer' => 'По умолчанию у модели есть created_at и updated_at, заполняемые автоматически. Отключить: $timestamps = false. Изменить формат: $dateFormat. Поменять имена: const CREATED_AT, const UPDATED_AT. Точечно отключить обновление updated_at: $model->timestamps = false перед save или метод updateQuietly.',
                'code_example' => 'class Post extends Model {
    public $timestamps = true;
    const CREATED_AT = \'creation_date\';
    const UPDATED_AT = \'last_update\';
}

// Обновить без изменения updated_at
$post->timestamps = false;
$post->save();

// или quietly - без срабатывания событий (saving/saved/updating/updated)
$post->updateQuietly([\'views\' => $post->views + 1]);',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое chunk, lazy и cursor в Eloquent? В чём разница?',
                'answer' => 'chunk - выбирает по N записей и отдаёт коллекцию в callback. lazy - возвращает LazyCollection, выбирая записи порциями (внутри также chunked). cursor - использует SQL-курсор и держит ОДНУ запись в памяти, экономит память сильнее всего, но открывает долгое соединение. Все три - для обработки больших таблиц без OOM.',
                'code_example' => 'User::chunk(1000, function ($users) {
    foreach ($users as $u) { /* ... */ }
});

User::lazy()->each(function ($u) { /* ... */ });

foreach (User::cursor() as $user) { /* ... */ }',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое whereHas и whereDoesntHave?',
                'answer' => 'whereHas фильтрует основные записи по наличию связи с условием. whereDoesntHave - наоборот, по отсутствию. Например: пользователи, у которых есть посты с определённым заголовком.',
                'code_example' => 'User::whereHas(\'posts\', function ($q) {
    $q->where(\'published\', true);
})->get();

User::whereDoesntHave(\'posts\')->get(); // без постов',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое lockForUpdate и sharedLock?',
                'answer' => 'lockForUpdate - "пишущая" блокировка строки до конца транзакции (FOR UPDATE), другие транзакции не смогут читать с lock или писать. sharedLock - "читающая" блокировка (FOR SHARE), другие могут читать, но не писать. Используется для борьбы с гонками (race conditions).',
                'code_example' => 'DB::transaction(function () {
    $account = Account::where(\'id\', 1)->lockForUpdate()->first();
    $account->balance -= 100;
    $account->save();
});',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что делает DB::afterCommit?',
                'answer' => 'afterCommit регистрирует callback, который выполнится только ПОСЛЕ успешного commit транзакции. Полезно для отправки событий, очередей, уведомлений - чтобы не отправлять их, если транзакция откатится. У моделей и job-ов есть свойства $afterCommit или ShouldQueueAfterCommit.',
                'code_example' => 'DB::transaction(function () use ($order) {
    $order->save();

    DB::afterCommit(function () use ($order) {
        SendOrderConfirmation::dispatch($order);
    });
});',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как делать пагинацию в Laravel?',
                'answer' => 'У Eloquent и Query Builder есть paginate($perPage), simplePaginate (только prev/next, без подсчёта total), cursorPaginate (быстрый, по cursor вместо offset, не показывает номера страниц). В Blade можно вывести ссылки через {{ $items->links() }}. Для API используется ->toArray() или JsonResource.',
                'code_example' => '$users = User::paginate(15);
$users = User::simplePaginate(15);
$users = User::cursorPaginate(15);

// API
return UserResource::collection(User::paginate(15));

// Blade
{{ $users->links() }}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как реализовать поиск с фильтрами в Eloquent?',
                'answer' => 'Через условные методы when() Query Builder. Также популярно использовать пакет Spatie Query Builder. Идея: для каждого фильтра проверяем, передан ли он, и добавляем where.',
                'code_example' => 'public function index(Request $request) {
    return Post::query()
        ->when($request->search, fn($q, $s) =>
            $q->where(\'title\', \'like\', "%$s%"))
        ->when($request->category, fn($q, $c) =>
            $q->where(\'category_id\', $c))
        ->when($request->author, fn($q, $a) =>
            $q->whereHas(\'author\', fn($qa) => $qa->where(\'id\', $a)))
        ->orderBy(\'created_at\', \'desc\')
        ->paginate(15);
}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем Eloquent Observer отличается от Event/Listener и когда выбирать что?',
                'answer' => 'Observer - класс, методы которого - это коллбэки на жизненный цикл модели (creating, saved, deleted). Удобен, когда логика тесно связана с моделью. Event/Listener - общая шина: модель/код диспатчит произвольное событие, на него подписываются несколько слушателей, легко асинхронить через ShouldQueue. Observer лаконичнее для аудита/таймстампов, события - для кросс-доменной интеграции.',
                'code_example' => '<?php
class UserObserver {
    public function created(User $u): void { Mail::to($u)->send(new Welcome()); }
    public function deleting(User $u): void { $u->posts()->delete(); }
}
// AppServiceProvider::boot
User::observe(UserObserver::class);',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как избежать N+1 при полиморфных связях morphTo?',
                'answer' => 'Обычный with("commentable") не работает напрямую, потому что для каждого типа нужен отдельный запрос. Используйте with("commentable") + morphWith() для жадной подзагрузки конкретных типов с их связями. Также есть morphMap в boot() - фиксирует строковые алиасы вместо FQCN, что устойчиво к рефакторингу. Альтернативно - явный foreach с groupBy типа.',
                'code_example' => '<?php
Comment::with(["commentable" => function (MorphTo $morphTo) {
    $morphTo->morphWith([
        Post::class => ["author"],
        Video::class => ["channel"],
    ]);
}])->get();',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем отличаются local query scope от global scope и какие подводные камни у global?',
                'answer' => 'Local scope - public method scopeXxx, явно вызывается в цепочке (User::active()->get()). Global scope автоматически применяется ко всем запросам модели, реализуется через Scope-интерфейс или Closure в booted(). Проблема: можно забыть и удивляться "куда делись записи". Снимать глобальный scope через withoutGlobalScope/withoutGlobalScopes. Также job, сериализующий модель и достающий её через query, может зависеть от текущего auth/tenant контекста, который во время выполнения job уже другой.',
                'code_example' => 'protected static function booted(): void {
    static::addGlobalScope(\'tenant\', function (Builder $b) {
        if ($tenantId = auth()->user()?->tenant_id) {
            $b->where(\'tenant_id\', $tenantId);
        }
    });
}

// Снять
Post::withoutGlobalScope(\'tenant\')->get();
Post::withoutGlobalScopes()->get();',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что произойдёт, если вызвать $user->posts во foreach без with("posts")?',
                'answer' => 'Это классический N+1: для каждого юзера выполнится отдельный SELECT по posts. with("posts") делает eager loading: один SELECT users + один WHERE user_id IN (...). При большом наборе данных N+1 даёт сотни запросов и убивает latency. Полезно включить Model::preventLazyLoading() в локальной среде - оно бросает исключение при ленивой загрузке и сразу ловит баг.',
                'code_example' => '<?php
// AppServiceProvider::boot
Model::preventLazyLoading(! app()->isProduction());

// в коде
$users = User::with(["posts" => fn($q) => $q->latest()->limit(5)])->get();',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работают Laravel-транзакции с deadlock и как их повторять?',
                'answer' => 'DB::transaction($callback, $attempts) ловит QueryException и при коде deadlock (например, 1213 в MySQL) повторяет до $attempts раз. Без указания attempts он бросает первое же исключение. Для распределённых сценариев nested-транзакции используют SAVEPOINT - DB::transaction внутри другой создаёт точку отката, а не новую транзакцию. afterCommit-хуки сработают только после внешнего коммита.',
                'code_example' => '<?php
DB::transaction(function () use ($from, $to, $sum) {
    $from->lockForUpdate()->decrement("balance", $sum);
    $to->lockForUpdate()->increment("balance", $sum);
}, attempts: 3);',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'В чём разница между whereIn и whereIntegerInRaw, и когда выбирать второй?',
                'answer' => 'whereIn($col, $array) использует PDO-bindings: для каждого элемента массива добавляется плейсхолдер (?), значение проходит через драйвер БД и экранируется. Это безопасно для строк/смешанных типов, но имеет цену: на 50 000 ID будет 50 000 плейсхолдеров, что упирается в лимиты драйвера (PDO имеет лимит на 65 535 параметров на запрос в MySQL/MariaDB), сильно нагружает парсер SQL и сжирает память при подготовке запроса. whereIntegerInRaw($col, $array) поступает иначе: каждый элемент массива принудительно кастится в (int) и подставляется ПРЯМО в SQL-строку без bindings: WHERE id IN (1, 2, 3, ...). Безопасно потому что (int) гарантирует - там не может оказаться SQL-инъекции; документированный профит - снижение использования памяти на стороне приложения при подготовке запроса с большим массивом. Когда использовать: импорты, синхронизация с внешним источником, broadcast-операции вида "обновить статус у списка из 100k записей". Для строк аналога нет - там нужен либо ->whereIn() c осознанием лимитов, либо chunk на части по 1000-5000 ID, либо JOIN со временной таблицей.',
                'code_example' => '<?php
// проблема - массив на 50_000 ID
$ids = User::where("region", "EU")->pluck("id")->all();

// whereIn: 50_000 плейсхолдеров - упрётся в лимит PDO/высокая память
User::whereIn("id", $ids)->update(["gdpr_notified_at" => now()]);

// whereIntegerInRaw: SQL вида WHERE id IN (1,2,3,...) без bindings
User::whereIntegerInRaw("id", $ids)->update(["gdpr_notified_at" => now()]);

// Также есть whereIntegerNotInRaw - инверсия

// Для строк - chunk
collect($emails)->chunk(1000)->each(function ($chunk) {
    User::whereIn("email", $chunk->all())->update([...]);
});',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как настроить read/write connections в Laravel и что делает опция sticky?',
                'answer' => 'В config/database.php у соединения можно указать массив "read" и "write" с отдельными хостами: SELECT-запросы пойдут на read-реплику, INSERT/UPDATE/DELETE - на write (master). Это горизонтально масштабирует чтение в типичном "много чтений / мало записей" приложении. Подводный камень: репликация асинхронна, лаг между master и реплики - десятки миллисекунд (а под нагрузкой - секунды). Классический баг: создаём пользователя POST /users → сразу редирект на GET /users/{id} → юзер не найден, потому что INSERT ушёл в master, а SELECT - в реплику, куда строка ещё не доехала. Решение - опция "sticky" => true в конфиге соединения: ОПЦИОНАЛЬНО (по умолчанию false, нужно включить руками), и если включено, то после ЛЮБОЙ операции записи в текущем request cycle все последующие SELECT того же запроса автоматически идут на write-соединение. Это даёт "read your own writes" гарантию ценой снятия части нагрузки с реплик после первого write. Если sticky выключен и нужно прочитать только что записанные данные - явно использовать DB::connection("mysql")->select() с указанием write, либо $model->refresh() с опцией useWritePdo() (Model::on("mysql")->useWritePdo()->find($id)).',
                'code_example' => '<?php
// config/database.php
"connections" => [
    "mysql" => [
        "driver"   => "mysql",
        "read"     => ["host" => ["10.0.0.2", "10.0.0.3"]], // реплики
        "write"    => ["host" => "10.0.0.1"],               // master
        "sticky"   => true, // ← по умолчанию false, обязательно включить руками
        "database" => env("DB_DATABASE"),
        "username" => env("DB_USERNAME"),
        "password" => env("DB_PASSWORD"),
    ],
],

// Без sticky - багопасный паттерн
$user = User::create($data);          // → master
return redirect("/users/{$user->id}"); // → реплика, может вернуть 404

// С sticky - SELECT после write идёт в master весь оставшийся request

// Принудительно использовать master разово
$fresh = User::on("mysql")->useWritePdo()->find($user->id);',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.eloquent_advanced',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как использовать PHP 8.1 Backed Enums в роутах, $casts моделей и валидации?',
                'answer' => 'Laravel 9+ поддерживает PHP 8.1 backed enums (string или int) в трёх ключевых местах. 1) В роутах через Implicit Enum Binding: если параметр в сигнатуре контроллера затайпхинчен enum-классом, Laravel автоматически попытается создать экземпляр через Enum::tryFrom($urlValue); если значение не соответствует ни одному case - ОФИЦИАЛЬНО возвращается 404 без необходимости вручную проверять. 2) В модели в массиве $casts: "status" => UserStatus::class - при чтении атрибута получаете объект Enum, при сохранении в БД уходит ->value (строка/int); работает и с однозначными, и с массивами enums (AsEnumCollection). 3) В валидации через Rule::enum(UserStatus::class) - проверяет, что значение есть в case-ах. Также есть has() / In::enum() для расширенных кейсов. Бонус: в Blade и Resource классе можно сравнивать через ===, потому что enum - это singleton по case, а не строка. Подводный камень: чистый enum (без ": string"/": int") НЕ поддерживается ни в роутах, ни в $casts - нужен именно backed enum, потому что нужно соответствие БД-значению.',
                'code_example' => '<?php
// 1) Enum
enum UserStatus: string {
    case Active    = "active";
    case Suspended = "suspended";
    case Banned    = "banned";
}

// 2) В роуте - 404 на невалидном значении из коробки
Route::get("/users/by-status/{status}", function (UserStatus $status) {
    return User::where("status", $status->value)->get();
});
// /users/by-status/active   → ok
// /users/by-status/whatever → 404 без if-ов

// 3) В модели - двусторонний каст
class User extends Model {
    protected $casts = [
        "status" => UserStatus::class,
    ];
}
$user->status === UserStatus::Active; // bool, без сравнения строк

// 4) В валидации
$request->validate([
    "status" => [Rule::enum(UserStatus::class)],
]);

// 5) Коллекция enums (Laravel 11+)
protected $casts = [
    "permissions" => AsEnumCollection::class . ":" . Permission::class,
];',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.eloquent_advanced',
            ],
        ];
    }
}
