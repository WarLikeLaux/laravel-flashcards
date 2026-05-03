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
        ];
    }
}
