<?php

namespace Database\Seeders\Data\Categories\Php;

class Php8Features
{
    public static function all(): array
    {
        return [
            [
                'category' => 'PHP',
                'question' => 'Что такое именованные аргументы (named arguments)?',
                'answer' => 'Named arguments (PHP 8.0+) позволяют передавать аргументы в функцию по имени параметра, а не позиции. Синтаксис: name: value. Полезно когда много опциональных параметров - не нужно помнить порядок и пропускать промежуточные. Можно смешивать с позиционными, но именованные строго после позиционных. С PHP 8.1 - в аттрибутах и enum.',
                'code_example' => '<?php
function createUser(
    string $name,
    int $age = 18,
    bool $isAdmin = false,
    string $role = "user",
) {}

// Старый способ - пришлось бы передавать всё
createUser("Иван", 30, false, "manager");

// Named arguments - только нужное
createUser(name: "Иван", role: "manager");

// Можно в любом порядке
createUser(role: "admin", name: "Аня");

// Смешанно
createUser("Петя", isAdmin: true);

// В сложных функциях очень помогает
str_replace(
    search: ["a", "b"],
    replace: ["1", "2"],
    subject: $text,
);',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'php.php8_features',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работает match-выражение в PHP 8?',
                'answer' => 'match (PHP 8.0+) - выражение для сопоставления значений, аналог switch, но: 1) использует строгое сравнение ===, 2) возвращает значение, 3) не нуждается в break, 4) выбрасывает UnhandledMatchError если ни одна ветка не подошла, 5) может объединять несколько значений через запятую. Намного безопаснее и лаконичнее switch.',
                'code_example' => '<?php
$status = "active";

// match - выражение
$label = match($status) {
    "active", "online" => "Активен",
    "inactive" => "Неактивен",
    "banned" => "Заблокирован",
    default => "Неизвестно",
};

// switch требует break и не возвращает значение
switch ($status) {
    case "active":
    case "online":
        $label = "Активен";
        break;
    // ...
}

// match со строгим сравнением
$result = match(1) {
    "1" => "string",  // не совпадёт!
    1 => "int",       // совпадёт
};

// Без default - UnhandledMatchError при отсутствии
$x = match($y) { 1 => "a" };',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'php.php8_features',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое enum в PHP 8.1?',
                'answer' => 'Enum (PHP 8.1+) - тип-перечисление с фиксированным набором значений. Бывает: pure (просто кейсы) и backed (каждый кейс - значение типа int или string). Поддерживает методы, интерфейсы, статические методы. Кейс - синглтон, сравнение через ===. Backed enum имеет from() (выбросит ошибку) и tryFrom() (вернёт null). Cases() возвращает все варианты.',
                'code_example' => '<?php
// Pure enum
enum Status {
    case Active;
    case Inactive;
    case Banned;
}

$s = Status::Active;
var_dump($s === Status::Active); // true

// Backed enum
enum Role: string {
    case Admin = "admin";
    case User = "user";
    case Guest = "guest";

    public function label(): string {
        return match($this) {
            Role::Admin => "Администратор",
            Role::User => "Пользователь",
            Role::Guest => "Гость",
        };
    }
}

$role = Role::from("admin");          // Role::Admin
$role = Role::tryFrom("xxx");         // null
echo Role::Admin->value;              // "admin"
echo Role::Admin->label();            // "Администратор"
print_r(Role::cases());               // все варианты',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'php.php8_features',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как PHP управляет памятью в долгоживущих CLI-процессах (демонах, воркерах) и как избежать утечек?',
                'answer' => 'В обычном fpm-цикле каждый запрос получает свежее состояние и память освобождается после завершения скрипта - можно почти не думать об утечках. В CLI-демонах (Laravel queue:work, Octane, Swoole, ReactPHP) процесс живёт часами/днями, и любой объект, который не отпустили, навсегда занимает память. PHP использует reference counting + cycle collector: память освобождается, когда refcount = 0. Циклические ссылки (A→B, B→A) собирает GC периодически (gc_collect_cycles вызывается автоматически при заполнении буфера или вручную). Типичные источники утечек: 1) Глобальные/статические массивы-кеши без TTL. 2) Eloquent-модели, удерживаемые в Job через свойства. 3) Singleton-сервисы с накапливающимся state. 4) Замыкания, захватывающие $this и удерживающие крупные объекты. Практика: queue:work --max-jobs=1000 --max-time=3600 - воркер сам перезапустится, освобождая всё; в Octane - flush сервисов между запросами. Мониторинг через memory_get_usage(true) в логах.',
                'code_example' => '<?php
// Job, накапливающий утечку
class ProcessOrderJob
{
    private static array $cache = []; // ⚠️ статика живёт между jobs

    public function handle(int $orderId): void
    {
        self::$cache[$orderId] = Order::with("items")->find($orderId);
        // через 100k jobs - OOM
    }
}

// Грамотный воркер
// supervisor: php artisan queue:work --max-jobs=1000 --max-time=3600 --memory=256

// Принудительная очистка
gc_collect_cycles();
DB::disconnect();

// Мониторинг
Log::info("memory", [
    "mb" => round(memory_get_usage(true) / 1024 / 1024, 1),
    "peak" => round(memory_get_peak_usage(true) / 1024 / 1024, 1),
]);',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'php.php8_features',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое FFI (Foreign Function Interface) в PHP?',
                'answer' => 'FFI (расширение php-ffi, появилось в PHP 7.4) позволяет вызывать функции C-библиотек напрямую из PHP-кода без написания нативного PHP-расширения. Раньше для интеграции с libsodium, libcurl, libwebp нужно было писать .c-обёртку и компилировать в .so/.dll. С FFI достаточно загрузить заголовочный файл (или строку с C-объявлениями) и вызвать функции через объект FFI. Применение: интеграция с системными библиотеками без extension-разработки, прототипирование биндингов, доступ к нативным API ОС. FrankenPHP использует FFI/cgo для интеграции PHP-runtime с Go-сервером Caddy. Подводные камни: FFI медленнее обычного нативного расширения (overhead на маршалинг типов), небезопасен (типичные C-проблемы - segfault, undefined behavior), на проде нужно использовать opcache.preload для FFI - иначе FFI::cdef парсит .h-файл на каждом запросе. По умолчанию в production режим FFI ограничен через ffi.enable=preload (только preload-скрипт может его использовать).',
                'code_example' => '<?php
// Вызов libc strlen
$ffi = FFI::cdef(
    "size_t strlen(const char *s);",
    "libc.so.6"
);
echo $ffi->strlen("hello"); // 5

// Своя .so
$lib = FFI::cdef(file_get_contents("mylib.h"), "./mylib.so");
$result = $lib->compute_hash("data");

// php.ini в проде
// ffi.enable=preload
// opcache.preload=/path/to/preload.php',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'php.php8_features',
            ],
            [
                'category' => 'PHP',
                'question' => 'Дают ли Fibers настоящую многопоточность? Чем они отличаются от потоков ОС?',
                'answer' => 'НЕТ. Fibers (PHP 8.1) - это кооперативная многозадачность (concurrency), а не параллелизм (parallelism). Все fibers выполняются в ОДНОМ потоке ОС: только один fiber работает в любой момент времени, переключение происходит явно через Fiber::suspend()/resume() - не вытесняюще. Это значит: CPU-bound задачи в fibers не ускорятся (используется одно ядро), но IO-bound задачи могут эффективно совмещаться (пока один fiber ждёт сокет, шедулер запускает другой). Fibers - примитив низкого уровня для написания async-runtimes (amphp v3, ReactPHP в новых версиях): сами по себе они не делают код асинхронным, нужен event loop, который при IO-операции переключает fiber. Для настоящего параллелизма (несколько ядер CPU) в PHP используют: ext-parallel (отдельные потоки с shared-nothing моделью), pcntl_fork (форк процессов), очереди (распределение задач на воркеры). Аналогии: fibers ≈ async/await в Python/JS, корутины в Kotlin без многопоточного диспетчера, goroutines в одно-поточном GOMAXPROCS=1.',
                'code_example' => '<?php
$fiber = new Fiber(function (): void {
    echo "1 ";
    $value = Fiber::suspend("paused");
    echo "3 (получил: $value) ";
});

echo $fiber->start();   // "1 paused"
echo "2 ";
$fiber->resume("hi"); // "3 (получил: hi)"
// Вывод: "1 paused 2 3 (получил: hi) "

// Всё в ОДНОМ потоке - никакого параллелизма
// Для CPU-параллелизма:
// - ext-parallel: $runtime->run(fn() => heavyWork())
// - pcntl_fork()
// - очереди: dispatch(new HeavyJob)->onQueue("workers")',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'php.php8_features',
            ],
        ];
    }
}
