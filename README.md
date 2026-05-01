# LaraCards - Laravel Flashcards

Тренажёр карточек для подготовки к собеседованиям по PHP, ООП, Laravel и базам данных. Карточки с прогрессивным повторением: ошибся, поднимается планка обязательных правильных подряд.

## Стек

- PHP 8.3+ (CI на 8.5)
- Laravel 13.7 + Inertia 3 + Wayfinder
- React 19 + TypeScript + Vite 8
- Tailwind 4, Radix UI, shadcn-стиль
- Pest 4 (unit + feature)
- SQLite по умолчанию
- Pint, ESLint, Prettier, tsc

## Что внутри

- Модель `Flashcard` со spaced-repetition: `markCorrect`, `markIncorrect`, `resetProgress`, scope `due`
- CRUD карточек на Inertia: список со статистикой, создание, удаление, сброс прогресса
- Режим изучения: случайная необученная карточка, ответ правильно/неправильно
- Сидер `FlashcardSeeder` с 35 вопросами по PHP, ООП, Laravel, Database
- Тесты на модель и оба контроллера
- CI: Pest + Pint + ESLint + Prettier + tsc

## Алгоритм повторения

- Старт: `correct_streak=0`, `required_correct=1`, `is_learned=false`
- Правильный ответ: `correct_streak++`, при достижении `required_correct` карточка помечается выученной
- Ошибка: `correct_streak=0`, `required_correct++`, карточка снова в очереди и теперь требует на один правильный ответ больше
- `resetProgress` или `flashcards.reset` обнуляют всё разом

## Маршруты

- `/` редирект на `/flashcards`
- `GET /flashcards` список + статистика
- `GET /flashcards/create`, `POST /flashcards` создание
- `DELETE /flashcards/{id}` удаление
- `POST /flashcards/reset` сброс прогресса всех карточек
- `GET /study` случайная карточка из `due`
- `POST /study/{id}/answer` приём ответа `correct`/`incorrect`

## Установка

```bash
make install     # composer + npm + .env + key + sqlite + миграции
make dev         # server + queue + logs + vite одной командой
```

Или вручную через `composer setup`. См. `make help` для всех команд.

## Сидер

```bash
php artisan db:seed
```

Загружает готовые карточки. Категории: PHP, ООП, Laravel, Database.

## Тесты и качество

```bash
make test        # pest
make lint        # pint + eslint --fix + prettier
make lint-check  # без правок
make ci          # полный пайплайн как в github actions
```

## Структура

```
app/
  Http/Controllers/  FlashcardController, StudyController
  Http/Requests/     StoreFlashcardRequest
  Models/            Flashcard
database/
  migrations/        2026_05_01_..._create_flashcards_table
  seeders/           DatabaseSeeder, FlashcardSeeder
  factories/         FlashcardFactory
resources/js/
  pages/flashcards/  index.tsx, create.tsx
  pages/study/       index.tsx
routes/web.php
tests/
  Unit/Feature       FlashcardTest, FlashcardControllerTest, StudyControllerTest
```
