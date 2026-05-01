# LaraCards - Laravel Flashcards

Тренажёр карточек для подготовки к собеседованиям по PHP, ООП, Laravel, базам данных и system design. 7 режимов изучения чередуются случайно, прогрессивное повторение поднимает планку правильных ответов после каждой ошибки.

## Стек

- PHP 8.3+ (CI на 8.5)
- Laravel 13.7 + Inertia 3 + Wayfinder
- React 19 + TypeScript + Vite 8
- Tailwind 4, Radix UI, shadcn-стиль
- prism-react-renderer для подсветки кода
- Pest 4 (unit + feature)
- SQLite по умолчанию
- Pint, ESLint, Prettier, tsc

## Что внутри

- Модель `Flashcard` со spaced-repetition: `markCorrect`, `markIncorrect`, `resetProgress`, scope `due`
- 7 режимов study с автоматическим выбором по содержимому карточки
- CRUD карточек на Inertia: список со статистикой, создание (с code-примером), удаление, сброс прогресса
- Сидер на 160 карточек с реальных middle/senior собеседований
- Подсветка кода в карточках и режимах study
- Тесты на модель, оба контроллера и все режимы
- CI: Pest + Pint + ESLint + Prettier + tsc

## Алгоритм повторения

- Старт: `correct_streak=0`, `required_correct=1`, `is_learned=false`
- Правильный ответ: `correct_streak++`, при достижении `required_correct` карточка помечается выученной
- Ошибка: `correct_streak=0`, `required_correct++`, карточка снова в очереди и теперь требует на один правильный ответ больше
- `resetProgress` или `flashcards.reset` обнуляют всё разом

## Режимы study

Контроллер выбирает режим случайно из доступных под конкретную карточку (или мини-режим matching по категории). После любого ответа — markCorrect/markIncorrect и редирект на `/study` со следующим случайным режимом.

| Режим | Когда доступен | UI |
|---|---|---|
| `reveal` | всегда | вопрос → «Show answer» → самооценка Right/Wrong |
| `true_false` | ≥1 соседа в категории | показывается реальный или чужой ответ из той же категории, кнопки True/False с подсветкой |
| `multiple_choice` | ≥3 соседей | 4–10 вариантов (1 правильный + дистракторы из категории), подсветка верного и выбранного |
| `cloze` | есть `cloze_text` с `{{...}}` | inline inputs прямо в коде/тексте, levenshtein-tolerance 1 |
| `type_in` | есть `short_answer` | один input + Enter, прощает опечатки (tolerance растёт по длине: 0/1/2 символа) |
| `assemble` | `assemble_chunks` ≥2 | пул кусочков (правильные + 2 дистрактора из соседних карточек) → собрать тапами в нужном порядке |
| `matching` | ≥4 due-карточек одной категории с `short_answer` (~20% шанс) | 4 термина ↔ 4 коротких ответа, попарный клик, проверка по совпадению id |

Cloze/type_in/assemble — клиент сам сравнивает ввод с ожидаемым и шлёт `result` в `study.answer`. Type-in использует Levenshtein для tolerance к опечаткам.

Matching — отдельный endpoint `study.matching`: для каждой пары `{question_id, answer_id}` сервер сверяет совпадение и атомарно делает markCorrect/markIncorrect для соответствующей карточки.

## Поля карточки

- `category` — PHP, OOP, Laravel, Database, System Design
- `question`, `answer` — основной текст
- `code_example`, `code_language` — опциональный фрагмент кода с подсветкой (показывается после ответа)
- `cloze_text` — шаблон с пропусками вида `php artisan {{make:controller}} {{--resource}}` (включает режим cloze)
- `short_answer` — короткий точный ответ для type-in и matching (например, `explode`)
- `assemble_chunks` — JSON-массив правильной последовательности кусочков для duolingo-style сборки
- Прогресс: `correct_streak`, `required_correct`, `is_learned`

## Маршруты

- `/` редирект на `/flashcards`
- `GET /flashcards` список + статистика, показ code-примеров с подсветкой
- `GET /flashcards/create`, `POST /flashcards` создание (поддерживает все опциональные поля)
- `DELETE /flashcards/{id}` удаление
- `POST /flashcards/reset` сброс прогресса всех карточек
- `GET /study` случайный режим под случайную карточку (или матчинг)
- `POST /study/{id}/answer` приём результата `correct`/`incorrect`
- `POST /study/matching` пакетная проверка пар `[{question_id, answer_id}, …]`

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

Загружает 160 карточек из трёх источников:

- 35 базовых вопросов (`FlashcardSeeder::cards()`) — основы по PHP/ООП/Laravel/Database
- 90 middle/senior вопросов (`Database\Seeders\Data\InterviewQuestions`) — реальные с собеседований, 58 с code-примерами: copy-on-write, fibers, JIT, opcache, GC, SOLID с реальными нарушениями LSP, deferred providers, contextual binding, Octane caveats, polymorphic eager loading, isolation levels с аномалиями, MVCC, partitioning, replication lag, materialized views, system design (rate limiter, idempotency, sharding, CDN, event sourcing)
- 35 advanced (`Database\Seeders\Data\AdvancedQuestions`) — семплы для новых режимов: 10 cloze, 15 type-in, 10 assemble

Распределение по категориям: PHP 37, Laravel 41, Database 21, OOP 18, System Design 8.

## Тесты и качество

```bash
make test        # pest, 27 тестов
make lint        # pint + eslint --fix + prettier
make lint-check  # без правок
make ci          # полный пайплайн как в github actions
```

## Структура

```
app/
  Http/Controllers/   FlashcardController, StudyController
  Http/Requests/      StoreFlashcardRequest
  Models/             Flashcard
database/
  migrations/         create_flashcards_table
                      add_code_example_to_flashcards_table
                      add_advanced_study_fields_to_flashcards_table
  seeders/            DatabaseSeeder, FlashcardSeeder
  seeders/Data/       InterviewQuestions, AdvancedQuestions
  factories/          FlashcardFactory (states: learned, withCode,
                      withCloze, withShortAnswer, withAssemble)
resources/js/
  components/code-block.tsx          подсветка через prism-react-renderer
  components/study/                  reveal/true-false/multiple-choice/
                                     cloze/type-in/assemble/matching modes
                                     + answer-form, card-code
  lib/levenshtein.ts                 distance + looseEquals
  pages/flashcards/   index.tsx, create.tsx
  pages/study/        index.tsx (оркестратор режимов)
  types/flashcard.ts  Flashcard, StudyMode, StudyShown, StudyOption,
                      StudyAssemble, StudyMatching
routes/web.php
tests/
  Unit/        FlashcardTest
  Feature/     FlashcardControllerTest, StudyControllerTest
```
