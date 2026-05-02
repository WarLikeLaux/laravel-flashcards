<?php

namespace Database\Seeders\Data\Categories;

class LaravelQuestions
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, cloze_text?: ?string, short_answer?: ?string, assemble_chunks?: ?array<int, string>}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Что такое Laravel?',
                'answer' => 'Laravel - это PHP-фреймворк для разработки веб-приложений, основанный на архитектуре MVC. Простыми словами: это набор готовых инструментов и правил, который помогает быстро писать веб-сайты и API на PHP, не изобретая велосипед. Laravel включает ORM (Eloquent), систему маршрутизации, миграции, очереди, аутентификацию, шаблонизатор Blade и многое другое.',
                'code_example' => 'composer create-project laravel/laravel example-app
cd example-app
php artisan serve',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие основные преимущества Laravel?',
                'answer' => 'Преимущества Laravel: 1) Элегантный синтаксис и читаемый код. 2) Огромная экосистема пакетов (Sanctum, Horizon, Telescope, Octane, Scout). 3) Eloquent ORM - удобная работа с БД. 4) Встроенные миграции, сидеры, фабрики. 5) Очереди, события, кеш, сессии "из коробки". 6) Большое сообщество и документация. 7) Artisan CLI для генерации кода. 8) Активное развитие и регулярные релизы.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое архитектура MVC и как она реализована в Laravel?',
                'answer' => 'MVC (Model-View-Controller) - это паттерн разделения логики на 3 части. Model - работа с данными (Eloquent-модели). View - отображение (Blade-шаблоны). Controller - обработка запроса и связь между моделью и видом. В Laravel роуты направляют запрос в контроллер, контроллер достаёт данные через модель и передаёт их во view.',
                'code_example' => '// Route
Route::get(\'/users/{id}\', [UserController::class, \'show\']);

// Controller
class UserController extends Controller {
    public function show($id) {
        $user = User::findOrFail($id); // Model
        return view(\'users.show\', compact(\'user\')); // View
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Опиши структуру проекта Laravel - что лежит в основных папках?',
                'answer' => 'app/ - основной код приложения (модели, контроллеры, провайдеры). bootstrap/ - стартовые файлы и кеш. config/ - конфигурационные файлы. database/ - миграции, сидеры, фабрики. public/ - точка входа index.php и статика. resources/ - views, css, js, lang-файлы. routes/ - файлы маршрутов (web.php, api.php, console.php). storage/ - логи, кеш, загрузки. tests/ - тесты. vendor/ - зависимости composer.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Laravel',
                'question' => 'Опиши жизненный цикл запроса в Laravel.',
                'answer' => '1) Запрос попадает в public/index.php. 2) Загружается composer autoload и создаётся экземпляр Application (контейнер). 3) Bootstraps - регистрируются провайдеры, загружается env, конфиги. 4) HTTP-ядро (Kernel) пропускает запрос через глобальные middleware. 5) Запрос диспатчится в роутер, который находит маршрут и его middleware. 6) Запускается контроллер/closure. 7) Формируется Response. 8) Response проходит обратно через middleware (terminate). 9) Ответ отправляется клиенту.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Service Container (IoC контейнер) в Laravel?',
                'answer' => 'Service Container - это механизм для управления зависимостями и инъекции зависимостей (DI). Простыми словами: контейнер - это "склад" объектов, который умеет сам создавать и подставлять нужные зависимости. Когда вы в конструкторе указываете тип параметра, Laravel автоматически найдёт и подставит нужный объект.',
                'code_example' => '// Bind
app()->bind(PaymentInterface::class, StripePayment::class);

// Resolve
$payment = app(PaymentInterface::class);

// Через DI в контроллере
public function __construct(PaymentInterface $payment) {
    $this->payment = $payment;
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'В чём разница между bind, singleton, scoped и instance в Service Container?',
                'answer' => 'bind - каждый раз создаётся новый объект при resolve. singleton - объект создаётся один раз и переиспользуется в течение всего приложения. scoped - объект живёт в рамках одного запроса/job (важно для Octane). instance - регистрирует уже созданный объект как singleton.',
                'code_example' => '$this->app->bind(Foo::class, fn() => new Foo());
$this->app->singleton(Bar::class, fn() => new Bar());
$this->app->scoped(Baz::class, fn() => new Baz());
$this->app->instance(Qux::class, new Qux());',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое contextual binding в Service Container?',
                'answer' => 'Contextual binding - это привязка разных реализаций интерфейса для разных классов. Например, в одном контроллере нужен Stripe, в другом - PayPal, оба реализуют PaymentInterface.',
                'code_example' => '$this->app->when(OrderController::class)
    ->needs(PaymentInterface::class)
    ->give(StripePayment::class);

$this->app->when(SubscriptionController::class)
    ->needs(PaymentInterface::class)
    ->give(PayPalPayment::class);',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Service Provider и в чём разница между методами register и boot?',
                'answer' => 'Service Provider - это класс, в котором вы регистрируете сервисы в контейнере и настраиваете их. register() - только биндинги в контейнер, нельзя обращаться к другим сервисам. boot() - вызывается после регистрации всех провайдеров, здесь можно использовать другие сервисы (роуты, события, директивы Blade).',
                'code_example' => 'class AppServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->app->singleton(PaymentInterface::class, StripePayment::class);
    }

    public function boot(): void {
        Blade::directive(\'money\', fn($expr) => "<?= number_format($expr, 2) ?>");
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое deferred providers (отложенные провайдеры)?',
                'answer' => 'Deferred provider - это провайдер, который загружается только когда реально нужен один из его сервисов. Простыми словами: если вы зарегистрировали тяжёлый сервис, но он используется редко, отложенный провайдер не будет загружаться при каждом запросе. Нужно реализовать DeferrableProvider и вернуть массив provides().',
                'code_example' => 'class HeavyServiceProvider extends ServiceProvider implements DeferrableProvider {
    public function register(): void {
        $this->app->singleton(HeavyService::class, fn() => new HeavyService());
    }

    public function provides(): array {
        return [HeavyService::class];
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Facades в Laravel и как они работают?',
                'answer' => 'Facade - это статический "прокси" к объекту в контейнере. Простыми словами: вы пишете Cache::get(), а на самом деле вызывается метод объекта, который Laravel взял из контейнера. Под капотом Facade использует магический метод __callStatic, перенаправляя вызов на реальный сервис.',
                'code_example' => 'use Illuminate\Support\Facades\Cache;

Cache::put(\'key\', \'value\', 60);
// эквивалентно
app(\'cache\')->put(\'key\', \'value\', 60);',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Middleware и для чего оно нужно?',
                'answer' => 'Middleware - это слой между запросом и контроллером, который может перехватывать, модифицировать или отклонять запросы. Простыми словами: это "фильтр" для HTTP-запросов. Используется для аутентификации, логирования, CORS, throttle, проверки прав и т.д.',
                'code_example' => 'class CheckAge {
    public function handle(Request $request, Closure $next) {
        if ($request->age < 18) {
            return redirect(\'/home\');
        }
        return $next($request);
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие типы middleware бывают в Laravel?',
                'answer' => 'Глобальные middleware - выполняются для всех запросов (зарегистрированы в Kernel/$middleware). Group middleware - применяются к группе роутов (web, api). Route middleware - назначаются вручную на конкретные роуты через alias. Terminate-middleware - выполняется после отправки ответа клиенту (метод terminate).',
                'code_example' => 'Route::middleware([\'auth\', \'verified\'])->group(function () {
    Route::get(\'/dashboard\', [DashboardController::class, \'index\']);
});',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое terminate middleware?',
                'answer' => 'Terminate middleware - это middleware, у которого есть метод terminate(), вызываемый ПОСЛЕ отправки ответа пользователю. Используется для тяжёлых задач, которые не должны блокировать ответ: логирование, очистка ресурсов, аналитика. Работает только с FastCGI и не работает на встроенном PHP-сервере.',
                'code_example' => 'class LogRequestMiddleware {
    public function handle($request, Closure $next) {
        return $next($request);
    }

    public function terminate($request, $response): void {
        Log::info(\'Request finished\', [\'url\' => $request->url()]);
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое маршрут (route) в Laravel?',
                'answer' => 'Маршрут - это правило, которое связывает URL и HTTP-метод с конкретным действием (контроллером или замыканием). Простыми словами: когда пользователь заходит на /users, Laravel смотрит в файл routes/web.php и находит, какой код выполнить.',
                'code_example' => 'Route::get(\'/users\', [UserController::class, \'index\']);
Route::post(\'/users\', [UserController::class, \'store\']);
Route::put(\'/users/{id}\', [UserController::class, \'update\']);
Route::delete(\'/users/{id}\', [UserController::class, \'destroy\']);',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как объявить параметры маршрута, в том числе опциональные и с regex-ограничениями?',
                'answer' => 'Параметры в фигурных скобках {id}. Опциональный - {name?} с обязательным значением по умолчанию в замыкании/контроллере. Regex-ограничения через ->where(). Также есть готовые helper-методы whereNumber, whereAlpha, whereUuid.',
                'code_example' => 'Route::get(\'/user/{id}\', fn($id) => $id)
    ->where(\'id\', \'[0-9]+\');

Route::get(\'/user/{name?}\', fn($name = \'guest\') => $name);

Route::get(\'/post/{slug}\', [PostController::class, \'show\'])
    ->whereAlpha(\'slug\');',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое именованные маршруты (named routes) и зачем они нужны?',
                'answer' => 'Именованный маршрут - это маршрут с уникальным именем, по которому можно генерировать URL через route() и редиректить через redirect()->route(). Главный плюс: если URL изменится, не нужно менять ссылки по всему коду - имя остаётся тем же.',
                'code_example' => 'Route::get(\'/user/profile\', [ProfileController::class, \'show\'])
    ->name(\'profile\');

$url = route(\'profile\'); // /user/profile
return redirect()->route(\'profile\');',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое route groups (группы маршрутов)?',
                'answer' => 'Route group - это способ применить общие настройки (middleware, prefix, namespace, name prefix) к группе маршрутов. Простыми словами: вместо того чтобы дублировать middleware на каждом роуте, оборачиваем их в группу.',
                'code_example' => 'Route::middleware([\'auth\'])->prefix(\'admin\')->name(\'admin.\')->group(function () {
    Route::get(\'/users\', [UserController::class, \'index\'])->name(\'users.index\');
    Route::get(\'/posts\', [PostController::class, \'index\'])->name(\'posts.index\');
});',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что делает route caching и какие у него ограничения?',
                'answer' => 'php artisan route:cache компилирует все роуты в один кешируемый PHP-файл, что ускоряет работу приложения. Ограничение: нельзя использовать closure-роуты (анонимные функции), только массив [Controller::class, "method"]. Используется в продакшене.',
                'code_example' => 'php artisan route:cache
php artisan route:clear
php artisan route:list',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как создать контроллер в Laravel?',
                'answer' => 'Контроллеры создаются через artisan-команду make:controller. Можно создать пустой, resource (с CRUD-методами), invokable (single action), api (без create/edit).',
                'code_example' => 'php artisan make:controller UserController
php artisan make:controller UserController --resource
php artisan make:controller UserController --invokable
php artisan make:controller Api/UserController --api',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое resource-контроллер?',
                'answer' => 'Resource-контроллер - это контроллер с 7 стандартными методами для CRUD: index (список), create (форма создания), store (сохранение), show (просмотр), edit (форма редактирования), update (обновление), destroy (удаление). Подключается одной строкой Route::resource.',
                'code_example' => 'Route::resource(\'posts\', PostController::class);
// для API без create/edit
Route::apiResource(\'posts\', PostController::class);
// несколько ресурсов
Route::apiResources([
    \'posts\' => PostController::class,
    \'users\' => UserController::class,
]);',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое single action (invokable) контроллер?',
                'answer' => 'Single action controller - это контроллер с одним методом __invoke(). Используется, когда контроллер делает только одно действие. Удобно для упрощения кода и читаемости.',
                'code_example' => 'class ShowProfile {
    public function __invoke($id) {
        return view(\'profile\', [\'user\' => User::findOrFail($id)]);
    }
}

Route::get(\'/profile/{id}\', ShowProfile::class);',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работает dependency injection в контроллерах?',
                'answer' => 'Laravel автоматически разрешает зависимости в конструкторе и методах контроллеров через Service Container. Достаточно указать тип параметра, и контейнер подставит нужный объект. Это работает в __construct, методах действий и для FormRequest.',
                'code_example' => 'class UserController {
    public function __construct(private UserService $service) {}

    public function store(StoreUserRequest $request, UserRepository $repo) {
        return $repo->create($request->validated());
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как получить данные из Request в Laravel?',
                'answer' => 'Через объект Illuminate\Http\Request. Методы: input("name"), all(), only(["a", "b"]), except(["c"]), has("name"), filled("name"), get(), post(), query(), file("avatar"). Заголовки: header(). Cookie: cookie().',
                'code_example' => 'public function store(Request $request) {
    $name = $request->input(\'name\');
    $email = $request->input(\'email\', \'default@mail.com\');
    $only = $request->only([\'name\', \'email\']);
    $hasName = $request->has(\'name\');
    $token = $request->header(\'Authorization\');
    $file = $request->file(\'avatar\');
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие способы вернуть Response в Laravel?',
                'answer' => 'response($content), response()->json($data), response()->view("name"), response()->download($path), response()->stream(), redirect()->route(), back(), abort(404). Можно установить статус и заголовки.',
                'code_example' => 'return response(\'Hello\', 200)->header(\'X-Custom\', \'value\');
return response()->json([\'user\' => $user], 201);
return response()->download($path, \'file.pdf\');
return redirect()->route(\'home\')->with(\'success\', \'Готово\');
abort(404, \'Не найдено\');',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое FormRequest и зачем он нужен?',
                'answer' => 'FormRequest - это специальный класс для валидации входящих данных, отдельно от контроллера. Когда вы указываете FormRequest в типе параметра контроллера, Laravel автоматически запустит валидацию ДО выполнения метода. Если валидация не прошла - вернётся ошибка 422 (или редирект с ошибками).',
                'code_example' => 'class StoreUserRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            \'name\' => [\'required\', \'string\', \'max:255\'],
            \'email\' => [\'required\', \'email\', \'unique:users\'],
        ];
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие методы есть у FormRequest для кастомизации валидации?',
                'answer' => 'rules() - правила. messages() - кастомные сообщения. attributes() - читаемые имена полей. authorize() - проверка прав. prepareForValidation() - изменить данные ПЕРЕД валидацией. withValidator() - добавить кастомные правила/after-callback. passedValidation() - после успешной валидации. failedValidation() - переопределить поведение при ошибке.',
                'code_example' => 'public function prepareForValidation(): void {
    $this->merge([\'slug\' => Str::slug($this->title)]);
}

public function withValidator($validator): void {
    $validator->after(function ($v) {
        if ($this->title === $this->body) {
            $v->errors()->add(\'body\', \'Заголовок и текст одинаковые\');
        }
    });
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как создать кастомное правило валидации?',
                'answer' => 'Через artisan make:rule создать класс, реализующий ValidationRule (Laravel 10+) с методом validate. Также можно использовать closure-правило прямо в массиве rules. Класс Rule предоставляет готовые сложные правила: Rule::unique, Rule::exists, Rule::in, Rule::when.',
                'code_example' => 'class Uppercase implements ValidationRule {
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (strtoupper($value) !== $value) {
            $fail(\'Значение должно быть в верхнем регистре.\');
        }
    }
}

// Использование
$request->validate([\'code\' => [\'required\', new Uppercase()]]);',
                'code_language' => 'php',
            ],
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
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие виды связей в Eloquent? Опиши hasOne, hasMany, belongsTo, belongsToMany.',
                'answer' => 'hasOne - один-к-одному (User имеет один Profile). hasMany - один-ко-многим (User имеет много Posts). belongsTo - обратная сторона (Post принадлежит User). belongsToMany - многие-ко-многим через pivot-таблицу (User-Roles).',
                'code_example' => 'class User extends Model {
    public function profile() { return $this->hasOne(Profile::class); }
    public function posts()   { return $this->hasMany(Post::class); }
    public function roles()   { return $this->belongsToMany(Role::class); }
}

class Post extends Model {
    public function user() { return $this->belongsTo(User::class); }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое hasManyThrough и hasOneThrough?',
                'answer' => 'hasManyThrough - связь "через" промежуточную таблицу. Например: Country имеет много Posts через User (Country -> User -> Post). hasOneThrough - то же, но только один.',
                'code_example' => 'class Country extends Model {
    public function posts() {
        return $this->hasManyThrough(Post::class, User::class);
        // ищет посты пользователей этой страны
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое полиморфные связи (morphTo, morphMany, morphedByMany)?',
                'answer' => 'Полиморфная связь позволяет одной модели принадлежать нескольким разным моделям через одну таблицу. Например, Comment может относиться и к Post, и к Video. В таблице comments есть commentable_id и commentable_type. morphTo - на стороне Comment. morphMany - на стороне Post/Video. morphedByMany / morphToMany - many-to-many полиморфная.',
                'code_example' => 'class Comment extends Model {
    public function commentable() { return $this->morphTo(); }
}
class Post extends Model {
    public function comments() { return $this->morphMany(Comment::class, \'commentable\'); }
}
class Video extends Model {
    public function comments() { return $this->morphMany(Comment::class, \'commentable\'); }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое pivot-таблица в belongsToMany и как работать с ней?',
                'answer' => 'Pivot - это промежуточная таблица для связи многие-ко-многим, которая хранит связи между двумя сущностями. Например, role_user. Дополнительные поля pivot достаются через withPivot, временные метки - withTimestamps. Можно создать кастомную модель пивота через using().',
                'code_example' => 'public function roles() {
    return $this->belongsToMany(Role::class)
        ->withPivot(\'expires_at\', \'priority\')
        ->withTimestamps();
}

// Доступ
$user->roles->first()->pivot->expires_at;

// Прикрепление
$user->roles()->attach($roleId, [\'expires_at\' => now()->addYear()]);
$user->roles()->detach($roleId);
$user->roles()->sync([1, 2, 3]);',
                'code_language' => 'php',
            ],
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

// или quietly - без событий
$post->updateQuietly([\'views\' => $post->views + 1]);',
                'code_language' => 'php',
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
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое chunk, lazy и cursor в Eloquent? В чём разница?',
                'answer' => 'chunk - выбирает по N записей и отдаёт коллекцию в callback. lazy - возвращает LazyCollection, выбирая записи порциями (внутри также chunked). cursor - использует SQL-курсор и держит ОДНУ запись в памяти, экономит память сильнее всего, но открывает долгое соединение. Все три - для обработки больших таблиц без OOM.',
                'code_example' => 'User::chunk(1000, function ($users) {
    foreach ($users as $u) { /* ... */ }
});

User::lazy()->each(fn($u) => /* ... */);

foreach (User::cursor() as $user) { /* ... */ }',
                'code_language' => 'php',
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
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое миграции в Laravel?',
                'answer' => 'Миграции - это версионируемые описания изменений структуры БД в коде. Простыми словами: вместо ручного SQL вы пишете PHP-классы с методами up (применить) и down (откатить). Команда php artisan migrate применяет невыполненные миграции.',
                'code_example' => 'php artisan make:migration create_posts_table

// в миграции
public function up(): void {
    Schema::create(\'posts\', function (Blueprint $table) {
        $table->id();
        $table->string(\'title\');
        $table->text(\'body\');
        $table->timestamps();
    });
}

public function down(): void {
    Schema::dropIfExists(\'posts\');
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'В чём разница между migrate, rollback, refresh и fresh?',
                'answer' => 'migrate - применяет невыполненные миграции. rollback - откатывает последний batch миграций (через down). refresh - откатывает ВСЕ миграции, потом применяет заново. fresh - удаляет ВСЕ таблицы и применяет миграции (быстрее refresh, но без down). migrate:status - показать статус миграций.',
                'code_example' => 'php artisan migrate
php artisan migrate:rollback --step=1
php artisan migrate:refresh --seed
php artisan migrate:fresh --seed
php artisan migrate:status',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как объявить foreign key и индексы в миграции?',
                'answer' => 'foreign() с references()->on() - старый способ. foreignId()->constrained() - короткий вариант, который сам определяет таблицу. cascadeOnDelete, nullOnDelete, restrictOnDelete - поведение при удалении. Индексы: ->index(), ->unique(), ->primary(), составные индексы передаются массивом.',
                'code_example' => 'Schema::create(\'posts\', function (Blueprint $t) {
    $t->id();
    $t->foreignId(\'user_id\')->constrained()->cascadeOnDelete();
    $t->string(\'slug\')->unique();
    $t->string(\'status\')->index();
    $t->index([\'user_id\', \'status\']);
});',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Seeders и Factories?',
                'answer' => 'Seeder - класс, который заполняет БД тестовыми/начальными данными. Factory - "фабрика", которая описывает, как генерировать модели с фейковыми данными (через Faker). Используются вместе: фабрика создаёт модели, сидер вызывает фабрику.',
                'code_example' => 'php artisan make:seeder UsersSeeder
php artisan make:factory UserFactory --model=User

// Factory
public function definition(): array {
    return [
        \'name\' => fake()->name(),
        \'email\' => fake()->unique()->safeEmail(),
    ];
}

// Seeder
public function run(): void {
    User::factory()->count(50)->create();
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое DB::transaction и как использовать вложенные транзакции?',
                'answer' => 'DB::transaction оборачивает код в транзакцию: если внутри callback бросается исключение - rollback, иначе - commit. Поддерживаются deadlock-retries (второй аргумент). Вложенные транзакции реализуются через savepoints. Альтернатива: DB::beginTransaction, DB::commit, DB::rollBack вручную.',
                'code_example' => 'DB::transaction(function () {
    User::create([...]);
    Post::create([...]);
}, attempts: 3);

// Вручную
DB::beginTransaction();
try {
    // ...
    DB::commit();
} catch (\Throwable $e) {
    DB::rollBack();
    throw $e;
}',
                'code_language' => 'php',
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
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Cache в Laravel и какие драйверы существуют?',
                'answer' => 'Cache - это система кеширования данных для ускорения. Драйверы: file (по умолчанию), database, redis, memcached, array (для тестов), dynamodb. Конфигурируется в config/cache.php. Используется через Cache фасад.',
                'code_example' => 'Cache::put(\'key\', \'value\', 3600);
$value = Cache::get(\'key\', \'default\');
Cache::has(\'key\');
Cache::forget(\'key\');
Cache::flush();',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что делает Cache::remember?',
                'answer' => 'Cache::remember - получить значение из кеша или, если его нет, выполнить closure, записать результат в кеш и вернуть. Простыми словами: "если в кеше есть - возьми, если нет - вычисли и положи". Также есть rememberForever (без TTL).',
                'code_example' => '$users = Cache::remember(\'users.all\', 600, function () {
    return User::all();
});

// без TTL
$value = Cache::rememberForever(\'config\', fn() => loadHeavyConfig());',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое cache tags?',
                'answer' => 'Cache tags - это группировка кеш-записей по тегам, чтобы инвалидировать сразу группу. Поддерживается только в drivers redis/memcached. Простыми словами: пометили несколько ключей тегом "users" и потом одним вызовом сбросили все.',
                'code_example' => 'Cache::tags([\'users\', \'admins\'])->put(\'user.1\', $user, 600);
Cache::tags(\'users\')->flush(); // удалит всё с тегом users',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое atomic locks в Cache?',
                'answer' => 'Atomic lock - это распределённая блокировка через кеш, чтобы только один процесс мог выполнять секцию кода в один момент. Простыми словами: защита от одновременного выполнения (например, чтобы cron-задача не запустилась дважды).',
                'code_example' => '$lock = Cache::lock(\'process-orders\', 10);

if ($lock->get()) {
    try {
        // эксклюзивная работа
    } finally {
        $lock->release();
    }
}

// или короче
Cache::lock(\'foo\', 10)->block(5, function () {
    // ...
});',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое очереди (Queues) в Laravel?',
                'answer' => 'Очереди - это механизм отложенного выполнения задач в фоновом режиме. Простыми словами: тяжёлую задачу (отправка email, обработка изображений) кладём в очередь, чтобы пользователь не ждал. Драйверы: database, redis, sqs, beanstalkd, sync (для отладки), null.',
                'code_example' => 'php artisan make:job ProcessPodcast

class ProcessPodcast implements ShouldQueue {
    use Queueable;
    public function handle(): void { /* работа */ }
}

ProcessPodcast::dispatch($podcast);
ProcessPodcast::dispatch($podcast)->onQueue(\'high\')->delay(now()->addMinutes(5));',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работают воркеры очередей и как их запускать в продакшене?',
                'answer' => 'Воркер - это процесс php artisan queue:work, который непрерывно забирает и выполняет задачи из очереди. В продакшене запускается под Supervisor (или systemd, k8s), чтобы автоматически перезапускался при падении. После деплоя нужно делать queue:restart, чтобы воркеры перечитали код.',
                'code_example' => 'php artisan queue:work redis --queue=high,default --tries=3 --timeout=60
php artisan queue:restart

# supervisor config
[program:laravel-worker]
command=php /var/www/artisan queue:work redis --tries=3
autostart=true
autorestart=true
numprocs=4',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое retry, backoff и failed jobs?',
                'answer' => '$tries - максимальное количество попыток. backoff - задержка между попытками (число или массив для прогрессивного backoff). При исчерпании попыток job попадает в таблицу failed_jobs. Можно посмотреть через queue:failed, повторить через queue:retry, удалить через queue:flush.',
                'code_example' => 'class ProcessPodcast implements ShouldQueue {
    public int $tries = 5;
    public array $backoff = [1, 5, 10, 30];

    public function failed(\Throwable $e): void {
        // уведомить, залогировать
    }
}

php artisan queue:retry all
php artisan queue:flush',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое ShouldBeUnique?',
                'answer' => 'ShouldBeUnique - интерфейс, гарантирующий что в очереди в один момент есть только одна копия задачи с тем же ключом. Простыми словами: защита от дубликатов в очереди. Можно реализовать uniqueId() и uniqueFor() (TTL).',
                'code_example' => 'class UpdateSearchIndex implements ShouldQueue, ShouldBeUnique {
    public int $uniqueFor = 3600;

    public function uniqueId(): string {
        return $this->product->id;
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Job Batching и Chains?',
                'answer' => 'Chain - последовательное выполнение задач: если одна провалилась, следующие не запускаются. Batch - параллельное выполнение группы задач с общим callback (then/catch/finally) и прогрессом.',
                'code_example' => '// Chain
Bus::chain([
    new ImportCsv,
    new GenerateReport,
    new SendNotification,
])->dispatch();

// Batch
Bus::batch([
    new ProcessFile(\'a.csv\'),
    new ProcessFile(\'b.csv\'),
])->then(fn($batch) => Log::info("Done"))
  ->catch(fn($batch, $e) => Log::error($e))
  ->dispatch();',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Events и Listeners?',
                'answer' => 'Event - это объект, описывающий "что-то произошло" (UserRegistered, OrderPaid). Listener - класс, реагирующий на событие. Простыми словами: один событие может иметь много слушателей, что позволяет отделять логику. Слушатель может реализовать ShouldQueue для асинхронной обработки.',
                'code_example' => 'class UserRegistered {
    public function __construct(public User $user) {}
}

class SendWelcomeEmail implements ShouldQueue {
    public function handle(UserRegistered $event): void {
        Mail::to($event->user)->send(new WelcomeMail());
    }
}

UserRegistered::dispatch($user);',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Broadcasting в Laravel?',
                'answer' => 'Broadcasting - это передача событий с сервера на клиента в реальном времени через WebSockets. Каналы: public (любой), private (требует авторизации), presence (с информацией о подключённых пользователях). Драйверы: Pusher, Ably, Reverb (свой WebSocket сервер от Laravel), Redis. Клиент использует Laravel Echo.',
                'code_example' => 'class MessageSent implements ShouldBroadcast {
    public function broadcastOn(): PrivateChannel {
        return new PrivateChannel(\'chat.\' . $this->message->room_id);
    }
}

// JS клиент
Echo.private(`chat.${roomId}`)
    .listen(\'MessageSent\', (e) => console.log(e));',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Notifications в Laravel?',
                'answer' => 'Notifications - это унифицированный способ отправлять уведомления через разные каналы: mail, database, broadcast, slack, sms (vonage), и кастомные. Один класс уведомления, метод via() выбирает каналы.',
                'code_example' => 'class InvoicePaid extends Notification {
    public function via($notifiable): array {
        return [\'mail\', \'database\', \'broadcast\'];
    }
    public function toMail($notifiable): MailMessage {
        return (new MailMessage)->line(\'Оплата получена\');
    }
    public function toArray($notifiable): array {
        return [\'invoice_id\' => $this->invoice->id];
    }
}

$user->notify(new InvoicePaid($invoice));',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как отправлять Mail в Laravel?',
                'answer' => 'Создаётся Mailable-класс через make:mail. Он описывает заголовок (envelope), содержимое (content) и вложения (attachments). Шаблон может быть Blade-вьюшкой, markdown-шаблоном или обычным текстом. Отправка через Mail фасад. Драйверы SMTP, Mailgun, SES, Postmark, log, array.',
                'code_example' => 'php artisan make:mail OrderShipped --markdown=mail.orders.shipped

class OrderShipped extends Mailable {
    public function envelope(): Envelope {
        return new Envelope(subject: \'Заказ отправлен\');
    }
    public function content(): Content {
        return new Content(markdown: \'mail.orders.shipped\');
    }
}

Mail::to($user)->send(new OrderShipped($order));
Mail::to($user)->queue(new OrderShipped($order));',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Authentication Guards в Laravel?',
                'answer' => 'Guard - это способ аутентификации (как Laravel определяет, кто пользователь). Стандартные: web (через сессии), api (через токены), sanctum (cookies/токены SPA). Можно настроить несколько guards в config/auth.php (multi-auth) - например для admin и user отдельно.',
                'code_example' => 'auth()->guard(\'admin\')->attempt($credentials);
auth(\'admin\')->user();
Auth::guard(\'api\')->check();

// в config/auth.php
\'guards\' => [
    \'web\' => [\'driver\' => \'session\', \'provider\' => \'users\'],
    \'admin\' => [\'driver\' => \'session\', \'provider\' => \'admins\'],
],',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'В чём разница между Sanctum и Passport?',
                'answer' => 'Sanctum - простой и лёгкий пакет: API-токены (как GitHub) + SPA-аутентификация через сессии и cookies. Подходит для большинства SPA и мобильных приложений. Passport - полноценный OAuth2 сервер: авторизация сторонних приложений, grant types, refresh tokens. Использовать только если реально нужен OAuth2.',
                'code_example' => '// Sanctum
$token = $user->createToken(\'mobile\')->plainTextToken;

// в маршрутах
Route::middleware(\'auth:sanctum\')->get(\'/me\', fn(Request $r) => $r->user());

// клиент
fetch(\'/api/me\', { headers: { Authorization: `Bearer ${token}` } });',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Authorization, Gates и Policies?',
                'answer' => 'Authorization - проверка прав ("может ли пользователь сделать X"). Gate - простая проверка через closure (для отдельных действий). Policy - класс, привязанный к модели, с методами view/create/update/delete. Используется через can(), authorize(), Blade-директиву @can.',
                'code_example' => '// Gate
Gate::define(\'edit-settings\', fn(User $u) => $u->is_admin);
if (Gate::allows(\'edit-settings\')) { /* ... */ }

// Policy
php artisan make:policy PostPolicy --model=Post

class PostPolicy {
    public function update(User $user, Post $post): bool {
        return $user->id === $post->user_id;
    }
}

$this->authorize(\'update\', $post);
$user->can(\'update\', $post);',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что делает Gate::before?',
                'answer' => 'Gate::before - это глобальный pre-check, выполняемый перед любой проверкой Gate/Policy. Если возвращает true - доступ разрешён, false - запрещён, null - проверка идёт дальше. Часто используется для super-admin: "админу можно всё".',
                'code_example' => 'Gate::before(function (User $user, string $ability) {
    if ($user->is_super_admin) {
        return true;
    }
});',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работает session в Laravel?',
                'answer' => 'Сессия - это хранилище данных пользователя между запросами. Драйверы: file (по умолчанию), cookie, database, redis, memcached, array. Доступ через session() helper, $request->session() или Session фасад. Защищена от session fixation, регенерация ID при логине.',
                'code_example' => 'session([\'key\' => \'value\']);
$value = session(\'key\', \'default\');
session()->forget(\'key\');
session()->flush();
session()->regenerate();
$request->session()->flash(\'status\', \'Saved\'); // только для следующего запроса',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое File Storage и какие есть disks?',
                'answer' => 'File Storage - абстракция над файловыми хранилищами через Flysystem. Disks: local (storage/app), public (storage/app/public, доступен через symlink), s3 (Amazon S3), ftp, sftp. Один интерфейс - разные хранилища.',
                'code_example' => 'Storage::disk(\'s3\')->put(\'avatars/1.jpg\', $contents);
$url = Storage::disk(\'public\')->url(\'avatars/1.jpg\');
$content = Storage::get(\'file.txt\');
Storage::delete(\'file.txt\');

// Создать симлинк public
php artisan storage:link',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работает локализация в Laravel?',
                'answer' => 'Lang-файлы лежат в lang/ (или resources/lang/). Хелпер __() читает строку, trans_choice - с учётом числа (plural). Можно использовать lang-ключи (json) или короткие ключи (php-массивы). Текущая локаль: app()->getLocale(), app()->setLocale(\'ru\').',
                'code_example' => '// lang/ru.json
{ "Welcome": "Добро пожаловать" }

// lang/ru/messages.php
return [\'greeting\' => \'Привет, :name\'];

echo __(\'Welcome\');
echo __(\'messages.greeting\', [\'name\' => \'Anna\']);
echo trans_choice(\'apples\', 5);',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Blade и какие у него преимущества?',
                'answer' => 'Blade - это шаблонизатор Laravel. Преимущества: компилируется в PHP (быстрый), есть директивы (@if, @foreach, @auth, @csrf), наследование шаблонов (@extends, @section), компоненты, slots, безопасный по умолчанию (auto-escape через {{ }}).',
                'code_example' => '@extends(\'layouts.app\')

@section(\'content\')
    @if($user)
        <h1>Привет, {{ $user->name }}!</h1>
    @endif

    @foreach($posts as $post)
        <p>{{ $post->title }}</p>
    @endforeach
@endsection',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Blade Components и как работают slots?',
                'answer' => 'Blade-компонент - это переиспользуемый кусок UI (как в React/Vue). Создаётся через make:component, имеет класс с свойствами и шаблон. В шаблоне через <x-component-name>. Slots - именованные "дырки" для вставки контента: {{ $slot }} (default), <x-slot name="header">.',
                'code_example' => '// resources/views/components/alert.blade.php
<div class="alert alert-{{ $type }}">
    {{ $slot }}
</div>

// Использование
<x-alert type="success">
    Всё хорошо!
</x-alert>',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое @props в Blade?',
                'answer' => '@props объявляет свойства анонимного компонента (без класса). Можно задать значение по умолчанию. Все остальные атрибуты тега попадают в $attributes и могут быть выведены через {{ $attributes }}.',
                'code_example' => '// resources/views/components/button.blade.php
@props([\'type\' => \'primary\', \'size\' => \'md\'])

<button {{ $attributes->merge([\'class\' => "btn btn-$type btn-$size"]) }}>
    {{ $slot }}
</button>

// Использование
<x-button type="danger" id="del-btn">Удалить</x-button>',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Inertia.js?',
                'answer' => 'Inertia.js - это "монолит с SPA-чувствами". Простыми словами: вы пишете обычный Laravel (controllers, routes), но возвращаете не Blade, а компоненты Vue/React/Svelte. Inertia сам обновляет страницу через AJAX, без перезагрузки. Идея: иметь SPA без отдельного API. Не нужно строить REST или GraphQL.',
                'code_example' => '// Controller
return Inertia::render(\'Users/Index\', [
    \'users\' => User::all(),
]);

// Vue-компонент resources/js/Pages/Users/Index.vue
<script setup>
defineProps({ users: Array })
</script>',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Livewire?',
                'answer' => 'Livewire - это пакет для создания "реактивных" интерфейсов на чистом PHP/Blade без написания JavaScript. Простыми словами: ваш компонент - это PHP-класс + Blade-шаблон, а Livewire под капотом сам делает AJAX-запросы при изменении свойств. Идея: SPA без SPA, для тех кто не хочет учить Vue/React.',
                'code_example' => 'class Counter extends Component {
    public int $count = 0;

    public function increment(): void {
        $this->count++;
    }

    public function render() {
        return view(\'livewire.counter\');
    }
}

// blade
<button wire:click="increment">+</button>
<span>{{ $count }}</span>',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Laravel Octane? Какие у него плюсы и подводные камни?',
                'answer' => 'Octane - это пакет для Laravel, который держит приложение в памяти между запросами вместо перезагрузки. Простыми словами: обычный PHP при каждом запросе заново загружает Laravel - это медленно. Octane загружает один раз и потом каждый запрос обрабатывается мгновенно. Серверы: Swoole, RoadRunner, FrankenPHP. Подводные камни: 1) Утечки памяти - переменные класса не сбрасываются. 2) Состояние singleton-ов сохраняется. 3) Глобальные/статические переменные опасны. 4) Нужно использовать scoped-биндинги вместо singleton там, где состояние per-request. 5) Закрытые соединения с БД могут "висеть".',
                'code_example' => 'composer require laravel/octane
php artisan octane:install
php artisan octane:start --workers=4 --task-workers=2

// scoped binding для per-request состояния
$this->app->scoped(RequestContext::class);',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Laravel Horizon?',
                'answer' => 'Horizon - это пакет для управления Redis-очередями: красивый dashboard, балансировка воркеров (auto/simple), метрики, мониторинг failed jobs, теги задач. Простыми словами: GUI и автомасштабирование для php artisan queue:work на Redis.',
                'code_example' => 'composer require laravel/horizon
php artisan horizon:install
php artisan horizon

// config/horizon.php
\'environments\' => [
    \'production\' => [
        \'supervisor-1\' => [
            \'connection\' => \'redis\',
            \'queue\' => [\'default\', \'high\'],
            \'balance\' => \'auto\',
            \'maxProcesses\' => 10,
        ],
    ],
],',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Laravel Scout?',
                'answer' => 'Scout - это пакет для полнотекстового поиска в Eloquent-моделях. Драйверы: Algolia, Meilisearch, Typesense, database (простой LIKE), collection. Простыми словами: добавили трейт Searchable, и модель автоматически индексируется при сохранении.',
                'code_example' => 'class Post extends Model {
    use Searchable;

    public function toSearchableArray(): array {
        return [\'title\' => $this->title, \'body\' => $this->body];
    }
}

$results = Post::search(\'laravel\')->paginate(15);

php artisan scout:import "App\\Models\\Post"',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Laravel Telescope?',
                'answer' => 'Telescope - это инструмент отладки и мониторинга Laravel-приложения. Простыми словами: dashboard, который показывает все запросы, SQL-запросы, jobs, события, кеш, логи, mail, exceptions. Используется в development. В продакшене обычно отключается или ограничивается доступ.',
                'code_example' => 'composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate

// доступ /telescope',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Laravel Pulse?',
                'answer' => 'Pulse - это лёгкий dashboard для мониторинга performance в продакшене (от Laravel). Простыми словами: показывает медленные запросы, нагруженные jobs, slow queries, активных пользователей, cache hit rate в реальном времени. Альтернатива Telescope для production.',
                'code_example' => 'composer require laravel/pulse
php artisan vendor:publish --provider="Laravel\\Pulse\\PulseServiceProvider"
php artisan migrate

// доступ /pulse',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое php artisan?',
                'answer' => 'Artisan - это CLI-интерфейс Laravel. Простыми словами: командная строка для генерации кода (make:), управления БД (migrate), очередями (queue:work), кешем (cache:clear) и т.д. Можно создавать свои команды через make:command.',
                'code_example' => 'php artisan list                 # список всех команд
php artisan make:model Post -mfc # модель + миграция + фабрика + контроллер
php artisan migrate
php artisan db:seed
php artisan tinker
php artisan route:list
php artisan optimize',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Tinker?',
                'answer' => 'Tinker - это интерактивный REPL (как python REPL) для Laravel. Простыми словами: командная строка, в которой можно писать PHP-код с доступом ко всем классам Laravel. Удобно для отладки, проверки моделей, выполнения разовых операций.',
                'code_example' => 'php artisan tinker

>>> User::count()
=> 42

>>> $u = User::find(1)
=> App\Models\User { ... }

>>> $u->update([\'name\' => \'Test\'])
=> true',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что делают artisan optimize, route:cache, config:cache, view:cache?',
                'answer' => 'config:cache - объединяет все config-файлы в один кеш. route:cache - кеширует роуты в один файл. view:cache - предкомпилирует Blade-шаблоны. event:cache - кеширует события. optimize - вызывает несколько кешей сразу. Все вместе ускоряют работу в продакшене. После деплоя нужно выполнить, после изменений - сбросить (config:clear).',
                'code_example' => 'php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan optimize

# сброс
php artisan optimize:clear',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Почему нельзя использовать env() вне config-файлов после кеширования?',
                'answer' => 'При config:cache Laravel выполняет все config-файлы и сохраняет результат. Файл .env при этом НЕ читается на каждом запросе. Если в коде вы вызовете env() напрямую (вне config), оно вернёт null в продакшене. Правильно: значения env читать только в config/, а в коде использовать config(\'app.something\').',
                'code_example' => '// плохо - в коде
$key = env(\'STRIPE_KEY\'); // null после config:cache!

// правильно
// config/services.php
return [\'stripe\' => [\'key\' => env(\'STRIPE_KEY\')]];

// в коде
$key = config(\'services.stripe.key\');',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем отличаются PHPUnit и Pest в Laravel?',
                'answer' => 'PHPUnit - стандартный фреймворк тестирования для PHP, тесты пишутся как методы класса. Pest - надстройка над PHPUnit с более лаконичным синтаксисом (как Jest для JS): тесты как функции, expect-API. Под капотом всё равно PHPUnit. Можно использовать оба одновременно.',
                'code_example' => '// PHPUnit
class UserTest extends TestCase {
    public function test_user_can_register(): void {
        $response = $this->post(\'/register\', [...]);
        $response->assertOk();
    }
}

// Pest
test(\'user can register\', function () {
    $response = $this->post(\'/register\', [...]);
    expect($response->status())->toBe(200);
});',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'В чём разница между RefreshDatabase и DatabaseTransactions?',
                'answer' => 'RefreshDatabase - перед запуском всего тест-сьюта мигрирует БД с нуля, каждый тест оборачивается в транзакцию и откатывается. DatabaseTransactions - не мигрирует, просто оборачивает каждый тест в транзакцию (требует чтобы БД была уже мигрирована). RefreshDatabase надёжнее - всегда чистая БД. DatabaseMigrations - запускает миграции для каждого теста (медленно).',
                'code_example' => 'use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase {
    use RefreshDatabase;

    public function test_create_user(): void {
        $user = User::factory()->create();
        $this->assertDatabaseHas(\'users\', [\'id\' => $user->id]);
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое HTTP-тесты в Laravel?',
                'answer' => 'HTTP-тесты позволяют делать "фейковые" запросы к приложению без реального HTTP. Методы: get, post, put, delete, json, getJson, postJson. Помощники для assert: assertOk, assertStatus, assertRedirect, assertSee, assertJson, assertJsonStructure. Можно работать с auth: actingAs($user).',
                'code_example' => 'public function test_index_returns_users(): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->getJson(\'/api/users\');

    $response->assertOk()
        ->assertJsonStructure([\'data\' => [[\'id\', \'name\']]]);
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое fakes в Laravel-тестах?',
                'answer' => 'Fake - это подмена реального сервиса фейковым для тестов, чтобы проверить, что нужный код был вызван, без побочных эффектов. Fakes: Mail::fake(), Queue::fake(), Notification::fake(), Event::fake(), Bus::fake(), Storage::fake(), Http::fake().',
                'code_example' => 'public function test_email_sent(): void {
    Mail::fake();

    $this->post(\'/orders\', [...]);

    Mail::assertSent(OrderShipped::class, fn($m) => $m->hasTo(\'a@b.c\'));
}

public function test_job_dispatched(): void {
    Queue::fake();

    ProcessOrder::dispatch();

    Queue::assertPushed(ProcessOrder::class);
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как делать mocking в Laravel-тестах?',
                'answer' => 'Через фасады (Cache::shouldReceive), через Mockery (mock(), partialMock()), либо через подмену в контейнере ($this->instance(...)). Фасады удобно мокать сразу - они изначально проксируют через контейнер.',
                'code_example' => '// Mock фасада
Cache::shouldReceive(\'get\')->once()->with(\'key\')->andReturn(\'value\');

// Mock сервиса
$mock = $this->mock(PaymentService::class);
$mock->shouldReceive(\'charge\')->once()->andReturn(true);

// Подмена в контейнере
$this->instance(PaymentService::class, new FakePaymentService());',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как реализовать rate limiting в Laravel?',
                'answer' => 'Через middleware throttle. Можно по умолчанию (60 запросов в минуту), кастомный лимит, по группам. Сложные правила задаются через RateLimiter::for() в RouteServiceProvider/AppServiceProvider.',
                'code_example' => 'Route::middleware(\'throttle:60,1\')->group(...);

// Кастомный
RateLimiter::for(\'api\', function (Request $request) {
    return $request->user()
        ? Limit::perMinute(120)->by($request->user()->id)
        : Limit::perMinute(30)->by($request->ip());
});

Route::middleware(\'throttle:api\')->group(...);',
                'code_language' => 'php',
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
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Pipeline pattern в Laravel?',
                'answer' => 'Pipeline - это паттерн "конвейер": данные проходят через цепочку обработчиков. Laravel использует Pipeline внутри (middleware - это pipeline). Можно использовать самому через Pipeline фасад - удобно для последовательных трансформаций, фильтров, действий.',
                'code_example' => 'use Illuminate\Pipeline\Pipeline;

$result = app(Pipeline::class)
    ->send($request)
    ->through([
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
        FilterByUser::class,
    ])
    ->thenReturn();',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Macroable trait?',
                'answer' => 'Macroable - это трейт, позволяющий добавлять кастомные методы в классы Laravel runtime через ::macro(). Простыми словами: можно расширять Collection, Str, Request, Response своими методами. Регистрируется в Service Provider boot().',
                'code_example' => 'use Illuminate\Support\Str;

Str::macro(\'isUuid\', function ($value) {
    return preg_match(\'/^[0-9a-f-]{36}$/i\', $value) === 1;
});

Str::isUuid(\'550e8400-...\'); // true

Collection::macro(\'toUpper\', function () {
    return $this->map(fn($v) => strtoupper($v));
});

collect([\'a\', \'b\'])->toUpper(); // [\'A\', \'B\']',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое API Resources в Laravel?',
                'answer' => 'API Resource - это класс трансформации модели в JSON для API. Простыми словами: вместо того чтобы возвращать модель напрямую, мы оборачиваем её в Resource, где явно указываем, какие поля и как форматировать. Помогает скрыть лишние данные и формировать стабильный контракт API.',
                'code_example' => 'class UserResource extends JsonResource {
    public function toArray($request): array {
        return [
            \'id\' => $this->id,
            \'name\' => $this->name,
            \'email\' => $this->when($request->user()->is_admin, $this->email),
            \'posts\' => PostResource::collection($this->whenLoaded(\'posts\')),
        ];
    }
}

return new UserResource($user);
return UserResource::collection(User::all());',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как создать кастомную artisan команду?',
                'answer' => 'Через php artisan make:command. Класс наследуется от Command, имеет $signature (имя и аргументы) и $description. Логика в методе handle(). Зависимости можно инжектить в handle() или конструктор.',
                'code_example' => 'php artisan make:command SendEmails

class SendEmails extends Command {
    protected $signature = \'app:send-emails {user} {--queue=}\';
    protected $description = \'Send emails to user\';

    public function handle(): int {
        $userId = $this->argument(\'user\');
        $this->info("Sending to user {$userId}");
        return Command::SUCCESS;
    }
}

// Запуск
php artisan app:send-emails 1 --queue=high',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как планировать задачи (Task Scheduling) в Laravel?',
                'answer' => 'В Laravel есть встроенный планировщик задач, описываемый в коде, а не в crontab. На сервере добавляется ОДНА cron-запись на php artisan schedule:run каждую минуту, всё остальное - в коде. Доступны методы everyMinute, hourly, daily, cron(), withoutOverlapping и др.',
                'code_example' => '// routes/console.php (Laravel 11+) или Console/Kernel
Schedule::command(\'reports:generate\')->dailyAt(\'02:00\');
Schedule::job(new CleanLogs)->weekly();
Schedule::call(fn() => DB::table(\'sessions\')->delete())
    ->everyFifteenMinutes()
    ->withoutOverlapping();

// crontab
* * * * * cd /var/www && php artisan schedule:run >> /dev/null 2>&1',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое route model binding?',
                'answer' => 'Route Model Binding - автоматическая подстановка модели в контроллер по параметру маршрута. Простыми словами: вместо того чтобы вручную писать User::findOrFail($id), Laravel сам найдёт модель по ID или другому полю. Implicit binding - по типу параметра. Explicit binding - вручную через Route::bind.',
                'code_example' => '// Implicit
Route::get(\'/users/{user}\', function (User $user) {
    return $user; // автоматически найдено
});

// По другому полю
Route::get(\'/posts/{post:slug}\', fn(Post $post) => $post);

// Explicit
Route::bind(\'user\', fn($value) => User::where(\'username\', $value)->firstOrFail());',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Collections в Laravel?',
                'answer' => 'Collection - это обёртка вокруг массива с десятками методов: map, filter, reduce, pluck, where, groupBy, sortBy, chunk и т.д. Простыми словами: "удобный" массив с цепочкой методов как в JavaScript. Все Eloquent-результаты возвращаются как Collection.',
                'code_example' => 'collect([1, 2, 3, 4])
    ->filter(fn($n) => $n % 2 === 0)
    ->map(fn($n) => $n * 10)
    ->sum(); // 60

User::all()
    ->groupBy(\'country\')
    ->map(fn($users) => $users->count());',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'В чём разница между Collection и LazyCollection?',
                'answer' => 'Collection - все элементы в памяти сразу. LazyCollection - использует PHP-генераторы и обрабатывает элементы по одному, не загружая всё в память. Простыми словами: Collection ест RAM пропорционально количеству элементов, LazyCollection - почти не ест. Используется для огромных датасетов и потоков.',
                'code_example' => 'use Illuminate\Support\LazyCollection;

LazyCollection::make(function () {
    $handle = fopen(\'huge.log\', \'r\');
    while (($line = fgets($handle)) !== false) {
        yield $line;
    }
})->filter(fn($l) => str_contains($l, \'ERROR\'))
  ->take(10)
  ->each(fn($l) => print $l);',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как обрабатывать исключения в Laravel?',
                'answer' => 'Все exceptions попадают в обработчик. В Laravel 10 - app/Exceptions/Handler.php, в Laravel 11+ - bootstrap/app.php (метод withExceptions). Можно: переопределить рендеринг конкретных исключений, добавить контекст в логи, добавить reportable/renderable callbacks. Кастомные исключения могут реализовать report()/render().',
                'code_example' => '// Laravel 11+ bootstrap/app.php
->withExceptions(function (Exceptions $e) {
    $e->render(function (NotFoundHttpException $e, Request $r) {
        if ($r->is(\'api/*\')) {
            return response()->json([\'error\' => \'Not found\'], 404);
        }
    });
})

// Кастомное исключение
class PaymentFailed extends Exception {
    public function render(): JsonResponse {
        return response()->json([\'error\' => $this->getMessage()], 422);
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Action Classes (Single Action) и зачем они нужны?',
                'answer' => 'Action Class - это класс с одним методом execute/handle/__invoke, который инкапсулирует одно действие приложения (например, "создать пользователя"). Простыми словами: вытащить бизнес-логику из контроллера в отдельный класс. Чище контроллер, легче тестировать, переиспользуемо в job/console/controller.',
                'code_example' => 'class CreateUserAction {
    public function execute(array $data): User {
        return DB::transaction(function () use ($data) {
            $user = User::create($data);
            $user->profile()->create([\'avatar\' => null]);
            event(new UserCreated($user));
            return $user;
        });
    }
}

// Controller
public function store(StoreUserRequest $r, CreateUserAction $a) {
    $user = $a->execute($r->validated());
    return new UserResource($user);
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'В чём разница между config() и env()?',
                'answer' => 'env() читает значение из .env файла напрямую. config() читает значение из загруженных конфигов в памяти. ENV доступен везде ТОЛЬКО ДО config:cache, после кеширования env() возвращает null вне config-файлов. config() работает всегда, потому что значения зашиты в кеш.',
                'code_example' => '// .env
APP_NAME=MyApp

// config/app.php
\'name\' => env(\'APP_NAME\', \'Laravel\'),

// в коде
config(\'app.name\'); // правильно
env(\'APP_NAME\');    // null после config:cache в проде',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое CSRF и как Laravel защищает от него?',
                'answer' => 'CSRF (Cross-Site Request Forgery) - атака, при которой пользователя заставляют отправить запрос с его сессией на ваш сайт с другого. Laravel автоматически защищает все POST/PUT/DELETE формы web-роутов через middleware VerifyCsrfToken. В формах нужен @csrf, в Ajax - заголовок X-CSRF-TOKEN. Можно исключить роуты через $except.',
                'code_example' => '<form method="POST">
    @csrf
    <input name="title">
</form>

// Ajax (мета-тег + axios)
<meta name="csrf-token" content="{{ csrf_token() }}">

axios.defaults.headers.common[\'X-CSRF-TOKEN\'] =
    document.querySelector(\'meta[name="csrf-token"]\').content;',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Laravel Vapor и Forge?',
                'answer' => 'Forge - сервис для развёртывания Laravel-приложений на VPS (DigitalOcean, AWS, Linode). Автоматизирует настройку nginx, php-fpm, supervisor, SSL, deploy через git. Vapor - serverless-платформа для Laravel на AWS Lambda. Не нужны серверы, оплата по запросам, автомасштабирование. Подводный камень Vapor: не все Laravel-фичи работают (storage local не подходит, нужен S3).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое helpers в Laravel и приведи примеры.',
                'answer' => 'Хелперы - это глобальные функции, доступные везде. Примеры: route(), url(), config(), env(), auth(), now(), today(), abort(), back(), redirect(), response(), request(), session(), cookie(), view(), validator(), collect(), str(), tap(), throw_if(), throw_unless(), data_get(), data_set(), Arr::, Str::.',
                'code_example' => 'now()->addDays(7);
str(\'Hello\')->upper(); // Stringable
collect([1,2,3])->sum();
abort_if(! $user, 403);
$value = data_get($array, \'user.profile.name\', \'default\');
tap($user, fn($u) => $u->update([\'last_login\' => now()]))->save();',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что нового в Laravel 11 по сравнению с Laravel 10?',
                'answer' => 'Laravel 11: упрощённая структура (нет Kernel.php, Middleware, Exceptions - всё в bootstrap/app.php). routes/console.php вместо ConsoleKernel. Новый health endpoint /up. Новый Dumpable trait. Per-second rate limiting. Граф eager-loading улучшен. Casts через cast() метод вместо $casts (опционально). Минимальный PHP 8.2.',
                'code_example' => '// bootstrap/app.php
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(web: __DIR__.\'/../routes/web.php\')
    ->withMiddleware(function (Middleware $m) {
        $m->web(append: [EnsureUserIsActive::class]);
    })
    ->withExceptions(function (Exceptions $e) {})
    ->create();',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем bind отличается от singleton и от scoped в сервис-контейнере Laravel?',
                'answer' => 'bind() - каждый make() создаёт новый экземпляр. singleton() - один экземпляр на весь жизненный цикл приложения (т.е. на воркер). scoped() - один экземпляр в рамках запроса/job; Octane сбрасывает scoped-привязки между запросами, а singleton - нет, что важно для предотвращения утечки состояния. В FPM-режиме scoped и singleton ведут себя одинаково.',
                'code_example' => '<?php
$this->app->bind(Mailer::class, SmtpMailer::class);
$this->app->singleton(Cache::class, fn() => new RedisCache(...));
$this->app->scoped(RequestContext::class, fn() => new RequestContext());',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работают deferred service providers и зачем они нужны?',
                'answer' => 'Deferred provider не загружается при бутстрапе; в кэшированном manifest указано, какие сервисы он предоставляет. Когда контейнер впервые резолвит один из этих сервисов, провайдер регистрируется и загружается лениво. Это сокращает cold-start: тяжёлые провайдеры (платёжные SDK, поисковые движки) не запускаются, если не нужны. Условия: реализовать DeferrableProvider, метод provides() возвращает список биндов.',
                'code_example' => '<?php
class StripeServiceProvider extends ServiceProvider implements DeferrableProvider {
    public function register(): void {
        $this->app->singleton(StripeClient::class, fn() => new StripeClient(config("services.stripe.key")));
    }
    public function provides(): array { return [StripeClient::class]; }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое contextual binding и приведите кейс из реального проекта.',
                'answer' => 'Contextual binding позволяет внедрять разные реализации интерфейса в зависимости от потребляющего класса. Пример: PhotoController должен использовать LocalFilesystem, а VideoController - S3, оба зависят от Filesystem. Без contextual binding пришлось бы вводить именованные интерфейсы или конкреты в типах. when()->needs()->give() решает это в одном месте.',
                'code_example' => '<?php
$this->app->when(PhotoController::class)
    ->needs(Filesystem::class)
    ->give(fn() => Storage::disk("local"));

$this->app->when(VideoController::class)
    ->needs(Filesystem::class)
    ->give(fn() => Storage::disk("s3"));',
                'code_language' => 'php',
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
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как обеспечить идемпотентность Job в очереди и что произойдёт при двойном запуске?',
                'answer' => 'Очередь даёт at-least-once: при таймауте/падении воркера job переехдёт в attempts+1. Для идемпотентности используют ключ операции (заказ id, request id) и проверяют через WithoutOverlapping или БД-запись unique constraint, либо реализуют ShouldBeUnique. Альтернатива - middleware Throttled с уникальным ключом. Также важно ставить retry_after > timeout, чтобы не дублировать запуск из-за таймаута слушателя.',
                'code_example' => '<?php
class ProcessPayment implements ShouldQueue, ShouldBeUnique {
    public int $uniqueFor = 3600;
    public function __construct(public int $orderId) {}
    public function uniqueId(): string { return (string) $this->orderId; }
    public function handle() { /* charge once */ }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как настроить экспоненциальный backoff и максимальное число попыток для Job?',
                'answer' => 'Свойство $tries или метод tries() задаёт число попыток. backoff() возвращает int или массив задержек по каждой попытке (экспоненциальный backoff). retryUntil() задаёт абсолютный дедлайн. Для долгих jobs нужна синхронизация $timeout (sec) и retry_after в конфиге queue, чтобы воркер не считал job упавшим. failed() вызывается после исчерпания tries - место для алертов.',
                'code_example' => '<?php
class SyncCrm implements ShouldQueue {
    public int $tries = 5;
    public int $timeout = 120;
    public function backoff(): array { return [10, 30, 60, 120, 300]; }
    public function failed(Throwable $e): void { Log::critical("CRM sync gave up", ["e" => $e]); }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что произойдёт при деплое, если воркеры очереди держат старый код?',
                'answer' => 'Воркер бутстрапит фреймворк один раз и держит его в памяти. После деплоя он продолжит обрабатывать jobs со старыми сериализованными моделями и старыми классами. Решение - выполнять php artisan queue:restart, который выставляет таймстамп в кэше; воркеры периодически его проверяют и грейсфул-завершаются. Supervisor поднимет их с новым кодом. Также job-классы нельзя переименовывать без compatibility-shim, иначе сериализованные данные не десериализуются.',
                'code_example' => '# deploy.sh
php artisan queue:restart
php artisan migrate --force
php artisan config:cache route:cache event:cache',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие подводные камни у Octane по сравнению с обычным FPM?',
                'answer' => 'Octane держит фреймворк в памяти между запросами. Singletons и статические свойства не сбрасываются - типичный источник утечек данных между пользователями. Запрещено хранить в Auth::user() в синглтонах, использовать array-кэши на жизнь приложения, изменять контейнер из контроллеров. Решение: scoped()-биндинги, RefreshDatabase-аналоги в OctaneServiceProvider::tick. Также Octane не любит долгие и блокирующие операции - нужна модель Tasks/Coroutines.',
                'code_example' => '<?php
// плохо в Octane
class CartHolder { public static array $items = []; }

// хорошо
$this->app->scoped(CartHolder::class, fn() => new CartHolder());',
                'code_language' => 'php',
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
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем Lazy Collection отличается от обычной Collection и когда её использовать?',
                'answer' => 'LazyCollection обёртывает Generator: операции (map/filter/take) не выполняются до первого forEach/reduce, и не материализуют весь поток в память. Идеальна для построчной обработки больших файлов, cursor()-выборок Eloquent, импорта CSV. Основное ограничение - итератор однопроходный: count() или вторая итерация требуют remember()/eager(), что снова грузит в память.',
                'code_example' => '<?php
LazyCollection::make(function () {
    $h = fopen("big.csv", "r");
    while (($row = fgetcsv($h)) !== false) yield $row;
    fclose($h);
})->chunk(1000)->each(fn($chunk) => Order::insert($chunk->toArray()));',
                'code_language' => 'php',
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
            ],
            [
                'category' => 'Laravel',
                'question' => 'Безопасно ли использовать DB::transaction внутри job очереди и какие нюансы?',
                'answer' => 'Безопасно, но с оговорками. afterCommit() - слушатели/события, диспатченные внутри транзакции, должны выполниться только после её коммита, иначе job стартует и не найдёт данных. С Laravel 8+ можно ставить $afterCommit=true на job или использовать DB::afterCommit(). Длинные транзакции внутри job блокируют строки - лучше делать short-lived транзакции и идемпотентные операции.',
                'code_example' => '<?php
class SendInvoice implements ShouldQueue {
    public bool $afterCommit = true;
}
DB::transaction(function () use ($order) {
    $order->save();
    SendInvoice::dispatch($order); // сработает после COMMIT
});',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работает rate limiting в Laravel и в чём разница между Redis и database драйвером?',
                'answer' => 'RateLimiter использует cache-store: Redis даёт атомарные INCR/EXPIRE, что критично при гонках; database-драйвер делает SELECT/UPDATE и подвержен race-conditions при высоких RPS. Для распределённой системы и точного counting нужен Redis с sliding-window или token-bucket. RateLimiter::for() в RouteServiceProvider определяет лимиты, throttle:apiName применяет.',
                'code_example' => '<?php
RateLimiter::for("api", fn (Request $r) =>
    $r->user() ? Limit::perMinute(60)->by($r->user()->id)
               : Limit::perMinute(10)->by($r->ip())
);
// routes/api.php
Route::middleware("throttle:api")->group(...);',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое pivot model и зачем он нужен в belongsToMany?',
                'answer' => 'Базовый pivot - это просто строка-связка. Когда на ней нужны дополнительные поля (role, joined_at), методы или события, объявляют отдельную модель, наследующую Pivot, и подключают её через using(MembershipPivot::class). Это позволяет иметь withPivot, withTimestamps, accessors и события created/updated на самой связке.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие ограничения у route:cache и почему оно ломается с Closure-роутами?',
                'answer' => 'route:cache сериализует все маршруты в php-массив. Closure (Route::get("/", function() {...})) сериализовать нельзя - кеш падает с ошибкой. Поэтому в проде используют только controller@method или [Controller::class, "method"]. Также config:cache замораживает env(), который после кеша возвращает null вне config-файлов - это типичный source of bugs.',
                'code_example' => '<?php
// плохо: Closure
Route::get("/", function () { return "hi"; });

// хорошо
Route::get("/", [HomeController::class, "index"]);

// деплой
php artisan route:cache',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Form Request и какие у него этапы валидации?',
                'answer' => 'FormRequest - типизированный request с инкапсулированной валидацией и авторизацией. Контейнер резолвит его, вызывает authorize(), потом rules(), prepareForValidation() позволяет нормализовать вход до валидации, withValidator() добавлять after-rules, passedValidation() - пост-обработку. failedValidation/failedAuthorization кастомизируют ответы. Это переносит ответственность из контроллера и облегчает тестирование.',
                'code_example' => '<?php
class StoreUserRequest extends FormRequest {
    protected function prepareForValidation(): void {
        $this->merge(["email" => strtolower($this->email ?? "")]);
    }
    public function rules(): array {
        return ["email" => ["required", "email", Rule::unique("users")]];
    }
    public function authorize(): bool { return $this->user()->can("create-user"); }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем отличаются local query scope от global scope и какие подводные камни у global?',
                'answer' => 'Local scope - public method scopeXxx, явно вызывается в цепочке (User::active()->get()). Global scope автоматически применяется ко всем запросам модели, реализуется через Scope-интерфейс или Closure в booted(). Проблема: можно забыть и удивляться "куда делись soft-deleted записи". Снимать глобальный scope через withoutGlobalScope или withTrashed(). Также job, сериализующий модель, может потерять контекст scope.',
                'code_example' => null,
                'code_language' => null,
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
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работает Laravel Horizon и какие метрики он даёт?',
                'answer' => 'Horizon - дашборд и супервизор для Redis-очередей. Конфигурируется в config/horizon.php: массив supervisors с балансингом (auto/simple), maxProcesses, queues. Дашборд показывает throughput, runtime, failed jobs, worker memory. auto-balance перераспределяет процессы между очередями по нагрузке. horizon:terminate грейсфул-перезапускает воркеры при деплое.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое broadcasting и в чём разница private и presence-каналов?',
                'answer' => 'Broadcasting публикует серверные события клиенту через драйверы (Pusher, Reverb, Soketi). Public - открыт всем. Private - требует Auth::user() и колбэк в Broadcast::channel("orders.{user}", fn($u, $userId) => $u->id === $userId), который проверяет доступ. Presence - расширение private, ещё возвращает массив с данными присутствующих пользователей; используется для онлайн-статуса и совместного редактирования.',
                'code_example' => '<?php
Broadcast::channel("orders.{userId}", fn($u, $userId) => (int)$u->id === (int)$userId);

class OrderShipped implements ShouldBroadcast {
    public function broadcastOn(): PrivateChannel {
        return new PrivateChannel("orders.{$this->order->user_id}");
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое model binding и как сделать кастомное связывание по slug?',
                'answer' => 'Implicit binding ловит type-hint Model в методе контроллера и резолвит по primary key из URL-параметра. Чтобы биндить по slug, переопределите getRouteKeyName() на модели или укажите в роуте users/{user:slug}. Можно бросать 404 руками через Route::bind() и кастомный резолвер. Для расширенной логики - Explicit binding в RouteServiceProvider.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Laravel',
                'question' => 'Зачем нужен Pipeline и как его использовать вне middleware?',
                'answer' => 'Pipeline - декоратор поверх классов pipe-методов. Принимает входное значение и пропускает через цепочку, каждый pipe вызывает $next($payload). Используется для middleware HTTP, но прекрасно подходит для бизнес-цепочек: валидация-обогащение-вычисление-сохранение. Альтернатива длинному if-else или CoR вручную. Pipes могут быть Closure или класс с handle().',
                'code_example' => '<?php
$result = app(Pipeline::class)
    ->send($order)
    ->through([
        ValidateInventory::class,
        ApplyPromoCodes::class,
        ChargeCustomer::class,
        EmitOrderPlacedEvent::class,
    ])
    ->thenReturn();',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как Laravel Scout работает и какие нюансы при индексации больших коллекций?',
                'answer' => 'Scout - абстракция над поисковыми движками (Algolia, Meilisearch, database). Использует Searchable-трейт: автоматически синхронизирует модели с индексом на save/delete через очередь (если SCOUT_QUEUE=true). Для больших коллекций используют scout:import, который чанкует выборку. Для сложных фильтров комбинируют search($q)->where()->whereIn() и Builder-callback для специфичных запросов. softDeletes требуют отдельного флага, иначе удалённые остаются в индексе.',
                'code_example' => '<?php
class Product extends Model {
    use Searchable;
    public function toSearchableArray(): array {
        return ["name" => $this->name, "category" => $this->category->name];
    }
}
// php artisan scout:import App\\Models\\Product',
                'code_language' => 'php',
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
            ],

            // ===== Краткие Q/A =====
            [
                'category' => 'Laravel',
                'question' => 'Чем отличается Service Provider от Middleware?',
                'answer' => 'Service Provider регистрирует биндинги и бутстрапит сервисы при старте приложения. Middleware фильтрует HTTP-запросы по конвейеру до и после контроллера.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Eloquent ORM и Active Record?',
                'answer' => 'Eloquent - реализация паттерна Active Record: одна модель = одна таблица, экземпляр модели = строка, методы модели инкапсулируют CRUD и связи.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем hasOne отличается от belongsTo?',
                'answer' => 'hasOne - обратная сторона связи "один-к-одному" со стороны родителя (FK на дочерней). belongsTo - со стороны дочерней (FK у себя).',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое N+1 проблема и как её решать в Eloquent?',
                'answer' => 'N+1 - N дополнительных запросов на связанные записи при итерации. Решается eager loading через with(), withCount() или предзагрузкой через load().',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем отличаются queue jobs от events?',
                'answer' => 'Job - единица фоновой работы, ставится в очередь и выполняется воркером. Event - синхронное или асинхронное уведомление с N подписчиками-листенерами.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что делает middleware throttle?',
                'answer' => 'Ограничивает число запросов с одного клиента за период (rate limiting), используя кэш для счётчиков. Например, throttle:60,1 - 60 запросов в минуту.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем отличается Request от FormRequest?',
                'answer' => 'FormRequest - наследник Request с валидацией и авторизацией в отдельном классе. Валидация запускается до контроллера, ошибки автоматически возвращаются.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Route Model Binding?',
                'answer' => 'Автоматический резолв модели по параметру роута. Implicit - по типу аргумента и имени параметра, explicit - через Route::model или Route::bind.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Policy и Gate?',
                'answer' => 'Gate - замыкание для проверки права действия. Policy - класс, группирующий правила доступа для конкретной модели. Используются через can()/authorize().',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем отличается soft delete от обычного delete?',
                'answer' => 'Soft delete устанавливает deleted_at вместо физического удаления. Записи скрываются из выборок, восстанавливаются через restore(), удаляются окончательно через forceDelete().',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое observers в Eloquent?',
                'answer' => 'Класс с обработчиками событий жизненного цикла модели (creating, created, updating, deleted и т.д.). Регистрируется через ObservedBy-атрибут или Model::observe.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Зачем нужен php artisan optimize?',
                'answer' => 'Кэширует конфиг, роуты, события и вьюхи в одиночные файлы для production. Ускоряет загрузку фреймворка, исключая парсинг при каждом запросе.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое database transaction и как использовать в Laravel?',
                'answer' => 'Атомарная группа SQL-операций, либо все коммитятся, либо все откатываются. В Laravel - DB::transaction(closure) или явные beginTransaction/commit/rollBack.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем отличаются session, cookie и cache в Laravel?',
                'answer' => 'Cookie - данные у клиента. Session - серверное состояние пользователя, обычно идентифицируется cookie. Cache - общее key-value-хранилище без привязки к пользователю.',
            ],

            // ===== Cloze =====
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
                'category' => 'Laravel',
                'question' => 'Заполни scope для активных пользователей и его использование.',
                'answer' => 'Локальный scope - метод scopeXxx, доступный без префикса через query builder.',
                'cloze_text' => 'public function {{scopeActive}}(Builder $q): Builder {
    return $q->where("active", {{true}});
}
// usage:
User::{{active}}()->get();',
            ],

            // ===== Type-in =====
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
                'answer' => 'app() без аргументов вернёт Illuminate\\Foundation\\Application; с аргументом - резолвит зависимость из контейнера.',
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

            // ===== Assemble =====
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
                'answer' => 'onQueue выбирает очередь, delay - отложенный запуск.',
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
        ];
    }
}
