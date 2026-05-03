<?php

namespace Database\Seeders\Data\Categories\SystemDesign;

class Caching
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example: ?string, code_language: ?string, difficulty: int, topic: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое кэш простыми словами?',
                'answer' => 'Кэш - это быстрое временное хранилище для часто запрашиваемых данных. Простыми словами: записная книжка под рукой - не нужно каждый раз идти в большой архив. Если данные есть в кэше (cache hit) - отдаём моментально; если нет (cache miss) - берём из БД, кладём в кэш, отдаём. Хранилища: Redis, Memcached, локальная память приложения, файловый кэш.',
                'code_example' => '<?php
$user = Cache::remember("user:$id", 3600, function () use ($id) {
    return User::find($id);
});',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'system_design.caching',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие уровни кэширования бывают в веб-приложении?',
                'answer' => 'Слои кэша от клиента к БД: 1) Browser cache (Cache-Control в headers), 2) CDN (статика близко к пользователю), 3) Reverse proxy cache (Nginx, Varnish), 4) Application cache (Redis, Memcached), 5) ORM/query cache (внутри ORM), 6) Database buffer pool (внутри БД). Принцип: чем ближе к пользователю, тем быстрее, но меньше данных можно хранить.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.caching',
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
                'difficulty' => 3,
                'topic' => 'system_design.caching',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое write-through стратегия кэша?',
                'answer' => 'Write-through - запись идёт сначала в кэш, потом синхронно в БД (за это отвечает либо приложение, либо сам кэш как прослойка перед БД). Чтение - всегда из кэша, при промахе кэш сам загружает из БД (часто комбинируется с read-through). Плюсы: кэш всегда консистентен с БД, нет stale data. Минусы: запись медленнее (две операции), кэш заполняется только тем, что записывали - редко читаемые данные тоже там лежат. Подходит когда чтение во много раз чаще записи и важна консистентность.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.caching',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое read-through стратегия кэша?',
                'answer' => 'Read-through - кэш сам читает из БД при промахе, приложение всегда обращается только к кэшу. В отличие от cache-aside, где промахом управляет код приложения, здесь логика загрузки спрятана внутрь кэш-провайдера/библиотеки. Плюсы: код приложения проще, единая точка работы с данными. Минусы: первый запрос всегда медленный (cache miss), нужна готовая интеграция кэша с источником. Часто комбинируется с write-through. Пример: Hibernate 2nd-level cache, Ehcache CacheLoader, AWS DAX перед DynamoDB.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.caching',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое write-behind (write-back) стратегия кэша?',
                'answer' => 'Write-behind - запись только в кэш, в БД асинхронно через некоторое время или батчем. Простыми словами: записал в блокнот, в большую тетрадь перепишу позже. Самая быстрая запись. Минусы: при падении кэша теряются данные, сложнее реализовать. Подходит для счётчиков, метрик, логов - где немного потерянных данных не катастрофа.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.caching',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое write-around стратегия кэша?',
                'answer' => 'Write-around - запись идёт сразу в БД минуя кэш, кэш заполняется только при чтении. Плюсы: не засоряем кэш редко читаемыми данными, простая запись. Минусы: первое чтение после записи всегда медленное (cache miss). Хорошо когда записи много, а читается малая часть данных (логи событий, аудит).',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.caching',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие политики вытеснения (eviction) есть в кэше?',
                'answer' => 'LRU (Least Recently Used) - вытесняем то, что давно не использовали. LFU (Least Frequently Used) - то, что редко используется. FIFO - в порядке поступления. Random - случайно. TTL - по времени жизни. Redis по умолчанию использует noeviction (отказывает в записи при OOM), но можно настроить allkeys-lru, volatile-lru и др. Выбор зависит от паттерна доступа.',
                'code_example' => '# redis.conf
maxmemory 2gb
maxmemory-policy allkeys-lru',
                'code_language' => 'bash',
                'difficulty' => 3,
                'topic' => 'system_design.caching',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое cache stampede (dogpile) и как с ним бороться?',
                'answer' => 'Cache stampede (он же dogpile, thundering herd) - когда популярный ключ истекает в кэше и тысячи запросов одновременно начинают перестраивать его, забивая БД. Простыми словами: магазин закрылся на учёт - все клиенты ломятся одновременно. Решения: 1) atomic lock на пересборку (SET NX + блокировка - только один запрос строит, остальные ждут или отдают stale), 2) probabilistic early expiration (XFetch: с растущей вероятностью при подходе к TTL один воркер заранее перестраивает), 3) stale-while-revalidate (отдаём старое значение, пока в фоне обновляется новое), 4) bgrewrite через очередь по cron - данные никогда не "истекают" для пользователя.',
                'code_example' => '<?php
$value = Cache::lock("rebuild:$key", 10)->block(5, function () use ($key) {
    return Cache::remember($key, 300, fn() => expensiveQuery());
});',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'system_design.caching',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое CDN простыми словами?',
                'answer' => 'CDN (Content Delivery Network) - сеть серверов по всему миру, которые хранят копии твоих статичных файлов (картинки, JS, CSS) близко к пользователям. Простыми словами: твой сайт в Москве, а пользователь в Токио - вместо запроса через полпланеты, ему отдают файл с сервера CDN в Токио. Уменьшает latency, разгружает origin, защищает от DDoS. Примеры: Cloudflare, Fastly, AWS CloudFront, Akamai.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'system_design.caching',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между Redis и Memcached?',
                'answer' => 'Memcached - чистый in-memory key/value кэш: только строки/блобы, multi-threaded, очень простой и предсказуемый, slab-аллокатор, нет персистентности и репликации (в open-source). Redis - data structure server: строки, hashes, lists, sets, sorted sets, streams, bitmap, HyperLogLog, geo; есть Lua-скрипты, pub/sub, транзакции, persistence (RDB/AOF), репликация и Cluster, single-threaded I/O loop (Redis 6+ имеет multi-threaded I/O). Когда что: Memcached - когда нужен только LRU-кэш и шардирование клиентом; Redis - когда нужны структуры (rate limit на sorted set, очереди, leaderboards), persistence или replication.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.caching',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Почему cache invalidation - это сложно?',
                'answer' => 'Знаменитая цитата: "There are only two hard things in CS: cache invalidation and naming things". Сложно потому что: 1) трудно понять когда именно данные устарели, 2) одно изменение в БД может затронуть много ключей кэша, 3) в распределённой системе инвалидация сама требует консистентности, 4) баланс между актуальностью и производительностью. Решения: TTL, версионирование ключей (etag), tag-based invalidation, событийная инвалидация.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.caching',
            ],
        ];
    }
}
