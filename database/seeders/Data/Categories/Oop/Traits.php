<?php

namespace Database\Seeders\Data\Categories\Oop;

class Traits
{
    public static function all(): array
    {
        return [
            [
                'category' => 'ООП',
                'topic' => 'oop.traits',
                'difficulty' => 2,
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
                'topic' => 'oop.traits',
                'difficulty' => 4,
                'question' => 'Какие основные trade-offs у трейтов и когда их стоит/не стоит использовать?',
                'answer' => 'Трейты соблазнительны как способ "подключить функциональность", но платят за это серьёзными архитектурными штрафами. Главные минусы: 1) Скрытые зависимости. Если трейт использует $this->db, $this->logger или вызывает $this->save() - это неявная зависимость, которой не видно в конструкторе класса. Класс перестаёт быть честным про свои требования. 2) Нарушение SRP. Класс с пятью трейтами имеет пять причин для изменения - и обычно это означает, что трейты прячут отдельные ответственности, которые должны были быть отдельными объектами и инжектиться в конструктор. 3) Сложность тестирования. Трейт нельзя замокать отдельно - он встраивается в класс-носитель, и любой тест поведения, добавленного трейтом, требует инстанцирования всего класса. Подменить реализацию метода трейта можно только через override в самом классе или через as-rename + написание заместителя. 4) Композиция через статическое связывание. Поведение трейта фиксируется в compile-time, нельзя подменить в рантайме (в отличие от DI зависимости). Когда трейты ОК: маленькие, без внешних зависимостей, чистые - HasTimestamps, генерация UUID, Macroable, простые value-преобразования. Когда плохо: трейты, тянущие сервисы (логгер, БД, http-клиент) - это всегда сигнал, что должно быть DI. Альтернатива почти всегда: композиция (объект внутри класса) или интерфейс + реализация по DI.',
                'code_example' => '<?php
// ❌ Плохо: трейт со скрытой зависимостью от БД
trait Auditable
{
    public function logChange(string $action): void
    {
        // откуда $this->db? тест должен знать об этом
        $this->db->insert("audit_log", ["action" => $action]);
    }
}

class User
{
    use Auditable;
    // конструктор НИЧЕГО не говорит про БД, но класс от неё зависит
    public function __construct(public string $name) {}
}

// ✅ Хорошо: композиция через DI
final class AuditLogger
{
    public function __construct(private DatabaseInterface $db) {}
    public function logChange(string $action): void { /* ... */ }
}

final class User
{
    public function __construct(
        public string $name,
        private AuditLogger $audit, // зависимость явная, мокается легко
    ) {}
}

// ✅ Допустимый трейт: чистый, без внешних зависимостей
trait HasTimestamps
{
    public ?\DateTimeImmutable $createdAt = null;
    public function touch(): void { $this->createdAt = new \DateTimeImmutable(); }
}',
                'code_language' => 'php',
            ],
            [
                'category' => 'ООП',
                'topic' => 'oop.traits',
                'difficulty' => 4,
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
            [
                'category' => 'ООП',
                'topic' => 'oop.traits',
                'difficulty' => 4,
                'question' => 'Какой приоритет у методов: класс vs трейт vs родитель?',
                'answer' => 'PHP имеет строгий method resolution order для трейтов. Приоритет (от высшего к низшему): 1) Метод самого класса (определённый в нём напрямую). 2) Метод из подключённого трейта. 3) Метод унаследованный от родительского класса. То есть трейт ВСЕГДА переопределяет унаследованный метод от parent, но метод самого класса переопределяет трейт. Это критично для понимания миксин-механики PHP: трейт не "усиливает" класс, а буквально подмешивает свой код "поверх" родительского, но "под" собственный код класса. Если в нескольких трейтах одинаковый метод - это конфликт, и компилятор требует разрешить его через insteadof/as. Как проверить на практике: если ваш Eloquent-класс наследует Model (где есть scopeA), и подключил трейт с собственным scopeA - победит трейт; но если в самой User написать собственный scopeA - победит User. Применение знания: если хотите дать ровно гибкость "поведение по умолчанию из трейта, но возможность переопределить в классе" - просто оставляйте метод в трейте. Если нужна "подкладка" под parent - не сработает, метод класса всегда сверху parent через любой трейт.',
                'code_example' => '<?php
trait T
{
    public function hello(): string { return "from trait"; }
}

class ParentClass
{
    public function hello(): string { return "from parent"; }
}

// 1. Trait > Parent
class A extends ParentClass
{
    use T;
}
echo (new A)->hello(); // "from trait"

// 2. Class own > Trait
class B extends ParentClass
{
    use T;
    public function hello(): string { return "from B"; }
}
echo (new B)->hello(); // "from B"

// 3. Trait может вызывать parent через parent::
trait Logging
{
    public function save(): void
    {
        parent::save();        // ОК, обращается к методу parent класса
        Log::info("saved");
    }
}',
            ],
        ];
    }
}
