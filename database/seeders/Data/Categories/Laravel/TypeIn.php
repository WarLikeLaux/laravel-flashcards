<?php

namespace Database\Seeders\Data\Categories\Laravel;

class TypeIn
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, short_answer?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Команда artisan, очищающая весь app-cache (config, route, view, events).',
                'answer' => 'optimize:clear объединяет config:clear, route:clear, view:clear, event:clear, cache:clear.',
                'short_answer' => 'optimize:clear',
                'difficulty' => 2,
                'topic' => 'laravel.type_in',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Метод query builder для агрегата по выбранному столбцу с округлением вниз.',
                'answer' => 'Метод avg возвращает среднее значение. Похожие: sum, max, min, count.',
                'short_answer' => 'avg',
                'difficulty' => 2,
                'topic' => 'laravel.type_in',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Хелпер, который возвращает singleton-экземпляр приложения.',
                'answer' => 'app() без аргументов вернёт Illuminate\\Foundation\\Application; с аргументом - резолвит зависимость из контейнера.',
                'short_answer' => 'app',
                'difficulty' => 2,
                'topic' => 'laravel.type_in',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Метод модели, перезагружающий её атрибуты из БД.',
                'answer' => 'fresh() возвращает новый экземпляр, refresh() перезаписывает текущий и возвращает $this.',
                'short_answer' => 'refresh',
                'difficulty' => 2,
                'topic' => 'laravel.type_in',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Фасад для отправки события в очередь broadcast.',
                'answer' => 'event(new SomethingHappened(...)) публикует событие; для broadcasting класс реализует ShouldBroadcast.',
                'short_answer' => 'event',
                'difficulty' => 2,
                'topic' => 'laravel.type_in',
            ],
        ];
    }
}
