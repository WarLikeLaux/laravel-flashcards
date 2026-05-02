<?php

namespace Database\Seeders\Data\Categories\Oop;

class Cloze
{
    public static function all(): array
    {
        return [
            [
                'category' => 'ООП',
                'topic' => 'oop.cloze',
                'difficulty' => 2,
                'question' => 'Заполни декларацию интерфейса и реализации для команды.',
                'answer' => 'interface вводит контракт, implements обязывает класс реализовать все методы.',
                'cloze_text' => '{{interface}} Command {
    public function execute(): void;
}

class SendEmail {{implements}} Command {
    public function execute(): void { /* ... */ }
}',
            ],
        ];
    }
}
