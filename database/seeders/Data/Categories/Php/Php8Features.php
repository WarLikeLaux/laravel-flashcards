<?php

namespace Database\Seeders\Data\Categories\Php;

class Php8Features
{
    public static function all(): array
    {
        return [
            [
                'category' => 'PHP',
                'question' => 'Что такое именованные аргументы (named arguments)?',
                'answer' => 'Named arguments (PHP 8.0+) позволяют передавать аргументы в функцию по имени параметра, а не позиции. Синтаксис: name: value. Полезно когда много опциональных параметров - не нужно помнить порядок и пропускать промежуточные. Можно смешивать с позиционными, но именованные строго после позиционных. С PHP 8.1 - в аттрибутах и enum.',
                'code_example' => '<?php
function createUser(
    string $name,
    int $age = 18,
    bool $isAdmin = false,
    string $role = "user",
) {}

// Старый способ - пришлось бы передавать всё
createUser("Иван", 30, false, "manager");

// Named arguments - только нужное
createUser(name: "Иван", role: "manager");

// Можно в любом порядке
createUser(role: "admin", name: "Аня");

// Смешанно
createUser("Петя", isAdmin: true);

// В сложных функциях очень помогает
str_replace(
    search: ["a", "b"],
    replace: ["1", "2"],
    subject: $text,
);',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'php.php8_features',
            ],
            [
                'category' => 'PHP',
                'question' => 'Как работает match-выражение в PHP 8?',
                'answer' => 'match (PHP 8.0+) - выражение для сопоставления значений, аналог switch, но: 1) использует строгое сравнение ===, 2) возвращает значение, 3) не нуждается в break, 4) выбрасывает UnhandledMatchError если ни одна ветка не подошла, 5) может объединять несколько значений через запятую. Намного безопаснее и лаконичнее switch.',
                'code_example' => '<?php
$status = "active";

// match - выражение
$label = match($status) {
    "active", "online" => "Активен",
    "inactive" => "Неактивен",
    "banned" => "Заблокирован",
    default => "Неизвестно",
};

// switch требует break и не возвращает значение
switch ($status) {
    case "active":
    case "online":
        $label = "Активен";
        break;
    // ...
}

// match со строгим сравнением
$result = match(1) {
    "1" => "string",  // не совпадёт!
    1 => "int",       // совпадёт
};

// Без default - UnhandledMatchError при отсутствии
$x = match($y) { 1 => "a" };',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'php.php8_features',
            ],
            [
                'category' => 'PHP',
                'question' => 'Что такое enum в PHP 8.1?',
                'answer' => 'Enum (PHP 8.1+) - тип-перечисление с фиксированным набором значений. Бывает: pure (просто кейсы) и backed (каждый кейс - значение типа int или string). Поддерживает методы, интерфейсы, статические методы. Кейс - синглтон, сравнение через ===. Backed enum имеет from() (выбросит ошибку) и tryFrom() (вернёт null). Cases() возвращает все варианты.',
                'code_example' => '<?php
// Pure enum
enum Status {
    case Active;
    case Inactive;
    case Banned;
}

$s = Status::Active;
var_dump($s === Status::Active); // true

// Backed enum
enum Role: string {
    case Admin = "admin";
    case User = "user";
    case Guest = "guest";

    public function label(): string {
        return match($this) {
            Role::Admin => "Администратор",
            Role::User => "Пользователь",
            Role::Guest => "Гость",
        };
    }
}

$role = Role::from("admin");          // Role::Admin
$role = Role::tryFrom("xxx");         // null
echo Role::Admin->value;              // "admin"
echo Role::Admin->label();            // "Администратор"
print_r(Role::cases());               // все варианты',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'php.php8_features',
            ],
        ];
    }
}
