<?php

namespace Database\Seeders\Data\Categories\Laravel;

class Routing
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Что такое маршрут (route) в Laravel?',
                'answer' => 'Маршрут - это правило, которое связывает URL и HTTP-метод с конкретным действием (контроллером или замыканием). Простыми словами: когда пользователь заходит на /users, Laravel смотрит в файл routes/web.php и находит, какой код выполнить.',
                'code_example' => 'Route::get(\'/users\', [UserController::class, \'index\']);
Route::post(\'/users\', [UserController::class, \'store\']);
Route::put(\'/users/{id}\', [UserController::class, \'update\']);
Route::delete(\'/users/{id}\', [UserController::class, \'destroy\']);',
                'code_language' => 'php',
                'difficulty' => 1,
                'topic' => 'laravel.routing',
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
                'difficulty' => 2,
                'topic' => 'laravel.routing',
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
                'difficulty' => 2,
                'topic' => 'laravel.routing',
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
                'difficulty' => 2,
                'topic' => 'laravel.routing',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что делает route caching и какие у него ограничения?',
                'answer' => 'php artisan route:cache компилирует все роуты в один кешируемый PHP-файл, что ускоряет работу приложения. Ограничение: нельзя использовать closure-роуты (анонимные функции), только массив [Controller::class, "method"]. Используется в продакшене.',
                'code_example' => 'php artisan route:cache
php artisan route:clear
php artisan route:list',
                'code_language' => 'bash',
                'difficulty' => 3,
                'topic' => 'laravel.routing',
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
                'difficulty' => 3,
                'topic' => 'laravel.routing',
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
                'difficulty' => 3,
                'topic' => 'laravel.routing',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое model binding и как сделать кастомное связывание по slug?',
                'answer' => 'Implicit binding ловит type-hint Model в методе контроллера и резолвит по primary key из URL-параметра. Чтобы биндить по slug, переопределите getRouteKeyName() на модели или укажите в роуте users/{user:slug}. Можно бросать 404 руками через Route::bind() и кастомный резолвер. Для расширенной логики - Explicit binding в RouteServiceProvider.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'laravel.routing',
            ],
        ];
    }
}
