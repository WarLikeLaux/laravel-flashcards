<?php

namespace Database\Seeders\Data\Categories;

class SystemDesignQuestions
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example: ?string, code_language: ?string}>
     */
    public static function all(): array
    {
        return [
            // === БАЗОВАЯ АРХИТЕКТУРА ===
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое монолит простыми словами?',
                'answer' => 'Монолит - это одно большое приложение, в котором весь код (бизнес-логика, БД, UI) живёт вместе и деплоится одной "коробкой". Простыми словами: представь огромный швейцарский нож - один инструмент со всеми функциями. Плюсы: проще разрабатывать, дебажить, деплоить. Минусы: сложно масштабировать отдельные части, любая ошибка может уронить всё, тяжёлый деплой.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое микросервисы простыми словами?',
                'answer' => 'Микросервисы - это разбиение большого приложения на маленькие независимые сервисы, каждый отвечает за свою бизнес-задачу и общается с другими через сеть (HTTP, очереди). Простыми словами: вместо одного большого швейцарского ножа у тебя набор отдельных инструментов. Сервис заказов, сервис платежей, сервис уведомлений - каждый можно разрабатывать, деплоить и масштабировать отдельно.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие плюсы и минусы у микросервисов по сравнению с монолитом?',
                'answer' => 'Плюсы микросервисов: независимое масштабирование, разные технологии, изоляция отказов, независимые деплои, маленькие команды владеют сервисами. Минусы: сложность инфраструктуры (k8s, service mesh), сетевые задержки, распределённые транзакции, дебаг через множество сервисов, нужны DevOps-практики, eventual consistency. Монолит проще для маленьких команд, микросервисы оправданы при росте.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Service-Oriented Architecture (SOA)?',
                'answer' => 'SOA - предшественник микросервисов: приложение разбивается на сервисы, общающиеся через корпоративную шину (ESB). Сервисы крупнее микросервисов, обмен идёт через SOAP/XML, ESB централизует маршрутизацию и трансформации. Главное отличие от микросервисов: тяжёлая централизованная шина и крупные сервисы. Микросервисы - облегчённый SOA с REST/gRPC и без ESB.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое 3-х уровневая архитектура?',
                'answer' => '3-tier architecture - разделение приложения на три слоя: 1) Presentation (UI, фронтенд), 2) Business Logic (бэкенд, контроллеры, сервисы), 3) Data (БД, файловое хранилище). Каждый слой общается только со смежным. Это классика для веб-приложений, простыми словами: фронт спрашивает у бэка, бэк спрашивает у БД, никто не лезет через слой.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое гексагональная архитектура (Ports and Adapters)?',
                'answer' => 'Hexagonal architecture - подход, где доменная логика в центре, а вокруг "порты" (интерфейсы) и "адаптеры" (конкретные реализации: HTTP, БД, очередь). Простыми словами: ядро приложения не знает, откуда пришёл запрос (CLI, HTTP, тест) и куда сохраняются данные (Postgres, файл). Это даёт тестируемость и возможность менять инфраструктуру не трогая бизнес-логику.',
                'code_example' => '<?php
// Порт (интерфейс)
interface OrderRepository {
    public function save(Order $order): void;
}

// Адаптер для Postgres
class PgOrderRepository implements OrderRepository {
    public function save(Order $order): void { /* SQL */ }
}

// Адаптер для тестов
class InMemoryOrderRepository implements OrderRepository {
    private array $items = [];
    public function save(Order $order): void { $this->items[] = $order; }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Clean Architecture?',
                'answer' => 'Clean Architecture (Дядя Боб) - концентрические слои, зависимости направлены только внутрь. Слои снаружи внутрь: Frameworks & Drivers, Interface Adapters, Use Cases, Entities. Простыми словами: бизнес-правила (entities, use cases) не зависят от Laravel, Postgres или REST - можно переключить любой внешний слой не трогая ядро. Чем-то похоже на гексагональную, но с явной иерархией слоёв.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Onion Architecture?',
                'answer' => 'Onion Architecture - вариация Clean Architecture со слоями-кольцами луковицы. Центр - Domain Model (сущности), вокруг Domain Services, Application Services, на периферии Infrastructure (БД, UI, тесты). Зависимости направлены внутрь: внешние слои знают о внутренних, но не наоборот. Идея: бизнес-логика стабильна, инфраструктура меняется - значит инфраструктура должна зависеть от логики, а не наоборот.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Bounded Context в DDD?',
                'answer' => 'Bounded Context (ограниченный контекст) - область, в которой каждое понятие имеет одно конкретное значение. Простыми словами: слово "клиент" в контексте отдела продаж - это потенциальный покупатель, в контексте доставки - адресат. Это разные модели, поэтому их разделяют. В микросервисах bounded context часто соответствует одному сервису. Связь между контекстами описывается через Anti-Corruption Layer.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Anti-Corruption Layer?',
                'answer' => 'Anti-Corruption Layer (ACL) - прослойка между двумя bounded contexts, которая транслирует данные и не даёт чужой модели "испортить" твою. Простыми словами: переводчик на границе, который превращает данные внешнего сервиса (например, легаси-CRM) в чистые объекты твоего домена. Если завтра CRM поменяют - правишь только ACL, остальной код не трогаешь.',
                'code_example' => '<?php
class LegacyCrmAcl {
    public function __construct(private LegacyCrmClient $crm) {}

    public function getCustomer(int $id): Customer {
        $raw = $this->crm->getClientData($id);
        return new Customer(
            id: $raw["client_id"],
            name: $raw["full_name"],
            email: $raw["contact_email"],
        );
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое BFF (Backend for Frontend)?',
                'answer' => 'BFF - отдельный бэкенд для каждого фронтенда (web, iOS, Android). Простыми словами: вместо общего API, который пытается угодить всем клиентам, делают отдельный сервис для мобильного и отдельный для веба. Каждый отдаёт ровно те данные и в том формате, что нужен конкретному клиенту. Уменьшает overfetching, упрощает версионирование, но плодит дублирование кода.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое API Gateway?',
                'answer' => 'API Gateway - единая точка входа для всех клиентских запросов в микросервисную систему. Делает: маршрутизацию к нужному сервису, аутентификацию, rate limiting, кэширование, логирование, агрегацию ответов из нескольких сервисов. Простыми словами: швейцар на входе - проверяет билет, направляет в нужный зал, считает посетителей. Примеры: Kong, Tyk, AWS API Gateway, Nginx с конфигами.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое reverse proxy и для чего он нужен?',
                'answer' => 'Reverse proxy - сервер-посредник перед твоим приложением, который принимает запросы клиентов и передаёт их в бэкенд. Простыми словами: секретарь, который принимает звонки и переводит их на нужного сотрудника. Зачем: терминация TLS, балансировка нагрузки, кэш, защита от DDoS, скрытие внутренней инфраструктуры, обслуживание статики. Популярные: Nginx, HAProxy, Caddy, Traefik.',
                'code_example' => 'server {
    listen 443 ssl;
    server_name api.example.com;

    location / {
        proxy_pass http://backend:8000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    }
}',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Чем reverse proxy отличается от forward proxy?',
                'answer' => 'Forward proxy стоит перед клиентом, скрывает клиента от сервера (корпоративный прокси для выхода в интернет). Reverse proxy стоит перед сервером, скрывает сервер от клиента (Nginx перед Laravel). Простыми словами: forward proxy - это "я хожу через посредника", reverse proxy - это "ко мне приходят через посредника". Для пользователя reverse proxy выглядит как сам сервер.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое load balancer и какие алгоритмы балансировки бывают?',
                'answer' => 'Load balancer - распределяет входящие запросы между несколькими серверами. Алгоритмы: Round Robin (по очереди), Least Connections (на сервер с меньшим числом активных коннектов), Least Response Time, IP Hash (один IP всегда на один сервер), Weighted (с весами по мощности серверов). Sticky session - один пользователь всегда на тот же сервер (нужно для серверной сессии без Redis).',
                'code_example' => 'upstream backend {
    least_conn;
    server backend1.example.com weight=3;
    server backend2.example.com weight=1;
    server backend3.example.com backup;
}',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое sticky session и зачем нужна?',
                'answer' => 'Sticky session (session affinity) - привязка пользователя к одному и тому же серверу для всех его запросов. Простыми словами: если один раз попал на сервер №2, дальше всегда туда же. Нужна когда сессии хранятся в памяти конкретного сервера (file/array driver). Минусы: неравномерная нагрузка, при падении сервера пользователь теряет сессию. Лучше хранить сессии в Redis - тогда sticky не нужны.',
                'code_example' => null,
                'code_language' => null,
            ],

            // === КЭШИРОВАНИЕ ===
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое кэш простыми словами?',
                'answer' => 'Кэш - это быстрое временное хранилище для часто запрашиваемых данных. Простыми словами: записная книжка под рукой - не нужно каждый раз идти в большой архив. Если данные есть в кэше (cache hit) - отдаём моментально; если нет (cache miss) - берём из БД, кладём в кэш, отдаём. Хранилища: Redis, Memcached, локальная память приложения, файловый кэш.',
                'code_example' => '<?php
$user = Cache::remember("user:$id", 3600, function () use ($id) {
    return User::find($id);
});',
                'code_language' => 'php',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие уровни кэширования бывают в веб-приложении?',
                'answer' => 'Слои кэша от клиента к БД: 1) Browser cache (Cache-Control в headers), 2) CDN (статика близко к пользователю), 3) Reverse proxy cache (Nginx, Varnish), 4) Application cache (Redis, Memcached), 5) ORM/query cache (внутри ORM), 6) Database buffer pool (внутри БД). Принцип: чем ближе к пользователю, тем быстрее, но меньше данных можно хранить.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое cache-aside (lazy loading) стратегия?',
                'answer' => 'Cache-aside - приложение само управляет кэшем: при чтении сначала смотрит в кэш, если нет - читает из БД и кладёт в кэш. При записи - пишет в БД и инвалидирует/обновляет кэш. Простыми словами: ты сам решаешь, что и когда положить в записную книжку. Плюсы: простота, кэш не зависит от БД. Минусы: возможен stale data при гонке, первый запрос всегда медленный.',
                'code_example' => '<?php
function getUser(int $id): User {
    $user = Cache::get("user:$id");
    if ($user === null) {
        $user = User::find($id);
        Cache::put("user:$id", $user, 3600);
    }
    return $user;
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое write-through стратегия кэша?',
                'answer' => 'Write-through - запись идёт сначала в кэш, потом синхронно в БД. Чтение - всегда из кэша. Плюсы: кэш всегда консистентен с БД, нет stale data. Минусы: запись медленнее (две операции), кэш заполняется только при записи. Подходит когда чтение во много раз чаще записи и важна консистентность.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое write-behind (write-back) стратегия кэша?',
                'answer' => 'Write-behind - запись только в кэш, в БД асинхронно через некоторое время или батчем. Простыми словами: записал в блокнот, в большую тетрадь перепишу позже. Самая быстрая запись. Минусы: при падении кэша теряются данные, сложнее реализовать. Подходит для счётчиков, метрик, логов - где немного потерянных данных не катастрофа.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое write-around стратегия кэша?',
                'answer' => 'Write-around - запись идёт сразу в БД минуя кэш, кэш заполняется только при чтении. Плюсы: не засоряем кэш редко читаемыми данными, простая запись. Минусы: первое чтение после записи всегда медленное (cache miss). Хорошо когда записи много, а читается малая часть данных (логи событий, аудит).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие политики вытеснения (eviction) есть в кэше?',
                'answer' => 'LRU (Least Recently Used) - вытесняем то, что давно не использовали. LFU (Least Frequently Used) - то, что редко используется. FIFO - в порядке поступления. Random - случайно. TTL - по времени жизни. Redis по умолчанию использует noeviction (отказывает в записи при OOM), но можно настроить allkeys-lru, volatile-lru и др. Выбор зависит от паттерна доступа.',
                'code_example' => '# redis.conf
maxmemory 2gb
maxmemory-policy allkeys-lru',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое cache stampede и как с ним бороться?',
                'answer' => 'Cache stampede (thundering herd) - когда популярный ключ истекает в кэше и тысячи запросов одновременно начинают перестраивать его, забивая БД. Простыми словами: магазин закрылся на учёт - все клиенты ломятся одновременно. Решения: 1) atomic lock на пересборку (только один запрос строит, остальные ждут), 2) probabilistic early expiration (случайно обновляем чуть раньше TTL), 3) stale-while-revalidate.',
                'code_example' => '<?php
$value = Cache::lock("rebuild:$key", 10)->block(5, function () use ($key) {
    return Cache::remember($key, 300, fn() => expensiveQuery());
});',
                'code_language' => 'php',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое CDN простыми словами?',
                'answer' => 'CDN (Content Delivery Network) - сеть серверов по всему миру, которые хранят копии твоих статичных файлов (картинки, JS, CSS) близко к пользователям. Простыми словами: твой сайт в Москве, а пользователь в Токио - вместо запроса через полпланеты, ему отдают файл с сервера CDN в Токио. Уменьшает latency, разгружает origin, защищает от DDoS. Примеры: Cloudflare, Fastly, AWS CloudFront, Akamai.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Почему cache invalidation - это сложно?',
                'answer' => 'Знаменитая цитата: "There are only two hard things in CS: cache invalidation and naming things". Сложно потому что: 1) трудно понять когда именно данные устарели, 2) одно изменение в БД может затронуть много ключей кэша, 3) в распределённой системе инвалидация сама требует консистентности, 4) баланс между актуальностью и производительностью. Решения: TTL, версионирование ключей (etag), tag-based invalidation, событийная инвалидация.',
                'code_example' => null,
                'code_language' => null,
            ],

            // === ОЧЕРЕДИ И СООБЩЕНИЯ ===
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое очередь сообщений простыми словами?',
                'answer' => 'Message queue - буфер между компонентами системы. Один сервис кладёт сообщение в очередь и забывает, другой читает и обрабатывает. Простыми словами: почтовый ящик - отправитель опустил письмо и пошёл по делам, получатель забрал когда удобно. Зачем: 1) асинхронность (не ждём обработки), 2) сглаживание пиков нагрузки, 3) decoupling (сервисы не знают друг о друге), 4) надёжность (сообщения переживут падение).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Producer и Consumer в очередях?',
                'answer' => 'Producer (издатель, продюсер) - тот, кто кладёт сообщения в очередь. Consumer (подписчик, потребитель) - тот, кто читает и обрабатывает. Один продюсер может слать в несколько очередей, на одну очередь могут подписаться несколько консьюмеров. Если консьюмеров несколько на одной очереди (work queue) - сообщения распределяются между ними; если pub/sub - каждый получает копию.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между RabbitMQ и Kafka?',
                'answer' => 'RabbitMQ - классическая очередь сообщений: AMQP протокол, маршрутизация через exchanges, сообщение удаляется после прочтения, push-модель. Kafka - распределённый лог событий: сообщения хранятся днями, ничего не удаляется, consumer сам читает с offset (pull), горизонтально масштабируется через partitions. RabbitMQ для классических очередей задач (рассылки, обработка), Kafka для event streaming, аналитики, миллионов событий в секунду.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое at-most-once, at-least-once, exactly-once в очередях?',
                'answer' => 'At-most-once - сообщение доставится 0 или 1 раз, но не больше (можно потерять). At-least-once - 1 или больше раз (могут быть дубли). Exactly-once - ровно один раз (идеал). Большинство систем дают at-least-once, exactly-once в распределённой системе строго недостижимо (см. Two Generals Problem). На практике делают at-least-once + идемпотентного консьюмера = "effectively-once".',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое идемпотентность простыми словами?',
                'answer' => 'Идемпотентность - свойство операции, при котором её повторное выполнение даёт тот же результат что и первое. Простыми словами: нажать кнопку лифта 5 раз - то же что нажать 1 раз, лифт всё равно приедет один раз. В HTTP идемпотентны GET, PUT, DELETE; не идемпотентен POST. В очередях идемпотентность критична потому что at-least-once гарантирует возможные дубли - повторная обработка не должна списать деньги дважды.',
                'code_example' => '<?php
public function handle(PaymentMessage $msg): void {
    if (Payment::where("idempotency_key", $msg->key)->exists()) {
        return; // уже обработано
    }
    DB::transaction(function () use ($msg) {
        Payment::create(["idempotency_key" => $msg->key, ...]);
        $this->charge($msg);
    });
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Idempotency-Key и как использовать в платежах?',
                'answer' => 'Idempotency-Key - уникальный токен от клиента в HTTP-заголовке. Сервер хранит маппинг ключ → результат на N часов. Если приходит повторный запрос с тем же ключом - возвращаем кэшированный ответ, реально не выполняя операцию. Это защита от двойных списаний при сетевых ретраях. Stripe, AWS, Twilio - все так делают для платёжных API.',
                'code_example' => '<?php
$key = $request->header("Idempotency-Key");
if ($cached = Cache::get("idemp:$key")) {
    return response()->json($cached);
}
$result = $payment->charge($amount);
Cache::put("idemp:$key", $result, 86400);
return response()->json($result);',
                'code_language' => 'php',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между Pub/Sub и Message Queue?',
                'answer' => 'Message Queue (work queue) - одно сообщение получает один консьюмер, после прочтения сообщение удаляется. Подходит для задач: одна джоба - один воркер. Pub/Sub - сообщение получают все подписчики, у каждого своя копия. Подходит для уведомлений: пользователь зарегистрировался → отправь email + создай профиль + начисли бонус. В Kafka реализуется через consumer groups, в RabbitMQ - через fanout exchange.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Dead Letter Queue?',
                'answer' => 'Dead Letter Queue (DLQ) - очередь для сообщений, которые не получилось обработать после N попыток. Простыми словами: ящик "проблемные письма" куда идут те, что не смог разобрать почтальон. Зачем: не теряем сообщения, можно потом разобраться вручную или починить и повторить. В Laravel - failed_jobs таблица, в SQS/RabbitMQ - отдельная DLQ.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое backpressure?',
                'answer' => 'Backpressure - механизм когда медленный консьюмер "тормозит" быстрого продюсера, чтобы не переполнить очередь и не уронить систему. Простыми словами: на конвейере работник не успевает - конвейер замедляется или останавливается. Реализуется через ограничение размера очереди (если полна - блокируем producer), throttling, reactive streams (RxJS, Project Reactor). Без backpressure система ломается под пиками.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Apache Kafka простыми словами?',
                'answer' => 'Kafka - распределённый лог сообщений с высокой пропускной способностью. Простыми словами: огромный журнал, куда непрерывно дописываются события, и любой может читать с любой позиции. Топик (topic) - категория событий. Партиция (partition) - часть топика, упорядоченная последовательность. Offset - позиция сообщения в партиции. Consumer запоминает свой offset и продолжает с него после рестарта. Используется для event streaming, аналитики, CDC.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Event Sourcing простыми словами?',
                'answer' => 'Event Sourcing - вместо хранения текущего состояния хранится последовательность событий, изменивших состояние. Простыми словами: банковский счёт - не хранится "баланс 1000", хранятся события "пополнили 500", "пополнили 700", "сняли 200". Текущий баланс получается проигрыванием событий. Плюсы: полный аудит, можно посмотреть состояние на любой момент, легко перестроить аналитику. Минусы: сложнее, миграции схемы событий тяжелы.',
                'code_example' => '<?php
// События
class MoneyDeposited { public function __construct(public int $amount) {} }
class MoneyWithdrawn { public function __construct(public int $amount) {} }

// Восстановление состояния
function getBalance(array $events): int {
    $balance = 0;
    foreach ($events as $event) {
        if ($event instanceof MoneyDeposited) $balance += $event->amount;
        if ($event instanceof MoneyWithdrawn) $balance -= $event->amount;
    }
    return $balance;
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое CQRS простыми словами?',
                'answer' => 'CQRS (Command Query Responsibility Segregation) - разделение модели чтения и записи. Команды (write) меняют состояние, не возвращают данных. Запросы (read) только читают и могут использовать денормализованную модель для скорости. Простыми словами: для записи в банк используешь форму с полным набором полей (write-модель), для просмотра выписки - удобно отформатированный отчёт (read-модель). Часто используется с Event Sourcing.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Saga pattern?',
                'answer' => 'Saga - паттерн для распределённых транзакций между микросервисами. Вместо одной большой транзакции через все БД (что невозможно) - последовательность локальных транзакций с компенсирующими действиями. Простыми словами: заказ → списать деньги → зарезервировать товар → отправить курьера. Если на любом шаге сбой - выполняем "откаты" в обратном порядке (вернуть деньги, освободить товар). Реализации: choreography (события) или orchestration (центральный координатор).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Outbox pattern?',
                'answer' => 'Outbox - паттерн для надёжной отправки событий в очередь из транзакции. Проблема: если в транзакции и пишем в БД, и шлём в Kafka - могут разойтись (БД сохранила, Kafka упала). Решение: пишем событие в таблицу outbox в той же транзакции что и бизнес-данные. Отдельный процесс читает outbox и шлёт в Kafka, помечая как отправленные. Гарантирует at-least-once и атомарность с БД-операцией.',
                'code_example' => '<?php
DB::transaction(function () use ($order) {
    $order->save();
    OutboxEvent::create([
        "type" => "OrderCreated",
        "payload" => json_encode($order->toArray()),
        "sent_at" => null,
    ]);
});
// Отдельный воркер читает unsent события и шлёт в Kafka',
                'code_language' => 'php',
            ],

            // === РАСПРЕДЕЛЁННЫЕ СИСТЕМЫ ===
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое CAP теорема простыми словами?',
                'answer' => 'CAP теорема говорит: в распределённой системе при сбое сети между узлами нельзя одновременно обеспечить три свойства - Consistency (все узлы видят одинаковые данные), Availability (система отвечает на запросы) и Partition tolerance (работает при разрыве связи). Можно только два. Простыми словами: два магазина одной сети, связь оборвалась. Либо запрещаем продавать (C, но потеряли A), либо разрешаем но количество товара разойдётся (A, но потеряли C). Postgres - CP, Cassandra - AP.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое PACELC?',
                'answer' => 'PACELC - расширение CAP. При partition (P) выбираешь между A и C (как в CAP). Else (E), даже без сбоев, выбираешь между Latency (L) и Consistency (C). Простыми словами: даже когда сеть работает, синхронизация между репликами тратит время - либо ждём подтверждения от всех (медленнее, консистентно), либо отвечаем сразу (быстро, но возможна eventual consistency). DynamoDB - PA/EL, MongoDB - PA/EC.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое eventual consistency простыми словами?',
                'answer' => 'Eventual consistency - "в конечном итоге согласованность": после записи разные узлы могут какое-то время видеть разные значения, но рано или поздно сойдутся к одному. Простыми словами: новый пост в инстаграме - друг в Москве уже видит, друг в Токио ещё нет, но через секунду увидит. Достаточно для лайков, постов, корзин; не подходит для денежных операций где нужна strong consistency.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое distributed lock и зачем нужен?',
                'answer' => 'Distributed lock - блокировка, работающая между несколькими процессами/серверами. Простыми словами: если на одном сервере достаточно mutex, то когда воркеров на разных машинах - им нужен общий "ключ" в Redis или Zookeeper. Зачем: чтобы только один воркер обрабатывал джобу, чтобы только один cron запустился. Реализации: Redis SET NX EX, Redlock, Zookeeper. Минусы: TTL может истечь до завершения работы - нужен fencing token.',
                'code_example' => '<?php
$lock = Cache::lock("import-orders", 60);
if ($lock->get()) {
    try {
        importOrders();
    } finally {
        $lock->release();
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Circuit Breaker простыми словами?',
                'answer' => 'Circuit Breaker (предохранитель) - паттерн защиты от каскадных сбоев. Простыми словами: как электрический предохранитель - если в розетке КЗ, отключает ток, чтобы не сгорела вся проводка. Так же circuit breaker: если внешний сервис не отвечает, после N неудач "размыкает цепь" и сразу отдаёт ошибку, не дёргая сервис. Через время пробует один запрос (half-open) - если ОК, замыкает обратно. Защищает от долгих таймаутов и истощения коннектов.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое retry с exponential backoff и jitter?',
                'answer' => 'Retry - повторные попытки при ошибке. Exponential backoff - задержка растёт экспоненциально (1с, 2с, 4с, 8с, 16с) чтобы не забивать упавший сервис. Jitter - добавляем случайность к задержке, чтобы тысячи клиентов не ретраили одновременно (thundering herd). Без jitter после сбоя все клиенты ждут ровно 8 секунд и одновременно бьются - сервис снова падает. С jitter - размазываются во времени.',
                'code_example' => '<?php
$attempt = 1;
$base = 100; // ms
$delay = min($base * (2 ** $attempt), 30000) + random_int(0, 1000);
usleep($delay * 1000);',
                'code_language' => 'php',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Bulkhead pattern?',
                'answer' => 'Bulkhead (переборка) - изоляция ресурсов чтобы сбой одной части не уронил всё. Название от переборок на корабле: одна секция затопилась, корабль не тонет. Простыми словами: пул коннектов разделён по сервисам - если внешний API завис, на него уходят только 10 коннектов из 100, остальные обслуживают других. Реализуется через отдельные thread pools, connection pools, rate limits на сервис.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое service discovery?',
                'answer' => 'Service discovery - механизм, через который сервисы находят друг друга в динамической инфраструктуре. Простыми словами: микросервисы стартуют на разных IP/портах, постоянно меняются - вместо хардкода адресов есть "телефонная книга". Сервис при старте регистрируется, при отключении - удаляется. Клиенты спрашивают "где сервис заказов?" и получают актуальный адрес. Реализации: Consul, etcd, Kubernetes DNS, AWS Service Discovery.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое 2PC (Two-Phase Commit)?',
                'answer' => '2PC - протокол распределённой транзакции через несколько БД. Фаза 1 (prepare): координатор спрашивает у всех "готовы коммитить?", все либо да, либо нет. Фаза 2 (commit/abort): если все ответили да - команда commit, иначе rollback. Простыми словами: голосование перед общим решением. Минусы: блокирующий протокол, при падении координатора всё стоит. Поэтому в микросервисах предпочитают Saga вместо 2PC.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое шардирование простыми словами?',
                'answer' => 'Шардирование (sharding) - разделение одной большой базы на несколько маленьких частей (шардов) на разных серверах. Простыми словами: огромный торт, который не съешь одному - разрезали на куски и раздали друзьям. Каждый шард хранит свою часть данных. Зачем: когда одна БД не справляется по объёму или нагрузке. Шарды могут делиться по диапазону (id 1-1M на шарде A), хешу или директории.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие стратегии шардирования бывают?',
                'answer' => 'Range sharding - по диапазонам ключей (id 1-1M на шарде A, 1M-2M на B). Простой routing, но горячие шарды на свежих данных. Hash sharding - по хешу ключа, равномерно. Range queries становятся scatter-gather. Consistent hashing - добавление узла перемещает только малую часть ключей (Cassandra, Memcached). Directory-based - lookup-сервис знает где какой ключ. Гибко, но сам lookup точка отказа.',
                'code_example' => null,
                'code_language' => null,
            ],

            // === API ===
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
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между REST, GraphQL и gRPC?',
                'answer' => 'REST - HTTP + JSON, ресурсо-ориентированный, клиент берёт всё что отдаёт endpoint. GraphQL - один endpoint, клиент в запросе указывает какие именно поля нужны (нет over/under-fetching), есть схема и типы. gRPC - HTTP/2 + Protocol Buffers, бинарный, очень быстрый, контракт через .proto файлы, поддерживает streaming. REST - универсален, GraphQL - для сложных UI с разными нуждами, gRPC - для межсервисного общения с низкой задержкой.',
                'code_example' => null,
                'code_language' => null,
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
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие способы версионирования API существуют?',
                'answer' => '1) URI: /api/v1/users, /api/v2/users - просто, видно сразу. 2) Header: Accept: application/vnd.myapi.v2+json - чище URL, но скрытнее. 3) Query parameter: /api/users?version=2 - не каноничен. 4) Subdomain: v1.api.example.com - инфраструктурно сложнее. Чаще используют URI versioning - просто и понятно. Главное - не ломать старые версии резко, давать время на миграцию.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие HTTP методы идемпотентны?',
                'answer' => 'Идемпотентные: GET, HEAD, PUT, DELETE, OPTIONS - повторный вызов даёт тот же результат. Не идемпотентен: POST - каждый вызов создаёт новый ресурс. PATCH формально не идемпотентен, но может быть таким при правильной реализации. Безопасные (не меняют состояние): GET, HEAD, OPTIONS. Идемпотентность важна для retry-логики - можно безопасно повторять идемпотентные запросы при таймауте.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что означают основные HTTP статус-коды?',
                'answer' => '2xx Success: 200 OK (общий успех), 201 Created (создано), 204 No Content (успех без тела). 3xx Redirect: 301 Moved Permanently, 302 Found, 304 Not Modified. 4xx Client error: 400 Bad Request, 401 Unauthorized (не аутентифицирован), 403 Forbidden (нет прав), 404 Not Found, 409 Conflict, 422 Unprocessable Entity (валидация), 429 Too Many Requests. 5xx Server error: 500 Internal Server Error, 502 Bad Gateway, 503 Service Unavailable, 504 Gateway Timeout.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое WebSockets и для чего нужны?',
                'answer' => 'WebSocket - протокол двунаправленной связи между клиентом и сервером поверх одного TCP-соединения. Простыми словами: телефонный разговор вместо отправки писем (HTTP). После handshake канал остаётся открытым, обе стороны могут слать сообщения в любой момент. Используется для чатов, real-time уведомлений, онлайн-игр, торговых платформ, совместного редактирования. В Laravel - Reverb, Pusher, Soketi.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между WebSocket, SSE, long polling?',
                'answer' => 'Long polling - клиент шлёт запрос, сервер держит его до появления данных, потом отвечает, клиент сразу шлёт новый. Имитирует реалтайм через HTTP. SSE (Server-Sent Events) - односторонний канал сервер→клиент через HTTP, проще WebSocket, не работает в обратную сторону. WebSocket - полноценный двунаправленный канал. Для чата лучше WebSocket, для уведомлений хватает SSE, long polling - старый fallback.',
                'code_example' => null,
                'code_language' => null,
            ],

            // === БЕЗОПАСНОСТЬ ===
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое HTTPS и TLS простыми словами?',
                'answer' => 'HTTPS = HTTP + TLS. TLS (Transport Layer Security) - криптографический протокол, шифрующий передачу данных. Простыми словами: если HTTP - это открытка, которую может прочесть любой почтальон, то HTTPS - запечатанный конверт. Решает три задачи: 1) шифрование (никто не подслушает), 2) аутентификация сервера (через сертификат - это правда тот сайт), 3) целостность (данные не подменены). SSL - устаревший предшественник TLS.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Как работает TLS handshake простыми словами?',
                'answer' => 'TLS handshake (рукопожатие) - обмен между клиентом и сервером перед началом шифрования: 1) клиент: "привет, поддерживаю эти алгоритмы", 2) сервер: "выбираю этот, вот мой сертификат", 3) клиент проверяет сертификат через CA (центр сертификации), 4) обмениваются ключами через асимметричную криптографию (RSA/ECDHE), 5) договариваются о симметричном ключе для скорости, 6) дальше всё шифруется этим ключом. TLS 1.3 сократил handshake до 1 RTT.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между аутентификацией и авторизацией?',
                'answer' => 'Аутентификация (Authentication, AuthN) - "кто ты?" - проверка личности (логин/пароль, токен, биометрия). Авторизация (Authorization, AuthZ) - "что тебе можно?" - проверка прав на действие (роли, разрешения). Простыми словами: на проходной показал паспорт - аутентифицировали; чтобы войти в серверную - проверили разрешение, авторизовали. Сначала всегда AuthN, потом AuthZ.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое OAuth 2.0 и какие у него grant types?',
                'answer' => 'OAuth 2.0 - стандарт делегирования доступа. Простыми словами: ты разрешаешь приложению X получить доступ к твоим данным на сервисе Y, не отдавая пароль. 4 основных grant type: 1) Authorization Code - для веб-приложений с бэкендом (самый безопасный), 2) Client Credentials - сервис-сервис, 3) Resource Owner Password Credentials - устаревший, прямой логин/пароль, 4) Implicit - устарел, заменён на Code+PKCE для SPA.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое JWT и какие плюсы и минусы?',
                'answer' => 'JWT (JSON Web Token) - подписанный токен с тремя частями: header.payload.signature, разделёнными точкой. Внутри payload - claims (user_id, exp, roles). Подписан секретом или приватным ключом. Плюсы: stateless (сервер не хранит сессию), удобен для микросервисов и SPA. Минусы: нельзя отозвать до истечения срока (поэтому делают короткий exp + refresh token), размер больше cookie, легко слить чувствительные данные если положить в payload (он base64, не зашифрован).',
                'code_example' => 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIxMjMiLCJleHAiOjE3MDB9.signature',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое access token и refresh token?',
                'answer' => 'Access token - короткоживущий токен (15 мин - 1 час) для доступа к API. Refresh token - долгоживущий (дни/недели) для получения нового access token без логина. Простыми словами: access - пропуск на сегодня, refresh - удостоверение, по которому выдают пропуска. Если access утёк - украли на короткое время. Refresh хранится безопаснее (HttpOnly cookie), может быть отозван. На каждом запросе используется access, при истечении - refresh обновляет его.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое RBAC и ABAC?',
                'answer' => 'RBAC (Role-Based Access Control) - доступ через роли: admin, editor, viewer. У пользователя роль, у роли набор прав. Простой и понятный. ABAC (Attribute-Based Access Control) - доступ через атрибуты: пользователь+ресурс+действие+контекст. Например: "редактировать может автор, или админ, или модератор отдела автора, в рабочее время". Гибче RBAC, но сложнее. В реальности часто комбинируют: RBAC как база + ABAC-правила сверху.',
                'code_example' => null,
                'code_language' => null,
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
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое CSRF и как защищаться?',
                'answer' => 'CSRF (Cross-Site Request Forgery) - атака, когда вредоносный сайт от имени залогиненного пользователя шлёт запрос на твой сайт через его cookies. Простыми словами: ты залогинен в банке, открыл вредоносный сайт - он скрытно шлёт POST /transfer от твоего имени. Защита: CSRF-токен в форме (Laravel @csrf), который вредоносный сайт не может узнать. SameSite cookies (Strict/Lax) тоже помогают.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое XSS и как защищаться?',
                'answer' => 'XSS (Cross-Site Scripting) - инъекция вредоносного JS в страницу. Простыми словами: пользователь оставил коммент с <script>alert(stolenCookie)</script>, и этот скрипт выполняется у других посетителей. Защита: 1) экранировать вывод (Blade {{ }} автоматом), 2) Content-Security-Policy header, 3) HttpOnly cookies (JS не доступен), 4) sanitize HTML если разрешён (HTMLPurifier). Никогда не вставляй пользовательский ввод в HTML/JS без обработки.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Почему нельзя хешировать пароли через md5 или sha256?',
                'answer' => 'md5 и sha256 быстрые - именно поэтому плохие для паролей. Современные GPU считают миллиарды sha256/сек, при утечке базы пароли подбираются за минуты. Для паролей нужны медленные функции: bcrypt, argon2, scrypt - они спроектированы быть медленными и потребляющими память. Они автоматически добавляют salt (защита от rainbow tables) и имеют параметр cost (можно увеличивать с ростом мощности железа). В PHP - password_hash/password_verify.',
                'code_example' => '<?php
$hash = password_hash("password123", PASSWORD_ARGON2ID);
if (password_verify($input, $hash)) {
    // OK
}',
                'code_language' => 'php',
            ],

            // === ПРОИЗВОДИТЕЛЬНОСТЬ ===
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между latency и throughput?',
                'answer' => 'Latency - задержка одной операции (сколько ждать ответа на один запрос). Throughput - пропускная способность (сколько запросов в секунду). Простыми словами: автобан с одной полосой и скоростью 100 км/ч - низкая latency, но низкий throughput. Дорога в 10 полос с пробкой 30 км/ч - высокая latency, но высокий throughput. Оптимизировать одно не значит улучшить другое.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое перцентили P50, P95, P99 в метриках?',
                'answer' => 'Перцентили - не среднее, а распределение. P50 (медиана) - 50% запросов быстрее этого значения. P95 - 95% быстрее (худшие 5% хуже). P99 - 99% быстрее. Простыми словами: средняя задержка может быть 100мс, но P99=2с означает что у 1% пользователей всё тормозит. Среднее обманывает - перцентили показывают "хвост". Цель SRE - снижать P95/P99, потому что именно они портят UX.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое observability и три её столпа?',
                'answer' => 'Observability - возможность понять что происходит внутри системы по её внешним сигналам. Три столпа: 1) Logs - дискретные записи событий ("user 42 logged in"), 2) Metrics - числовые ряды во времени (RPS, CPU, latency), 3) Traces - путь запроса через систему (через какие сервисы прошёл, где сколько времени). Monitoring отвечает "система работает?", observability - "почему так работает?". Инструменты: Prometheus+Grafana, OpenTelemetry, Jaeger.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое distributed tracing?',
                'answer' => 'Distributed tracing - отслеживание прохождения одного запроса через множество микросервисов. Каждый запрос получает trace_id, каждый шаг - span_id с родителем. На выходе видно: запрос пошёл в gateway → auth-service (5мс) → user-service (20мс) → db (15мс). Сразу видно где тормозит. Стандарт - W3C Trace Context, инструменты: Jaeger, Zipkin, OpenTelemetry, Datadog APM.',
                'code_example' => null,
                'code_language' => null,
            ],

            // === DEVOPS ===
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Docker простыми словами?',
                'answer' => 'Docker - технология контейнеризации. Контейнер - это упакованное приложение со всеми зависимостями, которое работает одинаково везде (локально, на стейдже, на проде). Простыми словами: коробка с приложением и всем что ему нужно для жизни. В отличие от VM не виртуализирует ОС - использует ядро хоста, поэтому быстрый и лёгкий. Образ (image) - шаблон, контейнер - запущенный экземпляр. Dockerfile описывает как собрать образ.',
                'code_example' => 'FROM php:8.3-fpm
WORKDIR /var/www
COPY . .
RUN composer install --no-dev --optimize-autoloader
EXPOSE 9000
CMD ["php-fpm"]',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Чем Docker отличается от виртуальной машины (VM)?',
                'answer' => 'VM виртуализирует железо - запускает полную гостевую ОС со своим ядром. Docker контейнер использует ядро хоста и изолирован через namespaces/cgroups. Простыми словами: VM - целая отдельная квартира, Docker - комната в квартире хозяина. VM весит гигабайты, стартует минуты. Контейнер весит мегабайты, стартует секунды. VM безопаснее изолирован, контейнер быстрее и легче. Часто используют вместе: VM с Docker внутри.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Kubernetes простыми словами?',
                'answer' => 'Kubernetes (k8s) - оркестратор контейнеров. Простыми словами: дирижёр оркестра - управляет десятками/тысячами Docker-контейнеров, решает где их запускать, перезапускает упавшие, балансирует нагрузку, масштабирует под нагрузку. Сам Docker не умеет это, k8s сверху. Основные сущности: Pod (группа контейнеров), Deployment (как развернуть), Service (стабильный адрес для подов), Ingress (маршрутизация HTTP).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Pod, Deployment, Service в Kubernetes?',
                'answer' => 'Pod - наименьшая единица k8s, обычно один контейнер (иногда несколько связанных, например app+sidecar). Эфемерный: упал - создаётся новый. Deployment - декларация "хочу N реплик такого пода с такой стратегией обновления". Сам управляет ReplicaSet и подами. Service - стабильная точка входа к набору подов через label selector. У подов меняются IP, у service постоянный. Типы: ClusterIP (внутри), NodePort, LoadBalancer (внешний).',
                'code_example' => 'apiVersion: apps/v1
kind: Deployment
metadata: { name: api }
spec:
  replicas: 3
  selector: { matchLabels: { app: api } }
  template:
    metadata: { labels: { app: api } }
    spec:
      containers:
      - name: api
        image: myapp:1.2
        ports: [{ containerPort: 8000 }]',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое blue-green deployment?',
                'answer' => 'Blue-green - стратегия деплоя без простоя. Имеешь две идентичные среды: blue (текущая прод) и green (новая версия). Деплоишь в green, прогоняешь тесты, переключаешь трафик с blue на green одной командой (через load balancer или DNS). Если проблема - моментально переключаешь обратно. Плюсы: instant rollback, нет downtime. Минусы: двойные ресурсы, миграции БД сложнее (схема должна работать с обеими версиями).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое canary deployment?',
                'answer' => 'Canary deploy - постепенный rollout: новая версия сначала получает 1% трафика, потом 5%, 25%, 100%. Простыми словами: канарейка в шахте - если что-то не так, потеряем малость. Метрики (ошибки, latency) на каждом этапе сравниваются с baseline - если ухудшение, автоматический rollback. Плюсы: маленький blast radius при ошибках. Минусы: нужна инфраструктура для маршрутизации (Istio, Linkerd, Argo Rollouts) и хороший observability.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое rolling deployment?',
                'answer' => 'Rolling deploy - обновление подов по одному: убрали один старый, подняли один новый, проверили health, повторили. По умолчанию в Kubernetes Deployment. Простыми словами: меняем колёса на машине по одному, не останавливая её. Параметры: maxUnavailable (сколько может быть offline), maxSurge (сколько лишних можно поднять). Минус: во время деплоя одновременно работают обе версии - нужна обратная совместимость БД и API.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое feature flags и зачем нужны?',
                'answer' => 'Feature flags (toggles) - условные блоки в коде, включающие/выключающие фичи без редеплоя. Простыми словами: рубильник на новую фичу - можно включить только для тестовых юзеров, потом 10%, потом всем. Плюсы: trunk-based development, A/B тесты, kill switch при проблеме, разделение деплоя и релиза. Минусы: код засоряется if-ами, надо чистить старые флаги. Инструменты: LaunchDarkly, Unleash, GrowthBook, или своя БД-таблица.',
                'code_example' => '<?php
if (Feature::active("new-checkout", $user)) {
    return view("checkout.v2");
}
return view("checkout.v1");',
                'code_language' => 'php',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое 12-factor app?',
                'answer' => '12-factor - методология построения SaaS-приложений. Ключевые: 1) Codebase в git, 2) Dependencies явные, 3) Config в env, 4) Backing services как ресурсы, 5) Build/release/run разделены, 6) Stateless процессы, 7) Port binding, 8) Concurrency через процессы, 9) Disposability (быстрый старт/остановка), 10) Dev/prod parity, 11) Logs как stream stdout, 12) Admin tasks как one-off процессы. Идеология современного облачного приложения.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое CI/CD простыми словами?',
                'answer' => 'CI (Continuous Integration) - каждый коммит автоматически собирается и проходит тесты. Простыми словами: что бы ты ни запушил - сразу проверка качества. CD (Continuous Delivery/Deployment) - после успешного CI код автоматически деплоится в стейдж/прод. Delivery - готов к деплою (нажми кнопку), Deployment - деплоится сам. Зачем: ловим баги рано, релизы маленькие и частые. Инструменты: GitHub Actions, GitLab CI, Jenkins, CircleCI, Drone.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Infrastructure as Code (IaC)?',
                'answer' => 'IaC - описание инфраструктуры в коде вместо ручной настройки в UI. Простыми словами: вместо кликов в AWS-консоли пишешь файл, который их сделает за тебя - и его можно ревьюить, версионировать, переиспользовать. Декларативный (Terraform, CloudFormation) - описываешь желаемое состояние. Императивный (Ansible, Chef) - последовательность шагов. Плюсы: воспроизводимость, history через git, code review для инфраструктуры.',
                'code_example' => 'resource "aws_instance" "api" {
  ami           = "ami-0c55b159"
  instance_type = "t3.medium"
  tags = { Name = "api-server" }
}',
                'code_language' => 'bash',
            ],

            // === System Design задачи ===
            [
                'category' => 'Архитектура систем',
                'question' => 'Как спроектировать rate limiter?',
                'answer' => 'Алгоритмы: 1) Fixed window (счётчик за минуту, прост, но всплеск на границах окон), 2) Sliding window log (хранит timestamp каждого запроса, точно но дорого по памяти), 3) Sliding window counter (компромисс), 4) Token bucket (поддерживает всплески, классика), 5) Leaky bucket. Хранилище: Redis с атомарным INCR/EXPIRE и Lua-скриптом. Ключ: user_id или IP. При превышении - 429 Too Many Requests + Retry-After + X-RateLimit-* headers.',
                'code_example' => '-- Redis Lua: token bucket
local tokens = tonumber(redis.call("HGET", KEYS[1], "t") or ARGV[1])
local last = tonumber(redis.call("HGET", KEYS[1], "l") or ARGV[3])
tokens = math.min(ARGV[1], tokens + (ARGV[3]-last)*ARGV[2])
if tokens < 1 then return 0 end
redis.call("HMSET", KEYS[1], "t", tokens-1, "l", ARGV[3])
return 1',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Как спроектировать URL shortener (как bit.ly)?',
                'answer' => '1) Генерация: base62 от автоинкремента (без коллизий, но предсказуемо) или хеш URL+salt с проверкой уникальности. 2) Хранилище: K/V (DynamoDB) или sharded RDBMS по hash(short_code). 3) Чтение во много раз чаще записи - агрессивный кэш в Redis с hit ratio 95%+. 4) CDN перед редиректом для статичных популярных ссылок. 5) Аналитика - асинхронно через Kafka, агрегаты раз в N минут. 6) Кастомные алиасы - UNIQUE-индекс и обработка conflict.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Как спроектировать новостную ленту (Twitter/Instagram)?',
                'answer' => 'Два подхода: 1) Pull (на чтение) - при загрузке ленты делаем запрос "посты от моих фолловингов, последние, отсортировано" - просто, но тяжёлое чтение. 2) Push (fan-out на запись) - при публикации поста копируем его во все ленты подписчиков - быстрое чтение, но тяжёлая запись (особенно у звёзд с миллионами фолловеров). Гибрид: push для обычных, pull для celebrity-аккаунтов. Хранилище: Redis для горячих лент, Cassandra для архива.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Как спроектировать систему уведомлений?',
                'answer' => 'Компоненты: 1) Notification Service принимает запросы (event-driven через Kafka). 2) Template engine рендерит шаблон под язык/канал. 3) Channel adapters - email (SES, SendGrid), push (FCM, APNS), SMS (Twilio), in-app (WebSocket). 4) Очередь на канал с rate limit и retry. 5) Preference Service - что юзер хочет получать. 6) Tracking - delivered/opened/clicked. 7) Idempotency для предотвращения дублей. Throttling: не спамить в quiet hours.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Как спроектировать систему платежей с идемпотентностью?',
                'answer' => '1) Клиент передаёт Idempotency-Key. 2) Сервис в транзакции: проверяет существование ключа в БД (UNIQUE-индекс), если есть - возвращает кэшированный ответ. Если нет - создаёт запись с pending. 3) Вызывает платёжный шлюз. 4) Обновляет запись результатом. 5) При сбоях retry-логика клиента шлёт тот же Idempotency-Key - не дёргаем шлюз повторно. 6) Outbox pattern для событий "payment_succeeded". 7) Webhook от шлюза проверяется по подписи и тоже идемпотентен.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое throttling и как отличается от rate limiting?',
                'answer' => 'Часто используются как синонимы, но строго: rate limiting - жёсткий лимит "не больше N запросов в минуту", при превышении 429. Throttling - замедление: "запросы выше лимита обрабатываются медленнее, в очереди". Простыми словами: rate limit - "не пустим", throttling - "пустим, но в порядке очереди". Throttling мягче для пользователя, но требует буфер. На практике обычно делают rate limiting на API gateway.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое APM (Application Performance Monitoring)?',
                'answer' => 'APM - инструменты для мониторинга производительности приложения в проде. Простыми словами: рентген для приложения - видно где тормозит, какой SQL медленный, где исключения, какой endpoint самый горячий. Включает: tracing запросов, профилирование, алерты, дашборды, error tracking. Инструменты: New Relic, Datadog, Sentry, Elastic APM, Laravel Telescope/Pulse. Без APM в большом проде ты слепой.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое connection pooling и зачем нужен?',
                'answer' => 'Connection pool - готовый набор открытых коннектов к БД, переиспользуемых между запросами. Простыми словами: вместо того чтобы заново звонить и здороваться при каждом обращении - держим телефон поднятым. Открытие коннекта к Postgres дорого (TCP+TLS+auth = 10-50мс). Pool: 20-50 коннектов, при запросе берём свободный, после возвращаем в пул. Внешние пулы для PHP-FPM (где коннект на запрос): pgbouncer, RDS Proxy.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое service mesh?',
                'answer' => 'Service mesh - инфраструктурный слой для взаимодействия микросервисов. Прокси (sidecar) рядом с каждым сервисом перехватывает весь сетевой трафик и обеспечивает: retry, circuit breaker, mTLS, tracing, traffic splitting (canary), rate limiting - без изменений в коде сервисов. Простыми словами: общий "сетевой стек" для всех сервисов вынесен в инфраструктуру. Реализации: Istio, Linkerd, Consul Connect. Sidecar обычно Envoy.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое event-driven architecture?',
                'answer' => 'Event-driven architecture - сервисы общаются через события вместо прямых вызовов. Сервис A публикует "OrderCreated" в шину (Kafka, RabbitMQ), сервисы B, C, D подписываются и реагируют каждый по-своему. Простыми словами: вместо телефонных звонков - публикация новостей в газете. Плюсы: loose coupling, легко добавить нового подписчика, асинхронность. Минусы: сложнее дебажить, eventual consistency, нужна хорошая обсервабилити для трассировки.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Content Security Policy (CSP)?',
                'answer' => 'CSP - HTTP-заголовок, говорящий браузеру откуда можно загружать ресурсы (JS, CSS, картинки, fetch). Защита от XSS: даже если злоумышленник вставил скрипт, браузер откажется его выполнять, если источник не разрешён. Например: "JS только из своего домена и cdn.jsdelivr.net". Очень эффективно, но требует настройки и тестирования - можно сломать сайт.',
                'code_example' => 'Content-Security-Policy:
  default-src \'self\';
  script-src \'self\' https://cdn.jsdelivr.net;
  style-src \'self\' \'unsafe-inline\';
  img-src \'self\' data: https:;
  connect-src \'self\' https://api.example.com;',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между monitoring и observability?',
                'answer' => 'Monitoring - заранее знаем что мерить и алертим на отклонения (CPU>80%, latency>500ms). Отвечает на вопрос "система здорова?". Observability - возможность задать любой вопрос системе и получить ответ из её сигналов. Отвечает на "почему так?". Простыми словами: monitoring - "горит ли красная лампочка", observability - "что именно сломалось и где". Одно дополняет другое: monitoring алертит, observability помогает диагностировать.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Спроектируйте rate limiter на 1000 RPS на пользователя. Какие алгоритмы и хранилища выберете?',
                'answer' => 'Sliding window log - точный, но дорогой по памяти. Sliding window counter - компромисс точности и памяти. Token bucket - поддерживает всплески, классика для API. Хранилище - Redis с атомарными INCR/EXPIRE и Lua-скриптом для атомарности проверки и обновления. Для распределённого ratelimit с low-latency - локальный counter с периодической синхронизацией (sloppy counter). Ключи: user-id или api-key, TTL = окно. Ответ: 429 + Retry-After + X-RateLimit-Remaining headers.',
                'code_example' => '-- redis Lua: token bucket
local tokens = tonumber(redis.call("HGET", KEYS[1], "t") or ARGV[1])
local last = tonumber(redis.call("HGET", KEYS[1], "l") or ARGV[3])
tokens = math.min(ARGV[1], tokens + (ARGV[3]-last)*ARGV[2])
if tokens < 1 then return 0 end
redis.call("HMSET", KEYS[1], "t", tokens-1, "l", ARGV[3])
return 1',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Как спроектировать URL shortener на миллиарды записей?',
                'answer' => 'Генерация: base62 от автоинкремента (читаемо, коллизий нет, но предсказуемо) или хеш URL+random salt + проверка уникальности. Хранилище: K/V (DynamoDB, Cassandra) или sharded RDBMS по hash(short). Запись редкая, чтение очень частое - кэш Redis перед БД, hit ratio 95%+. CDN для редиректов с Cache-Control. Аналитика - асинхронный поток в Kafka, агрегаты раз в N минут. Для кастомных alias - UNIQUE-индекс на short и реакция на conflict.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между cache-aside, write-through и write-behind?',
                'answer' => 'Cache-aside: приложение само читает кэш, при промахе читает БД и заполняет кэш. Запись напрямую в БД, кэш инвалидируется. Простота и надёжность, но возможна stale data при гонке. Write-through: запись идёт через кэш в БД синхронно - кэш всегда консистентен, но запись медленнее. Write-behind: запись в кэш, асинхронно flush в БД - самая быстрая, но при падении кэша теряются данные. Cache-aside - дефолт для веба; write-behind - для high-throughput с допустимой потерей.',
                'code_example' => '<?php
// cache-aside на Laravel
$user = Cache::remember("user:$id", 3600, fn() => User::find($id));
// при обновлении
$user->save();
Cache::forget("user:$id");',
                'code_language' => 'php',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое idempotency key и как реализовать его в платежах?',
                'answer' => 'Idempotency key - уникальный токен от клиента, гарантирующий, что повторный POST не выполнит операцию дважды. Сервер хранит маппинг ключ → результат с TTL (например, 24ч). При повторе с тем же ключом возвращает кэшированный ответ, не вызывая внешний gateway. Реализация: уникальный индекс по ключу + транзакция, либо Redis SET NX EX. Полезно для платежей, заказов и любых операций с сетевыми ретраями.',
                'code_example' => '<?php
$key = $request->header("Idempotency-Key");
$result = Cache::lock("idemp:$key", 60)->block(5, function () use ($key) {
    return Cache::remember("idemp-result:$key", 86400, function () {
        return $this->payment->charge(...);
    });
});',
                'code_language' => 'php',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Чем at-least-once отличается от exactly-once в очередях и достижим ли exactly-once на практике?',
                'answer' => 'At-least-once: сообщение точно доставится один или больше раз - стандарт в SQS, Kafka, RabbitMQ. Exactly-once строго в распределённой системе невозможно (Two Generals problem). На практике достигается комбинацией at-least-once + идемпотентного потребителя (dedup по message-id) - это называется "effectively-once". Kafka даёт transactional EOS внутри своих топиков, но при выходе наружу ответственность ложится на consumer.',
                'code_example' => '<?php
// идемпотентный consumer
public function handle(Message $m): void {
    if (ProcessedMessage::where("id", $m->id)->exists()) return;
    DB::transaction(function () use ($m) {
        ProcessedMessage::create(["id" => $m->id]);
        $this->doWork($m);
    });
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Когда event sourcing уместен и какие у него подводные камни?',
                'answer' => 'Event sourcing: вместо текущего состояния хранится последовательность событий; состояние получается их сверткой. Уместен в доменах с богатой историей (банкинг, аудит, медицина), для аналитики "почему" и для восстановления состояния на любую точку. Минусы: сложность, проекции/read-models надо строить отдельно, миграции схемы событий тяжёлые (нужен upcasting), нельзя удалять события без compensating event-а - конфликт с GDPR требует crypto-shredding.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие стратегии шардинга есть и в чём их компромиссы?',
                'answer' => 'Range sharding (по диапазонам ключей) - простой routing, но горячие шарды на свежих данных. Hash sharding - равномерное распределение, но range-запросы становятся scatter-gather. Consistent hashing - добавление/удаление узла перемещает только малую долю ключей, идеален для memcached/Cassandra. Directory-based - отдельный lookup-сервис, гибко, но точка отказа. Главный compromise: легко балансировать или легко делать range queries, не оба сразу.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Зачем нужна CDN перед приложением и какие нюансы при работе с динамикой?',
                'answer' => 'CDN кэширует статику (изображения, JS/CSS) близко к пользователю - снижает latency и нагрузку на origin. Для динамики используют edge-кэш с коротким TTL и cache-key по нормализованному URL без cookies. Stale-while-revalidate отдаёт чуть устаревший ответ, пока на фоне обновляется. Surrogate-Control + tag-based purge (Fastly, Cloudflare) позволяют точечно инвалидировать. Важно: avoid Vary: Cookie без необходимости - он рушит cache-hit ratio.',
                'code_example' => 'Cache-Control: public, max-age=60, s-maxage=300, stale-while-revalidate=600
Surrogate-Key: user-123 product-42',
                'code_language' => 'bash',
            ],
        ];
    }
}
