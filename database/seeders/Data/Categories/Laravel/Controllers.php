<?php

namespace Database\Seeders\Data\Categories\Laravel;

class Controllers
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Как создать контроллер в Laravel?',
                'answer' => 'Контроллеры создаются через artisan-команду make:controller. Можно создать пустой, resource (с CRUD-методами), invokable (single action), api (без create/edit).',
                'code_example' => 'php artisan make:controller UserController
php artisan make:controller UserController --resource
php artisan make:controller UserController --invokable
php artisan make:controller Api/UserController --api',
                'code_language' => 'bash',
                'difficulty' => 2,
                'topic' => 'laravel.controllers',
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
                'difficulty' => 2,
                'topic' => 'laravel.controllers',
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
                'difficulty' => 2,
                'topic' => 'laravel.controllers',
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
                'difficulty' => 3,
                'topic' => 'laravel.controllers',
            ],
        ];
    }
}
