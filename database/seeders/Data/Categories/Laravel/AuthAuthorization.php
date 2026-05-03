<?php

namespace Database\Seeders\Data\Categories\Laravel;

class AuthAuthorization
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
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
                'difficulty' => 3,
                'topic' => 'laravel.auth_authorization',
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
                'difficulty' => 4,
                'topic' => 'laravel.auth_authorization',
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
                'difficulty' => 3,
                'topic' => 'laravel.auth_authorization',
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
                'difficulty' => 3,
                'topic' => 'laravel.auth_authorization',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое уязвимость IDOR и как её предотвращать в Laravel?',
                'answer' => 'IDOR (Insecure Direct Object Reference) - атака, при которой авторизованный пользователь меняет идентификатор в URL/теле запроса (/orders/5 → /orders/6, или body { "user_id": 7 }) и получает доступ к чужой сущности. Уязвимость возникает, когда контроллер находит модель только по первичному ключу, не проверяя ВЛАДЕНИЕ. Ловушка: route model binding (Order $order) сам по себе не защищает - он лишь делает Order::findOrFail($id), не зная про текущего пользователя. Три способа защиты, по возрастанию надёжности: 1) Policy + $this->authorize() в контроллере - явная проверка владения на уровне домена, легко тестировать, видно в логах. 2) Scoped query через отношение текущего пользователя: Auth::user()->orders()->findOrFail($id) - SQL-запрос изначально содержит WHERE user_id = ?, просто невозможно достать чужое. 3) Scoped implicit binding через Route::scopeBindings() (или метод scopeBindings() на конкретном роуте) - заставляет Laravel при /users/{user}/orders/{order} проверять, что order принадлежит user. Также: для multi-tenant приложений заворачивайте всё в Global Scope с tenant_id, и тестируйте политики через actingAs($otherUser)->getJson("/orders/{$ownOrder->id}")->assertForbidden(). Никогда не доверяйте $request->input("user_id") - всегда брать $request->user()->id.',
                'code_example' => '<?php
// УЯЗВИМО: route model binding без проверки владения
public function show(Order $order) {
    return new OrderResource($order); // /orders/6 от чужого юзера → утечка
}

// 1) Через Policy - явно
public function show(Order $order) {
    $this->authorize("view", $order); // OrderPolicy::view → user_id === auth()->id()
    return new OrderResource($order);
}

// 2) Scoped query - запросом, не PHP-проверкой
public function show(int $id) {
    $order = $request->user()->orders()->findOrFail($id);
    return new OrderResource($order);
}

// 3) Scoped implicit binding - Laravel сам проверит связь
Route::get("/users/{user}/orders/{order}", function (User $user, Order $order) {
    // order гарантированно принадлежит user (WHERE user_id = users.id)
    return $order;
})->scopeBindings();',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.auth_authorization',
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
                'difficulty' => 3,
                'topic' => 'laravel.auth_authorization',
            ],
        ];
    }
}
