<?php

namespace Database\Seeders\Data\Categories\SystemDesign;

class MessagingQueues
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example: ?string, code_language: ?string, difficulty: int, topic: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое очередь сообщений простыми словами?',
                'answer' => 'Message queue - буфер между компонентами системы. Один сервис кладёт сообщение в очередь и забывает, другой читает и обрабатывает. Простыми словами: почтовый ящик - отправитель опустил письмо и пошёл по делам, получатель забрал когда удобно. Зачем: 1) асинхронность (не ждём обработки), 2) сглаживание пиков нагрузки, 3) decoupling (сервисы не знают друг о друге), 4) надёжность (сообщения переживут падение).',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'system_design.messaging_queues',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Producer и Consumer в очередях?',
                'answer' => 'Producer (издатель, продюсер) - тот, кто кладёт сообщения в очередь. Consumer (подписчик, потребитель) - тот, кто читает и обрабатывает. Один продюсер может слать в несколько очередей, на одну очередь могут подписаться несколько консьюмеров. Если консьюмеров несколько на одной очереди (work queue) - сообщения распределяются между ними; если pub/sub - каждый получает копию.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'system_design.messaging_queues',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между RabbitMQ и Kafka?',
                'answer' => 'RabbitMQ - классический message broker по AMQP 0.9.1: маршрутизация через exchanges (direct/topic/fanout/headers), сообщение удаляется после ack, push-модель, сложная routing-логика, ordering на уровне очереди. Kafka - распределённый append-only лог: сообщения хранятся по retention (часы/дни/forever), ничего не удаляется по факту чтения, consumer сам держит offset (pull), горизонтально масштабируется через partitions, ordering гарантируется только внутри partition. SQS - managed AWS-очередь, Standard (at-least-once, без порядка) и FIFO (exactly-once + порядок, но 300 msg/s/группа). Производительность - типичная цифра, которую часто путают: 1) Classic Mirrored Queues RabbitMQ давали ~30-50k msg/s на узел и были замечательны для классического AMQP-кейса, но deprecated в 3.13 и удалены в 4.0. 2) Quorum Queues (RabbitMQ 3.8+, на Raft) - сотни тысяч msg/s, durable, replicated. 3) Streams (RabbitMQ 3.9+, log-based как Kafka) - миллионы msg/s, замысел был догнать Kafka на сходных юзкейсах. Так что современный RabbitMQ по чистой пропускной способности уже не уступает Kafka радикально - выбор делается по семантике: если нужна богатая routing-логика, per-message ack, priority queues, RPC - RabbitMQ; если event streaming, infinite retention, replay, log compaction, partition-параллелизм - Kafka. Kafka типично - миллионы msg/s/брокер. Выбор: RabbitMQ для task queue с богатой routing; Kafka для event streaming, аналитики, CDC, replay; SQS - serverless AWS.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.messaging_queues',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое at-most-once, at-least-once, exactly-once в очередях?',
                'answer' => 'At-most-once - сообщение доставится 0 или 1 раз (можно потерять при сбое), реализуется через fire-and-forget без ack. At-least-once - 1 или больше раз: producer ретраит при отсутствии ack, consumer ack-ает после обработки; стандарт SQS Standard, RabbitMQ с ack, Kafka с acks=all. Дубли возможны - нужна идемпотентность. Exactly-once строго в распределённой системе недостижимо (Two Generals Problem). На практике достигается комбинацией at-least-once + идемпотентный consumer (dedup по message-id) - это называется "effectively-once". Kafka даёт transactional EOS внутри своих топиков (idempotent producer + transactions + isolation.level=read_committed), но при выходе наружу (БД, HTTP) ответственность ложится на consumer. SQS FIFO даёт exactly-once в пределах 5-минутного окна.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.messaging_queues',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие гарантии порядка сообщений дают разные брокеры?',
                'answer' => 'Kafka: строгий порядок только внутри partition; partition выбирается по hash(key), поэтому сообщения с одним key всегда в одной partition (используется для "все события заказа №42 в одном порядке"). При нескольких partition между ними порядка нет. RabbitMQ: порядок в пределах одной очереди при одном consumer; при нескольких consumer-ах порядок ломается из-за параллельной обработки и redelivery. SQS Standard - порядок не гарантируется вообще; SQS FIFO - порядок в пределах MessageGroupId. Если важен порядок - выбирай ключ группировки осознанно (по entity_id) и держи parallelism=1 на ключ (single-active consumer в RabbitMQ, partition=consumer в Kafka).',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.messaging_queues',
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
                'difficulty' => 3,
                'topic' => 'system_design.messaging_queues',
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
                'difficulty' => 4,
                'topic' => 'system_design.messaging_queues',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между Pub/Sub и Message Queue?',
                'answer' => 'Message Queue (work queue) - одно сообщение получает один консьюмер, после прочтения сообщение удаляется. Подходит для задач: одна джоба - один воркер. Pub/Sub - сообщение получают все подписчики, у каждого своя копия. Подходит для уведомлений: пользователь зарегистрировался → отправь email + создай профиль + начисли бонус. В Kafka реализуется через consumer groups, в RabbitMQ - через fanout exchange.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.messaging_queues',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Dead Letter Queue?',
                'answer' => 'Dead Letter Queue (DLQ) - очередь для сообщений, которые не получилось обработать после N попыток. Простыми словами: ящик "проблемные письма" куда идут те, что не смог разобрать почтальон. Зачем: не теряем сообщения, можно потом разобраться вручную или починить и повторить. В Laravel - failed_jobs таблица, в SQS/RabbitMQ - отдельная DLQ.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.messaging_queues',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое backpressure?',
                'answer' => 'Backpressure - механизм когда медленный консьюмер "тормозит" быстрого продюсера, чтобы не переполнить очередь и не уронить систему. Простыми словами: на конвейере работник не успевает - конвейер замедляется или останавливается. Реализуется через ограничение размера очереди (если полна - блокируем producer), throttling, reactive streams (RxJS, Project Reactor). Без backpressure система ломается под пиками.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.messaging_queues',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Apache Kafka простыми словами?',
                'answer' => 'Kafka - распределённый лог сообщений с высокой пропускной способностью. Простыми словами: огромный журнал, куда непрерывно дописываются события, и любой может читать с любой позиции. Топик (topic) - категория событий. Партиция (partition) - часть топика, упорядоченная последовательность. Offset - позиция сообщения в партиции. Consumer запоминает свой offset и продолжает с него после рестарта. Используется для event streaming, аналитики, CDC.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.messaging_queues',
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
                'difficulty' => 4,
                'topic' => 'system_design.messaging_queues',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое CQRS простыми словами?',
                'answer' => 'CQRS (Command Query Responsibility Segregation) - разделение модели чтения и записи. Команды (write) меняют состояние, не возвращают данных. Запросы (read) только читают и могут использовать денормализованную модель для скорости. Простыми словами: для записи в банк используешь форму с полным набором полей (write-модель), для просмотра выписки - удобно отформатированный отчёт (read-модель). ВАЖНОЕ заблуждение: CQRS и Event Sourcing - РАЗНЫЕ паттерны, их часто упоминают вместе и путают. CQRS можно (и обычно стоит) применять БЕЗ Event Sourcing: типичный продакшен-сетап - запись через Eloquent-агрегаты в Postgres-master, чтение через read-only реплики или денормализованную таблицу/Elasticsearch/Redis-индекс - это уже полноценный CQRS, никаких событий хранить не надо. Event Sourcing - лишь один из способов хранить write-модель (как лог событий вместо текущего state), и его можно использовать без CQRS (хотя на практике без CQRS он почти не имеет смысла из-за плохой производительности чтения текущего состояния). Когда CQRS оправдан: разные требования к нагрузке на чтение и запись (read >> write), сложные read-модели (агрегации, поисковая выдача), нужно несколько read-проекций одних данных. Когда не нужен: простой CRUD - CQRS добавляет сложность без выгоды.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.messaging_queues',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Saga pattern?',
                'answer' => 'Saga - паттерн для распределённых транзакций между микросервисами. Вместо одной большой транзакции через все БД (что невозможно) - последовательность локальных транзакций с компенсирующими действиями. Простыми словами: заказ → списать деньги → зарезервировать товар → отправить курьера. Если на любом шаге сбой - выполняем "откаты" в обратном порядке (вернуть деньги, освободить товар). Реализации: choreography (события) или orchestration (центральный координатор).',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 5,
                'topic' => 'system_design.messaging_queues',
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
                'difficulty' => 5,
                'topic' => 'system_design.messaging_queues',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Change Data Capture (CDC) и зачем он нужен?',
                'answer' => 'Change Data Capture - паттерн для извлечения изменений из БД и стрима их в другую систему (Kafka, Elasticsearch, ClickHouse, дата-озеро) без изменения исходного приложения. Решает классическую проблему dual write: когда сервис должен записать в основную БД И в очередь/индекс одновременно - между ними нет распределённой транзакции, и одна из записей может пропасть при сбое. Outbox-паттерн решает это с помощью изменений в коде (запись в outbox-таблицу в той же транзакции), а CDC - вообще без правки кода. Как работает: инструмент (Debezium - стандарт де-факто, или AWS DMS, Maxwell, GoldenGate) подключается к транзакционному логу СУБД: WAL (write-ahead log) в PostgreSQL через logical replication, binlog в MySQL, change tracking в SQL Server, oplog в MongoDB. WAL хранит каждое INSERT/UPDATE/DELETE в порядке коммита; CDC-агент читает его, конвертирует строки в JSON-сообщения и публикует в Kafka-топик "db.public.users" с before/after состояниями. Преимущества: 1) Нулевое влияние на код приложения - монолиту вообще не надо знать про Kafka. 2) Гарантия at-least-once - WAL хранит все изменения; CDC-агент может перечитать с нужного offset после рестарта. 3) Транзакционная консистентность - в Kafka попадают только закоммиченные изменения, в правильном порядке. 4) Нет dual-write - изменение либо записалось в БД (и попадёт в Kafka), либо нет. Недостатки: 1) Структура сообщений привязана к схеме БД - переименование колонки сломает downstream consumers, нужна осторожная schema evolution и версионирование событий через Outbox-таблицу как промежуточный слой. 2) Сложность в эксплуатации (мониторинг replication slot lag в PG, дисковое место под WAL, перезапуск Debezium). 3) Не подходит для отправки бизнес-событий ("OrderShipped") - CDC видит изменения rows, не доменные события; для этого нужен явный outbox с domain-событиями. Применение: репликация монолит → микросервис без передачи нагрузки на исходный сервис, обновление поискового индекса (Elasticsearch), стриминг в data warehouse (Snowflake, BigQuery), создание audit-лога, сине-зелёные миграции БД.',
                'code_example' => '-- PostgreSQL: включить logical replication
-- postgresql.conf:
--   wal_level = logical
--   max_replication_slots = 4
--   max_wal_senders = 4

-- Создать публикацию для Debezium
CREATE PUBLICATION debezium_pub FOR TABLE orders, users;

-- Replication slot создаст сам Debezium при подключении
SELECT * FROM pg_replication_slots;

-- В Debezium connector config (kafka-connect):
-- {
--   "connector.class": "io.debezium.connector.postgresql.PostgresConnector",
--   "database.hostname": "pg.internal",
--   "database.dbname": "shop",
--   "publication.name": "debezium_pub",
--   "slot.name": "debezium_slot",
--   "topic.prefix": "shop"
-- }
-- → Debezium publishes:
--   topic "shop.public.orders" message:
--   { "before": null,
--     "after": {"id": 42, "status": "paid"},
--     "op": "c", "ts_ms": 1717000000 }

-- Consumer (Laravel/PHP):
-- читает Kafka-топик shop.public.orders, обновляет ES/Redis-индекс
-- Изменения приходят в порядке коммита, можно безопасно реплицировать состояние

-- Outbox + CDC = best of both worlds
-- 1. Сервис в той же транзакции пишет domain-событие в outbox-таблицу
-- 2. Debezium читает WAL и публикует events из outbox в Kafka
-- 3. Получаем доменные события + транзакционную гарантию + zero dual-write',
                'code_language' => 'sql',
                'difficulty' => 5,
                'topic' => 'system_design.messaging_queues',
            ],
        ];
    }
}
