<?php

namespace Database\Seeders\Data\Categories\SystemDesign;

class Distributed
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example: ?string, code_language: ?string, difficulty: int, topic: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое CAP теорема простыми словами?',
                'answer' => 'CAP теорема (Brewer): в распределённой системе при разрыве сети (Partition) приходится выбирать между Consistency (все читают самые свежие данные) и Availability (любой живой узел отвечает). P выбирать не приходится - сеть всегда может разорваться, поэтому реальный выбор: CP или AP. Простыми словами: два магазина одной сети, связь оборвалась. Либо запрещаем продавать (CP - потеряли A), либо разрешаем, но остатки разойдутся (AP - потеряли C). Примеры: HBase, MongoDB (с majority writes), etcd, Zookeeper - CP; Cassandra, DynamoDB, Riak - AP. Важно: классификация условна, многие системы tunable (Cassandra с QUORUM ближе к CP).',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.distributed',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое PACELC?',
                'answer' => 'PACELC - расширение CAP. При partition (P) выбираешь между A и C (как в CAP). Else (E), даже без сбоев, выбираешь между Latency (L) и Consistency (C). Простыми словами: даже когда сеть работает, синхронизация между репликами тратит время - либо ждём подтверждения от всех (медленнее, консистентно), либо отвечаем сразу (быстро, но возможна eventual consistency). DynamoDB - PA/EL, MongoDB - PA/EC.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 5,
                'topic' => 'system_design.distributed',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое eventual consistency простыми словами?',
                'answer' => 'Eventual consistency - "в конечном итоге согласованность": после записи разные узлы могут какое-то время видеть разные значения, но рано или поздно сойдутся к одному. Простыми словами: новый пост в инстаграме - друг в Москве уже видит, друг в Токио ещё нет, но через секунду увидит. Достаточно для лайков, постов, корзин; не подходит для денежных операций где нужна strong consistency.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.distributed',
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
                'difficulty' => 4,
                'topic' => 'system_design.distributed',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Circuit Breaker простыми словами?',
                'answer' => 'Circuit Breaker (предохранитель) - паттерн защиты от каскадных сбоев. Простыми словами: как электрический предохранитель - если в розетке КЗ, отключает ток, чтобы не сгорела вся проводка. Так же circuit breaker: если внешний сервис не отвечает, после N неудач "размыкает цепь" и сразу отдаёт ошибку, не дёргая сервис. Через время пробует один запрос (half-open) - если ОК, замыкает обратно. Защищает от долгих таймаутов и истощения коннектов.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.distributed',
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
                'difficulty' => 4,
                'topic' => 'system_design.distributed',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое Bulkhead pattern?',
                'answer' => 'Bulkhead (переборка) - изоляция ресурсов чтобы сбой одной части не уронил всё. Название от переборок на корабле: одна секция затопилась, корабль не тонет. Простыми словами: пул коннектов разделён по сервисам - если внешний API завис, на него уходят только 10 коннектов из 100, остальные обслуживают других. Реализуется через отдельные thread pools, connection pools, rate limits на сервис.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.distributed',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое service discovery?',
                'answer' => 'Service discovery - механизм, через который сервисы находят друг друга в динамической инфраструктуре. Простыми словами: микросервисы стартуют на разных IP/портах, постоянно меняются - вместо хардкода адресов есть "телефонная книга". Сервис при старте регистрируется, при отключении - удаляется. Клиенты спрашивают "где сервис заказов?" и получают актуальный адрес. Реализации: Consul, etcd, Kubernetes DNS, AWS Service Discovery.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.distributed',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое consensus и алгоритмы Paxos/Raft?',
                'answer' => 'Distributed consensus - проблема согласования значения между узлами при сбоях сети и отказах. Используется для leader election, репликации лога, atomic commit. Paxos (Lamport, 1989) - формально доказан, но печально известен сложностью реализации. Raft (Stanford, 2013) - спроектирован для понимаемости: явное разделение на leader election, log replication, safety. Все алгоритмы требуют большинства (quorum, N/2+1) - кластер из 5 узлов переживает падение 2. ZAB (Zookeeper) и Multi-Paxos похожи. Используется в etcd, Consul, CockroachDB, Kafka KRaft, MongoDB.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 5,
                'topic' => 'system_design.distributed',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое leader election и split-brain?',
                'answer' => 'Leader election - выбор одного узла-лидера среди множества для координации операций (запись в реплицированный лог, master в БД). Реализуется через consensus (Raft, ZAB) или distributed lock (Zookeeper ephemeral node, Redis lock с fencing). Split-brain - ситуация когда из-за разрыва сети два узла одновременно считают себя лидером и принимают записи. Грозит расхождением данных и невозможностью merge. Защита: 1) quorum (лидер требует подтверждения большинства - в меньшинстве он не сможет писать), 2) fencing token - монотонный счётчик, старый лидер не сможет писать после переизбрания, 3) STONITH ("Shoot The Other Node In The Head") в HA-кластерах.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 5,
                'topic' => 'system_design.distributed',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое 2PC (Two-Phase Commit)?',
                'answer' => '2PC - протокол распределённой транзакции через несколько БД. Фаза 1 (prepare): координатор спрашивает у всех "готовы коммитить?", все либо да, либо нет. Фаза 2 (commit/abort): если все ответили да - команда commit, иначе rollback. Простыми словами: голосование перед общим решением. Минусы: блокирующий протокол, при падении координатора всё стоит. Поэтому в микросервисах предпочитают Saga вместо 2PC.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 5,
                'topic' => 'system_design.distributed',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое шардирование простыми словами?',
                'answer' => 'Шардирование (sharding) - разделение одной большой базы на несколько маленьких частей (шардов) на разных серверах. Простыми словами: огромный торт, который не съешь одному - разрезали на куски и раздали друзьям. Каждый шард хранит свою часть данных. Зачем: когда одна БД не справляется по объёму или нагрузке. Шарды могут делиться по диапазону (id 1-1M на шарде A), хешу или директории.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.distributed',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие стратегии шардирования бывают?',
                'answer' => 'Range sharding - по диапазонам ключей (id 1-1M на шарде A, 1M-2M на B). Простой routing, но горячие шарды на свежих данных. Hash sharding - по хешу ключа, равномерно. Range queries становятся scatter-gather. Consistent hashing - добавление узла перемещает только малую часть ключей (Cassandra, Memcached). Directory-based - lookup-сервис знает где какой ключ. Гибко, но сам lookup точка отказа.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.distributed',
            ],
        ];
    }
}
