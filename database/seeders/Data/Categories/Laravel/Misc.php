<?php

namespace Database\Seeders\Data\Categories\Laravel;

class Misc
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
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
                'difficulty' => 1,
                'topic' => 'laravel.misc',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие основные преимущества Laravel?',
                'answer' => 'Преимущества Laravel: 1) Элегантный синтаксис и читаемый код. 2) Огромная экосистема пакетов (Sanctum, Horizon, Telescope, Octane, Scout). 3) Eloquent ORM - удобная работа с БД. 4) Встроенные миграции, сидеры, фабрики. 5) Очереди, события, кеш, сессии "из коробки". 6) Большое сообщество и документация. 7) Artisan CLI для генерации кода. 8) Активное развитие и регулярные релизы.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 1,
                'topic' => 'laravel.misc',
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
                'difficulty' => 2,
                'topic' => 'laravel.misc',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Опиши структуру проекта Laravel - что лежит в основных папках?',
                'answer' => 'app/ - основной код приложения (модели, контроллеры, провайдеры). bootstrap/ - стартовые файлы и кеш. config/ - конфигурационные файлы. database/ - миграции, сидеры, фабрики. public/ - точка входа index.php и статика. resources/ - views, css, js, lang-файлы. routes/ - файлы маршрутов (web.php, api.php, console.php). storage/ - логи, кеш, загрузки. tests/ - тесты. vendor/ - зависимости composer.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'laravel.misc',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Опиши жизненный цикл запроса в Laravel.',
                'answer' => '1) Запрос попадает в public/index.php. 2) Загружается composer autoload и создаётся экземпляр Application (контейнер). 3) Bootstraps - регистрируются провайдеры, загружается env, конфиги. 4) HTTP-ядро (Kernel) пропускает запрос через глобальные middleware. 5) Запрос диспатчится в роутер, который находит маршрут и его middleware. 6) Запускается контроллер/closure. 7) Формируется Response. 8) Response проходит обратно через middleware (terminate). 9) Ответ отправляется клиенту.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'laravel.misc',
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
                'difficulty' => 3,
                'topic' => 'laravel.misc',
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
                'difficulty' => 2,
                'topic' => 'laravel.misc',
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
                'difficulty' => 3,
                'topic' => 'laravel.misc',
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
                'difficulty' => 2,
                'topic' => 'laravel.misc',
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
                'difficulty' => 2,
                'topic' => 'laravel.misc',
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
                'difficulty' => 3,
                'topic' => 'laravel.misc',
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
                'difficulty' => 4,
                'topic' => 'laravel.misc',
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
                'difficulty' => 4,
                'topic' => 'laravel.misc',
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
                'difficulty' => 3,
                'topic' => 'laravel.misc',
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
                'difficulty' => 3,
                'topic' => 'laravel.misc',
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
                'difficulty' => 3,
                'topic' => 'laravel.misc',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Laravel Vapor и Forge?',
                'answer' => 'Forge - сервис для развёртывания Laravel-приложений на VPS (DigitalOcean, AWS, Linode). Автоматизирует настройку nginx, php-fpm, supervisor, SSL, deploy через git. Vapor - serverless-платформа для Laravel на AWS Lambda. Не нужны серверы, оплата по запросам, автомасштабирование. Подводный камень Vapor: не все Laravel-фичи работают (storage local не подходит, нужен S3).',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'laravel.misc',
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
                'difficulty' => 2,
                'topic' => 'laravel.misc',
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
                'difficulty' => 3,
                'topic' => 'laravel.misc',
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
                'difficulty' => 4,
                'topic' => 'laravel.misc',
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
                'difficulty' => 4,
                'topic' => 'laravel.misc',
            ],
        ];
    }
}
