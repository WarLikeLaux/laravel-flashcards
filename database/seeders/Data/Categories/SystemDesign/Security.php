<?php

namespace Database\Seeders\Data\Categories\SystemDesign;

class Security
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example: ?string, code_language: ?string, difficulty: int, topic: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое HTTPS и TLS простыми словами?',
                'answer' => 'HTTPS = HTTP + TLS. TLS (Transport Layer Security) - криптографический протокол, шифрующий передачу данных. Простыми словами: если HTTP - это открытка, которую может прочесть любой почтальон, то HTTPS - запечатанный конверт. Решает три задачи: 1) шифрование (никто не подслушает), 2) аутентификация сервера (через сертификат - это правда тот сайт), 3) целостность (данные не подменены). SSL - устаревший предшественник TLS.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'system_design.security',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Как работает TLS handshake простыми словами?',
                'answer' => 'TLS handshake (рукопожатие) - обмен между клиентом и сервером перед началом шифрования: 1) клиент: "привет, поддерживаю эти алгоритмы", 2) сервер: "выбираю этот, вот мой сертификат", 3) клиент проверяет сертификат через CA (центр сертификации), 4) обмениваются ключами через асимметричную криптографию (RSA/ECDHE), 5) договариваются о симметричном ключе для скорости, 6) дальше всё шифруется этим ключом. TLS 1.3 сократил handshake до 1 RTT.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.security',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между аутентификацией и авторизацией?',
                'answer' => 'Аутентификация (Authentication, AuthN) - "кто ты?" - проверка личности (логин/пароль, токен, биометрия). Авторизация (Authorization, AuthZ) - "что тебе можно?" - проверка прав на действие (роли, разрешения). Простыми словами: на проходной показал паспорт - аутентифицировали; чтобы войти в серверную - проверили разрешение, авторизовали. Сначала всегда AuthN, потом AuthZ.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'system_design.security',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое OAuth 2.0 и какие у него grant types?',
                'answer' => 'OAuth 2.0 - стандарт делегирования доступа. Простыми словами: ты разрешаешь приложению X получить доступ к твоим данным на сервисе Y, не отдавая пароль. 4 основных grant type: 1) Authorization Code - для веб-приложений с бэкендом (самый безопасный), 2) Client Credentials - сервис-сервис, 3) Resource Owner Password Credentials - устаревший, прямой логин/пароль, 4) Implicit - устарел, заменён на Code+PKCE для SPA.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.security',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое JWT и какие плюсы и минусы?',
                'answer' => 'JWT (JSON Web Token, RFC 7519) - подписанный токен с тремя частями: header.payload.signature, разделёнными точкой, base64url-кодированы. Внутри payload - claims (sub, iat, exp, roles). Подписан симметричным секретом (HS256) или асимметричным ключом (RS256/ES256). Плюсы: stateless (сервер не хранит сессию), удобен для микросервисов и SPA, любой сервис с public key может проверить токен. Минусы: 1) нельзя отозвать до exp без серверного blacklist (теряем stateless), поэтому короткий exp 5-15 мин + refresh token, 2) размер больше cookie session_id, 3) payload не зашифрован, только подписан - не клади туда чувствительное (для шифрования есть JWE), 4) исторически были атаки alg=none и confusion (RS256→HS256 с public key как secret) - всегда явно whitelisting alg.',
                'code_example' => 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIxMjMiLCJleHAiOjE3MDB9.signature',
                'code_language' => 'bash',
                'difficulty' => 3,
                'topic' => 'system_design.security',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'JWT vs server-side sessions - что выбрать?',
                'answer' => 'Server-side session: сервер хранит сессию (Redis/БД), клиенту даёт session_id в HttpOnly cookie. Плюсы: моментальная отзываемость (удалил из Redis - session мертва), маленький cookie, изменения профиля видны сразу. Минусы: каждый запрос идёт в session store, нужен общий store при горизонтальном масштабировании. JWT: токен с подписью, сервер ничего не помнит. Плюсы: stateless, любой микросервис верифицирует через public key, хорош для distributed/edge. Минусы: отзыв сложен (blacklist убивает stateless), большой размер. Правило: monolith с одной БД сессии - sessions проще; распределённые системы и B2B SSO - JWT (или opaque tokens с introspection как в OAuth2).',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.security',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое access token и refresh token?',
                'answer' => 'Access token - короткоживущий токен (15 мин - 1 час) для доступа к API. Refresh token - долгоживущий (дни/недели) для получения нового access token без логина. Простыми словами: access - пропуск на сегодня, refresh - удостоверение, по которому выдают пропуска. Если access утёк - украли на короткое время. Refresh хранится безопаснее (HttpOnly cookie), может быть отозван. На каждом запросе используется access, при истечении - refresh обновляет его.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.security',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое RBAC и ABAC?',
                'answer' => 'RBAC (Role-Based Access Control) - доступ через роли: admin, editor, viewer. У пользователя роль, у роли набор прав. Простой и понятный. ABAC (Attribute-Based Access Control) - доступ через атрибуты: пользователь+ресурс+действие+контекст. Например: "редактировать может автор, или админ, или модератор отдела автора, в рабочее время". Гибче RBAC, но сложнее. В реальности часто комбинируют: RBAC как база + ABAC-правила сверху.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.security',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое CORS простыми словами?',
                'answer' => 'CORS (Cross-Origin Resource Sharing) - механизм браузера, разрешающий или запрещающий запросы с одного домена на другой. Простыми словами: браузер по умолчанию запрещает сайту example.com делать запросы к api.other.com (защита от XSS). Сервер api.other.com должен явно разрешить через заголовок Access-Control-Allow-Origin. Преflight-запрос (OPTIONS) идёт перед "сложными" запросами для проверки разрешений.',
                'code_example' => 'Access-Control-Allow-Origin: https://example.com
Access-Control-Allow-Methods: GET, POST, PUT, DELETE
Access-Control-Allow-Headers: Content-Type, Authorization
Access-Control-Max-Age: 86400',
                'code_language' => 'bash',
                'difficulty' => 3,
                'topic' => 'system_design.security',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое CSRF и как защищаться?',
                'answer' => 'CSRF (Cross-Site Request Forgery) - атака, когда вредоносный сайт от имени залогиненного пользователя шлёт запрос на твой сайт через его cookies. Простыми словами: ты залогинен в банке, открыл вредоносный сайт - он скрытно шлёт POST /transfer от твоего имени. Защита: CSRF-токен в форме (Laravel @csrf), который вредоносный сайт не может узнать. SameSite cookies (Strict/Lax) тоже помогают.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.security',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое XSS и как защищаться?',
                'answer' => 'XSS (Cross-Site Scripting) - инъекция вредоносного JS в страницу. Простыми словами: пользователь оставил коммент с <script>alert(stolenCookie)</script>, и этот скрипт выполняется у других посетителей. Защита: 1) экранировать вывод (Blade {{ }} автоматом), 2) Content-Security-Policy header, 3) HttpOnly cookies (JS не доступен), 4) sanitize HTML если разрешён (HTMLPurifier). Никогда не вставляй пользовательский ввод в HTML/JS без обработки.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.security',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое OWASP Top 10?',
                'answer' => 'OWASP Top 10 (2021) - топ-10 веб-уязвимостей: A01 Broken Access Control (нарушение прав доступа, IDOR), A02 Cryptographic Failures (слабая криптография, plain text), A03 Injection (SQLi, NoSQLi, командная), A04 Insecure Design, A05 Security Misconfiguration (дефолтные креды, debug в проде), A06 Vulnerable and Outdated Components (старые либы с CVE), A07 Identification and Authentication Failures (слабые пароли, brute-force), A08 Software and Data Integrity Failures (CI/CD, supply chain), A09 Security Logging and Monitoring Failures, A10 Server-Side Request Forgery (SSRF). Это базовый чек-лист для аудита.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.security',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое SQL injection и как защищаться?',
                'answer' => 'SQL Injection - подмена логики SQL-запроса через непроверенный пользовательский ввод. Пример: "SELECT * FROM users WHERE name = \'" . $name . "\'", где $name = "\' OR 1=1 --" даёт всех пользователей. Грозит чтением/изменением/удалением данных, эскалацией прав. Защита: 1) prepared statements (параметризованные запросы) - ввод никогда не попадает в SQL-парсер, всегда как value, 2) ORM (Eloquent, Doctrine) делает это по умолчанию, 3) валидация и whitelist для имён колонок/таблиц (их параметризовать нельзя), 4) принцип минимальных прав - у app-юзера нет DROP, 5) WAF как доп. слой. Никогда не делай ручную конкатенацию SQL.',
                'code_example' => '<?php
// плохо - SQL injection
$users = DB::select("SELECT * FROM users WHERE email = \'$email\'");

// хорошо - prepared statement
$users = DB::select("SELECT * FROM users WHERE email = ?", [$email]);

// хорошо - Eloquent (под капотом prepared)
$user = User::where("email", $email)->first();

// для имён колонок нужен whitelist
$allowed = ["name", "created_at", "email"];
$column = in_array($sortBy, $allowed) ? $sortBy : "id";
User::orderBy($column)->get();',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'system_design.security',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Почему нельзя хешировать пароли через md5 или sha256?',
                'answer' => 'md5 и sha256 быстрые - именно поэтому плохие для паролей. Современные GPU считают миллиарды sha256/сек, при утечке базы пароли подбираются за минуты. md5 ещё и ломан криптографически (collision attacks). Для паролей нужны медленные функции: bcrypt, argon2, scrypt - они спроектированы быть медленными и потребляющими память. bcrypt: классика с 1999, cost factor (12+), есть лимит в 72 байта. Argon2id (победитель Password Hashing Competition 2015) - современный выбор, защищён от GPU/ASIC, есть параметры memory/time/parallelism. scrypt - между ними, memory-hard. Все они автоматически добавляют salt (защита от rainbow tables). В PHP - password_hash/password_verify (PASSWORD_BCRYPT по умолчанию, рекомендуется PASSWORD_ARGON2ID).',
                'code_example' => '<?php
$hash = password_hash("password123", PASSWORD_ARGON2ID);
if (password_verify($input, $hash)) {
    // OK
}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'system_design.security',
            ],
        ];
    }
}
