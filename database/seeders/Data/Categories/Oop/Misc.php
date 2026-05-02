<?php

namespace Database\Seeders\Data\Categories\Oop;

class Misc
{
    public static function all(): array
    {
        return [
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 2,
                'question' => 'Что такое final-классы и методы?',
                'answer' => 'Ключевое слово final запрещает наследование класса и/или переопределение метода. final class - от него нельзя наследоваться. final method - его нельзя переопределить в потомках. Используется для защиты дизайна: явно показывает, что класс/метод не предназначен для расширения. Помогает избежать неожиданных проблем с LSP и инкапсуляцией. Совет от Effective Java/Sandi Metz: "по умолчанию делайте классы final, наследование разрешайте осознанно".',
                'code_example' => '<?php
final class Money
{
    // от этого класса нельзя наследоваться
}

class Service
{
    final public function critical(): void
    {
        // нельзя переопределить в потомках
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Что такое магические методы в PHP?',
                'answer' => 'Магические методы - специальные методы PHP, начинающиеся с двух подчёркиваний. Они вызываются автоматически в определённых ситуациях. Основные: __construct/__destruct, __get/__set/__isset/__unset (для свойств), __call/__callStatic (для несуществующих методов), __toString, __invoke (вызов объекта как функции), __clone (клонирование), __sleep/__wakeup, __serialize/__unserialize. Используются осторожно: они скрывают поведение и усложняют отладку.',
                'code_example' => '<?php
class Container
{
    private array $data = [];

    public function __get(string $name): mixed
    {
        return $this->data[$name] ?? null;
    }
    public function __set(string $name, mixed $value): void
    {
        $this->data[$name] = $value;
    }
    public function __invoke(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }
}

$c = new Container();
$c->foo = 42;     // __set
echo $c->foo;     // __get
echo $c(\'foo\'); // __invoke',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Что такое late static binding (позднее статическое связывание)?',
                'answer' => 'Late Static Binding (LSB) - механизм PHP, позволяющий ссылаться на фактический класс, на котором был вызван статический метод (а не на класс, где он объявлен). Реализуется через ключевое слово static. self ссылается на класс, где написан код (раннее связывание), static - на класс, по которому идёт вызов. LSB важен для фабричных методов и Active Record.',
                'code_example' => '<?php
class Model
{
    public static function create(): static
    {
        return new static(); // создастся фактический класс
    }
}

class User extends Model {}

$u = User::create(); // вернёт User, а не Model',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 2,
                'question' => 'Что такое анонимный класс?',
                'answer' => 'Анонимный класс (anonymous class) - класс без имени, объявленный и инстанцированный одним выражением. Появился в PHP 7.0. Удобен для одноразовых реализаций интерфейсов (например, для тестов или мелких mock-объектов), для inline-стратегий, без создания отдельного файла.',
                'code_example' => '<?php
interface Logger {
    public function log(string $m): void;
}

function doWork(Logger $logger): void
{
    $logger->log(\'work\');
}

doWork(new class implements Logger {
    public function log(string $m): void
    {
        echo $m;
    }
});',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Чем агрегация отличается от композиции?',
                'answer' => 'Оба отношения - "часть-целое" (has-a), но: Композиция (сильная) - часть не существует без целого, целое управляет жизненным циклом части (например, дом и комнаты - удалили дом, удалились комнаты). Агрегация (слабая) - часть может существовать самостоятельно, целое лишь использует её (например, университет и студенты - универ закрылся, студенты остались). В коде разница часто в том, кто создаёт зависимость: при композиции - внутри объекта, при агрегации - передаётся снаружи (DI).',
                'code_example' => '<?php
// Композиция: Engine создаётся внутри Car, живёт с ним
class Car
{
    private Engine $engine;
    public function __construct()
    {
        $this->engine = new Engine();
    }
}

// Агрегация: Driver передаётся снаружи, может ездить на разных машинах
class Vehicle
{
    public function __construct(private Driver $driver) {}
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Что такое immutable объект?',
                'answer' => 'Immutable (неизменяемый) объект - объект, состояние которого нельзя изменить после создания. Любые операции, которые "меняют" его, на самом деле возвращают новый объект. Плюсы: безопасность в многопоточных средах, можно использовать как ключ в кешах, проще отлаживать (значение не меняется), исключает баги из-за случайного изменения. В PHP 8.1+ удобно делать через readonly. Классический пример - Value Objects, DateTimeImmutable.',
                'code_example' => '<?php
final readonly class Point
{
    public function __construct(
        public float $x,
        public float $y,
    ) {}

    public function moveX(float $dx): self
    {
        // не меняем this, возвращаем новый
        return new self($this->x + $dx, $this->y);
    }
}

$p1 = new Point(1, 2);
$p2 = $p1->moveX(5); // p1 не изменился',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Что такое DTO (Data Transfer Object)?',
                'answer' => 'DTO (объект передачи данных) - простой объект для переноса данных между слоями приложения. Содержит только публичные свойства (или геттеры) без бизнес-логики. Часто иммутабелен. Используется на границах: API-запрос/ответ, передача данных из контроллера в сервис, между микросервисами. В PHP 8 удобно через readonly + constructor promotion. Не путать с Value Object: VO имеет валидацию и поведение, DTO - просто данные.',
                'code_example' => '<?php
final readonly class CreateUserDto
{
    public function __construct(
        public string $name,
        public string $email,
        public int $age,
    ) {}
}

class UserController
{
    public function create(Request $r): void
    {
        $dto = new CreateUserDto(
            $r->input(\'name\'),
            $r->input(\'email\'),
            (int) $r->input(\'age\'),
        );
        $this->service->create($dto);
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 4,
                'question' => 'Что такое covariance и contravariance в PHP?',
                'answer' => 'Covariance (ковариантность) - возможность переопределить метод в потомке так, чтобы он возвращал более специфичный тип, чем метод родителя. Contravariance (контравариантность) - возможность принимать в потомке более общий тип параметра, чем в родителе. Поддержаны в PHP 7.4+. Это делает систему типов более гибкой и помогает соблюдать LSP. Параметры - контравариантны, возвращаемые значения - ковариантны.',
                'code_example' => '<?php
class Animal {}
class Dog extends Animal {}

class Shelter
{
    public function adopt(): Animal { return new Animal(); }
}

class DogShelter extends Shelter
{
    // ковариантность: возвращаем более конкретный тип
    public function adopt(): Dog { return new Dog(); }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Что такое перегрузка методов (method overloading) и есть ли она в PHP?',
                'answer' => 'Перегрузка методов - возможность объявить в одном классе несколько методов с одинаковым именем, но разными сигнатурами (например, разное число параметров). В PHP перегрузки в классическом смысле НЕТ - нельзя объявить два метода с одним именем. Имитировать можно: 1) Через переменное число аргументов и func_get_args. 2) Через типизированные параметры с union types. 3) Через __call. 4) Через именованные аргументы (PHP 8). Часто роль перегрузки играют именованные конструкторы (static-фабрики).',
                'code_example' => '<?php
class Money
{
    private function __construct(public int $amount, public string $currency) {}

    // именованные "конструкторы" вместо перегрузки
    public static function fromCents(int $cents, string $cur): self
    {
        return new self($cents, $cur);
    }
    public static function fromDollars(float $dollars): self
    {
        return new self((int)($dollars * 100), \'USD\');
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 4,
                'question' => 'Что такое Open Recursion и проблема fragile base class?',
                'answer' => 'Open recursion - когда метод родительского класса вызывает другой метод того же объекта (через $this), и потомок может переопределить этот метод, изменив поведение базового. Это даёт гибкость, но порождает проблему fragile base class (хрупкий базовый класс): изменения в родителе могут сломать потомков, потому что они зависят от внутренних вызовов методов. Снижает инкапсуляцию. Решения: помечать "хук-методы" final или выносить через композицию (Strategy/Template Method с явными шагами).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Что такое typed properties и какие есть типы в PHP?',
                'answer' => 'С PHP 7.4 свойства класса можно типизировать. Поддерживаются: скаляры (int, float, string, bool), массивы (array), объекты (классы и интерфейсы), iterable, callable (только для параметров), nullable (?string), self/parent/static, union types (int|string, PHP 8), intersection types (Foo&Bar, PHP 8.1), never (PHP 8.1, только возвращаемый), mixed (PHP 8). Типизированное свойство по умолчанию uninitialized - доступ к нему до инициализации бросит Error.',
                'code_example' => '<?php
class Profile
{
    public string $name;            // обязательно инициализировать
    public ?int $age = null;        // nullable со значением по умолчанию
    public array $tags = [];
    public int|string $id;          // union
    public Countable&Iterator $col; // intersection (PHP 8.1)
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Что такое Active Record vs Data Mapper?',
                'answer' => 'Active Record - паттерн, в котором объект представляет строку в БД и сам умеет себя сохранять/удалять/искать ($user->save()). Плюсы: просто, удобно для CRUD. Минусы: смешивает доменную логику и инфраструктуру, нарушает SRP, сложнее тестировать. Пример - Eloquent в Laravel. Data Mapper - паттерн, в котором есть отдельный объект-маппер, который перекладывает данные между объектами и БД ($mapper->save($user)). Объект домена не знает о хранилище. Лучше для DDD и сложной логики. Пример - Doctrine.',
                'code_example' => '<?php
// Active Record (Eloquent)
$user = new User();
$user->name = \'Иван\';
$user->save(); // объект сам пишет в БД

// Data Mapper (Doctrine)
$user = new User(\'Иван\'); // чистый POPO
$entityManager->persist($user);
$entityManager->flush(); // маппер пишет в БД',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Что такое Null Object паттерн?',
                'answer' => 'Null Object - объект, имитирующий поведение "ничего" вместо null. Это позволяет избежать проверок на null в клиентском коде. Реализует тот же интерфейс, что и реальный объект, но методы возвращают пустые/нейтральные значения. Например, NullLogger ничего не пишет; NullUser - анонимный гость с пустыми правами. Делает код чище и безопаснее.',
                'code_example' => '<?php
interface Logger
{
    public function log(string $m): void;
}

class FileLogger implements Logger
{
    public function log(string $m): void { /* пишем */ }
}

class NullLogger implements Logger
{
    public function log(string $m): void { /* ничего */ }
}

class Service
{
    public function __construct(private Logger $logger = new NullLogger()) {}
    public function run(): void
    {
        $this->logger->log(\'work\'); // не нужно if($this->logger)
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 1,
                'question' => 'YAGNI, KISS, DRY - что это?',
                'answer' => 'Это базовые принципы хорошего кода. DRY (Don\'t Repeat Yourself) - не повторяйся: одно знание - в одном месте. Дублирование логики - источник багов при правках. KISS (Keep It Simple, Stupid) - делайте проще: не усложняйте, пока не нужно. Простой код легче читать и поддерживать. YAGNI (You Aren\'t Gonna Need It) - не пишите код "на будущее" в надежде, что пригодится. Чаще всего не пригодится, а лишний код придётся поддерживать. Принципы взаимодополняют SOLID.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 4,
                'question' => 'Что такое cohesion на уровне модулей и классов?',
                'answer' => 'Cohesion (сплочённость) показывает, насколько элементы внутри одного модуля связаны общей целью. Высокая cohesion - класс делает одно дело и делает его хорошо. Низкая - класс мешает разнородные функции. Виды (от плохой к хорошей): coincidental (случайная), logical (функции одной категории), temporal (вызываются вместе), procedural (выполняются последовательно), communicational (работают с одними данными), sequential (выход одного - вход другого), functional (всё для одной задачи) - идеал. Высокая cohesion - следствие SRP.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 4,
                'question' => 'Что такое coupling на уровне модулей и классов?',
                'answer' => 'Coupling (зацепление, связанность) показывает, насколько модули зависят друг от друга. Виды от плохого к хорошему: content (один модуль лезет во внутренности другого), common (общие глобальные данные), control (один управляет логикой другого через флаги), stamp (передают сложные структуры, но используют только часть), data (передают только нужные параметры), message coupling (взаимодействие только через интерфейсы) - идеал. Низкое coupling - результат DIP, ISP, инкапсуляции и Law of Demeter.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Сформулируйте принцип Лисков и приведите пример его нарушения на квадрате и прямоугольнике.',
                'answer' => 'LSP: объекты подкласса должны быть замещаемы объектами базового без нарушения корректности программы. Классический контрпример: Square наследует Rectangle и переопределяет setWidth/setHeight, чтобы стороны были равны. Клиент, написанный для Rectangle, ожидает независимости измерений (после setWidth(5);setHeight(10) площадь=50). Со Square площадь будет 100. Решение - выделить интерфейс Shape с area() и не наследовать Square от Rectangle.',
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
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'В чём разница между Dependency Injection и Service Locator и почему DI обычно лучше?',
                'answer' => 'DI: зависимости передаются явно через конструктор/сеттер; класс не знает о контейнере. Service Locator: класс получает контейнер и сам запрашивает зависимости. SL скрывает реальные зависимости, мешает тестированию (надо мокать контейнер), создаёт неявную связность с фреймворком. DI делает зависимости частью сигнатуры - они видны в коде и в типах, легко мокаются. SL допустим как escape hatch в фреймворковых местах вроде middleware-фабрик.',
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
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Что такое Interface Segregation Principle и как он соотносится с "fat interfaces"?',
                'answer' => 'ISP: клиент не должен зависеть от методов интерфейса, которыми не пользуется. "Толстый" интерфейс заставляет реализаторов писать заглушки, а потребителей - игнорировать ненужные методы, что усложняет рефакторинг. Решение - разбить интерфейс на ролевые: Readable/Writable, Authenticatable/Authorizable. Признак нарушения - методы вроде throw new BadMethodCallException("not supported") в реализациях.',
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
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Чем Strategy отличается от State и приведите кейс для каждого.',
                'answer' => 'Strategy инкапсулирует взаимозаменяемые алгоритмы, выбирается клиентом и обычно не меняется на лету: например, разные алгоритмы расчёта налога. State моделирует поведение объекта в зависимости от внутреннего состояния и переключает само себя: Order переходит pending → paid → shipped, и каждое состояние имеет свой набор разрешённых действий. Структурно паттерны похожи (композиция + полиморфизм), различие - в семантике переходов: в Strategy объекты-стратегии stateless, в State объект-состояние сам выбирает следующее.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 4,
                'question' => 'Что такое value object, чем он отличается от сущности и какие у него инварианты?',
                'answer' => 'Value object - объект, идентичность которого определяется значением полей; равенство - структурное. Иммутабелен и валидирует инварианты в конструкторе. Не имеет ID, в отличие от entity. Примеры: Money, Email, DateRange. Любое изменение даёт новый объект (with* методы). Польза: ловим невалидные значения в момент создания, делаем сигнатуры самодокументируемыми, упрощаем тесты.',
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
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 4,
                'question' => 'Что такое Aggregate Root в DDD и зачем он нужен?',
                'answer' => 'Aggregate - кластер связанных объектов, который трактуется как единое целое для изменений. У агрегата есть Aggregate Root - единственная сущность, через которую внешние объекты обращаются к содержимому. Root охраняет инварианты всего агрегата и является границей транзакции. Внешние агрегаты ссылаются на root по идентификатору, а не по объекту. Это упрощает консистентность и позволяет масштабировать (один агрегат - одна транзакция).',
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
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 4,
                'question' => 'Чем отличается Factory Method от Abstract Factory?',
                'answer' => 'Factory Method - метод (часто абстрактный) в классе-создателе, возвращающий продукт; используется для одного семейства, подклассы переопределяют метод. Abstract Factory - объект-фабрика, создающий несколько связанных продуктов одного "семейства" (UI для Material/Cupertino: Button + Checkbox + Menu). FM решает "какой класс инстанцировать", AF - "какое семейство объектов согласованно создать".',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Что такое Open/Closed Principle и как его реализовать без наследования через композицию?',
                'answer' => 'OCP: модули открыты для расширения, закрыты для изменения. Добавление нового поведения не должно требовать правок существующего кода. Через наследование это делает Template Method, через композицию - Strategy/полиморфизм по интерфейсу. Например, чтобы поддержать новый тип скидки, не правим if-цепочку Calculator, а добавляем класс, реализующий DiscountRule, и регистрируем его в коллекции.',
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
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Когда применять паттерн Decorator и чем он отличается от наследования?',
                'answer' => 'Decorator оборачивает объект, реализующий тот же интерфейс, и добавляет поведение до/после вызова, не меняя оригинал. Можно компоновать множество декораторов рантайм. Наследование фиксируется на этапе компиляции и взрывается комбинаторно при многих ортогональных фичах (LoggingCachedAuthRepository...). Decorator решает это: каждое поведение - отдельный декоратор, выстраиваются цепочкой через DI.',
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
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 4,
                'question' => 'В чём суть паттерна Specification и зачем он нужен в репозиториях?',
                'answer' => 'Specification инкапсулирует условие выборки/проверки в виде объекта. Спецификации комбинируются через and/or/not, переиспользуются между фильтрацией коллекций и SQL-выборкой. В репозиториях это избавляет от десятков методов вроде findActiveUsersOlderThan(). В Eloquent аналог - query scopes; для сложных фильтров со множеством параметров Specification читаемее.',
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
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 4,
                'question' => 'Что такое anemic domain model и почему её считают анти-паттерном?',
                'answer' => 'Anemic model - сущности без поведения, только геттеры/сеттеры; вся логика вытекает в "сервисы". Внешне OO, по сути - процедурный код, нарушающий инкапсуляцию: инварианты можно нарушить через сеттеры, бизнес-правила распыляются по сервисам. Лекарство - rich model: методы, изменяющие состояние, проверяют инварианты. Сеттеры заменяются доменными операциями типа Order::pay(), Order::cancel().',
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
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 4,
                'question' => 'Что такое CQRS и какие проблемы он решает?',
                'answer' => 'Command Query Responsibility Segregation - разделение модели чтения и записи. Команды меняют состояние, не возвращают данных; запросы читают, не меняют. Преимущества: разные модели позволяют оптимизировать чтение (денормализованные read-models, кэш) отдельно от записи (агрегаты, инварианты). Часто сочетается с event sourcing. Минус - сложность и eventual consistency между read- и write-моделями; для типового CRUD-приложения это overkill.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Чем композиция предпочтительнее наследования и в каких случаях наследование оправдано?',
                'answer' => 'Композиция - has-a, делегирование зависимостям, динамическая замена через DI, плоская иерархия. Наследование - is-a, фиксируется в compile-time, тянет всю реализацию родителя, ломается при изменении базы (fragile base class). Наследование оправдано при настоящем подтипе с LSP (Square→Shape, нет), при шаблонном методе с общим алгоритмом и при использовании framework hooks (extends FormRequest). В прикладной логике - почти всегда композиция.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.misc',
                'difficulty' => 3,
                'question' => 'Что такое инверсия зависимостей (DIP) и чем она отличается от инъекции зависимостей (DI)?',
                'answer' => 'DIP - принцип проектирования: модули верхнего уровня не зависят от модулей нижнего уровня; оба зависят от абстракций. Абстракции не должны зависеть от деталей. DI - техника реализации DIP: передача зависимостей извне. DIP может быть выполнен и без DI (например, через локатор), но без зависимости на абстракцию. Часто говорят "DIP на интерфейсе, DI в конструкторе".',
                'code_example' => '<?php
// DIP: NotificationService зависит от абстракции
interface Channel { public function send(Message $m): void; }
class NotificationService {
    public function __construct(private Channel $ch) {} // DI
}
class SmsChannel implements Channel { /* low-level */ }',
                'code_language' => 'php',
            ],
        ];
    }
}
