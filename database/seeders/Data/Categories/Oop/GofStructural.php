<?php

namespace Database\Seeders\Data\Categories\Oop;

class GofStructural
{
    public static function all(): array
    {
        return [
            [
                'category' => 'ООП',
                'topic' => 'oop.gof_structural',
                'difficulty' => 3,
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
                'topic' => 'oop.gof_structural',
                'difficulty' => 4,
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
                'topic' => 'oop.gof_structural',
                'difficulty' => 3,
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
                'topic' => 'oop.gof_structural',
                'difficulty' => 3,
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
                'topic' => 'oop.gof_structural',
                'difficulty' => 3,
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
                'topic' => 'oop.gof_structural',
                'difficulty' => 4,
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
                'topic' => 'oop.gof_structural',
                'difficulty' => 3,
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
        ];
    }
}
