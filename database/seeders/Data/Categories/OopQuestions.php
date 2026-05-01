<?php

namespace Database\Seeders\Data\Categories;

class OopQuestions
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example: ?string, code_language: ?string}>
     */
    public static function all(): array
    {
        return [
            // ===== Базовые понятия =====
            [
                'category' => 'ООП',
                'question' => 'Что такое ООП?',
                'answer' => 'ООП (объектно-ориентированное программирование) - это парадигма программирования, в которой программа моделируется как набор взаимодействующих объектов. Каждый объект - это сущность, которая имеет состояние (свойства) и поведение (методы). ООП помогает структурировать код, переиспользовать его и моделировать предметную область реального мира в коде.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'question' => 'Какие основные парадигмы программирования существуют?',
                'answer' => 'Основные парадигмы: 1) Императивная (пошаговое описание команд) - например, процедурное программирование. 2) Декларативная (описание что нужно, а не как) - SQL, функциональная. 3) ООП (объектно-ориентированная) - программа как набор объектов. 4) Функциональная - программа как композиция чистых функций. 5) Логическая - на основе логических утверждений (Prolog). PHP поддерживает несколько парадигм одновременно.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'question' => 'Зачем нужно ООП?',
                'answer' => 'ООП решает проблемы сложности больших программ: 1) Структурирует код в логические блоки (классы). 2) Повторное использование кода через наследование и композицию. 3) Инкапсуляция скрывает детали реализации. 4) Полиморфизм позволяет менять поведение без переписывания кода. 5) Близость к реальному миру - проще моделировать домен. 6) Тестируемость - легче изолировать модули. 7) Командная разработка - чёткое разделение ответственностей.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое класс?',
                'answer' => 'Класс - это шаблон (чертёж), описывающий структуру и поведение объектов. В классе определяются свойства (данные) и методы (действия). Сам по себе класс - это не объект, а описание того, какими будут его экземпляры. Аналогия: класс - это чертёж дома, а объект - это конкретный построенный дом.',
                'code_example' => '<?php
class User
{
    public string $name;
    public int $age;

    public function greet(): string
    {
        return \'Привет, я \' . $this->name;
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое объект?',
                'answer' => 'Объект - это конкретный экземпляр класса, существующий в памяти. У каждого объекта своё состояние (значения свойств), но поведение (методы) общее, заданное классом. Объект создаётся через оператор new. У одного класса может быть множество объектов, каждый со своими данными.',
                'code_example' => '<?php
$user1 = new User();
$user1->name = \'Иван\';

$user2 = new User();
$user2->name = \'Мария\';

// Это два разных объекта одного класса
echo $user1->greet(); // Привет, я Иван
echo $user2->greet(); // Привет, я Мария',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Чем класс отличается от объекта?',
                'answer' => 'Класс - это описание (тип, шаблон), а объект - это конкретный экземпляр класса в памяти. Класс существует на этапе компиляции/определения, объект - во время выполнения. Класс один, объектов может быть много. Аналогия: класс Cat - это понятие "кошка вообще", а объект - это конкретная кошка Мурка с её цветом, возрастом, именем.',
                'code_example' => '<?php
// Класс - описание
class Cat
{
    public string $name;
}

// Объекты - конкретные экземпляры
$murka = new Cat();
$murka->name = \'Мурка\';

$barsik = new Cat();
$barsik->name = \'Барсик\';',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое метод?',
                'answer' => 'Метод - это функция, объявленная внутри класса. Метод описывает поведение объектов класса и обычно работает с их данными (свойствами). Методы вызываются через объект (->) или через имя класса (::) для статических методов. Метод - это та же функция, но привязанная к классу и имеющая доступ к $this.',
                'code_example' => '<?php
class Calculator
{
    public function add(int $a, int $b): int
    {
        return $a + $b;
    }
}

$calc = new Calculator();
echo $calc->add(2, 3); // 5',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое свойство?',
                'answer' => 'Свойство (property, поле) - это переменная, объявленная внутри класса. Свойство хранит данные конкретного объекта. У каждого объекта свой набор значений свойств, но имена и типы свойств описаны в классе. С PHP 7.4 свойства можно типизировать.',
                'code_example' => '<?php
class Product
{
    public string $name;
    public float $price;
    public int $quantity = 0; // значение по умолчанию
}

$p = new Product();
$p->name = \'Книга\';
$p->price = 599.99;',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое $this в PHP?',
                'answer' => '$this - это специальная псевдо-переменная, которая внутри метода ссылается на текущий объект (тот, на котором был вызван метод). Через $this можно обращаться к свойствам и методам этого же объекта. $this существует только внутри нестатических методов класса. В статических методах $this недоступен - вместо него используется self или static.',
                'code_example' => '<?php
class User
{
    public string $name;

    public function setName(string $name): void
    {
        $this->name = $name; // $this - это сам объект
    }

    public function getName(): string
    {
        return $this->name;
    }
}',
                'code_language' => 'php',
            ],

            // ===== 4 принципа ООП =====
            [
                'category' => 'ООП',
                'question' => 'Какие 4 основных принципа ООП?',
                'answer' => '4 столпа ООП: 1) Инкапсуляция - сокрытие внутреннего состояния и предоставление контролируемого доступа через методы. 2) Наследование - создание новых классов на основе существующих, переиспользуя их код. 3) Полиморфизм - возможность объектов разных классов реагировать на одинаковые вызовы по-разному. 4) Абстракция - выделение существенных характеристик объекта и сокрытие несущественных деталей.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое инкапсуляция?',
                'answer' => 'Инкапсуляция - это объединение данных и методов работы с ними в одном классе плюс ограничение прямого доступа к внутреннему состоянию объекта. Внешний код не видит "внутренностей" и работает только через публичный интерфейс. Это защищает данные от некорректного использования и позволяет менять реализацию без поломки клиентов. В PHP реализуется через модификаторы public/protected/private.',
                'code_example' => '<?php
class BankAccount
{
    private float $balance = 0;

    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException(\'Сумма должна быть положительной\');
        }
        $this->balance += $amount;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }
}
// Напрямую $balance изменить нельзя - только через deposit()',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое наследование?',
                'answer' => 'Наследование - механизм, позволяющий создать новый класс (потомок, дочерний) на основе существующего (родительского). Потомок получает все public/protected свойства и методы родителя и может добавлять свои или переопределять родительские. В PHP наследование одиночное (один класс может наследовать только один родительский класс), но можно реализовывать множество интерфейсов и подключать множество трейтов.',
                'code_example' => '<?php
class Animal
{
    public function eat(): string
    {
        return \'ест\';
    }
}

class Dog extends Animal
{
    public function bark(): string
    {
        return \'гав!\';
    }
}

$dog = new Dog();
echo $dog->eat();  // ест (унаследовано)
echo $dog->bark(); // гав!',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое полиморфизм?',
                'answer' => 'Полиморфизм (от греч. "много форм") - возможность объектов разных классов обрабатываться единообразно через общий интерфейс. Простыми словами: один и тот же вызов метода может приводить к разному поведению в зависимости от конкретного класса объекта. В PHP реализуется через наследование и интерфейсы. Это даёт расширяемость: можно добавлять новые типы без изменения старого кода.',
                'code_example' => '<?php
interface Shape
{
    public function area(): float;
}

class Circle implements Shape
{
    public function __construct(private float $r) {}
    public function area(): float
    {
        return M_PI * $this->r ** 2;
    }
}

class Square implements Shape
{
    public function __construct(private float $side) {}
    public function area(): float
    {
        return $this->side ** 2;
    }
}

function printArea(Shape $s): void
{
    echo $s->area(); // вызов один, поведение разное
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое абстракция?',
                'answer' => 'Абстракция - выделение в объекте только существенных для решаемой задачи свойств и поведения, игнорируя несущественные детали. Простыми словами: вы пользуетесь автомобилем через руль, педали и КПП, не зная, как устроен двигатель внутри. В коде абстракция реализуется через классы, абстрактные классы и интерфейсы, которые описывают "что делает объект", скрывая "как он это делает".',
                'code_example' => '<?php
// Абстракция: интерфейс описывает контракт без деталей
interface PaymentGateway
{
    public function pay(float $amount): bool;
}

// Конкретные реализации скрывают детали
class StripeGateway implements PaymentGateway
{
    public function pay(float $amount): bool
    {
        // вся сложная логика Stripe API скрыта
        return true;
    }
}',
                'code_language' => 'php',
            ],

            // ===== Видимость =====
            [
                'category' => 'ООП',
                'question' => 'Какие модификаторы видимости есть в PHP?',
                'answer' => 'В PHP три модификатора видимости: 1) public - доступен везде (внутри класса, потомках, снаружи). 2) protected - доступен только внутри класса и его потомков. 3) private - доступен только внутри объявившего класса (даже потомки не видят). По умолчанию (если не указан) свойство/метод имеет видимость public. С PHP 8.4 появились asymmetric visibility для свойств (например, public read, private write).',
                'code_example' => '<?php
class Example
{
    public string $publicProp = \'видно везде\';
    protected string $protectedProp = \'видно в классе и потомках\';
    private string $privateProp = \'видно только в этом классе\';

    public function show(): void { /* доступ ко всем трём */ }
}

$e = new Example();
echo $e->publicProp;    // OK
// echo $e->privateProp; // Fatal error',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'В чём разница между protected и private?',
                'answer' => 'protected - свойство/метод доступно внутри объявившего класса И всех его потомков. private - доступно ТОЛЬКО внутри того класса, где объявлено, потомки его не видят. Используйте private для деталей реализации, которые не должны меняться даже в наследниках. protected - когда хотите дать потомкам доступ для расширения. На практике private чаще предпочтительнее: меньше связности.',
                'code_example' => '<?php
class Base
{
    private string $secret = \'тайна\';
    protected string $shared = \'для потомков\';
}

class Child extends Base
{
    public function test(): void
    {
        echo $this->shared; // OK
        // echo $this->secret; // Ошибка - private недоступен
    }
}',
                'code_language' => 'php',
            ],

            // ===== Конструктор и деструктор =====
            [
                'category' => 'ООП',
                'question' => 'Что такое конструктор?',
                'answer' => 'Конструктор - специальный метод __construct(), который вызывается автоматически при создании объекта через new. Используется для инициализации свойств объекта. С PHP 8.0 есть constructor property promotion - можно объявлять свойства прямо в параметрах конструктора, что сокращает бойлерплейт. Конструктор может принимать параметры; если родитель имеет свой конструктор, потомок может вызвать его через parent::__construct().',
                'code_example' => '<?php
// Старый стиль
class UserOld
{
    public string $name;
    public int $age;

    public function __construct(string $name, int $age)
    {
        $this->name = $name;
        $this->age = $age;
    }
}

// PHP 8+ promotion
class User
{
    public function __construct(
        public string $name,
        public int $age,
    ) {}
}

$u = new User(\'Иван\', 30);',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое деструктор?',
                'answer' => 'Деструктор - метод __destruct(), который вызывается автоматически при уничтожении объекта (когда на него больше нет ссылок или скрипт завершается). Используется для освобождения ресурсов: закрытия файлов, соединений, очистки кешей. В PHP с автоматическим управлением памятью деструкторы используются реже, чем в C++. Не гарантируется порядок вызова деструкторов; в деструкторе нельзя бросать исключения.',
                'code_example' => '<?php
class FileLogger
{
    private $handle;

    public function __construct(string $path)
    {
        $this->handle = fopen($path, \'a\');
    }

    public function log(string $msg): void
    {
        fwrite($this->handle, $msg . PHP_EOL);
    }

    public function __destruct()
    {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
    }
}',
                'code_language' => 'php',
            ],

            // ===== Статические методы и свойства =====
            [
                'category' => 'ООП',
                'question' => 'Что такое статические методы и свойства?',
                'answer' => 'Статические методы и свойства принадлежат самому классу, а не его экземплярам. Доступ - через имя класса и оператор :: (Class::method()). Статические свойства одни на весь класс - значение общее для всех. Статические методы не имеют $this, но имеют self/static. Используются для утилитарных функций, фабричных методов, синглтонов, счётчиков. Минусы: усложняют тестирование (тяжело замокать), скрытая глобальная зависимость.',
                'code_example' => '<?php
class Counter
{
    public static int $count = 0;

    public static function increment(): void
    {
        self::$count++;
    }
}

Counter::increment();
Counter::increment();
echo Counter::$count; // 2',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'В чём разница между self, static и parent в PHP?',
                'answer' => 'self - указывает на тот класс, где написан код (раннее связывание). static - указывает на фактический класс вызвавшего объекта (позднее статическое связывание, late static binding). parent - указывает на родительский класс. Различие self/static важно при наследовании и фабричных методах: при new self() всегда создастся объект исходного класса, а при new static() - объект класса-наследника, на котором вызвали метод.',
                'code_example' => '<?php
class A
{
    public static function createSelf(): self
    {
        return new self();
    }
    public static function createStatic(): static
    {
        return new static();
    }
}

class B extends A {}

var_dump(B::createSelf());   // object(A)
var_dump(B::createStatic()); // object(B)',
                'code_language' => 'php',
            ],

            // ===== Абстрактные классы и интерфейсы =====
            [
                'category' => 'ООП',
                'question' => 'Что такое абстрактный класс?',
                'answer' => 'Абстрактный класс - класс, помеченный ключевым словом abstract, который нельзя инстанцировать напрямую. Может содержать как реализованные методы, так и абстрактные (без тела), которые обязаны реализовать потомки. Используется как частичная реализация: общая логика в родителе, специфика в потомках. В PHP класс может наследоваться только от одного абстрактного класса.',
                'code_example' => '<?php
abstract class Shape
{
    abstract public function area(): float;

    public function describe(): string
    {
        return \'Площадь: \' . $this->area();
    }
}

class Circle extends Shape
{
    public function __construct(private float $r) {}
    public function area(): float
    {
        return M_PI * $this->r ** 2;
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое интерфейс?',
                'answer' => 'Интерфейс - это контракт, описывающий какие методы должен иметь класс, но не их реализацию. Класс реализует интерфейс через implements и обязан реализовать все его методы. Интерфейс не имеет свойств (только константы) и не содержит логики. PHP позволяет одному классу реализовывать несколько интерфейсов - это форма множественного наследования контрактов. Интерфейсы - основа полиморфизма и DI.',
                'code_example' => '<?php
interface Loggable
{
    public function log(string $message): void;
}

interface Cacheable
{
    public function getCacheKey(): string;
}

class Service implements Loggable, Cacheable
{
    public function log(string $message): void { /* ... */ }
    public function getCacheKey(): string
    {
        return \'service\';
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'В чём разница между абстрактным классом и интерфейсом?',
                'answer' => 'Абстрактный класс может содержать реализацию методов и свойства, интерфейс - только сигнатуры методов и константы. Класс может наследоваться только от одного абстрактного класса, но реализовывать множество интерфейсов. Абстрактный класс используют, когда нужна общая частичная реализация для группы схожих классов. Интерфейс - когда нужно описать поведение, не привязываясь к иерархии (например, классы из совершенно разных иерархий могут быть Comparable).',
                'code_example' => '<?php
interface Drawable
{
    public function draw(): void; // только контракт
}

abstract class Widget // частичная реализация
{
    public function __construct(protected int $x, protected int $y) {}
    abstract public function render(): string;
    public function position(): string
    {
        return "($this->x, $this->y)";
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Может ли интерфейс содержать константы и свойства?',
                'answer' => 'Интерфейс может содержать константы (public const), но НЕ может содержать свойства (поля). Все методы интерфейса по умолчанию public и абстрактные. С PHP 8.1 константы интерфейсов можно объявлять как final. С PHP 8.4 константы можно типизировать. Для общих свойств между классами обычно используют абстрактный класс или трейт.',
                'code_example' => '<?php
interface HttpStatus
{
    public const OK = 200;
    public const NOT_FOUND = 404;
    final public const SERVER_ERROR = 500;

    public function getStatus(): int;
}',
                'code_language' => 'php',
            ],

            // ===== Трейты =====
            [
                'category' => 'ООП',
                'question' => 'Что такое трейты в PHP?',
                'answer' => 'Трейт - механизм горизонтального переиспользования кода в PHP. Это набор методов и свойств, которые можно "подключить" в класс через use. По сути - копирование кода в класс на этапе компиляции. Решает проблему отсутствия множественного наследования: класс может использовать множество трейтов. Минусы: скрытое поведение, конфликты имён, повышенная связность. Хорошее применение - небольшие переиспользуемые куски (например, HasTimestamps, Macroable).',
                'code_example' => '<?php
trait HasTimestamps
{
    public ?\DateTime $createdAt = null;
    public ?\DateTime $updatedAt = null;

    public function touch(): void
    {
        $this->updatedAt = new \DateTime();
    }
}

class Article
{
    use HasTimestamps;

    public string $title;
}

$a = new Article();
$a->touch();',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Как разрешить конфликты имён при использовании нескольких трейтов?',
                'answer' => 'Если два трейта содержат метод с одинаковым именем, при их одновременном использовании возникнет ошибка. Решение - инструкции insteadof (выбрать какой использовать) и as (создать алиас). Также as позволяет изменить видимость метода. Это сложный механизм, и обычно проще не допускать таких конфликтов.',
                'code_example' => '<?php
trait A {
    public function hello(): string { return \'A\'; }
}
trait B {
    public function hello(): string { return \'B\'; }
}

class C
{
    use A, B {
        A::hello insteadof B; // используем версию из A
        B::hello as helloFromB; // алиас для B
    }
}',
                'code_language' => 'php',
            ],

            // ===== Композиция vs наследование =====
            [
                'category' => 'ООП',
                'question' => 'Композиция vs наследование - что выбрать?',
                'answer' => 'Композиция - объект содержит другие объекты как поля и делегирует им работу. Наследование - класс получает функциональность от родителя через extends. Принцип "Composition over Inheritance" говорит: предпочитайте композицию. Наследование жёстко связывает классы, нарушает инкапсуляцию (потомок зависит от деталей родителя), не подходит для отношений "имеет" (has-a). Используйте наследование для "является" (is-a) и при настоящей иерархии типов.',
                'code_example' => '<?php
// Плохо: наследование там, где нужно владение
class CarBad extends Engine {}

// Хорошо: композиция
class Car
{
    public function __construct(private Engine $engine) {}

    public function start(): void
    {
        $this->engine->run();
    }
}

class Engine
{
    public function run(): void {}
}',
                'code_language' => 'php',
            ],

            // ===== SOLID =====
            [
                'category' => 'ООП',
                'question' => 'Что такое SOLID?',
                'answer' => 'SOLID - 5 принципов проектирования классов, помогающих делать код понятным, гибким и поддерживаемым. Сформулированы Робертом Мартином (Uncle Bob). S - Single Responsibility (единственная ответственность). O - Open/Closed (открыт для расширения, закрыт для модификации). L - Liskov Substitution (подстановка Лисков). I - Interface Segregation (разделение интерфейсов). D - Dependency Inversion (инверсия зависимостей).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'question' => 'SRP - Single Responsibility Principle (Принцип единственной ответственности)',
                'answer' => 'У класса должна быть только одна причина для изменения - иначе говоря, он отвечает за одну задачу. Классы, делающие много всего (Бог-объекты), сложно сопровождать: правка одной функции случайно ломает другую. Признак нарушения SRP: класс UserService, который и валидирует, и шлёт email, и пишет в БД, и форматирует JSON. Решение - разбить на отдельные классы: UserValidator, EmailSender, UserRepository, UserSerializer.',
                'code_example' => '<?php
// Плохо: класс делает всё
class UserBad
{
    public function save() {}
    public function validate() {}
    public function sendEmail() {}
    public function toJson() {}
}

// Хорошо: каждый класс отвечает за своё
class User { public string $email; }
class UserRepository { public function save(User $u) {} }
class UserValidator { public function validate(User $u) {} }
class Mailer { public function sendTo(User $u) {} }',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'OCP - Open/Closed Principle (Принцип открытости/закрытости)',
                'answer' => 'Сущности должны быть открыты для расширения, но закрыты для модификации. То есть добавление новой функциональности должно происходить через создание новых классов, а не через правку существующих. Достигается через абстракции: интерфейсы, абстрактные классы, полиморфизм. Это снижает риск сломать работающий код при добавлении новых требований.',
                'code_example' => '<?php
// Плохо: каждый новый тип - правка switch
class AreaCalc
{
    public function area($shape): float
    {
        if ($shape instanceof Circle) return M_PI * $shape->r ** 2;
        if ($shape instanceof Square) return $shape->side ** 2;
        // добавили Triangle - правим класс
    }
}

// Хорошо: новые фигуры - новые классы
interface Shape {
    public function area(): float;
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'LSP - Liskov Substitution Principle (Принцип подстановки Лисков)',
                'answer' => 'Объекты потомков должны быть подставимыми вместо объектов родителя без поломки программы. То есть наследник не должен сужать контракт родителя: не выбрасывать новые исключения, не требовать более строгих параметров, не возвращать менее специфичные значения. Нарушения LSP проявляются в проверках instanceof перед использованием объекта. Если наследник не может выполнить контракт родителя - это не его наследник.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'question' => 'Классический пример нарушения LSP - Square/Rectangle',
                'answer' => 'Математически квадрат - частный случай прямоугольника, но в коде это разные сущности. Если Square extends Rectangle и переопределяет setWidth/setHeight чтобы менять обе стороны - это нарушение LSP: код, ожидающий Rectangle (можно менять стороны независимо), сломается с Square. Правильное решение - не делать Square наследником Rectangle, а ввести общий интерфейс Shape с методом area(), либо моделировать через композицию.',
                'code_example' => '<?php
// Нарушение LSP
class Rectangle
{
    public function setWidth(int $w): void { $this->w = $w; }
    public function setHeight(int $h): void { $this->h = $h; }
    public function area(): int { return $this->w * $this->h; }
    protected int $w = 0; protected int $h = 0;
}

class Square extends Rectangle
{
    // ломает контракт: setWidth меняет и высоту
    public function setWidth(int $w): void {
        $this->w = $w; $this->h = $w;
    }
    public function setHeight(int $h): void {
        $this->w = $h; $this->h = $h;
    }
}

// Код, ожидавший прямоугольник, сломается:
function test(Rectangle $r): void {
    $r->setWidth(5);
    $r->setHeight(4);
    assert($r->area() === 20); // для Square: 16, провал
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'ISP - Interface Segregation Principle (Принцип разделения интерфейсов)',
                'answer' => 'Клиенты не должны зависеть от методов, которыми они не пользуются. Лучше много маленьких специализированных интерфейсов, чем один "толстый". Если у вас интерфейс Worker с методами work(), eat(), sleep(), а робот реализует его - ему придётся реализовывать eat()/sleep() пустышками. Правильнее разбить на Workable, Eatable, Sleepable.',
                'code_example' => '<?php
// Плохо: толстый интерфейс
interface Worker
{
    public function work(): void;
    public function eat(): void;
    public function sleep(): void;
}

// Хорошо: разделили
interface Workable { public function work(): void; }
interface Eatable  { public function eat(): void; }
interface Sleepable { public function sleep(): void; }

class Human implements Workable, Eatable, Sleepable { /* ... */ }
class Robot implements Workable { /* eat и sleep не нужны */ }',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'DIP - Dependency Inversion Principle (Принцип инверсии зависимостей)',
                'answer' => 'Модули верхнего уровня не должны зависеть от модулей нижнего уровня - оба должны зависеть от абстракций. Абстракции не должны зависеть от деталей; детали должны зависеть от абстракций. На практике: вместо new MySqlRepo() в сервисе принимайте RepositoryInterface через конструктор. Это позволяет менять реализацию (БД, моки) без правки сервиса. DIP - это про направление зависимостей в архитектуре.',
                'code_example' => '<?php
// Плохо: сервис привязан к конкретной реализации
class OrderServiceBad
{
    public function __construct()
    {
        $this->db = new MySqlOrderRepo(); // жёсткая зависимость
    }
}

// Хорошо: зависим от абстракции
interface OrderRepository {
    public function save(Order $o): void;
}

class OrderService
{
    public function __construct(private OrderRepository $repo) {}
}',
                'code_language' => 'php',
            ],

            // ===== Паттерны GoF: Порождающие =====
            [
                'category' => 'ООП',
                'question' => 'Паттерн Singleton',
                'answer' => 'Singleton (одиночка) гарантирует, что у класса есть только один экземпляр, и предоставляет глобальную точку доступа к нему. Подводные камни: 1) Глобальное состояние - усложняет тестирование, рождает скрытые зависимости. 2) Нарушает SRP (класс отвечает и за свою логику, и за свой жизненный цикл). 3) Сложно подменить мок в тестах. 4) Проблемы с многопоточностью (в PHP не критично, но в других языках). 5) Считается анти-паттерном; в современных приложениях вместо Singleton используют DI-контейнер с одним экземпляром (scope=singleton).',
                'code_example' => '<?php
final class Config
{
    private static ?self $instance = null;
    private array $data;

    private function __construct() { $this->data = []; }
    private function __clone() {}

    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }
}

$c1 = Config::getInstance();
$c2 = Config::getInstance();
var_dump($c1 === $c2); // true',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Factory Method',
                'answer' => 'Factory Method (фабричный метод) определяет интерфейс для создания объекта, но позволяет подклассам решать, какой класс инстанцировать. Используется, когда заранее не известно, какие именно объекты нужно создавать. Разделяет код-клиент и код-создание. Практический пример: в Laravel - метод make() контейнера, ResponseFactory.',
                'code_example' => '<?php
abstract class Logger
{
    abstract protected function createWriter(): Writer;

    public function log(string $msg): void
    {
        $this->createWriter()->write($msg);
    }
}

class FileLogger extends Logger
{
    protected function createWriter(): Writer
    {
        return new FileWriter();
    }
}

class DbLogger extends Logger
{
    protected function createWriter(): Writer
    {
        return new DbWriter();
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Abstract Factory',
                'answer' => 'Abstract Factory (абстрактная фабрика) предоставляет интерфейс для создания семейства связанных объектов, не указывая их конкретных классов. Отличие от Factory Method: одна фабрика создаёт несколько связанных продуктов. Пример: GUI-фабрика для разных ОС - WinFactory создаёт WinButton+WinWindow, MacFactory - MacButton+MacWindow, и они согласованы между собой.',
                'code_example' => '<?php
interface Button { public function render(): string; }
interface Checkbox { public function render(): string; }

interface GuiFactory
{
    public function createButton(): Button;
    public function createCheckbox(): Checkbox;
}

class WinFactory implements GuiFactory
{
    public function createButton(): Button { return new WinButton(); }
    public function createCheckbox(): Checkbox { return new WinCheckbox(); }
}

class MacFactory implements GuiFactory
{
    public function createButton(): Button { return new MacButton(); }
    public function createCheckbox(): Checkbox { return new MacCheckbox(); }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Builder',
                'answer' => 'Builder (строитель) отделяет конструирование сложного объекта от его представления, позволяя одним и тем же кодом строить разные представления. Удобен, когда у объекта много опциональных параметров (телескопический конструктор). Часто реализуется через fluent interface (цепочки вызовов). Пример: построитель SQL-запроса в Laravel Query Builder.',
                'code_example' => '<?php
class QueryBuilder
{
    private array $where = [];
    private string $table = \'\';
    private ?int $limit = null;

    public function from(string $t): self
    {
        $this->table = $t; return $this;
    }
    public function where(string $cond): self
    {
        $this->where[] = $cond; return $this;
    }
    public function limit(int $n): self
    {
        $this->limit = $n; return $this;
    }
    public function build(): string
    {
        $sql = "SELECT * FROM $this->table";
        if ($this->where) $sql .= \' WHERE \' . implode(\' AND \', $this->where);
        if ($this->limit) $sql .= " LIMIT $this->limit";
        return $sql;
    }
}

$sql = (new QueryBuilder())
    ->from(\'users\')
    ->where(\'age > 18\')
    ->limit(10)
    ->build();',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Prototype',
                'answer' => 'Prototype (прототип) позволяет копировать существующие объекты без зависимости от их конкретных классов. Полезен, когда создание нового объекта дороже клонирования существующего. В PHP реализуется через ключевое слово clone и магический метод __clone() (для глубокого копирования вложенных объектов). По умолчанию clone делает поверхностную копию.',
                'code_example' => '<?php
class Document
{
    public function __construct(
        public string $title,
        public Author $author,
    ) {}

    public function __clone(): void
    {
        // глубокое копирование вложенного объекта
        $this->author = clone $this->author;
    }
}

$original = new Document(\'A\', new Author(\'Иван\'));
$copy = clone $original;
$copy->title = \'B\';',
                'code_language' => 'php',
            ],

            // ===== Паттерны GoF: Структурные =====
            [
                'category' => 'ООП',
                'question' => 'Паттерн Adapter',
                'answer' => 'Adapter (адаптер) преобразует интерфейс одного класса в интерфейс, ожидаемый клиентом. Простыми словами: позволяет работать вместе классам с несовместимыми интерфейсами. Аналогия - переходник для розетки. Часто используется при интеграции legacy-кода или сторонних библиотек.',
                'code_example' => '<?php
// Старый класс с неудобным интерфейсом
class LegacyXmlLogger
{
    public function writeXml(string $xml): void {}
}

// Желаемый клиентом интерфейс
interface Logger
{
    public function log(string $message): void;
}

// Адаптер: оборачивает старый класс
class LegacyLoggerAdapter implements Logger
{
    public function __construct(private LegacyXmlLogger $legacy) {}

    public function log(string $message): void
    {
        $xml = "<log>$message</log>";
        $this->legacy->writeXml($xml);
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Bridge',
                'answer' => 'Bridge (мост) разделяет абстракцию и реализацию так, чтобы их можно было изменять независимо. Простыми словами: вместо комбинаторного взрыва классов (КвадратКрасный, КругКрасный, КвадратСиний...) выделяем две независимые иерархии - формы и цвета - и связываем их через композицию. Полезен, когда у сущности есть несколько ортогональных вариативностей.',
                'code_example' => '<?php
interface Color
{
    public function fill(): string;
}

class Red implements Color
{
    public function fill(): string { return \'red\'; }
}

abstract class Shape
{
    public function __construct(protected Color $color) {}
    abstract public function draw(): string;
}

class Circle extends Shape
{
    public function draw(): string
    {
        return \'Circle filled with \' . $this->color->fill();
    }
}

$c = new Circle(new Red());',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Composite',
                'answer' => 'Composite (компоновщик) группирует объекты в древовидные структуры и позволяет работать с группой объектов так же, как с одиночным. Простыми словами: лист и контейнер реализуют один интерфейс. Пример - файловая система: и файл, и папка имеют size(), но папка считает size() как сумму содержимого.',
                'code_example' => '<?php
interface FsNode
{
    public function size(): int;
}

class File implements FsNode
{
    public function __construct(private int $size) {}
    public function size(): int { return $this->size; }
}

class Folder implements FsNode
{
    private array $children = [];
    public function add(FsNode $n): void { $this->children[] = $n; }
    public function size(): int
    {
        return array_sum(array_map(fn($c) => $c->size(), $this->children));
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Decorator',
                'answer' => 'Decorator (декоратор) динамически добавляет объекту новые обязанности, оборачивая его в другой объект с тем же интерфейсом. Альтернатива наследованию для расширения поведения. Декораторы можно стекать. Пример: в Laravel pipeline - middleware оборачивает запрос. В Symfony - декорирование сервисов.',
                'code_example' => '<?php
interface Notifier
{
    public function send(string $msg): void;
}

class EmailNotifier implements Notifier
{
    public function send(string $msg): void
    {
        echo "Email: $msg\n";
    }
}

class SmsDecorator implements Notifier
{
    public function __construct(private Notifier $inner) {}

    public function send(string $msg): void
    {
        $this->inner->send($msg);
        echo "SMS: $msg\n";
    }
}

$n = new SmsDecorator(new EmailNotifier());
$n->send(\'Привет\'); // и email, и sms',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Facade',
                'answer' => 'Facade (фасад) предоставляет упрощённый унифицированный интерфейс к сложной подсистеме. Скрывает много мелких классов за одним удобным API. Не путать с Laravel Facades - там это статический прокси к контейнеру, а классический Facade - именно фасад над подсистемой. Используйте, когда хотите упростить взаимодействие с библиотекой/модулем.',
                'code_example' => '<?php
class VideoConverter // Facade
{
    public function convert(string $file, string $format): string
    {
        $video = (new VideoFile($file))->load();
        $codec = (new CodecFactory())->extract($video);
        $buffer = (new BitrateReader())->read($file, $codec);
        $result = (new AudioMixer())->fix($buffer);
        return (new VideoFile($result))->save($format);
    }
}

// Клиент использует один простой метод
$converter = new VideoConverter();
$converter->convert(\'a.mp4\', \'webm\');',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Flyweight',
                'answer' => 'Flyweight (приспособленец, легковес) экономит память за счёт разделения общего состояния между множеством объектов. Простыми словами: вместо тысячи объектов с одинаковыми данными - один общий объект, который разделяется. Внутреннее состояние (общее) хранится во flyweight, внешнее (уникальное) передаётся в методы. Пример: рендеринг 10000 деревьев в лесу - тип дерева (модель, текстура) общий, координаты уникальны.',
                'code_example' => '<?php
class TreeType // flyweight: общее состояние
{
    public function __construct(
        public string $name,
        public string $texture,
    ) {}

    public function draw(int $x, int $y): void
    {
        echo "Tree {$this->name} at ($x,$y)\n";
    }
}

class TreeFactory
{
    private static array $types = [];

    public static function get(string $name, string $texture): TreeType
    {
        $key = $name . $texture;
        return self::$types[$key] ??= new TreeType($name, $texture);
    }
}

// 1000 деревьев, но только N уникальных типов
foreach (range(1, 1000) as $i) {
    $type = TreeFactory::get(\'oak\', \'oak.png\');
    $type->draw(rand(0, 100), rand(0, 100));
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Proxy',
                'answer' => 'Proxy (заместитель) - объект, имеющий тот же интерфейс, что и реальный объект, но контролирующий доступ к нему. Виды: 1) Virtual Proxy - ленивая инициализация дорогого объекта. 2) Protection Proxy - проверка прав доступа. 3) Remote Proxy - представление удалённого объекта. 4) Logging/Caching Proxy. Используется в Doctrine (lazy entities), в Laravel (контейнер делает proxy для биндингов).',
                'code_example' => '<?php
interface Image
{
    public function display(): void;
}

class RealImage implements Image
{
    public function __construct(private string $file)
    {
        echo "Loading $file\n"; // дорого
    }
    public function display(): void { echo "Displaying $this->file\n"; }
}

class ImageProxy implements Image // ленивый
{
    private ?RealImage $real = null;
    public function __construct(private string $file) {}

    public function display(): void
    {
        $this->real ??= new RealImage($this->file);
        $this->real->display();
    }
}',
                'code_language' => 'php',
            ],

            // ===== Паттерны GoF: Поведенческие =====
            [
                'category' => 'ООП',
                'question' => 'Паттерн Chain of Responsibility',
                'answer' => 'Chain of Responsibility (цепочка обязанностей) передаёт запрос последовательно по цепочке обработчиков, пока кто-то его не обработает. Каждый обработчик решает: обработать запрос или передать дальше. Используется в middleware (Laravel, Symfony), обработке событий, валидации, авторизации. Удобно для гибких пайплайнов.',
                'code_example' => '<?php
abstract class Handler
{
    protected ?Handler $next = null;
    public function setNext(Handler $h): Handler
    {
        $this->next = $h;
        return $h;
    }
    abstract public function handle(Request $req): ?Response;
}

class AuthHandler extends Handler
{
    public function handle(Request $req): ?Response
    {
        if (!$req->isAuth()) return new Response(\'401\');
        return $this->next?->handle($req);
    }
}

class LogHandler extends Handler
{
    public function handle(Request $req): ?Response
    {
        echo "log\n";
        return $this->next?->handle($req);
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Command',
                'answer' => 'Command (команда) превращает запросы в объекты. Это позволяет: параметризовать клиентов, ставить запросы в очередь, логировать их, отменять. Команда инкапсулирует действие и его аргументы. Пример: Laravel Jobs - очередь команд; кнопки в GUI с undo/redo. Состоит из Command (интерфейс), ConcreteCommand, Receiver, Invoker.',
                'code_example' => '<?php
interface Command
{
    public function execute(): void;
}

class SendEmailCommand implements Command
{
    public function __construct(
        private Mailer $mailer,
        private string $to,
        private string $body,
    ) {}

    public function execute(): void
    {
        $this->mailer->send($this->to, $this->body);
    }
}

class CommandQueue
{
    private array $queue = [];
    public function add(Command $c): void { $this->queue[] = $c; }
    public function run(): void
    {
        foreach ($this->queue as $c) $c->execute();
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Iterator',
                'answer' => 'Iterator (итератор) даёт способ последовательного доступа к элементам коллекции, не раскрывая её внутреннего устройства. В PHP есть встроенные интерфейсы Iterator и IteratorAggregate. Реализация позволяет использовать объект в foreach. Также есть генераторы (yield) - удобный способ создания итераторов.',
                'code_example' => '<?php
class NumberCollection implements \IteratorAggregate
{
    public function __construct(private array $items) {}

    public function getIterator(): \Generator
    {
        foreach ($this->items as $item) {
            yield $item * 2;
        }
    }
}

$nc = new NumberCollection([1, 2, 3]);
foreach ($nc as $n) echo $n; // 246',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Mediator',
                'answer' => 'Mediator (посредник) уменьшает связность между классами, заставляя их общаться не напрямую, а через объект-посредник. Простыми словами: вместо звезды связей "все со всеми" получается звезда "все через одного". Пример - ChatRoom: пользователи не пишут друг другу напрямую, а через комнату. Также паттерн часто используется в GUI, где компоненты диалога взаимодействуют через диалог-посредник.',
                'code_example' => '<?php
interface ChatMediator
{
    public function send(string $msg, User $from): void;
}

class ChatRoom implements ChatMediator
{
    private array $users = [];
    public function add(User $u): void { $this->users[] = $u; }
    public function send(string $msg, User $from): void
    {
        foreach ($this->users as $u) {
            if ($u !== $from) $u->receive($msg);
        }
    }
}

class User
{
    public function __construct(
        private string $name,
        private ChatMediator $chat,
    ) {}
    public function send(string $msg): void
    {
        $this->chat->send($msg, $this);
    }
    public function receive(string $msg): void
    {
        echo "{$this->name} получил: $msg\n";
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Memento',
                'answer' => 'Memento (хранитель) позволяет сохранять и восстанавливать прошлые состояния объекта, не нарушая его инкапсуляции. Простыми словами: реализация undo/redo. Состоит из Originator (объект, чьё состояние сохраняется), Memento (снимок состояния), Caretaker (хранит снимки, не зная их структуры).',
                'code_example' => '<?php
class EditorMemento // снимок
{
    public function __construct(public readonly string $content) {}
}

class Editor // originator
{
    private string $content = \'\';

    public function type(string $text): void
    {
        $this->content .= $text;
    }
    public function save(): EditorMemento
    {
        return new EditorMemento($this->content);
    }
    public function restore(EditorMemento $m): void
    {
        $this->content = $m->content;
    }
}

$editor = new Editor();
$editor->type(\'Hello\');
$snapshot = $editor->save();
$editor->type(\' world\');
$editor->restore($snapshot); // вернулись к "Hello"',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Observer',
                'answer' => 'Observer (наблюдатель) определяет зависимость "один ко многим" между объектами: когда один меняет состояние, все зависящие от него уведомляются автоматически. Используется в системах событий, реактивном программировании. В Laravel - Eloquent observers, события (event/listener). Также основа архитектуры MVC.',
                'code_example' => '<?php
interface Observer
{
    public function update(string $event): void;
}

class EventBus
{
    private array $observers = [];
    public function subscribe(Observer $o): void
    {
        $this->observers[] = $o;
    }
    public function emit(string $event): void
    {
        foreach ($this->observers as $o) $o->update($event);
    }
}

class EmailSubscriber implements Observer
{
    public function update(string $event): void
    {
        echo "Send email on $event\n";
    }
}

$bus = new EventBus();
$bus->subscribe(new EmailSubscriber());
$bus->emit(\'order.created\');',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн State',
                'answer' => 'State (состояние) позволяет объекту менять поведение при изменении внутреннего состояния. Создаёт иллюзию, что класс меняется. Альтернатива большим switch-case в методах. Каждое состояние - отдельный класс, реализующий общий интерфейс. Пример: заказ может быть New/Paid/Shipped/Delivered, и в каждом состоянии методы pay()/ship() ведут себя по-разному.',
                'code_example' => '<?php
interface OrderState
{
    public function pay(Order $o): void;
    public function ship(Order $o): void;
}

class NewState implements OrderState
{
    public function pay(Order $o): void
    {
        $o->setState(new PaidState());
        echo "Оплачено\n";
    }
    public function ship(Order $o): void
    {
        echo "Нельзя отправить - не оплачено\n";
    }
}

class PaidState implements OrderState
{
    public function pay(Order $o): void { echo "Уже оплачено\n"; }
    public function ship(Order $o): void
    {
        $o->setState(new ShippedState());
    }
}

class Order
{
    public function __construct(private OrderState $state = new NewState()) {}
    public function setState(OrderState $s): void { $this->state = $s; }
    public function pay(): void { $this->state->pay($this); }
    public function ship(): void { $this->state->ship($this); }
}

class ShippedState implements OrderState {
    public function pay(Order $o): void {}
    public function ship(Order $o): void {}
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Strategy',
                'answer' => 'Strategy (стратегия) определяет семейство взаимозаменяемых алгоритмов и делает их взаимозаменяемыми. Клиент выбирает нужный алгоритм во время выполнения. Похож на State, но State про переходы между состояниями, а Strategy - про выбор алгоритма. Пример: разные способы оплаты, разные алгоритмы сортировки, разные стратегии расчёта скидок.',
                'code_example' => '<?php
interface SortStrategy
{
    public function sort(array $data): array;
}

class QuickSort implements SortStrategy
{
    public function sort(array $data): array { sort($data); return $data; }
}

class BubbleSort implements SortStrategy
{
    public function sort(array $data): array { /* ... */ return $data; }
}

class Sorter
{
    public function __construct(private SortStrategy $strategy) {}
    public function sort(array $data): array
    {
        return $this->strategy->sort($data);
    }
}

$s = new Sorter(new QuickSort());
$s->sort([3, 1, 2]);',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Template Method',
                'answer' => 'Template Method (шаблонный метод) определяет скелет алгоритма в методе базового класса, делегируя реализацию некоторых шагов потомкам. Потомки переопределяют шаги, не меняя структуру алгоритма. В отличие от Strategy (композиция), Template Method работает через наследование. Пример: общий процесс импорта данных - load/parse/save - со специфичным parse() в каждом потомке.',
                'code_example' => '<?php
abstract class DataImporter
{
    final public function import(string $file): void
    {
        $raw = $this->load($file);
        $data = $this->parse($raw);
        $this->save($data);
    }

    protected function load(string $f): string
    {
        return file_get_contents($f);
    }
    abstract protected function parse(string $raw): array;
    protected function save(array $d): void { /* ... */ }
}

class CsvImporter extends DataImporter
{
    protected function parse(string $raw): array
    {
        return array_map(\'str_getcsv\', explode("\n", $raw));
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Паттерн Visitor',
                'answer' => 'Visitor (посетитель) позволяет добавлять новые операции к объектам, не меняя их классы. Решает проблему: у вас есть иерархия классов, и нужно добавить новую операцию для всех. Без Visitor вам пришлось бы менять каждый класс. Visitor собирает все операции одного типа в одном классе. Двойная диспетчеризация: object->accept(visitor), visitor->visitConcrete(object).',
                'code_example' => '<?php
interface Visitor
{
    public function visitCircle(Circle $c): void;
    public function visitSquare(Square $s): void;
}

interface Shape
{
    public function accept(Visitor $v): void;
}

class Circle implements Shape
{
    public float $r = 1;
    public function accept(Visitor $v): void { $v->visitCircle($this); }
}

class Square implements Shape
{
    public float $side = 1;
    public function accept(Visitor $v): void { $v->visitSquare($this); }
}

class AreaCalculator implements Visitor
{
    public float $total = 0;
    public function visitCircle(Circle $c): void
    {
        $this->total += M_PI * $c->r ** 2;
    }
    public function visitSquare(Square $s): void
    {
        $this->total += $s->side ** 2;
    }
}',
                'code_language' => 'php',
            ],

            // ===== DI, IoC, Service Locator =====
            [
                'category' => 'ООП',
                'question' => 'Что такое Dependency Injection (DI)?',
                'answer' => 'Dependency Injection (внедрение зависимостей) - это техника, при которой объект получает свои зависимости извне, а не создаёт их сам. Виды: 1) Constructor Injection (через конструктор) - предпочтительный. 2) Setter Injection (через setter). 3) Property Injection (через публичное поле). DI - это паттерн, позволяющий следовать DIP. Делает код тестируемым, гибким, слабо связанным.',
                'code_example' => '<?php
// Без DI: жёсткая зависимость
class OrderServiceBad
{
    public function process(): void
    {
        $repo = new OrderRepository(); // вшито
    }
}

// С DI: зависимость передана извне
class OrderService
{
    public function __construct(
        private OrderRepository $repo,
        private Mailer $mailer,
    ) {}
}

// Передаём зависимости явно
$service = new OrderService(
    new OrderRepository(),
    new SmtpMailer()
);',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'В чём разница между DI и DIP?',
                'answer' => 'Это разные понятия. DIP (Dependency Inversion Principle) - принцип проектирования: зависим от абстракций, а не от конкретных классов. DI (Dependency Injection) - техника, способ передавать зависимости в объект (через конструктор, сеттер). Можно соблюдать DIP без DI (например, создавая абстракции вручную). Можно использовать DI без соблюдения DIP (передавать конкретные классы). На практике DI - один из главных способов реализации DIP.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое Inversion of Control (IoC)?',
                'answer' => 'IoC (инверсия управления) - принцип, при котором управление потоком программы передаётся фреймворку или контейнеру, а не пишется в коде приложения. Простыми словами: "не звоните нам, мы позвоним вам" - вы пишете компоненты, а фреймворк решает, когда их вызвать. Примеры IoC: фреймворк вызывает ваш контроллер, DI-контейнер создаёт объекты, hooks/события дёргают ваши обработчики. DI - это частный случай IoC.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое Service Locator и почему его считают анти-паттерном?',
                'answer' => 'Service Locator - объект-реестр, в котором по ключу можно получить нужный сервис: $locator->get(\'mailer\'). Считается анти-паттерном потому что: 1) Скрывает зависимости класса (по конструктору не видно, что нужно). 2) Усложняет тестирование (надо мокать локатор и регистрировать в нём). 3) Связывает класс с локатором. 4) Нарушает SRP. Альтернатива - Constructor Injection: явные зависимости через параметры. Laravel App container можно использовать как Service Locator (плохо) или как DI-контейнер (хорошо, через type-hint в конструкторе).',
                'code_example' => '<?php
// Анти-паттерн Service Locator
class OrderService
{
    public function process(): void
    {
        $repo = ServiceLocator::get(\'orderRepo\'); // скрытая зависимость
        $repo->save(\'...\');
    }
}

// Хорошо: явная зависимость
class OrderServiceGood
{
    public function __construct(private OrderRepository $repo) {}
    public function process(): void
    {
        $this->repo->save(\'...\');
    }
}',
                'code_language' => 'php',
            ],

            // ===== DDD =====
            [
                'category' => 'ООП',
                'question' => 'Что такое Domain-Driven Design (DDD)?',
                'answer' => 'DDD (предметно-ориентированное проектирование) - это подход к разработке сложных систем, в центре которого глубокое понимание предметной области. Идея: код должен отражать бизнес-домен, а не техническую реализацию. Ключевые концепции: Ubiquitous Language (единый язык бизнеса и кода), Bounded Context (границы модели), Entity, Value Object, Aggregate, Repository, Domain Service, Domain Event. DDD особенно ценен в больших проектах со сложной бизнес-логикой.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое Aggregate Root в DDD?',
                'answer' => 'Aggregate Root (корень агрегата) - это главный объект внутри группы связанных объектов (агрегата). Простыми словами: представь корзину покупок - она объединяет товары, скидки, итоговую сумму. Корзина - это Aggregate Root, всё взаимодействие извне идёт через неё, а не напрямую с товарами внутри. Это гарантирует согласованность данных: правила (например, лимит на товары) проверяются в одном месте. Из вне можно получать только корень, не его внутренние сущности.',
                'code_example' => '<?php
class Order // Aggregate Root
{
    private array $items = [];

    public function addItem(Product $p, int $qty): void
    {
        if (count($this->items) >= 100) {
            throw new \DomainException(\'Лимит товаров\');
        }
        $this->items[] = new OrderItem($p, $qty); // правила в корне
    }

    // нельзя получить items напрямую и менять их
    public function items(): array
    {
        return $this->items;
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое Value Object в DDD?',
                'answer' => 'Value Object (объект-значение) - объект, у которого нет идентичности; он определяется только своими значениями. Если у двух VO одинаковые поля - они равны. Примеры: Money (100 USD), Address, DateRange, Email. Свойства: иммутабельны (не меняются после создания, новое значение - новый объект), сравниваются по значению, инкапсулируют валидацию. В отличие от Entity, у которой есть id и идентичность сохраняется во времени.',
                'code_example' => '<?php
final readonly class Money
{
    public function __construct(
        public int $amount,
        public string $currency,
    ) {
        if ($amount < 0) {
            throw new \InvalidArgumentException(\'Сумма не может быть отрицательной\');
        }
    }

    public function add(Money $other): self
    {
        if ($this->currency !== $other->currency) {
            throw new \DomainException(\'Валюты не совпадают\');
        }
        return new self($this->amount + $other->amount, $this->currency);
    }

    public function equals(Money $other): bool
    {
        return $this->amount === $other->amount
            && $this->currency === $other->currency;
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое Entity в DDD?',
                'answer' => 'Entity (сущность) - объект, у которого есть уникальный идентификатор (id) и идентичность сохраняется во времени, даже если меняются другие свойства. Простыми словами: пользователь может сменить имя, email, адрес, но это всё ещё тот же пользователь (с тем же id). Entity сравниваются по id, а не по полям. Примеры: User, Order, Article. Противоположность - Value Object, у которого идентичности нет.',
                'code_example' => '<?php
class User // Entity
{
    public function __construct(
        public readonly string $id,
        private string $name,
        private string $email,
    ) {}

    public function changeName(string $name): void
    {
        $this->name = $name; // меняется, но id - тот же
    }

    public function equals(User $other): bool
    {
        return $this->id === $other->id; // по id, не по полям
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое Repository в DDD?',
                'answer' => 'Repository (репозиторий) - паттерн, абстрагирующий доступ к хранилищу агрегатов. Простыми словами: репозиторий выглядит как коллекция в памяти - find/save/remove - а внутри обращается к БД, кешу или внешнему API. Доменный код не знает о деталях хранения. Один репозиторий обычно работает с одним Aggregate Root. Это даёт возможность менять способ хранения без изменения бизнес-логики.',
                'code_example' => '<?php
interface UserRepository
{
    public function findById(string $id): ?User;
    public function save(User $user): void;
    public function remove(User $user): void;
}

// Реализация для PostgreSQL
class PostgresUserRepository implements UserRepository
{
    public function findById(string $id): ?User
    {
        // SQL ...
    }
    public function save(User $user): void { /* SQL */ }
    public function remove(User $user): void { /* SQL */ }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое Domain Service в DDD?',
                'answer' => 'Domain Service (доменный сервис) - объект, содержащий бизнес-логику, которая не принадлежит ни одной Entity или Value Object естественным образом. Например, перевод денег между двумя счетами - это операция над двумя агрегатами, не принадлежит ни одному из них. Domain Service оперирует доменными объектами, не имеет состояния (stateless). Не путать с Application Service - тот оркестрирует use case (транзакции, события, авторизация).',
                'code_example' => '<?php
class MoneyTransferService // Domain Service
{
    public function transfer(
        Account $from,
        Account $to,
        Money $amount,
    ): void {
        $from->withdraw($amount);
        $to->deposit($amount);
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое Bounded Context в DDD?',
                'answer' => 'Bounded Context (ограниченный контекст) - граница, внутри которой модель имеет конкретное значение. Простыми словами: слово "продукт" в контексте продаж - это товар с ценой, а в контексте склада - это коробка с весом и габаритами. Это разные модели! BC разделяет систему на независимые куски, у каждого своя модель и язык. Между контекстами - явные интеграции (anti-corruption layer, shared kernel). Помогает бороться со сложностью больших доменов.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое Ubiquitous Language в DDD?',
                'answer' => 'Ubiquitous Language (вездесущий язык) - единый язык, на котором общаются разработчики, бизнес-аналитики и заказчики. Этот же язык используется в коде: имена классов, методов, переменных совпадают с терминами бизнеса. Простыми словами: если бизнес говорит "оформить заказ" - в коде должен быть метод placeOrder(), а не doStuff(). Это устраняет двусмысленность и потери при переводе требований в код.',
                'code_example' => null,
                'code_language' => null,
            ],

            // ===== Event Sourcing, CQRS =====
            [
                'category' => 'ООП',
                'question' => 'Что такое Event Sourcing?',
                'answer' => 'Event Sourcing (событийное хранилище) - подход, при котором состояние системы хранится не как текущий снимок, а как последовательность событий, которые к нему привели. Простыми словами: вместо "баланс счёта = 100" мы храним "положили 50, положили 80, сняли 30". Текущее состояние получается воспроизведением событий. Плюсы: полный аудит, возможность отмотать историю, легко добавить новые проекции данных. Минусы: сложность, eventual consistency, миграции событий.',
                'code_example' => '<?php
abstract class Event { public \DateTime $occurredAt; }
class MoneyDeposited extends Event { public function __construct(public int $amount) { $this->occurredAt = new \DateTime(); } }
class MoneyWithdrawn extends Event { public function __construct(public int $amount) { $this->occurredAt = new \DateTime(); } }

class Account
{
    private int $balance = 0;
    /** @var Event[] */
    private array $events = [];

    public function deposit(int $amount): void
    {
        $this->apply(new MoneyDeposited($amount));
    }

    private function apply(Event $e): void
    {
        match (true) {
            $e instanceof MoneyDeposited => $this->balance += $e->amount,
            $e instanceof MoneyWithdrawn => $this->balance -= $e->amount,
        };
        $this->events[] = $e;
    }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое CQRS?',
                'answer' => 'CQRS (Command Query Responsibility Segregation) - разделение операций записи (Command) и чтения (Query) на разные модели. Простыми словами: одни классы только пишут изменения, другие только читают данные. Зачем: запись и чтение часто имеют разные требования (запись требует валидации/транзакций, чтение - быстрых выборок и кешей). При CQRS можно оптимизировать каждую сторону независимо: денормализованные view-таблицы для чтения, нормализованная БД для записи. Часто комбинируется с Event Sourcing.',
                'code_example' => '<?php
// Command - изменяет состояние, не возвращает данных
final class CreateOrderCommand
{
    public function __construct(
        public string $userId,
        public array $items,
    ) {}
}

class CreateOrderHandler
{
    public function handle(CreateOrderCommand $cmd): void { /* пишем */ }
}

// Query - читает данные, не меняет состояние
final class GetUserOrdersQuery
{
    public function __construct(public string $userId) {}
}

class GetUserOrdersHandler
{
    public function handle(GetUserOrdersQuery $q): array { /* читаем */ return []; }
}',
                'code_language' => 'php',
            ],

            // ===== Anemic vs Rich =====
            [
                'category' => 'ООП',
                'question' => 'Anemic vs Rich domain model - в чём разница?',
                'answer' => 'Anemic Model (анемичная) - объекты домена это просто сумки данных (геттеры/сеттеры), а вся логика в сервисах. Это близко к процедурному стилю и считается анти-паттерном в DDD. Rich Model (богатая) - объекты содержат и данные, и поведение, инкапсулируют бизнес-правила. Пример: вместо $orderService->cancel($order) - сам $order->cancel(), который проверит правила. Rich-модель ближе к ООП, защищает инварианты, более понятна.',
                'code_example' => '<?php
// Anemic - объект-сумка, логика снаружи
class OrderAnemic
{
    public string $status;
    public \DateTime $createdAt;
}
class OrderService
{
    public function cancel(OrderAnemic $o): void
    {
        if ($o->status === \'shipped\') throw new \Exception();
        $o->status = \'cancelled\';
    }
}

// Rich - логика внутри объекта
class Order
{
    private string $status = \'new\';
    public function cancel(): void
    {
        if ($this->status === \'shipped\') {
            throw new \DomainException(\'Нельзя отменить отгруженный\');
        }
        $this->status = \'cancelled\';
    }
}',
                'code_language' => 'php',
            ],

            // ===== Law of Demeter, Tell Don't Ask, Coupling/Cohesion =====
            [
                'category' => 'ООП',
                'question' => 'Что такое Law of Demeter (закон Деметры)?',
                'answer' => 'Закон Деметры (принцип минимального знания): объект должен взаимодействовать только с непосредственными "друзьями", не лазить через них к чужим объектам. Простыми словами: говорите только со своими ближайшими объектами. Признак нарушения - длинные цепочки $a->getB()->getC()->doSomething() (train wreck). Это создаёт сильную связность - изменения в C ломают код, который ничего о C не знал. Решение - дать $a метод, который сам обратится к C, инкапсулируя цепочку.',
                'code_example' => '<?php
// Плохо - нарушение Law of Demeter
$user->getProfile()->getAddress()->getCity()->getName();

// Хорошо - даём User метод, скрывающий внутренности
class User
{
    public function cityName(): string
    {
        return $this->profile->cityName();
    }
}
$user->cityName();',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое принцип "Tell, Don\'t Ask"?',
                'answer' => '"Tell, Don\'t Ask" - не спрашивай у объекта данные, чтобы потом принять решение - скажи ему сделать. Простыми словами: вместо "получить статус и проверить можно ли отменить" - "попроси заказ отменить себя". Это ведёт к более инкапсулированному коду: бизнес-логика живёт внутри объектов, а не размазана по сервисам. Тесно связан с Rich-моделью и Law of Demeter.',
                'code_example' => '<?php
// Ask - спрашиваем и решаем снаружи
if ($order->getStatus() === \'new\' && $order->getTotal() > 0) {
    $order->setStatus(\'paid\');
}

// Tell - говорим объекту что делать
$order->markAsPaid();',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое Coupling и Cohesion?',
                'answer' => 'Coupling (связность, связанность) - степень зависимости одного модуля от другого. Чем сильнее coupling - тем труднее менять код, тестировать, переиспользовать. Стремимся к loose coupling (слабой связности). Cohesion (сплочённость) - насколько элементы внутри модуля связаны общей задачей. Высокая cohesion - модуль делает одно дело хорошо. Низкая - смесь несвязанных функций. Цель ООП: low coupling + high cohesion. Это коррелирует с SRP (cohesion) и DIP (coupling).',
                'code_example' => null,
                'code_language' => null,
            ],

            // ===== Дополнительные =====
            [
                'category' => 'ООП',
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
                'question' => 'Что такое Open Recursion и проблема fragile base class?',
                'answer' => 'Open recursion - когда метод родительского класса вызывает другой метод того же объекта (через $this), и потомок может переопределить этот метод, изменив поведение базового. Это даёт гибкость, но порождает проблему fragile base class (хрупкий базовый класс): изменения в родителе могут сломать потомков, потому что они зависят от внутренних вызовов методов. Снижает инкапсуляцию. Решения: помечать "хук-методы" final или выносить через композицию (Strategy/Template Method с явными шагами).',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
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
                'question' => 'YAGNI, KISS, DRY - что это?',
                'answer' => 'Это базовые принципы хорошего кода. DRY (Don\'t Repeat Yourself) - не повторяйся: одно знание - в одном месте. Дублирование логики - источник багов при правках. KISS (Keep It Simple, Stupid) - делайте проще: не усложняйте, пока не нужно. Простой код легче читать и поддерживать. YAGNI (You Aren\'t Gonna Need It) - не пишите код "на будущее" в надежде, что пригодится. Чаще всего не пригодится, а лишний код придётся поддерживать. Принципы взаимодополняют SOLID.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое cohesion на уровне модулей и классов?',
                'answer' => 'Cohesion (сплочённость) показывает, насколько элементы внутри одного модуля связаны общей целью. Высокая cohesion - класс делает одно дело и делает его хорошо. Низкая - класс мешает разнородные функции. Виды (от плохой к хорошей): coincidental (случайная), logical (функции одной категории), temporal (вызываются вместе), procedural (выполняются последовательно), communicational (работают с одними данными), sequential (выход одного - вход другого), functional (всё для одной задачи) - идеал. Высокая cohesion - следствие SRP.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'question' => 'Что такое coupling на уровне модулей и классов?',
                'answer' => 'Coupling (зацепление, связанность) показывает, насколько модули зависят друг от друга. Виды от плохого к хорошему: content (один модуль лезет во внутренности другого), common (общие глобальные данные), control (один управляет логикой другого через флаги), stamp (передают сложные структуры, но используют только часть), data (передают только нужные параметры), message coupling (взаимодействие только через интерфейсы) - идеал. Низкое coupling - результат DIP, ISP, инкапсуляции и Law of Demeter.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
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
                'question' => 'Чем Strategy отличается от State и приведите кейс для каждого.',
                'answer' => 'Strategy инкапсулирует взаимозаменяемые алгоритмы, выбирается клиентом и обычно не меняется на лету: например, разные алгоритмы расчёта налога. State моделирует поведение объекта в зависимости от внутреннего состояния и переключает само себя: Order переходит pending → paid → shipped, и каждое состояние имеет свой набор разрешённых действий. Структурно паттерны похожи (композиция + полиморфизм), различие - в семантике переходов: в Strategy объекты-стратегии stateless, в State объект-состояние сам выбирает следующее.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
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
                'question' => 'Чем отличается Factory Method от Abstract Factory?',
                'answer' => 'Factory Method - метод (часто абстрактный) в классе-создателе, возвращающий продукт; используется для одного семейства, подклассы переопределяют метод. Abstract Factory - объект-фабрика, создающий несколько связанных продуктов одного "семейства" (UI для Material/Cupertino: Button + Checkbox + Menu). FM решает "какой класс инстанцировать", AF - "какое семейство объектов согласованно создать".',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
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
                'question' => 'Что такое CQRS и какие проблемы он решает?',
                'answer' => 'Command Query Responsibility Segregation - разделение модели чтения и записи. Команды меняют состояние, не возвращают данных; запросы читают, не меняют. Преимущества: разные модели позволяют оптимизировать чтение (денормализованные read-models, кэш) отдельно от записи (агрегаты, инварианты). Часто сочетается с event sourcing. Минус - сложность и eventual consistency между read- и write-моделями; для типового CRUD-приложения это overkill.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
                'question' => 'Чем композиция предпочтительнее наследования и в каких случаях наследование оправдано?',
                'answer' => 'Композиция - has-a, делегирование зависимостям, динамическая замена через DI, плоская иерархия. Наследование - is-a, фиксируется в compile-time, тянет всю реализацию родителя, ломается при изменении базы (fragile base class). Наследование оправдано при настоящем подтипе с LSP (Square→Shape, нет), при шаблонном методе с общим алгоритмом и при использовании framework hooks (extends FormRequest). В прикладной логике - почти всегда композиция.',
                'code_example' => null,
                'code_language' => null,
            ],
            [
                'category' => 'ООП',
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
