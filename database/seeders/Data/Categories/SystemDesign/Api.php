<?php

namespace Database\Seeders\Data\Categories\SystemDesign;

class Api
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example: ?string, code_language: ?string, difficulty: int, topic: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое REST и какие у него принципы?',
                'answer' => 'REST (Representational State Transfer) - архитектурный стиль API. Принципы: 1) Stateless (сервер не хранит состояние клиента между запросами), 2) Client-Server разделение, 3) Cacheable (ответы можно кэшировать), 4) Uniform Interface (стандартные HTTP методы и URL), 5) Layered System (между клиентом и сервером могут быть прокси/CDN), 6) Code on Demand (опционально). Ресурсы - существительные (/users), действия - HTTP-методы.',
                'code_example' => 'GET /api/users          - список
GET /api/users/42       - один пользователь
POST /api/users         - создать
PUT /api/users/42       - заменить
PATCH /api/users/42     - частичное обновление
DELETE /api/users/42    - удалить',
                'code_language' => 'bash',
                'difficulty' => 2,
                'topic' => 'system_design.api',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между REST, GraphQL и gRPC?',
                'answer' => 'REST - HTTP + JSON, ресурсо-ориентированный, клиент берёт всё что отдаёт endpoint, кэшируется штатно через HTTP-кэш. GraphQL - один POST-endpoint, клиент в запросе указывает какие поля нужны (нет over/under-fetching), сильная типизация через SDL, но HTTP-кэш не работает (всё POST). gRPC - HTTP/2 + Protocol Buffers, бинарный, поддерживает 4 типа стриминга (unary, server-, client-, bidirectional), контракт через .proto, кодогенерация на 11+ языков. Выбор: REST - публичный API и CRUD, GraphQL - богатый UI с разными view, gRPC - межсервисное общение с низкой задержкой и стримингом.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.api',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое GraphQL и проблема N+1 в нём?',
                'answer' => 'GraphQL - язык запросов: клиент шлёт один запрос с описанием нужных полей и связей. Сервер возвращает ровно эти данные. Проблема N+1: запрос users { posts { author } } может породить N+1 SQL-запросов (1 на users, 1 на posts, N на authors). Решение: DataLoader - батчит и кэширует загрузки в рамках одного GraphQL-запроса. В Laravel есть пакеты типа lighthouse-php.',
                'code_example' => 'query {
  users(first: 10) {
    id
    name
    posts(first: 5) {
      title
      comments {
        body
      }
    }
  }
}',
                'code_language' => 'json',
                'difficulty' => 4,
                'topic' => 'system_design.api',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое gRPC и Protocol Buffers?',
                'answer' => 'gRPC - RPC-фреймворк от Google поверх HTTP/2. Protocol Buffers (protobuf) - бинарный формат сериализации с .proto-схемами. Плюсы: в 5-10 раз меньше JSON, в разы быстрее парсится, типизированные контракты, кодогенерация на 11+ языков, streaming. Минусы: бинарный (сложнее дебажить), хуже для браузеров (нужен grpc-web). Используется для внутреннего общения микросервисов.',
                'code_example' => 'syntax = "proto3";
service UserService {
  rpc GetUser (UserRequest) returns (UserReply);
}
message UserRequest { int32 id = 1; }
message UserReply { string name = 1; string email = 2; }',
                'code_language' => 'bash',
                'difficulty' => 4,
                'topic' => 'system_design.api',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие способы версионирования API существуют?',
                'answer' => '1) URI: /api/v1/users, /api/v2/users - просто, видно сразу, легко кэшировать; нарушает REST-идею, что URL = ресурс (Roy Fielding не любит). 2) Header: Accept: application/vnd.myapi.v2+json (media type versioning) - чище URL, но скрытнее, сложнее тестировать в браузере. 3) Custom header: API-Version: 2. 4) Query: /api/users?version=2 - не каноничен, плохо кэшируется. 5) Subdomain: v1.api.example.com. На практике чаще URI - просто и читаемо. Стратегия: deprecation в headers (Sunset, Deprecation), 6-12 мес поддержки старой версии, semver: ломающие изменения - major.',
                'code_example' => 'GET /api/v2/users HTTP/1.1
Host: api.example.com
Accept: application/json

# или через media type
GET /api/users HTTP/1.1
Accept: application/vnd.myapi.v2+json

# ответ для устаревшей версии
HTTP/1.1 200 OK
Deprecation: true
Sunset: Sat, 31 Dec 2026 23:59:59 GMT
Link: </api/v3/users>; rel="successor-version"',
                'code_language' => 'bash',
                'difficulty' => 3,
                'topic' => 'system_design.api',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие HTTP методы идемпотентны?',
                'answer' => 'Идемпотентные по RFC 9110: GET, HEAD, PUT, DELETE, OPTIONS, TRACE - повторный вызов даёт тот же эффект на сервере, что и один. Не идемпотентен: POST - каждый вызов создаёт новый ресурс. PATCH формально не идемпотентен, но может быть таким при правильной реализации (например, замена поля). Безопасные (read-only, не меняют состояние): GET, HEAD, OPTIONS, TRACE. Идемпотентность важна для retry: при таймауте/502 можно безопасно повторить запрос; для POST используют Idempotency-Key.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.api',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что означают основные HTTP статус-коды?',
                'answer' => '2xx Success: 200 OK (общий успех), 201 Created (создано), 204 No Content (успех без тела). 3xx Redirect: 301 Moved Permanently, 302 Found, 304 Not Modified. 4xx Client error: 400 Bad Request, 401 Unauthorized (не аутентифицирован), 403 Forbidden (нет прав), 404 Not Found, 409 Conflict, 422 Unprocessable Entity (валидация), 429 Too Many Requests. 5xx Server error: 500 Internal Server Error, 502 Bad Gateway, 503 Service Unavailable, 504 Gateway Timeout.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'system_design.api',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое WebSockets и для чего нужны?',
                'answer' => 'WebSocket - протокол двунаправленной связи между клиентом и сервером поверх одного TCP-соединения. Простыми словами: телефонный разговор вместо отправки писем (HTTP). После handshake канал остаётся открытым, обе стороны могут слать сообщения в любой момент. Используется для чатов, real-time уведомлений, онлайн-игр, торговых платформ, совместного редактирования. В Laravel - Reverb, Pusher, Soketi.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.api',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Главная боль масштабирования WebSockets - чем её решают?',
                'answer' => 'WebSocket - STATEFUL протокол: после handshake соединение между клиентом и КОНКРЕТНЫМ сервером живёт долго. В отличие от stateless HTTP, нельзя "положить запрос в любой инстанс через round-robin". Это создаёт проблемы при горизонтальном масштабировании. ОСНОВНАЯ ПРОБЛЕМА: если у вас 3 WS-сервера и пользователь A подключён к ws-1, а пользователь B - к ws-3, то когда A пишет сообщение в чат, ws-1 не знает, что B существует, и не может ему отдать. РЕШЕНИЯ: 1) Pub/Sub Backplane - все WS-серверы подписываются на общий канал в Redis (или NATS / RabbitMQ / Kafka). При получении сообщения ws-сервер публикует его в Redis канал "chat:42", все остальные WS-серверы (тоже подписанные) получают его и рассылают своим подключённым клиентам. Это де-факто стандарт для Socket.io adapters, Laravel Reverb с pub/sub режимом, ActionCable в Rails. 2) Sticky sessions на L4/L7-балансировщике - привязка клиента к конкретному серверу по IP/cookie, помогает с переподключением, но НЕ решает проблему обмена между серверами - всё равно нужен backplane. 3) Specialized router/gateway - один frontend-сервер хранит routing table "user_id → ws-server" и форвардит сообщения. 4) "Безсерверные" решения (AWS API Gateway WebSocket, Pusher, Ably) - SaaS берёт routing на себя, ваш бэкенд только обрабатывает event-ы по HTTP. Дополнительные подводные камни WS на проде: heartbeat (ping/pong) для обнаружения мёртвых соединений, лимит на дескрипторы (ulimit -n), правильная остановка (graceful shutdown с уведомлением клиентов о disconnect), обновление сертификатов и rotation API-ключей без обрыва коннектов, бэкбоны NAT/proxy (некоторые корп-сети режут WS-handshake - fallback на long-polling).',
                'code_example' => '<?php
// Laravel Reverb с Redis backplane для multi-server деплоя
// config/reverb.php
"servers" => [
    "reverb" => [
        "host" => env("REVERB_HOST", "0.0.0.0"),
        "port" => env("REVERB_PORT", 8080),
        "scaling" => [
            "enabled" => env("REVERB_SCALING_ENABLED", true), // ключ к multi-server
            "channel" => "reverb",
            "server" => [
                "url" => env("REDIS_URL"),
            ],
        ],
    ],
],

// Когда включён scaling, Reverb публикует все сообщения в Redis pub/sub;
// другие инстансы Reverb подписаны и форвардят клиентам

// Архитектура (общая для любого WS-движка):
//
//   client_A ─┐                           ┌─ client_B
//             ↓                           ↑
//          [ws-1]                     [ws-3]
//             ↓ publish "chat:42"        ↑ deliver to client_B
//             └──→  [Redis Pub/Sub]  ────┘
//                       ↑ subscribe by "chat:42"
//                    [ws-2] (нет подписчиков на этот канал)

// Без backplane: ws-1 не знает, что client_B есть на ws-3 - сообщение теряется

// Sticky session - дополнение, не замена
// nginx upstream
// ip_hash; # привязка клиента к серверу по IP
// или cookie-based: sticky cookie srv_id expires=1h domain=.example.com path=/;',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'system_design.api',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между offset и cursor пагинацией?',
                'answer' => 'Offset (LIMIT N OFFSET M) - просто, но при больших M база сканирует и отбрасывает M строк (медленно на 100k+), и при вставке новых записей возможны дубли/пропуски между страницами. Cursor (keyset) пагинация - используется WHERE id > :last_id ORDER BY id LIMIT N, всегда O(log N) по индексу, стабильна при вставках. Минус cursor: нельзя прыгнуть на N-ю страницу, только next/prev. Вывод: offset для админки с малыми объёмами и нумерацией, cursor для бесконечных лент, API и больших таблиц.',
                'code_example' => '# offset (плохо для больших страниц)
GET /api/posts?page=1000&per_page=20
SELECT * FROM posts ORDER BY id DESC LIMIT 20 OFFSET 19980;

# cursor (быстро, стабильно)
GET /api/posts?after=eyJpZCI6MTIzNDV9&limit=20
SELECT * FROM posts WHERE id < 12345 ORDER BY id DESC LIMIT 20;
# ответ: { data: [...], next_cursor: "eyJpZCI6MTIzMjV9" }',
                'code_language' => 'bash',
                'difficulty' => 3,
                'topic' => 'system_design.api',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между WebSocket, SSE, long polling?',
                'answer' => 'Long polling - клиент шлёт запрос, сервер держит его до появления данных, потом отвечает, клиент сразу шлёт новый. Имитирует реалтайм через HTTP. SSE (Server-Sent Events) - односторонний канал сервер→клиент через HTTP, проще WebSocket, не работает в обратную сторону. WebSocket - полноценный двунаправленный канал. Для чата лучше WebSocket, для уведомлений хватает SSE, long polling - старый fallback.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.api',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие главные архитектурные проблемы у GraphQL на публичном API?',
                'answer' => 'GraphQL даёт клиентам гибкость (запрос только нужных полей, один round-trip вместо нескольких REST-вызовов, типизированный schema), но в продакшене порождает три серьёзные проблемы, которых нет в REST. 1) КЕШИРОВАНИЕ. GraphQL обычно делает все запросы как POST на /graphql с телом в JSON - стандартный HTTP-кеш (browser cache, CDN типа Cloudflare/Fastly, Varnish) полностью неэффективен, потому что они умеют кешировать GET по URL. Решения: Persisted Queries (клиент шлёт хеш query, сервер по хешу находит и выполняет - запрос становится GET-able), APQ (Automatic Persisted Queries в Apollo - первый раз шлётся вся query, потом только хеш), клиентские кеши (Apollo Client / Relay с нормализацией по __typename + id). На уровне приложения - кеширование на уровне резолверов (DataLoader). 2) RATE LIMITING. Лимитировать GraphQL по запросам в минуту бессмысленно: один query может вытащить полбазы (User { posts { comments { author { posts { ... } } } } }). Нужен Query Complexity Analysis - оцениваем "стоимость" каждого поля и резолвера ДО выполнения, складываем, превышение лимита - 429 без выполнения. Библиотеки: graphql-cost-analysis, query-complexity. Дополнительно: ограничить max query depth (например, максимум 7 уровней), отключить introspection в проде (или закрыть auth-ом), ограничить количество aliases (защита от alias-attack). 3) N+1 запросы. GraphQL резолверы вызываются по одному на каждое поле/запись - наивная реализация for ($posts as $post) { $post->user } делает N+1. Решение - DataLoader (изобретён Facebook): пакетирует запросы внутри одного tick event loop, дедуплицирует, кеширует на время запроса. В PHP-эквиваленты: webonyx/graphql-php + lighthouse-php имеют batch loading. Дополнительные подводные камни: обработка ошибок (один query может частично succeed/partially fail в одном HTTP 200 ответе), сложность мониторинга (нет per-endpoint метрик - всё /graphql), сложность file uploads (multipart spec костыльный), нагрузка на schema (большая schema - долгая инициализация и память). Когда GraphQL имеет смысл: BFF (backend-for-frontend) для разных клиентов с разными нуждами, federation между микросервисами (Apollo Federation), внутренние API. Когда лучше REST: публичные API с акцентом на кеш и стандарты, простые CRUD, файлы.',
                'code_example' => '<?php
// 1) Query Complexity (lighthouse-php / webonyx-php)
// schema.graphql
"""
type Query {
    posts(first: Int @rules(["max:100"])): [Post!]!
        @paginate(maxCount: 100)
        @complexity(resolver: "App\\\\GraphQL\\\\Complexity@perPage")
}
"""

// PerPage.php
public function perPage(int $childComplexity, array $args): int
{
    return $args["first"] * ($childComplexity + 1);
}

// 2) DataLoader pattern - решает N+1
class UserBatchLoader
{
    private array $cache = [];

    public function load(int $userId): User
    {
        // первый раз накапливаем ID, потом одним запросом
        $this->ids[] = $userId;

        if (! isset($this->cache[$userId])) {
            $users = User::whereIn("id", array_unique($this->ids))->get()->keyBy("id");
            foreach ($users as $u) $this->cache[$u->id] = $u;
        }

        return $this->cache[$userId];
    }
}

// Без DataLoader: 100 постов → 101 запрос
// С DataLoader: 100 постов → 2 запроса (1 для постов + 1 для всех users)

// 3) Persisted Queries - кеш на CDN
// Клиент:
//   GET /graphql?id=abc123&variables={"limit":10}
// Сервер:
//   читает файл queries/abc123.graphql, выполняет
//   ставит Cache-Control: public, max-age=60
// Cloudflare кеширует по URL - profit

// 4) Безопасность в проде
// - Отключить introspection: GraphQL::removeIntrospection()
// - Max depth: 7
// - Max complexity: 1000
// - Persisted-queries-only (запретить произвольные queries в проде)',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'system_design.api',
            ],
        ];
    }
}
