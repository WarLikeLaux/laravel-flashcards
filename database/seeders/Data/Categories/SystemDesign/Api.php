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
                'answer' => 'REST - HTTP + JSON, ресурсо-ориентированный, клиент берёт всё что отдаёт endpoint. GraphQL - один endpoint, клиент в запросе указывает какие именно поля нужны (нет over/under-fetching), есть схема и типы. gRPC - HTTP/2 + Protocol Buffers, бинарный, очень быстрый, контракт через .proto файлы, поддерживает streaming. REST - универсален, GraphQL - для сложных UI с разными нуждами, gRPC - для межсервисного общения с низкой задержкой.',
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
                'code_language' => 'bash',
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
                'answer' => '1) URI: /api/v1/users, /api/v2/users - просто, видно сразу. 2) Header: Accept: application/vnd.myapi.v2+json - чище URL, но скрытнее. 3) Query parameter: /api/users?version=2 - не каноничен. 4) Subdomain: v1.api.example.com - инфраструктурно сложнее. Чаще используют URI versioning - просто и понятно. Главное - не ломать старые версии резко, давать время на миграцию.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.api',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие HTTP методы идемпотентны?',
                'answer' => 'Идемпотентные: GET, HEAD, PUT, DELETE, OPTIONS - повторный вызов даёт тот же результат. Не идемпотентен: POST - каждый вызов создаёт новый ресурс. PATCH формально не идемпотентен, но может быть таким при правильной реализации. Безопасные (не меняют состояние): GET, HEAD, OPTIONS. Идемпотентность важна для retry-логики - можно безопасно повторять идемпотентные запросы при таймауте.',
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
