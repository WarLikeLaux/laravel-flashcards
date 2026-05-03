<?php

namespace Database\Seeders\Data\Categories\Php;

class BasicQa
{
    public static function all(): array
    {
        return [
            [
                'category' => 'PHP',
                'question' => 'В чём разница между == и === в PHP?',
                'answer' => '== сравнивает значения с приведением типов, === сравнивает значения и типы строго без приведения.',
                'difficulty' => 2,
                'topic' => 'php.basic_qa',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем readonly свойство отличается от обычного private?',
                'answer' => 'readonly разрешает записать свойство ровно один раз - обычно в конструкторе, но строго это "первая запись из области видимости класса", а не только из конструктора. После первой записи попытка изменить - Error. Доступно с PHP 8.1; на уровне класса (readonly class - все нестатические свойства автоматически readonly) с PHP 8.2; в PHP 8.3 появилась возможность переинициализации внутри __clone() (clone with - можно создать "обновлённую" копию).',
                'difficulty' => 3,
                'topic' => 'php.basic_qa',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое generator и yield?',
                'answer' => 'Generator - функция, возвращающая Iterator через yield, не материализуя весь массив в памяти. Подходит для ленивых последовательностей и потоковой обработки.',
                'difficulty' => 3,
                'topic' => 'php.basic_qa',
            ],
            [
                'category' => 'PHP',
                'question' => 'Чем отличаются include, include_once, require, require_once?',
                'answer' => 'require падает с fatal error если файла нет, include даёт warning. *_once гарантируют единичную загрузку файла за процесс.',
                'difficulty' => 2,
                'topic' => 'php.basic_qa',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое traits и для чего они нужны?',
                'answer' => 'Traits - механизм горизонтального переиспользования кода. Решают ограничение единичного наследования, позволяя подмешивать методы и свойства в классы.',
                'difficulty' => 2,
                'topic' => 'php.basic_qa',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работает spl_autoload_register и PSR-4?',
                'answer' => 'spl_autoload_register регистрирует функцию автозагрузки классов. PSR-4 - стандарт маппинга namespace на пути файлов, реализуемый Composer-ом автоматически.',
                'difficulty' => 3,
                'topic' => 'php.basic_qa',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое nullsafe-оператор ?->?',
                'answer' => 'Сокращение цепочки вызовов: если левая часть null, оператор ?-> возвращает null и short-circuit-ит остаток цепочки вместо TypeError/Error при обращении к методу/свойству у null (в PHP нет Java-style NullPointerException). $a?->b()?->c.',
                'difficulty' => 3,
                'topic' => 'php.basic_qa',
            ],
        ];
    }
}
