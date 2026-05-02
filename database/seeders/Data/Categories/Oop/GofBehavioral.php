<?php

namespace Database\Seeders\Data\Categories\Oop;

class GofBehavioral
{
    public static function all(): array
    {
        return [
            [
                'category' => 'ООП',
                'topic' => 'oop.gof_behavioral',
                'difficulty' => 3,
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
                'topic' => 'oop.gof_behavioral',
                'difficulty' => 3,
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
                'topic' => 'oop.gof_behavioral',
                'difficulty' => 3,
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
                'topic' => 'oop.gof_behavioral',
                'difficulty' => 4,
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
                'topic' => 'oop.gof_behavioral',
                'difficulty' => 4,
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
                'topic' => 'oop.gof_behavioral',
                'difficulty' => 3,
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
                'topic' => 'oop.gof_behavioral',
                'difficulty' => 3,
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
                'topic' => 'oop.gof_behavioral',
                'difficulty' => 3,
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
                'topic' => 'oop.gof_behavioral',
                'difficulty' => 3,
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
                'topic' => 'oop.gof_behavioral',
                'difficulty' => 4,
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
        ];
    }
}
