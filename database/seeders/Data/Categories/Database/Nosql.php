<?php

namespace Database\Seeders\Data\Categories\Database;

class Nosql
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Базы данных',
                'question' => 'Что такое NoSQL простыми словами?',
                'answer' => 'NoSQL ("Not Only SQL") - семейство БД, которые отходят от строгой реляционной модели. Часто гибче по схеме, лучше масштабируются горизонтально, но обычно не дают полноценных транзакций. Простыми словами: если SQL - это шкаф с одинаковыми ящиками с метками, то NoSQL - это коробки разной формы, в которые можно класть что угодно.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 2,
                'topic' => 'database.nosql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Какие есть виды NoSQL баз?',
                'answer' => '1) Key-Value: ключ -> значение (Redis, DynamoDB, Memcached). 2) Document: хранит документы (обычно JSON) - MongoDB, CouchDB. 3) Column-family (wide-column): таблицы с динамическими столбцами - Cassandra, HBase. 4) Graph: вершины и рёбра - Neo4j, ArangoDB. Также сюда часто относят поисковые движки (ElasticSearch) и time-series БД (InfluxDB, TimescaleDB).',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'database.nosql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Redis и его основные структуры данных?',
                'answer' => 'Redis - in-memory key-value БД, чрезвычайно быстрая. Поддерживает структуры: String, List, Hash, Set, Sorted Set (ZSet), Stream, HyperLogLog, Bitmap, Geo. Используется как: кэш, сессии, очереди (LPUSH/BRPOP, Streams), счётчики, лидерборды (ZSet), pub/sub, распределённые блокировки.',
                'code_example' => <<<'BASH'
SET user:1:name "Иван"
GET user:1:name

LPUSH queue "task1"
RPOP queue

ZADD leaderboard 100 "alice" 200 "bob"
ZREVRANGE leaderboard 0 9 WITHSCORES

INCR page:home:views
EXPIRE page:home:views 60
BASH,
                'code_language' => 'bash',
                'difficulty' => 3,
                'topic' => 'database.nosql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое MongoDB?',
                'answer' => 'MongoDB - документная NoSQL БД. Хранит JSON-подобные документы (BSON) в коллекциях, без жёсткой схемы. Поддерживает богатые запросы по полям документа (включая вложенные), индексы, агрегационный пайплайн, транзакции (с 4.0). Хороша когда схема меняется часто, нет сложных JOIN-ов, нужна гибкость. Минус: транзакции через несколько коллекций медленнее реляционных.',
                'code_example' => <<<'BASH'
db.users.insertOne({ name: "Иван", tags: ["admin", "user"] });

db.users.find({ "tags": "admin" });

db.orders.aggregate([
    { $match: { status: "paid" } },
    { $group: { _id: "$user_id", total: { $sum: "$amount" } } }
]);
BASH,
                'code_language' => 'bash',
                'difficulty' => 3,
                'topic' => 'database.nosql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Cassandra и для чего она?',
                'answer' => 'Apache Cassandra - распределённая wide-column NoSQL БД с упором на масштабируемость и доступность (AP по CAP). Идеально для записи огромных объёмов данных (логи, телеметрия, IoT, временные ряды). Архитектура без мастера (peer-to-peer), линейно масштабируется добавлением нод. Минусы: ограниченные запросы (нужно проектировать под них), eventual consistency.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'database.nosql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое ElasticSearch?',
                'answer' => 'ElasticSearch - поисковый движок поверх Apache Lucene. Документная NoSQL-БД, заточенная под full-text search и аналитику. Хорош в: поиске с relevance scoring, фасетах, агрегациях, гео-поиске, логах (часть стека ELK). Не подходит как primary store для строгой транзакционной нагрузки. Часто используется в паре с реляционной БД.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'database.nosql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Когда выбирать SQL, а когда NoSQL?',
                'answer' => 'SQL: когда схема стабильна, нужны сложные запросы и JOIN-ы, важна целостность и ACID-транзакции (финансы, e-commerce, CRM). NoSQL: когда схема меняется часто, нужно горизонтальное масштабирование на терабайты данных, простые запросы по ключу (ленты, чаты, IoT, кэш). Часто в реальных системах используется и то и другое (polyglot persistence).',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'database.nosql',
            ],
        ];
    }
}
