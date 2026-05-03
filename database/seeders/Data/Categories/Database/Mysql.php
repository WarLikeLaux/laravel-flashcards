<?php

namespace Database\Seeders\Data\Categories\Database;

class Mysql
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Базы данных',
                'question' => 'InnoDB vs MyISAM в MySQL?',
                'answer' => 'InnoDB - современный движок MySQL по умолчанию. Поддерживает: транзакции (ACID), foreign keys, row-level locks, crash recovery, MVCC. MyISAM - старый движок: только table-level locks, нет транзакций и FK, но быстрее на простых SELECT-only нагрузках и full-text. На практике почти всегда используют InnoDB. MyISAM считается устаревшим.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'database.mysql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое Clustered index в InnoDB?',
                'answer' => 'В InnoDB строки физически хранятся в порядке primary key - это и есть кластерный индекс. Поэтому PK lookup очень быстрый - данные сразу с ним. Все остальные (вторичные) индексы хранят PK как ссылку на строку. Следствия: PK должен быть коротким (он повторяется в каждом вторичном индексе), последовательный PK даёт лучшую локальность записи.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'database.mysql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Как выбрать storage engine в MySQL?',
                'answer' => 'В 99% случаев - InnoDB (он по умолчанию). Используй MyISAM только для ныне редких юзкейсов "много чтения, нет записи". Memory (HEAP) - для временных in-memory таблиц. Archive - для архивных данных только на чтение/append. NDB - для кластерного MySQL Cluster.',
                'code_example' => <<<'SQL'
CREATE TABLE users (
    id INT PRIMARY KEY,
    name VARCHAR(100)
) ENGINE = InnoDB;
SQL,
                'code_language' => 'sql',
                'difficulty' => 3,
                'topic' => 'database.mysql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'REPEATABLE READ в InnoDB и gap locks?',
                'answer' => 'В стандарте SQL уровень REPEATABLE READ защищает от non-repeatable read, но не от phantoms. В InnoDB на REPEATABLE READ механизм ДВОЙНОЙ и зависит от типа чтения. (1) Для CONSISTENT READS (обычный SELECT без FOR UPDATE / LOCK IN SHARE MODE) phantom-ы исключены за счёт MVCC-снимка: транзакция читает на момент первого SELECT, новые строки от других транзакций для неё просто не существуют - блокировки тут ни при чём. (2) Для LOCKING READS (SELECT ... FOR UPDATE / LOCK IN SHARE MODE, UPDATE/DELETE по диапазону) включаются next-key и gap locks - блокировки на "промежутках" между значениями индекса. SELECT * FROM t WHERE x BETWEEN 5 AND 10 FOR UPDATE заблокирует не только существующие строки, но и пустые промежутки - вторая транзакция не сможет вставить x=7. Это и предотвращает фантомы для locking reads. ВАЖНО: gap locks - частая причина неожиданных deadlock-ов под нагрузкой; на READ COMMITTED InnoDB их отключает (только row locks), но тогда фантомы возможны и для locking reads тоже. Уникальная особенность InnoDB - именно сочетание MVCC + gap locks на одном уровне изоляции.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 5,
                'topic' => 'database.mysql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Что такое ONLY_FULL_GROUP_BY и почему он часто ломает легаси-MySQL-запросы?',
                'answer' => 'ONLY_FULL_GROUP_BY - режим в sql_mode MySQL (по умолчанию ВКЛЮЧЁН с MySQL 5.7.5), который требует строгое соответствие SQL-стандарту: каждое поле в SELECT, которое не является агрегатом (SUM/COUNT/AVG/MIN/MAX) или константой, должно либо присутствовать в GROUP BY, либо быть функционально зависимым от GROUP BY-колонок (PK / UNIQUE NOT NULL). До 5.7.5 (и в MySQL по дефолту до того) MySQL разрешал писать SELECT u.id, u.name, COUNT(*) ... GROUP BY u.id - и для каждой группы возвращал ПРОИЗВОЛЬНОЕ значение u.name, что часто приводило к неочевидным багам в отчётах. С включённым ONLY_FULL_GROUP_BY такой запрос валится с ошибкой 1055 "Expression #N of SELECT list is not in GROUP BY clause and contains nonaggregated column". Решения: 1) добавить все non-aggregate колонки в GROUP BY; 2) обернуть лишние колонки агрегатами вроде ANY_VALUE(u.name) - явно сказать "мне всё равно, какое значение"; 3) переписать через subquery / window функции; 4) (НЕ рекомендуется в проде) выключить режим в sql_mode. На собесе spotter: запросы вида "SELECT * FROM orders GROUP BY user_id" - нарушение ONLY_FULL_GROUP_BY и одновременно бизнес-ошибка (какие * вернутся - непредсказуемо).',
                'code_example' => '-- ❌ Сломается при ONLY_FULL_GROUP_BY (1055)
SELECT u.id, u.name, u.email, COUNT(o.id) AS orders
FROM users u LEFT JOIN orders o ON o.user_id = u.id
GROUP BY u.id;

-- ✅ Все non-aggregate в GROUP BY
SELECT u.id, u.name, u.email, COUNT(o.id) AS orders
FROM users u LEFT JOIN orders o ON o.user_id = u.id
GROUP BY u.id, u.name, u.email;

-- ✅ ANY_VALUE - "не важно какое значение"
SELECT u.id, ANY_VALUE(u.name) AS name, COUNT(o.id) AS orders
FROM users u LEFT JOIN orders o ON o.user_id = u.id
GROUP BY u.id;

-- ✅ Window function вместо GROUP BY (MySQL 8+)
SELECT id, name, email,
       COUNT(*) OVER (PARTITION BY id) AS orders
FROM users;

-- Проверить текущий sql_mode
SELECT @@sql_mode;',
                'code_language' => 'sql',
                'difficulty' => 4,
                'topic' => 'database.mysql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'В чём разница между MySQL DATETIME и TIMESTAMP, и какая боль возникает при смене таймзоны сервера?',
                'answer' => 'DATETIME и TIMESTAMP - оба хранят дату и время, но семантика принципиально разная. TIMESTAMP: 4 байта, диапазон 1970-01-19 - 2038-01-19 (Y2K38), хранится ВНУТРЕННЕ В UTC. При записи MySQL конвертирует значение из текущей session timezone в UTC, при чтении - обратно из UTC в timezone сессии. То есть значение "плавает" вместе с настройкой time_zone клиента/сервера. DATETIME: 8 байт (5 в MySQL 5.6.4+ для лучшей точности с долями секунд), диапазон 1000-9999 годы, хранится КАК ЕСТЬ - никаких преобразований; что положили строкой "2024-06-15 12:00:00" - то и достанете, независимо от timezone. ПРАКТИЧЕСКАЯ БОЛЬ при миграции сервера в другую таймзону: TIMESTAMP-колонки начинают возвращать другие значения для тех же физических байтов (потому что меняется конверсия из UTC), DATETIME-колонки остаются неизменными. Прод-история: проект начат в Москве, сервер MSK (UTC+3), миграция в AWS Frankfurt (UTC+1) - все TIMESTAMP-поля "сдвинулись" на 2 часа в отчётах. Лечение: либо заранее держать time_zone="+00:00" на серверах и фронте, либо использовать DATETIME для бизнес-дат (заказ оформлен в "12:00") и TIMESTAMP только для технических полей (created_at/updated_at, где UTC-семантика как раз нужна). Laravel дефолт - timestamp() в миграции для created_at/updated_at, $casts =>"datetime" для отдельных полей; CARBON_TIMEZONE и app.timezone в config влияют только на PHP-сторону.',
                'code_example' => '-- TIMESTAMP - хранится в UTC, конвертируется на лету
CREATE TABLE events_ts (
    id INT PRIMARY KEY,
    happened_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
SET time_zone = "+03:00";
INSERT INTO events_ts(id) VALUES(1); -- залетит UTC, виден как +03:00
SELECT happened_at FROM events_ts WHERE id=1;  -- например, 12:00:00
SET time_zone = "+00:00";
SELECT happened_at FROM events_ts WHERE id=1;  -- то же значение, но 09:00:00
-- ⚠ значение "сдвинулось" из-за смены timezone

-- DATETIME - стабильно, что положил, то прочёл
CREATE TABLE events_dt (
    id INT PRIMARY KEY,
    happened_at DATETIME
);
INSERT INTO events_dt VALUES(1, "2024-06-15 12:00:00");
SET time_zone = "+00:00";
SELECT happened_at FROM events_dt; -- по-прежнему 2024-06-15 12:00:00

-- Проверка текущей timezone
SELECT @@global.time_zone, @@session.time_zone;',
                'code_language' => 'sql',
                'difficulty' => 4,
                'topic' => 'database.mysql',
            ],
            [
                'category' => 'Базы данных',
                'question' => 'Зачем отключают FOREIGN_KEY_CHECKS на массовых импортах и почему "NOT NULL DEFAULT ..." - design rule?',
                'answer' => 'Foreign keys - не бесплатны: на каждый INSERT/UPDATE/DELETE InnoDB проверяет валидность ссылки, что требует look-up в индексе родительской таблицы и часто берёт shared lock на родительскую строку. На массовых операциях (миграции данных, dump-restore, bulk-import 10M строк) это: а) сильно тормозит, потому что проверки на каждую строку; б) ломает порядок: нельзя залить детей раньше родителей. Стандартный паттерн на тяжёлых импортах: SET FOREIGN_KEY_CHECKS=0 в начале, заливаем данные в любом порядке/любым методом (LOAD DATA INFILE или multi-row INSERT), SET FOREIGN_KEY_CHECKS=1 в конце. ВАЖНО: после этого FK не валидируются автоматически - ответственность на разработчике; рекомендуется отдельно прогнать аудит-запросы на сирот (LEFT JOIN ... WHERE parent.id IS NULL). MySQL также пропускает запись о дочерних строках в binary log для slave-репликации в этом режиме - на репликах нужны те же чек-настройки. Связанное design rule "NOT NULL DEFAULT ...": NULL семантически означает "значение неизвестно", это специальное состояние с трёхзначной логикой (TRUE/FALSE/NULL), которое усложняет запросы (WHERE x = 5 не вернёт строки, где x IS NULL; индексы по nullable-колонкам в некоторых СУБД не покрывают IS NULL - см. Oracle). Если по бизнес-смыслу значение всегда есть - объявляйте NOT NULL DEFAULT 0/-1/""/sentinel: меньше боли в WHERE, чище семантика, чуть лучше планы запросов, нет ловушек NULL-распространения в выражениях. NULL только когда NULL имеет ОТДЕЛЬНЫЙ смысл "ещё не задано" (deleted_at, deleted_at, archived_at).',
                'code_example' => '-- Bulk-импорт миллионов строк - FK выключаем
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;     -- бонус: пропустить уникальные проверки
SET autocommit = 0;        -- одна большая транзакция на все

LOAD DATA INFILE "/tmp/orders.csv" INTO TABLE orders FIELDS TERMINATED BY ",";
LOAD DATA INFILE "/tmp/order_items.csv" INTO TABLE order_items;

COMMIT;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
SET autocommit = 1;

-- Аудит-запрос на сирот после импорта
SELECT oi.id FROM order_items oi
LEFT JOIN orders o ON o.id = oi.order_id
WHERE o.id IS NULL;

-- Design rule: NOT NULL DEFAULT там, где NULL не нужен бизнесу
CREATE TABLE products (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL DEFAULT "",
    qty  INT          NOT NULL DEFAULT 0,
    archived_at DATETIME NULL  -- NULL имеет смысл "не архивирован"
);',
                'code_language' => 'sql',
                'difficulty' => 4,
                'topic' => 'database.mysql',
            ],
        ];
    }
}
