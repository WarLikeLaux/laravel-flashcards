<?php

namespace Database\Seeders;

use App\Models\Flashcard;
use Database\Seeders\Data\InterviewQuestions;
use Illuminate\Database\Seeder;

class FlashcardSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([...$this->cards(), ...InterviewQuestions::all()] as $card) {
            Flashcard::query()->create($card);
        }
    }

    /**
     * @return array<int, array{category: string, question: string, answer: string}>
     */
    private function cards(): array
    {
        return [
            [
                'category' => 'PHP',
                'question' => 'В чём разница между == и === в PHP?',
                'answer' => '== сравнивает значения с приведением типов, === сравнивает значения и типы строго без приведения.',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое late static binding и как работает static::?',
                'answer' => 'Late static binding позволяет ссылаться на вызываемый класс в иерархии наследования. self:: указывает на класс, где определён метод; static:: — на класс, через который метод вызвали.',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем readonly свойство отличается от обычного private?',
                'answer' => 'readonly запрещает изменение свойства после инициализации в конструкторе. Доступно с PHP 8.1, на уровне класса с PHP 8.2.',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое generator и yield?',
                'answer' => 'Generator — функция, возвращающая Iterator через yield, не материализуя весь массив в памяти. Подходит для ленивых последовательностей и потоковой обработки.',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем отличаются include, include_once, require, require_once?',
                'answer' => 'require падает с fatal error если файла нет, include даёт warning. *_once гарантируют единичную загрузку файла за процесс.',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое traits и для чего они нужны?',
                'answer' => 'Traits — механизм горизонтального переиспользования кода. Решают ограничение единичного наследования, позволяя подмешивать методы и свойства в классы.',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работает spl_autoload_register и PSR-4?',
                'answer' => 'spl_autoload_register регистрирует функцию автозагрузки классов. PSR-4 — стандарт маппинга namespace на пути файлов, реализуемый Composer-ом автоматически.',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое match-выражение и чем оно отличается от switch?',
                'answer' => 'match — выражение со строгим сравнением (===), без fallthrough, возвращает значение, требует исчерпывающих веток или выбрасывает UnhandledMatchError.',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое enum в PHP 8.1+?',
                'answer' => 'Перечисление — фиксированный набор именованных значений. Backed enum имеет скалярный тип (string|int) и методы from/tryFrom для конвертации из значений.',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое nullsafe-оператор ?->?',
                'answer' => 'Сокращение цепочки вызовов: если левая часть null, цепочка возвращает null без NullPointerException. $a?->b()?->c.',
            ],
            [
                'category' => 'OOP',
                'question' => 'Перечислите принципы SOLID.',
                'answer' => 'Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, Dependency Inversion.',
            ],
            [
                'category' => 'OOP',
                'question' => 'Чем абстрактный класс отличается от интерфейса?',
                'answer' => 'Абстрактный класс может содержать реализацию и состояние, поддерживает единичное наследование. Интерфейс — только контракт без состояния, поддерживает множественную реализацию.',
            ],
            [
                'category' => 'OOP',
                'question' => 'Что такое Dependency Injection?',
                'answer' => 'Передача зависимостей объекту извне (через конструктор, сеттер, метод) вместо создания их внутри. Упрощает тестирование и снижает связанность.',
            ],
            [
                'category' => 'OOP',
                'question' => 'Чем композиция лучше наследования?',
                'answer' => 'Композиция гибче: поведение собирается из независимых объектов в рантайме, нет жёсткой иерархии, проще менять и тестировать. Принцип "favor composition over inheritance".',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Service Container в Laravel?',
                'answer' => 'IoC-контейнер для управления зависимостями: регистрирует биндинги, разрешает зависимости через рефлексию, поддерживает singleton и contextual binding.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем отличается Service Provider от Middleware?',
                'answer' => 'Service Provider регистрирует биндинги и бутстрапит сервисы при старте приложения. Middleware фильтрует HTTP-запросы по конвейеру до и после контроллера.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Eloquent ORM и Active Record?',
                'answer' => 'Eloquent — реализация паттерна Active Record: одна модель = одна таблица, экземпляр модели = строка, методы модели инкапсулируют CRUD и связи.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем hasOne отличается от belongsTo?',
                'answer' => 'hasOne — обратная сторона связи "один-к-одному" со стороны родителя (FK на дочерней). belongsTo — со стороны дочерней (FK у себя).',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое N+1 проблема и как её решать в Eloquent?',
                'answer' => 'N+1 — N дополнительных запросов на связанные записи при итерации. Решается eager loading через with(), withCount() или предзагрузкой через load().',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем отличаются queue jobs от events?',
                'answer' => 'Job — единица фоновой работы, ставится в очередь и выполняется воркером. Event — синхронное или асинхронное уведомление с N подписчиками-листенерами.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что делает middleware throttle?',
                'answer' => 'Ограничивает число запросов с одного клиента за период (rate limiting), используя кэш для счётчиков. Например, throttle:60,1 — 60 запросов в минуту.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем отличается Request от FormRequest?',
                'answer' => 'FormRequest — наследник Request с валидацией и авторизацией в отдельном классе. Валидация запускается до контроллера, ошибки автоматически возвращаются.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Route Model Binding?',
                'answer' => 'Автоматический резолв модели по параметру роута. Implicit — по типу аргумента и имени параметра, explicit — через Route::model или Route::bind.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Policy и Gate?',
                'answer' => 'Gate — замыкание для проверки права действия. Policy — класс, группирующий правила доступа для конкретной модели. Используются через can()/authorize().',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем отличается soft delete от обычного delete?',
                'answer' => 'Soft delete устанавливает deleted_at вместо физического удаления. Записи скрываются из выборок, восстанавливаются через restore(), удаляются окончательно через forceDelete().',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое observers в Eloquent?',
                'answer' => 'Класс с обработчиками событий жизненного цикла модели (creating, created, updating, deleted и т.д.). Регистрируется через ObservedBy-атрибут или Model::observe.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Inertia.js?',
                'answer' => 'Адаптер для построения SPA на классических серверных контроллерах: контроллер возвращает Inertia::render с пропсами, фронт-фреймворк рендерит компонент без отдельного API.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Зачем нужен php artisan optimize?',
                'answer' => 'Кэширует конфиг, роуты, события и вьюхи в одиночные файлы для production. Ускоряет загрузку фреймворка, исключая парсинг при каждом запросе.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое database transaction и как использовать в Laravel?',
                'answer' => 'Атомарная группа SQL-операций, либо все коммитятся, либо все откатываются. В Laravel — DB::transaction(closure) или явные beginTransaction/commit/rollBack.',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Чем отличаются session, cookie и cache в Laravel?',
                'answer' => 'Cookie — данные у клиента. Session — серверное состояние пользователя, обычно идентифицируется cookie. Cache — общее key-value-хранилище без привязки к пользователю.',
            ],
            [
                'category' => 'Database',
                'question' => 'Что такое индекс и когда он не помогает?',
                'answer' => 'Структура для ускорения поиска по столбцам. Не помогает на маленьких таблицах, при низкой селективности, при функциях/преобразованиях столбца, при LIKE %x%.',
            ],
            [
                'category' => 'Database',
                'question' => 'Чем отличается INNER JOIN от LEFT JOIN?',
                'answer' => 'INNER возвращает только пары, удовлетворяющие условию. LEFT возвращает все строки слева плюс совпадения справа, отсутствующие справа заполняются NULL.',
            ],
            [
                'category' => 'Database',
                'question' => 'Что такое ACID?',
                'answer' => 'Свойства транзакций: Atomicity (атомарность), Consistency (согласованность), Isolation (изолированность), Durability (устойчивость).',
            ],
            [
                'category' => 'Database',
                'question' => 'Что такое нормальные формы и зачем нормализация?',
                'answer' => 'Правила декомпозиции таблиц для устранения избыточности и аномалий. 1НФ — атомарность, 2НФ — зависимость от полного ключа, 3НФ — отсутствие транзитивных зависимостей.',
            ],
            [
                'category' => 'Database',
                'question' => 'Чем отличается WHERE от HAVING?',
                'answer' => 'WHERE фильтрует строки до агрегации, HAVING — группы после агрегации. В HAVING можно использовать агрегатные функции, в WHERE — нет.',
            ],
        ];
    }
}
