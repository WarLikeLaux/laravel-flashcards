<?php

namespace Database\Seeders\Data;

class InterviewQuestions
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example: ?string, code_language: ?string}>
     */
    public static function all(): array
    {
        return [
            // ===== PHP =====
            [
                'category' => 'PHP',
                'question' => 'Как работает copy-on-write для массивов и строк в PHP и когда он перестаёт работать?',
                'answer' => 'PHP хранит значения в zval со счётчиком ссылок refcount. При присваивании увеличивается refcount, а сам zval не копируется. Глубокое копирование (separation) происходит только при первой записи в одну из связанных переменных. CoW ломается, если переменная передана по ссылке (&$var) или захвачена в замыкание по ссылке — тогда копия делается сразу или вообще не делается.',
                'code_example' => '<?php
$a = range(1, 1_000_000); // 1 zval
$b = $a;                  // refcount=2, копии нет
$b[0] = 0;                // separation: копируется массив
$c = &$a;                 // CoW отключён для пары $a/$c',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем generator отличается от обычной функции и почему он экономит память?',
                'answer' => 'Generator — это функция с yield, возвращающая объект Generator, реализующий Iterator. Тело функции выполняется лениво: на каждой итерации до следующего yield, после чего стек замораживается. В памяти живёт только текущее значение и состояние корутины, а не весь набор данных. Это позволяет обрабатывать потоки данных любого размера в O(1) памяти. Дополнительно поддерживаются send() (двусторонняя коммуникация) и yield from (делегирование).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое Fiber в PHP 8.1 и чем он отличается от generator и от корутины Go?',
                'answer' => 'Fiber — примитив пользовательских стеков: можно приостановить (Fiber::suspend) и возобновить (resume) выполнение в произвольной точке, не только на yield. Generator кооперативен и тесно связан с iterator-протоколом, fiber же универсальнее и используется в ReactPHP/AMPHP для скрытия await. В отличие от горутин, fibers однопоточные, не имеют шедулера в ядре языка и не дают параллелизма — только конкурентность.',
                'code_example' => '<?php
$fiber = new Fiber(function (): void {
    $x = Fiber::suspend("ready");
    echo "got $x\n";
});
$msg = $fiber->start();   // "ready"
$fiber->resume("hello");  // печатает "got hello"',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Зачем нужны readonly-свойства и readonly-классы (PHP 8.2) и какие у них ограничения?',
                'answer' => 'readonly-свойство можно инициализировать один раз изнутри объявившего класса (обычно в конструкторе) и нельзя переписать снаружи или из наследника. readonly-класс делает все нестатические свойства readonly автоматически. Это даёт иммутабельные DTO/value objects без бойлерплейта геттеров. Ограничения: нельзя иметь типизированные default-значения, нельзя клонировать с изменением (нужен __clone с reflection или wither-методы), невозможно использовать с static-свойствами.',
                'code_example' => '<?php
final readonly class Money {
    public function __construct(
        public int $amount,
        public string $currency,
    ) {}
}
$m = new Money(100, "USD");
// $m->amount = 200; // Error',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что делает OPcache и почему важна opcache.validate_timestamps в проде?',
                'answer' => 'OPcache кэширует скомпилированный байткод PHP в shared memory, избавляя от парсинга и компиляции на каждый запрос. validate_timestamps=1 заставляет PHP проверять mtime файлов; в проде её ставят в 0 для скорости и сбрасывают кэш во время деплоя через opcache_reset() или перезапуск FPM. Также важны opcache.memory_consumption, max_accelerated_files и preloading (PHP 7.4+) для разогрева классов до старта воркеров.',
                'code_example' => '; production php.ini
opcache.enable=1
opcache.validate_timestamps=0
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
opcache.preload=/var/www/preload.php',
                'code_language' => 'bash',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работает JIT в PHP 8 и в каких задачах он реально ускоряет?',
                'answer' => 'JIT (tracing/function режимы) компилирует горячий байткод в машинный код через DynASM. Для типичных веб-приложений выигрыш скромный, потому что бутылочное горлышко — IO/база, а не CPU. Реальный профит — на CPU-bound задачах: вычислениях, image-processing, парсерах, ML-инференсе. Включается через opcache.jit_buffer_size и opcache.jit=tracing в php.ini.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Как устроен сборщик циклических ссылок в PHP и когда он включается?',
                'answer' => 'Базовый GC — это refcounting. Когда refcount достигает 0, zval освобождается. Циклы (a→b→a) refcount не сбрасывают, поэтому существует второй уровень — буфер «возможных корней» (gc_collect_cycles). Когда буфер заполняется (по умолчанию 10000 узлов), запускается алгоритм Bacon-Rajan: помечает потомков и удаляет недостижимые. Принудительно вызывается gc_collect_cycles().',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'В чём разница между WeakMap, WeakReference и SplObjectStorage?',
                'answer' => 'SplObjectStorage хранит сильные ссылки — объект-ключ не освободится, пока хранилище живёт. WeakReference (PHP 7.4) — обёртка, не препятствующая GC, get() вернёт null после уборки. WeakMap (PHP 8.0) — ассоциативный массив со слабыми ключами: при удалении объекта запись исчезает автоматически. Используется для кэшей и метаданных, привязанных к объекту, без утечек.',
                'code_example' => '<?php
$cache = new WeakMap();
$user = new User(1);
$cache[$user] = "expensive_payload";
unset($user);             // запись из WeakMap уйдёт',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем отличается == от === и какие сюрпризы бывают на нестрогом сравнении в PHP 8+?',
                'answer' => '=== сравнивает тип и значение, == выполняет приведение типов. В PHP 8 поведение string vs number стало строже: "abc" == 0 теперь false (раньше true). Но "1abc" == 1 всё ещё true; "10" == "1e1" тоже true (оба числовые строки). Для null-safety и иммутабельности используйте ===, а для чисел — int-cast или явное приведение. Сравнение объектов по == проверяет класс и поля, а === — идентичность ссылки.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что произойдёт при new ClassName(...) для класса с конструктором, объявленным как private?',
                'answer' => 'Получите Error: Call to private ClassName::__construct(). Такой паттерн используется для именованных конструкторов и Singleton: класс предоставляет статические фабричные методы (fromArray, fromString), которые внутри вызывают new self(). Это позволяет инкапсулировать инвариант построения и иметь несколько способов создания с осмысленными именами.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работают атрибуты PHP 8 и чем они лучше PHPDoc-аннотаций?',
                'answer' => 'Атрибуты — это нативный синтаксис #[Attr(args)], который парсится компилятором и доступен через Reflection API без сторонних парсеров. У них есть таргеты (TARGET_CLASS, TARGET_METHOD), флаг IS_REPEATABLE и валидация аргументов, как у обычных классов. По сравнению с docblock-аннотациями: быстрее, безопаснее (нет регуляркой парсинга), IDE даёт автокомплит, типобезопасны.',
                'code_example' => '<?php
#[Attribute(Attribute::TARGET_METHOD)]
final class Route {
    public function __construct(public string $path, public string $method = "GET") {}
}
class Controller {
    #[Route("/users/{id}")]
    public function show(int $id) {}
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'В чём разница между abstract, interface и trait и когда выбирать что?',
                'answer' => 'Interface задаёт контракт без реализации, поддерживает множественную реализацию, не имеет состояния. Abstract class — частичная реализация плюс контракт, одиночное наследование, может иметь свойства. Trait — горизонтальное переиспользование кода (mixin), копируется в класс при компиляции, не образует тип. Интерфейс — для polymorphism, abstract — для шаблонного метода с общим состоянием, trait — для дублирующейся логики между несвязанными классами.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое late static binding и зачем нужен static вместо self?',
                'answer' => 'self ссылается на класс, в котором написана строка — связывание раннее, на этапе компиляции. static связывается поздно, по фактическому классу вызова. Это критично для фабричных методов и наследования: new self() вернёт родителя даже из дочернего класса, new static() — нужный потомок. Также static используется для возвращаемого типа методов вроде fluent API.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что выведет код с замыканием, захватившим переменную по значению, если её изменить после создания замыкания?',
                'answer' => 'use ($var) копирует значение в момент создания closure — последующие изменения снаружи не видны внутри. use (&$var) захватывает по ссылке: видны изменения в обе стороны. PHP 7.4+ поддерживает arrow functions (fn() =>), которые автоматически захватывают by value все используемые переменные внешнего скоупа.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Как реализованы enum в PHP 8.1 и чем backed-enum отличается от pure?',
                'answer' => 'Enum — это специальный объектный тип; кейсы — синглтоны, сравнение по === безопасно. Pure enum просто перечисление; backed enum имеет скалярный backing-тип (int|string), что даёт ::from()/::tryFrom() и автосериализацию. Enum может реализовывать интерфейсы, иметь методы и константы, но не имеет состояния (свойств). cases() возвращает все варианты в порядке объявления.',
                'code_example' => '<?php
enum Status: string {
    case Active = "active";
    case Banned = "banned";
    public function label(): string {
        return match($this) {
            self::Active => "Активен",
            self::Banned => "Забанен",
        };
    }
}
Status::from("active");',
                'code_language' => 'php',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое match-выражение и чем оно лучше switch?',
                'answer' => 'match сравнивает строго (===), возвращает значение, требует исчерпывающего покрытия (бросает UnhandledMatchError), не имеет fallthrough — каждая ветка завершается неявно. switch использует == и требует break, легко поймать баг с числовым строковым ключом. match — выражение, поэтому удобно присваивать в переменную или возвращать.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем PHP-FPM отличается от mod_php и как настраиваются пулы?',
                'answer' => 'mod_php встраивает интерпретатор в Apache-процесс, делая воркер тяжёлым и завязанным на веб-сервер. PHP-FPM — отдельный демон с FastCGI, общается с nginx/Apache по сокету, держит пулы воркеров. Стратегии pm: static (фиксированный пул), dynamic (масштабирует от min до max), ondemand (форкает по запросу, экономит память). pm.max_requests перезапускает воркер, чтобы избежать утечек.',
                'code_example' => '; pool.conf
pm = dynamic
pm.max_children = 50
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 20
pm.max_requests = 1000',
                'code_language' => 'bash',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем отличается include от require и от autoload, и почему autoload предпочтительнее?',
                'answer' => 'include выдаёт warning при отсутствии файла и продолжает выполнение, require — fatal error. _once делает идемпотентным. Autoload (spl_autoload_register / Composer PSR-4) загружает классы лениво: только когда они впервые упоминаются. Это снижает время загрузки, поддерживает namespaces и работает с opcache. В современных проектах ручные include использовать не нужно — только bootstrap.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое SPL и какие структуры из неё реально полезны на собеседованиях?',
                'answer' => 'Standard PHP Library предоставляет специализированные структуры данных и итераторы. SplQueue/SplStack/SplDoublyLinkedList — связные списки с O(1) на голову/хвост. SplPriorityQueue — куча. SplObjectStorage — set/map для объектов. SplFixedArray — массив с числовыми индексами и фиксированным размером, экономит память по сравнению с обычным array (~3-5x). Итераторы (RecursiveIteratorIterator, FilterIterator) дают компонуемые потоки.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работают типы never и void и в чём практическая разница?',
                'answer' => 'void — функция не возвращает ничего полезного, но завершается нормально. never (PHP 8.1) — функция никогда не возвращает: либо бросает исключение, либо вызывает exit/die/бесконечный цикл. Тип never используется анализаторами для exhaustiveness checking: компилятор знает, что код после вызова never-функции недостижим. Это чище, чем void для guard-функций вроде throwIfInvalid() и помогает type narrowing после ранних возвратов.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'В чём разница между __get/__set и реальными свойствами и какие подводные камни?',
                'answer' => 'Магические методы вызываются, когда обращение к свойству невозможно (отсутствует или недоступно по видимости). Они в разы медленнее прямых обращений, ломают статический анализ, IDE-автодополнение и type inference. На каждом __get создаётся фрейм. Их используют для прокси-объектов и lazy-loading, но в DDD предпочтительнее явные геттеры или public readonly. С isset() работают только если определён __isset().',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работает spread-оператор для массивов и именованных аргументов в PHP 8?',
                'answer' => '... разворачивает iterable в позиционные аргументы или элементы массива. PHP 8.1 разрешает разворачивать массивы со строковыми ключами — они становятся именованными аргументами. Это удобно для proxy/decorator: принять args, добавить/изменить и пробросить дальше. Также именованные аргументы делают вызовы с длинными сигнатурами читаемыми и устойчивыми к перестановке.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое first-class callable syntax (PHP 8.1) и зачем он нужен?',
                'answer' => 'Синтаксис $fn = strlen(...) или $obj->method(...) создаёт Closure из функции/метода без строкового имени. По сравнению со старым [$obj, "method"] и "strlen" — типобезопасно, поддерживает рефакторинг IDE, и, что важно, ловит ошибки опечаток на этапе компиляции. Удобно для array_map, pipeline и DI-резолверов.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем mb_* функции отличаются от обычных строковых и когда это критично?',
                'answer' => 'strlen, substr, strtolower работают побайтово. Для UTF-8 один кириллический символ — 2 байта, эмодзи — 4. mb_* функции учитывают кодировку и возвращают длину/срез в символах. Использование strlen для валидации длины пароля или substr для превью текста — частый источник багов и mojibake. Дефолтную кодировку задаёт mbstring.internal_encoding=UTF-8.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Как защититься от инъекций при сборке SQL вручную и почему prepared statements решают проблему?',
                'answer' => 'Prepared statements отделяют шаблон запроса от данных: драйвер парсит SQL один раз и подставляет значения как параметры на стороне сервера. Это исключает интерпретацию пользовательского ввода как кода. Эмулированные prepares (PDO::ATTR_EMULATE_PREPARES=true) на самом деле подставляют значения в шаблон на стороне клиента — безопасно, но теряются проверки типов и planning-cache. В проде включайте настоящие prepares.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое stream wrappers и как с их помощью читать gzip "на лету"?',
                'answer' => 'Stream wrapper — абстракция над источником данных с единым API fopen/fread/fwrite. PHP включает file://, http://, php://memory, а также compression-фильтры compress.zlib://, php://filter. Можно регистрировать свои через stream_wrapper_register. Это позволяет читать удалённые файлы, шифровать на лету и обрабатывать большие архивы потоково.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое preloading в PHP 7.4+ и какие у него ограничения?',
                'answer' => 'Preloading загружает указанные файлы в opcache при старте PHP-FPM master-процесса и навсегда держит их в памяти. Эти классы доступны во всех воркерах без файловой проверки, что даёт +5-15% к скорости старта запроса. Ограничения: при изменении preloaded-файла нужен полный рестарт FPM, нельзя использовать с runtime-кодом, скрипт исполняется в контексте master.',
                'code_example' => null,
                'code_language' => null,
            ],

            // ===== OOP / Patterns / SOLID / DDD =====
            [
                'category' => 'OOP',
                'question' => 'Сформулируйте принцип Лисков и приведите пример его нарушения на квадрате и прямоугольнике.',
                'answer' => 'LSP: объекты подкласса должны быть замещаемы объектами базового без нарушения корректности программы. Классический контрпример: Square наследует Rectangle и переопределяет setWidth/setHeight, чтобы стороны были равны. Клиент, написанный для Rectangle, ожидает независимости измерений (после setWidth(5);setHeight(10) площадь=50). Со Square площадь будет 100. Решение — выделить интерфейс Shape с area() и не наследовать Square от Rectangle.',
                'code_example' => '<?php
class Rectangle {
    public function __construct(protected int $w, protected int $h) {}
    public function setWidth(int $w): void { $this->w = $w; }
    public function setHeight(int $h): void { $this->h = $h; }
    public function area(): int { return $this->w * $this->h; }
}
class Square extends Rectangle {
    public function setWidth(int $w): void { $this->w = $w; $this->h = $w; }
    public function setHeight(int $h): void { $this->w = $h; $this->h = $h; }
}
// LSP нарушен: setWidth ломает инвариант Rectangle',
                'code_language' => 'php',
            ],
            [
                'category' => 'OOP',
                'question' => 'В чём разница между Dependency Injection и Service Locator и почему DI обычно лучше?',
                'answer' => 'DI: зависимости передаются явно через конструктор/сеттер; класс не знает о контейнере. Service Locator: класс получает контейнер и сам запрашивает зависимости. SL скрывает реальные зависимости, мешает тестированию (надо мокать контейнер), создаёт неявную связность с фреймворком. DI делает зависимости частью сигнатуры — они видны в коде и в типах, легко мокаются. SL допустим как escape hatch в фреймворковых местах вроде middleware-фабрик.',
                'code_example' => '<?php
// Плохо: Service Locator
class OrderService {
    public function __construct(private Container $c) {}
    public function pay() { $this->c->get(Gateway::class)->charge(); }
}
// Хорошо: DI
class OrderService {
    public function __construct(private Gateway $gw) {}
    public function pay() { $this->gw->charge(); }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'OOP',
                'question' => 'Что такое Interface Segregation Principle и как он соотносится с "fat interfaces"?',
                'answer' => 'ISP: клиент не должен зависеть от методов интерфейса, которыми не пользуется. "Толстый" интерфейс заставляет реализаторов писать заглушки, а потребителей — игнорировать ненужные методы, что усложняет рефакторинг. Решение — разбить интерфейс на ролевые: Readable/Writable, Authenticatable/Authorizable. Признак нарушения — методы вроде throw new BadMethodCallException("not supported") в реализациях.',
                'code_example' => '<?php
// Плохо
interface Worker { public function work(); public function eat(); }
class Robot implements Worker { public function eat() { throw new Exception(); } }

// Хорошо
interface Workable { public function work(); }
interface Eatable { public function eat(); }
class Robot implements Workable {}
class Human implements Workable, Eatable {}',
                'code_language' => 'php',
            ],
            [
                'category' => 'OOP',
                'question' => 'Чем Strategy отличается от State и приведите кейс для каждого.',
                'answer' => 'Strategy инкапсулирует взаимозаменяемые алгоритмы, выбирается клиентом и обычно не меняется на лету: например, разные алгоритмы расчёта налога. State моделирует поведение объекта в зависимости от внутреннего состояния и переключает само себя: Order переходит pending → paid → shipped, и каждое состояние имеет свой набор разрешённых действий. Структурно паттерны похожи (композиция + полиморфизм), различие — в семантике переходов: в Strategy объекты-стратегии stateless, в State объект-состояние сам выбирает следующее.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'OOP',
                'question' => 'Что такое value object, чем он отличается от сущности и какие у него инварианты?',
                'answer' => 'Value object — объект, идентичность которого определяется значением полей; равенство — структурное. Иммутабелен и валидирует инварианты в конструкторе. Не имеет ID, в отличие от entity. Примеры: Money, Email, DateRange. Любое изменение даёт новый объект (with* методы). Польза: ловим невалидные значения в момент создания, делаем сигнатуры самодокументируемыми, упрощаем тесты.',
                'code_example' => '<?php
final readonly class Email {
    public function __construct(public string $value) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email");
        }
    }
    public function equals(self $other): bool { return $this->value === $other->value; }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'OOP',
                'question' => 'Что такое Aggregate Root в DDD и зачем он нужен?',
                'answer' => 'Aggregate — кластер связанных объектов, который трактуется как единое целое для изменений. У агрегата есть Aggregate Root — единственная сущность, через которую внешние объекты обращаются к содержимому. Root охраняет инварианты всего агрегата и является границей транзакции. Внешние агрегаты ссылаются на root по идентификатору, а не по объекту. Это упрощает консистентность и позволяет масштабировать (один агрегат — одна транзакция).',
                'code_example' => '<?php
final class Order { // Root
    private array $items = [];
    public function addItem(ProductId $pid, int $qty): void {
        if ($this->isLocked()) throw new DomainException("Locked");
        $this->items[] = new OrderItem($pid, $qty);
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'OOP',
                'question' => 'Чем отличается Factory Method от Abstract Factory?',
                'answer' => 'Factory Method — метод (часто абстрактный) в классе-создателе, возвращающий продукт; используется для одного семейства, подклассы переопределяют метод. Abstract Factory — объект-фабрика, создающий несколько связанных продуктов одного "семейства" (UI для Material/Cupertino: Button + Checkbox + Menu). FM решает "какой класс инстанцировать", AF — "какое семейство объектов согласованно создать".',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'OOP',
                'question' => 'Что такое Open/Closed Principle и как его реализовать без наследования через композицию?',
                'answer' => 'OCP: модули открыты для расширения, закрыты для изменения. Добавление нового поведения не должно требовать правок существующего кода. Через наследование это делает Template Method, через композицию — Strategy/полиморфизм по интерфейсу. Например, чтобы поддержать новый тип скидки, не правим if-цепочку Calculator, а добавляем класс, реализующий DiscountRule, и регистрируем его в коллекции.',
                'code_example' => '<?php
interface DiscountRule { public function apply(Cart $c): Money; }
class CartCalculator {
    public function __construct(private iterable $rules) {}
    public function total(Cart $c): Money {
        $sum = $c->subtotal();
        foreach ($this->rules as $r) $sum = $sum->minus($r->apply($c));
        return $sum;
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'OOP',
                'question' => 'Когда применять паттерн Decorator и чем он отличается от наследования?',
                'answer' => 'Decorator оборачивает объект, реализующий тот же интерфейс, и добавляет поведение до/после вызова, не меняя оригинал. Можно компоновать множество декораторов рантайм. Наследование фиксируется на этапе компиляции и взрывается комбинаторно при многих ортогональных фичах (LoggingCachedAuthRepository...). Decorator решает это: каждое поведение — отдельный декоратор, выстраиваются цепочкой через DI.',
                'code_example' => '<?php
class CachedRepo implements UserRepo {
    public function __construct(private UserRepo $inner, private Cache $cache) {}
    public function find(int $id): User {
        return $this->cache->remember("u:$id", fn() => $this->inner->find($id));
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'OOP',
                'question' => 'В чём суть паттерна Specification и зачем он нужен в репозиториях?',
                'answer' => 'Specification инкапсулирует условие выборки/проверки в виде объекта. Спецификации комбинируются через and/or/not, переиспользуются между фильтрацией коллекций и SQL-выборкой. В репозиториях это избавляет от десятков методов вроде findActiveUsersOlderThan(). В Eloquent аналог — query scopes; для сложных фильтров со множеством параметров Specification читаемее.',
                'code_example' => '<?php
interface Spec { public function isSatisfiedBy(User $u): bool; }
class IsActive implements Spec {
    public function isSatisfiedBy(User $u): bool { return !$u->bannedAt; }
}
class AndSpec implements Spec {
    public function __construct(private Spec $a, private Spec $b) {}
    public function isSatisfiedBy(User $u): bool { return $this->a->isSatisfiedBy($u) && $this->b->isSatisfiedBy($u); }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'OOP',
                'question' => 'Что такое anemic domain model и почему её считают анти-паттерном?',
                'answer' => 'Anemic model — сущности без поведения, только геттеры/сеттеры; вся логика вытекает в "сервисы". Внешне OO, по сути — процедурный код, нарушающий инкапсуляцию: инварианты можно нарушить через сеттеры, бизнес-правила распыляются по сервисам. Лекарство — rich model: методы, изменяющие состояние, проверяют инварианты. Сеттеры заменяются доменными операциями типа Order::pay(), Order::cancel().',
                'code_example' => '<?php
// Плохо
class Order { public ?DateTime $paidAt = null; }
class PaymentService { public function pay(Order $o) { $o->paidAt = now(); } }

// Хорошо
class Order {
    private ?DateTime $paidAt = null;
    public function pay(): void {
        if ($this->paidAt) throw new DomainException("Already paid");
        $this->paidAt = new DateTime();
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'OOP',
                'question' => 'Что такое CQRS и какие проблемы он решает?',
                'answer' => 'Command Query Responsibility Segregation — разделение модели чтения и записи. Команды меняют состояние, не возвращают данных; запросы читают, не меняют. Преимущества: разные модели позволяют оптимизировать чтение (денормализованные read-models, кэш) отдельно от записи (агрегаты, инварианты). Часто сочетается с event sourcing. Минус — сложность и eventual consistency между read- и write-моделями; для типового CRUD-приложения это overkill.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'OOP',
                'question' => 'Чем композиция предпочтительнее наследования и в каких случаях наследование оправдано?',
                'answer' => 'Композиция — has-a, делегирование зависимостям, динамическая замена через DI, плоская иерархия. Наследование — is-a, фиксируется в compile-time, тянет всю реализацию родителя, ломается при изменении базы (fragile base class). Наследование оправдано при настоящем подтипе с LSP (Square→Shape, нет), при шаблонном методе с общим алгоритмом и при использовании framework hooks (extends FormRequest). В прикладной логике — почти всегда композиция.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'OOP',
                'question' => 'Что такое инверсия зависимостей (DIP) и чем она отличается от инъекции зависимостей (DI)?',
                'answer' => 'DIP — принцип проектирования: модули верхнего уровня не зависят от модулей нижнего уровня; оба зависят от абстракций. Абстракции не должны зависеть от деталей. DI — техника реализации DIP: передача зависимостей извне. DIP может быть выполнен и без DI (например, через локатор), но без зависимости на абстракцию. Часто говорят "DIP на интерфейсе, DI в конструкторе".',
                'code_example' => '<?php
// DIP: NotificationService зависит от абстракции
interface Channel { public function send(Message $m): void; }
class NotificationService {
    public function __construct(private Channel $ch) {} // DI
}
class SmsChannel implements Channel { /* low-level */ }',
                'code_language' => 'php',
            ],

            // ===== Laravel =====
            [
                'category' => 'Laravel',
                'question' => 'Чем bind отличается от singleton и от scoped в сервис-контейнере Laravel?',
                'answer' => 'bind() — каждый make() создаёт новый экземпляр. singleton() — один экземпляр на весь жизненный цикл приложения (т.е. на воркер). scoped() — один экземпляр в рамках запроса/job; Octane сбрасывает scoped-привязки между запросами, а singleton — нет, что важно для предотвращения утечки состояния. В FPM-режиме scoped и singleton ведут себя одинаково.',
                'code_example' => '<?php
$this->app->bind(Mailer::class, SmtpMailer::class);
$this->app->singleton(Cache::class, fn() => new RedisCache(...));
$this->app->scoped(RequestContext::class, fn() => new RequestContext());',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работают deferred service providers и зачем они нужны?',
                'answer' => 'Deferred provider не загружается при бутстрапе; в кэшированном manifest указано, какие сервисы он предоставляет. Когда контейнер впервые резолвит один из этих сервисов, провайдер регистрируется и загружается лениво. Это сокращает cold-start: тяжёлые провайдеры (платёжные SDK, поисковые движки) не запускаются, если не нужны. Условия: реализовать DeferrableProvider, метод provides() возвращает список биндов.',
                'code_example' => '<?php
class StripeServiceProvider extends ServiceProvider implements DeferrableProvider {
    public function register(): void {
        $this->app->singleton(StripeClient::class, fn() => new StripeClient(config("services.stripe.key")));
    }
    public function provides(): array { return [StripeClient::class]; }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое contextual binding и приведите кейс из реального проекта.',
                'answer' => 'Contextual binding позволяет внедрять разные реализации интерфейса в зависимости от потребляющего класса. Пример: PhotoController должен использовать LocalFilesystem, а VideoController — S3, оба зависят от Filesystem. Без contextual binding пришлось бы вводить именованные интерфейсы или конкреты в типах. when()->needs()->give() решает это в одном месте.',
                'code_example' => '<?php
$this->app->when(PhotoController::class)
    ->needs(Filesystem::class)
    ->give(fn() => Storage::disk("local"));

$this->app->when(VideoController::class)
    ->needs(Filesystem::class)
    ->give(fn() => Storage::disk("s3"));',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем Eloquent Observer отличается от Event/Listener и когда выбирать что?',
                'answer' => 'Observer — класс, методы которого — это коллбэки на жизненный цикл модели (creating, saved, deleted). Удобен, когда логика тесно связана с моделью. Event/Listener — общая шина: модель/код диспатчит произвольное событие, на него подписываются несколько слушателей, легко асинхронить через ShouldQueue. Observer лаконичнее для аудита/таймстампов, события — для кросс-доменной интеграции.',
                'code_example' => '<?php
class UserObserver {
    public function created(User $u): void { Mail::to($u)->send(new Welcome()); }
    public function deleting(User $u): void { $u->posts()->delete(); }
}
// AppServiceProvider::boot
User::observe(UserObserver::class);',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как обеспечить идемпотентность Job в очереди и что произойдёт при двойном запуске?',
                'answer' => 'Очередь даёт at-least-once: при таймауте/падении воркера job переехдёт в attempts+1. Для идемпотентности используют ключ операции (заказ id, request id) и проверяют через WithoutOverlapping или БД-запись unique constraint, либо реализуют ShouldBeUnique. Альтернатива — middleware Throttled с уникальным ключом. Также важно ставить retry_after > timeout, чтобы не дублировать запуск из-за таймаута слушателя.',
                'code_example' => '<?php
class ProcessPayment implements ShouldQueue, ShouldBeUnique {
    public int $uniqueFor = 3600;
    public function __construct(public int $orderId) {}
    public function uniqueId(): string { return (string) $this->orderId; }
    public function handle() { /* charge once */ }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как настроить экспоненциальный backoff и максимальное число попыток для Job?',
                'answer' => 'Свойство $tries или метод tries() задаёт число попыток. backoff() возвращает int или массив задержек по каждой попытке (экспоненциальный backoff). retryUntil() задаёт абсолютный дедлайн. Для долгих jobs нужна синхронизация $timeout (sec) и retry_after в конфиге queue, чтобы воркер не считал job упавшим. failed() вызывается после исчерпания tries — место для алертов.',
                'code_example' => '<?php
class SyncCrm implements ShouldQueue {
    public int $tries = 5;
    public int $timeout = 120;
    public function backoff(): array { return [10, 30, 60, 120, 300]; }
    public function failed(Throwable $e): void { Log::critical("CRM sync gave up", ["e" => $e]); }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что произойдёт при деплое, если воркеры очереди держат старый код?',
                'answer' => 'Воркер бутстрапит фреймворк один раз и держит его в памяти. После деплоя он продолжит обрабатывать jobs со старыми сериализованными моделями и старыми классами. Решение — выполнять php artisan queue:restart, который выставляет таймстамп в кэше; воркеры периодически его проверяют и грейсфул-завершаются. Supervisor поднимет их с новым кодом. Также job-классы нельзя переименовывать без compatibility-shim, иначе сериализованные данные не десериализуются.',
                'code_example' => '# deploy.sh
php artisan queue:restart
php artisan migrate --force
php artisan config:cache route:cache event:cache',
                'code_language' => 'bash',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие подводные камни у Octane по сравнению с обычным FPM?',
                'answer' => 'Octane держит фреймворк в памяти между запросами. Singletons и статические свойства не сбрасываются — типичный источник утечек данных между пользователями. Запрещено хранить в Auth::user() в синглтонах, использовать array-кэши на жизнь приложения, изменять контейнер из контроллеров. Решение: scoped()-биндинги, RefreshDatabase-аналоги в OctaneServiceProvider::tick. Также Octane не любит долгие и блокирующие операции — нужна модель Tasks/Coroutines.',
                'code_example' => '<?php
// плохо в Octane
class CartHolder { public static array $items = []; }

// хорошо
$this->app->scoped(CartHolder::class, fn() => new CartHolder());',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как избежать N+1 при полиморфных связях morphTo?',
                'answer' => 'Обычный with("commentable") не работает напрямую, потому что для каждого типа нужен отдельный запрос. Используйте with("commentable") + morphWith() для жадной подзагрузки конкретных типов с их связями. Также есть morphMap в boot() — фиксирует строковые алиасы вместо FQCN, что устойчиво к рефакторингу. Альтернативно — явный foreach с groupBy типа.',
                'code_example' => '<?php
Comment::with(["commentable" => function (MorphTo $morphTo) {
    $morphTo->morphWith([
        Post::class => ["author"],
        Video::class => ["channel"],
    ]);
}])->get();',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем Lazy Collection отличается от обычной Collection и когда её использовать?',
                'answer' => 'LazyCollection обёртывает Generator: операции (map/filter/take) не выполняются до первого forEach/reduce, и не материализуют весь поток в память. Идеальна для построчной обработки больших файлов, cursor()-выборок Eloquent, импорта CSV. Основное ограничение — итератор однопроходный: count() или вторая итерация требуют remember()/eager(), что снова грузит в память.',
                'code_example' => '<?php
LazyCollection::make(function () {
    $h = fopen("big.csv", "r");
    while (($row = fgetcsv($h)) !== false) yield $row;
    fclose($h);
})->chunk(1000)->each(fn($chunk) => Order::insert($chunk->toArray()));',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое custom cast и чем он отличается от accessor/mutator?',
                'answer' => 'Accessor/mutator — методы getXAttribute/setXAttribute на одной модели, дублируются между моделями. Custom cast (CastsAttributes) — отдельный класс, инкапсулирует пару get/set, переиспользуется на любых моделях. Поддерживает Castable-интерфейс на value object (Money::castUsing()), что даёт чистую интеграцию с DDD. Также есть AsCollection, AsEncryptedCollection, AsArrayObject из коробки.',
                'code_example' => '<?php
final class MoneyCast implements CastsAttributes {
    public function get($model, $key, $value, $attrs) {
        return new Money((int) $attrs["{$key}_amount"], $attrs["{$key}_currency"]);
    }
    public function set($model, $key, $value, $attrs) {
        return ["{$key}_amount" => $value->amount, "{$key}_currency" => $value->currency];
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Безопасно ли использовать DB::transaction внутри job очереди и какие нюансы?',
                'answer' => 'Безопасно, но с оговорками. afterCommit() — слушатели/события, диспатченные внутри транзакции, должны выполниться только после её коммита, иначе job стартует и не найдёт данных. С Laravel 8+ можно ставить $afterCommit=true на job или использовать DB::afterCommit(). Длинные транзакции внутри job блокируют строки — лучше делать short-lived транзакции и идемпотентные операции.',
                'code_example' => '<?php
class SendInvoice implements ShouldQueue {
    public bool $afterCommit = true;
}
DB::transaction(function () use ($order) {
    $order->save();
    SendInvoice::dispatch($order); // сработает после COMMIT
});',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работает rate limiting в Laravel и в чём разница между Redis и database драйвером?',
                'answer' => 'RateLimiter использует cache-store: Redis даёт атомарные INCR/EXPIRE, что критично при гонках; database-драйвер делает SELECT/UPDATE и подвержен race-conditions при высоких RPS. Для распределённой системы и точного counting нужен Redis с sliding-window или token-bucket. RateLimiter::for() в RouteServiceProvider определяет лимиты, throttle:apiName применяет.',
                'code_example' => '<?php
RateLimiter::for("api", fn (Request $r) =>
    $r->user() ? Limit::perMinute(60)->by($r->user()->id)
               : Limit::perMinute(10)->by($r->ip())
);
// routes/api.php
Route::middleware("throttle:api")->group(...);',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое pivot model и зачем он нужен в belongsToMany?',
                'answer' => 'Базовый pivot — это просто строка-связка. Когда на ней нужны дополнительные поля (role, joined_at), методы или события, объявляют отдельную модель, наследующую Pivot, и подключают её через using(MembershipPivot::class). Это позволяет иметь withPivot, withTimestamps, accessors и события created/updated на самой связке.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие ограничения у route:cache и почему оно ломается с Closure-роутами?',
                'answer' => 'route:cache сериализует все маршруты в php-массив. Closure (Route::get("/", function() {...})) сериализовать нельзя — кеш падает с ошибкой. Поэтому в проде используют только controller@method или [Controller::class, "method"]. Также config:cache замораживает env(), который после кеша возвращает null вне config-файлов — это типичный source of bugs.',
                'code_example' => '<?php
// плохо: Closure
Route::get("/", function () { return "hi"; });

// хорошо
Route::get("/", [HomeController::class, "index"]);

// деплой
php artisan route:cache',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Form Request и какие у него этапы валидации?',
                'answer' => 'FormRequest — типизированный request с инкапсулированной валидацией и авторизацией. Контейнер резолвит его, вызывает authorize(), потом rules(), prepareForValidation() позволяет нормализовать вход до валидации, withValidator() добавлять after-rules, passedValidation() — пост-обработку. failedValidation/failedAuthorization кастомизируют ответы. Это переносит ответственность из контроллера и облегчает тестирование.',
                'code_example' => '<?php
class StoreUserRequest extends FormRequest {
    protected function prepareForValidation(): void {
        $this->merge(["email" => strtolower($this->email ?? "")]);
    }
    public function rules(): array {
        return ["email" => ["required", "email", Rule::unique("users")]];
    }
    public function authorize(): bool { return $this->user()->can("create-user"); }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем отличаются local query scope от global scope и какие подводные камни у global?',
                'answer' => 'Local scope — public method scopeXxx, явно вызывается в цепочке (User::active()->get()). Global scope автоматически применяется ко всем запросам модели, реализуется через Scope-интерфейс или Closure в booted(). Проблема: можно забыть и удивляться "куда делись soft-deleted записи". Снимать глобальный scope через withoutGlobalScope или withTrashed(). Также job, сериализующий модель, может потерять контекст scope.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Laravel',
                'question' => 'В чём разница между firstOrCreate, updateOrCreate и upsert?',
                'answer' => 'firstOrCreate ищет по атрибутам и создаёт, если нет; не атомарен — между select и insert возможна гонка, лучше иметь UNIQUE-индекс. updateOrCreate дополнительно обновляет поля у найденного. upsert делает массовый INSERT ... ON DUPLICATE KEY UPDATE (MySQL) или ON CONFLICT (Postgres) и атомарен на уровне БД, обходит каждую строку без N запросов. Используйте upsert для импорта, и uniques + транзакцию для одиночных кейсов.',
                'code_example' => '<?php
User::upsert(
    [["email" => "a@b", "name" => "A"], ["email" => "c@d", "name" => "C"]],
    uniqueBy: ["email"],
    update:   ["name"],
);',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работает Laravel Horizon и какие метрики он даёт?',
                'answer' => 'Horizon — дашборд и супервизор для Redis-очередей. Конфигурируется в config/horizon.php: массив supervisors с балансингом (auto/simple), maxProcesses, queues. Дашборд показывает throughput, runtime, failed jobs, worker memory. auto-balance перераспределяет процессы между очередями по нагрузке. horizon:terminate грейсфул-перезапускает воркеры при деплое.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое broadcasting и в чём разница private и presence-каналов?',
                'answer' => 'Broadcasting публикует серверные события клиенту через драйверы (Pusher, Reverb, Soketi). Public — открыт всем. Private — требует Auth::user() и колбэк в Broadcast::channel("orders.{user}", fn($u, $userId) => $u->id === $userId), который проверяет доступ. Presence — расширение private, ещё возвращает массив с данными присутствующих пользователей; используется для онлайн-статуса и совместного редактирования.',
                'code_example' => '<?php
Broadcast::channel("orders.{userId}", fn($u, $userId) => (int)$u->id === (int)$userId);

class OrderShipped implements ShouldBroadcast {
    public function broadcastOn(): PrivateChannel {
        return new PrivateChannel("orders.{$this->order->user_id}");
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое model binding и как сделать кастомное связывание по slug?',
                'answer' => 'Implicit binding ловит type-hint Model в методе контроллера и резолвит по primary key из URL-параметра. Чтобы биндить по slug, переопределите getRouteKeyName() на модели или укажите в роуте users/{user:slug}. Можно бросать 404 руками через Route::bind() и кастомный резолвер. Для расширенной логики — Explicit binding в RouteServiceProvider.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Laravel',
                'question' => 'Зачем нужен Pipeline и как его использовать вне middleware?',
                'answer' => 'Pipeline — декоратор поверх классов pipe-методов. Принимает входное значение и пропускает через цепочку, каждый pipe вызывает $next($payload). Используется для middleware HTTP, но прекрасно подходит для бизнес-цепочек: валидация-обогащение-вычисление-сохранение. Альтернатива длинному if-else или CoR вручную. Pipes могут быть Closure или класс с handle().',
                'code_example' => '<?php
$result = app(Pipeline::class)
    ->send($order)
    ->through([
        ValidateInventory::class,
        ApplyPromoCodes::class,
        ChargeCustomer::class,
        EmitOrderPlacedEvent::class,
    ])
    ->thenReturn();',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как Laravel Scout работает и какие нюансы при индексации больших коллекций?',
                'answer' => 'Scout — абстракция над поисковыми движками (Algolia, Meilisearch, database). Использует Searchable-трейт: автоматически синхронизирует модели с индексом на save/delete через очередь (если SCOUT_QUEUE=true). Для больших коллекций используют scout:import, который чанкует выборку. Для сложных фильтров комбинируют search($q)->where()->whereIn() и Builder-callback для специфичных запросов. softDeletes требуют отдельного флага, иначе удалённые остаются в индексе.',
                'code_example' => '<?php
class Product extends Model {
    use Searchable;
    public function toSearchableArray(): array {
        return ["name" => $this->name, "category" => $this->category->name];
    }
}
// php artisan scout:import App\\Models\\Product',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что произойдёт, если вызвать $user->posts во foreach без with("posts")?',
                'answer' => 'Это классический N+1: для каждого юзера выполнится отдельный SELECT по posts. with("posts") делает eager loading: один SELECT users + один WHERE user_id IN (...). При большом наборе данных N+1 даёт сотни запросов и убивает latency. Полезно включить Model::preventLazyLoading() в локальной среде — оно бросает исключение при ленивой загрузке и сразу ловит баг.',
                'code_example' => '<?php
// AppServiceProvider::boot
Model::preventLazyLoading(! app()->isProduction());

// в коде
$users = User::with(["posts" => fn($q) => $q->latest()->limit(5)])->get();',
                'code_language' => 'php',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работают Laravel-транзакции с deadlock и как их повторять?',
                'answer' => 'DB::transaction($callback, $attempts) ловит QueryException и при коде deadlock (например, 1213 в MySQL) повторяет до $attempts раз. Без указания attempts он бросает первое же исключение. Для распределённых сценариев nested-транзакции используют SAVEPOINT — DB::transaction внутри другой создаёт точку отката, а не новую транзакцию. afterCommit-хуки сработают только после внешнего коммита.',
                'code_example' => '<?php
DB::transaction(function () use ($from, $to, $sum) {
    $from->lockForUpdate()->decrement("balance", $sum);
    $to->lockForUpdate()->increment("balance", $sum);
}, attempts: 3);',
                'code_language' => 'php',
            ],

            // ===== Database / SQL =====
            [
                'category' => 'Database',
                'question' => 'Чем B-tree индекс отличается от Hash и от GIN, и в каких случаях выбирать GIN?',
                'answer' => 'B-tree — упорядоченное дерево, поддерживает =, <, >, BETWEEN, ORDER BY, LIKE \'prefix%\'. Hash — только равенство, в Postgres с PG10+ wal-логируется и пригоден для интенсивных = поиска. GIN — обратный индекс: ключ → набор строк; идеален для tsvector (full-text), jsonb (?, @>), массивов и trigram (pg_trgm) для LIKE \'%inside%\'. GIN строится медленнее и больше на диске, но запросы по "содержит" выигрывают на порядки.',
                'code_example' => '-- быстрый поиск по вхождению
CREATE INDEX idx_products_name_trgm ON products USING gin (name gin_trgm_ops);
SELECT * FROM products WHERE name ILIKE \'%phone%\';

-- jsonb-фильтр
CREATE INDEX idx_events_payload ON events USING gin (payload);
SELECT * FROM events WHERE payload @> \'{"type":"click"}\';',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Database',
                'question' => 'Как читать вывод EXPLAIN ANALYZE в PostgreSQL и какие признаки плохого плана?',
                'answer' => 'EXPLAIN показывает план; ANALYZE реально выполняет запрос и добавляет actual time, rows, loops. Тревожные признаки: Seq Scan по большой таблице с селективным WHERE (нет индекса), резкое расхождение rows-estimate vs actual (плохая статистика, нужен ANALYZE), Nested Loop с большим внешним циклом (надо Hash Join), Sort с внешним диском (work_mem мал), Bitmap Heap Scan + Recheck Cond (lossy). Используют BUFFERS для shared hit/read.',
                'code_example' => 'EXPLAIN (ANALYZE, BUFFERS, VERBOSE)
SELECT u.id, COUNT(o.id)
FROM users u JOIN orders o ON o.user_id = u.id
WHERE u.created_at > NOW() - INTERVAL \'30 days\'
GROUP BY u.id;',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Database',
                'question' => 'Чем отличаются Nested Loop, Hash Join и Merge Join?',
                'answer' => 'Nested Loop: для каждой строки внешней таблицы ищет совпадения во внутренней; эффективен, если внешняя маленькая, а на внутренней есть индекс по ключу. Hash Join: строит хеш-таблицу по меньшей стороне в памяти, потом сканирует большую и ищет совпадения; хорош для больших равенств без индексов. Merge Join: обе стороны отсортированы по ключу — идёт двусторонний слиянием; быстро, если данные уже отсортированы (или есть подходящий индекс).',
                'code_example' => '-- форсируем тип join для теста
SET enable_hashjoin = off;
SET enable_mergejoin = off;
EXPLAIN ANALYZE SELECT * FROM a JOIN b USING (id);',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Database',
                'question' => 'Объясните уровни изоляции и какие аномалии каждый предотвращает.',
                'answer' => 'READ UNCOMMITTED — допускает dirty read. READ COMMITTED — нет dirty, но возможны non-repeatable read и phantom. REPEATABLE READ — устраняет non-repeatable; в Postgres также фантомы (snapshot), в MySQL InnoDB — фантомы возможны без gap-locks. SERIALIZABLE — полная сериализуемость, в Postgres через SSI с rollback при конфликте, в InnoDB — через range-locks. Также есть write skew — отлавливается только Serializable.',
                'code_example' => '-- write skew пример
BEGIN ISOLATION LEVEL SERIALIZABLE;
SELECT SUM(on_call) FROM doctors WHERE shift = \'night\';
-- если >=2, можно уйти
UPDATE doctors SET on_call = false WHERE id = 1;
COMMIT; -- может откатиться при serialization_failure',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Database',
                'question' => 'Как работает MVCC в PostgreSQL и зачем нужен VACUUM?',
                'answer' => 'MVCC: каждое UPDATE/DELETE не меняет строку, а создаёт новую версию с xmin (transaction id создания) и xmax (id удаления). Транзакции видят только версии с подходящим xmin/xmax относительно своего snapshot. Старые tuple остаются в таблице как "мертвые" — bloat. VACUUM маркирует их свободными для переиспользования; VACUUM FULL переписывает таблицу. Autovacuum триггерится по threshold; параметры autovacuum_vacuum_scale_factor нужно тюнить для горячих таблиц.',
                'code_example' => '-- увидеть bloat
SELECT relname, n_dead_tup, n_live_tup, last_autovacuum
FROM pg_stat_user_tables
ORDER BY n_dead_tup DESC LIMIT 10;',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Database',
                'question' => 'Что такое deadlock и как его диагностировать?',
                'answer' => 'Deadlock — циклическое ожидание блокировок между транзакциями: T1 держит A, ждёт B; T2 держит B, ждёт A. БД детектирует цикл и убивает одну транзакцию (deadlock_timeout). Профилактика: блокировать ресурсы в одинаковом порядке (отсортировать ID), уменьшать длительность транзакций, использовать SELECT ... FOR UPDATE NOWAIT/SKIP LOCKED, индексировать колонки в WHERE при UPDATE. В Postgres логи показывают полные query обоих участников.',
                'code_example' => '-- симметричный порядок блокировок
SELECT * FROM accounts WHERE id IN (:a, :b)
ORDER BY id FOR UPDATE;
-- теперь обе транзакции лочат A раньше B',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Database',
                'question' => 'Что такое covering index и когда он даёт большой выигрыш?',
                'answer' => 'Covering index содержит все колонки, нужные запросу, либо в ключе, либо в INCLUDE (Postgres 11+) — оптимизатор берёт данные прямо из индекса без обращения к heap (Index Only Scan). Это убирает random IO на табличные страницы для широких таблиц. В MySQL InnoDB primary key всегда кластерный, поэтому secondary index, содержащий PK + selected-columns, тоже covering.',
                'code_example' => 'CREATE INDEX idx_orders_status_created
ON orders (status, created_at) INCLUDE (total);
-- запрос обслуживается Index Only Scan
SELECT total FROM orders
WHERE status = \'paid\' AND created_at > NOW() - INTERVAL \'1 day\';',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Database',
                'question' => 'Какие виды партиционирования есть в Postgres и какие проблемы они решают?',
                'answer' => 'PARTITION BY RANGE (по диапазону, чаще по дате) — типично для логов и time-series, позволяет быстро дропать старые данные через DROP PARTITION. PARTITION BY LIST — по перечислению (страна, тенант). PARTITION BY HASH — равномерное распределение. Partition pruning — оптимизатор не сканирует партиции, не подходящие под WHERE. Local indexes на каждой партиции; declarative partitioning поддерживает FK между партициями только с PG12+.',
                'code_example' => 'CREATE TABLE events (
    id bigserial, created_at timestamptz NOT NULL, payload jsonb
) PARTITION BY RANGE (created_at);

CREATE TABLE events_2026_05 PARTITION OF events
    FOR VALUES FROM (\'2026-05-01\') TO (\'2026-06-01\');',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Database',
                'question' => 'Что такое replication lag и как с ним жить в read-heavy приложении?',
                'answer' => 'Async-репликация: реплика отстаёт на величину от ms до секунд. Если сразу после записи прочитать с реплики, можно не увидеть свою же запись (read-your-writes). Лекарства: sticky-сессия на мастер N секунд после записи, использование synchronous_commit=remote_apply (синхронная репликация, дороже), read-your-writes routing по cookie/HEAD-запросу. Также Postgres может вернуть LSN после COMMIT и читать с реплики только когда replay_lsn >= нужного.',
                'code_example' => '-- master
COMMIT;
SELECT pg_current_wal_lsn();
-- replica
SELECT pg_last_wal_replay_lsn() >= :lsn;',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Database',
                'question' => 'Что такое materialized view и когда она лучше обычного view?',
                'answer' => 'View — сохранённый запрос; разворачивается при каждом обращении. Materialized view физически хранит результат, обновляется явно через REFRESH MATERIALIZED VIEW (CONCURRENTLY — без эксклюзивной блокировки, но требует UNIQUE-индекса). Подходит для тяжёлых аналитических агрегатов, которые можно пересчитывать раз в N минут/часов. Минусы: stale data, нужно расписание обновления, индексы строятся отдельно. Альтернатива — incremental rollup в отдельной таблице с обновлением по триггеру или CDC.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Database',
                'question' => 'Чем отличаются jsonb и json в Postgres и почему jsonb обычно предпочтительнее?',
                'answer' => 'json хранится текстом as-is, сохраняет порядок ключей и whitespace, медленный для запросов. jsonb парсится в бинарный формат при INSERT, ключи нормализованы, дубли удалены, доступ к полям O(log n), поддерживает GIN-индексы и операторы @>, ?, ?|. jsonb предпочтительнее почти всегда — кроме случаев, когда критичен exact-text round-trip (логирование сырых payload).',
                'code_example' => 'CREATE INDEX idx_users_meta ON users USING gin (meta jsonb_path_ops);
SELECT * FROM users WHERE meta @> \'{"plan":"premium"}\';',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Database',
                'question' => 'Какие отличия между MySQL InnoDB и PostgreSQL практически важны для разработки?',
                'answer' => 'InnoDB: clustered primary index — данные физически отсортированы по PK, secondary indexes хранят PK как pointer. Postgres: heap-таблица + отдельные индексы, никакого clustering. InnoDB lock на gap для phantom; Postgres использует MVCC снапшоты. UPSERT: MySQL — ON DUPLICATE KEY UPDATE, Postgres — ON CONFLICT. Postgres имеет CTE, оконные с расширенным синтаксисом, jsonb, arrays, partial и expression indexes — MySQL это получил позже и беднее.',
                'code_example' => '-- Postgres: partial index только для активных записей
CREATE INDEX idx_users_active_email ON users(email)
WHERE deleted_at IS NULL;
-- MySQL аналога нет — нужен FULL index',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Database',
                'question' => 'Как устроен оптимизатор запросов и что такое статистики?',
                'answer' => 'Оптимизатор перебирает планы и оценивает стоимость через cost-based модель. Статистики (pg_statistic, ANALYZE) дают cardinality для столбцов: гистограммы, MCV, n_distinct. На их основе оценивается selectivity предикатов и размер промежуточных наборов. Если статистики устарели или коррелированные предикаты — план кривой. Решения: ANALYZE, увеличить default_statistics_target, CREATE STATISTICS для функциональных зависимостей.',
                'code_example' => '-- multivariate statistics для коррелированных колонок
CREATE STATISTICS orders_corr (dependencies)
ON status, payment_method FROM orders;
ANALYZE orders;',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Database',
                'question' => 'Что такое CAP-теорема и как она применяется в выборе БД?',
                'answer' => 'CAP: при network partition распределённая система может обеспечить либо Consistency, либо Availability — не оба. Single-leader RDBMS (Postgres, MySQL) — CP: при потере связи с мастером пишущая сторона недоступна. Cassandra/DynamoDB — AP: всегда отвечают, но возможна eventual consistency. Реальные системы тонко настраиваются: Postgres с synchronous_standby даёт сильнее C, ослабляет A; Cassandra QUORUM — компромисс. PACELC расширяет CAP, добавляя trade-off latency vs consistency без partition.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'Database',
                'question' => 'Что такое write skew и приведите пример из реального приложения.',
                'answer' => 'Write skew — две транзакции читают пересекающийся набор строк, принимают решение на основе snapshot и пишут разные строки, нарушая инвариант. Классический пример: дежурство врачей. Две транзакции видят, что дежурят 2 человека, и одновременно "уходят домой" — оба отметят off-call, нарушив правило "минимум один". REPEATABLE READ не ловит write skew, нужен SERIALIZABLE или SELECT FOR UPDATE на конфликтующие строки.',
                'code_example' => '-- защита через SELECT FOR UPDATE
BEGIN;
SELECT count(*) FROM doctors WHERE on_call = true FOR UPDATE;
-- если > 1, можно отключиться
UPDATE doctors SET on_call = false WHERE id = :me;
COMMIT;',
                'code_language' => 'sql',
            ],
            [
                'category' => 'Database',
                'question' => 'Как реализовать поиск с пагинацией без OFFSET и почему OFFSET плохой?',
                'answer' => 'OFFSET N сканирует и отбрасывает первые N строк — стоимость линейная, на 10-й странице запрос медленнее, чем на 1-й, при том же limit. Keyset (cursor) пагинация использует значение последней увиденной строки в WHERE и ORDER BY: WHERE (created_at, id) < (:last_at, :last_id). Стоимость стабильна и низкая при индексе на (created_at, id). Минус — нельзя прыгнуть на конкретную страницу, только next/prev.',
                'code_example' => '-- keyset pagination
SELECT id, title, created_at FROM posts
WHERE (created_at, id) < (:cursor_at, :cursor_id)
ORDER BY created_at DESC, id DESC
LIMIT 20;',
                'code_language' => 'sql',
            ],

            // ===== System Design =====
            [
                'category' => 'System Design',
                'question' => 'Спроектируйте rate limiter на 1000 RPS на пользователя. Какие алгоритмы и хранилища выберете?',
                'answer' => 'Sliding window log — точный, но дорогой по памяти. Sliding window counter — компромисс точности и памяти. Token bucket — поддерживает всплески, классика для API. Хранилище — Redis с атомарными INCR/EXPIRE и Lua-скриптом для атомарности проверки и обновления. Для распределённого ratelimit с low-latency — локальный counter с периодической синхронизацией (sloppy counter). Ключи: user-id или api-key, TTL = окно. Ответ: 429 + Retry-After + X-RateLimit-Remaining headers.',
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
                'category' => 'System Design',
                'question' => 'Как спроектировать URL shortener на миллиарды записей?',
                'answer' => 'Генерация: base62 от автоинкремента (читаемо, коллизий нет, но предсказуемо) или хеш URL+random salt + проверка уникальности. Хранилище: K/V (DynamoDB, Cassandra) или sharded RDBMS по hash(short). Запись редкая, чтение очень частое — кэш Redis перед БД, hit ratio 95%+. CDN для редиректов с Cache-Control. Аналитика — асинхронный поток в Kafka, агрегаты раз в N минут. Для кастомных alias — UNIQUE-индекс на short и реакция на conflict.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'System Design',
                'question' => 'В чём разница между cache-aside, write-through и write-behind?',
                'answer' => 'Cache-aside: приложение само читает кэш, при промахе читает БД и заполняет кэш. Запись напрямую в БД, кэш инвалидируется. Простота и надёжность, но возможна stale data при гонке. Write-through: запись идёт через кэш в БД синхронно — кэш всегда консистентен, но запись медленнее. Write-behind: запись в кэш, асинхронно flush в БД — самая быстрая, но при падении кэша теряются данные. Cache-aside — дефолт для веба; write-behind — для high-throughput с допустимой потерей.',
                'code_example' => '<?php
// cache-aside на Laravel
$user = Cache::remember("user:$id", 3600, fn() => User::find($id));
// при обновлении
$user->save();
Cache::forget("user:$id");',
                'code_language' => 'php',
            ],
            [
                'category' => 'System Design',
                'question' => 'Что такое idempotency key и как реализовать его в платежах?',
                'answer' => 'Idempotency key — уникальный токен от клиента, гарантирующий, что повторный POST не выполнит операцию дважды. Сервер хранит маппинг ключ → результат с TTL (например, 24ч). При повторе с тем же ключом возвращает кэшированный ответ, не вызывая внешний gateway. Реализация: уникальный индекс по ключу + транзакция, либо Redis SET NX EX. Полезно для платежей, заказов и любых операций с сетевыми ретраями.',
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
                'category' => 'System Design',
                'question' => 'Чем at-least-once отличается от exactly-once в очередях и достижим ли exactly-once на практике?',
                'answer' => 'At-least-once: сообщение точно доставится один или больше раз — стандарт в SQS, Kafka, RabbitMQ. Exactly-once строго в распределённой системе невозможно (Two Generals problem). На практике достигается комбинацией at-least-once + идемпотентного потребителя (dedup по message-id) — это называется "effectively-once". Kafka даёт transactional EOS внутри своих топиков, но при выходе наружу ответственность ложится на consumer.',
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
                'category' => 'System Design',
                'question' => 'Когда event sourcing уместен и какие у него подводные камни?',
                'answer' => 'Event sourcing: вместо текущего состояния хранится последовательность событий; состояние получается их сверткой. Уместен в доменах с богатой историей (банкинг, аудит, медицина), для аналитики "почему" и для восстановления состояния на любую точку. Минусы: сложность, проекции/read-models надо строить отдельно, миграции схемы событий тяжёлые (нужен upcasting), нельзя удалять события без compensating event-а — конфликт с GDPR требует crypto-shredding.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'System Design',
                'question' => 'Какие стратегии шардинга есть и в чём их компромиссы?',
                'answer' => 'Range sharding (по диапазонам ключей) — простой routing, но горячие шарды на свежих данных. Hash sharding — равномерное распределение, но range-запросы становятся scatter-gather. Consistent hashing — добавление/удаление узла перемещает только малую долю ключей, идеален для memcached/Cassandra. Directory-based — отдельный lookup-сервис, гибко, но точка отказа. Главный compromise: легко балансировать или легко делать range queries, не оба сразу.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'System Design',
                'question' => 'Зачем нужна CDN перед приложением и какие нюансы при работе с динамикой?',
                'answer' => 'CDN кэширует статику (изображения, JS/CSS) близко к пользователю — снижает latency и нагрузку на origin. Для динамики используют edge-кэш с коротким TTL и cache-key по нормализованному URL без cookies. Stale-while-revalidate отдаёт чуть устаревший ответ, пока на фоне обновляется. Surrogate-Control + tag-based purge (Fastly, Cloudflare) позволяют точечно инвалидировать. Важно: avoid Vary: Cookie без необходимости — он рушит cache-hit ratio.',
                'code_example' => 'Cache-Control: public, max-age=60, s-maxage=300, stale-while-revalidate=600
Surrogate-Key: user-123 product-42',
                'code_language' => 'bash',
            ],
        ];
    }
}
