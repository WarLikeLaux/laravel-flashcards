# LaraCards

Тренажёр карточек для подготовки к собеседованиям по PHP, Laravel, ООП, БД и system design.

## Стек

Laravel 13 · Inertia 3 · React 19 · TypeScript · Tailwind 4 · shadcn/ui · Pest 4 · SQLite · prism-react-renderer

## Функционал

**Карточки**
- CRUD: создание, редактирование, удаление
- Поля: вопрос, развёрнутый ответ, категория, пример кода с подсветкой
- Дополнительные поля включают режимы: `cloze_text`, `short_answer`, `assemble_chunks`

**Список `/flashcards`**
- Поиск по вопросу/ответу/категории/short_answer (debounce 250 мс)
- Фильтр статуса: Все / К повтору / Выучено
- Фильтр по категории через цветные чипы с прогресс-барами
- Сброс прогресса всей колоды
- Меню действий на карточке: Редактировать / Удалить

**Изучение `/study`** — 7 режимов, чередуются автоматически:

| Режим | Условие | Описание |
|---|---|---|
| Открыть ответ | всегда | Самооценка Знал / Не знал |
| Правда / Ложь | ≥1 соседа в категории | Реальный или чужой ответ |
| Выбор варианта | ≥3 соседей | 1 правильный + 3 дистрактора |
| Заполни пропуски | есть `cloze_text` | Inputs прямо в шаблоне `{{…}}`, levenshtein-tolerance 1 |
| Точный ввод | есть `short_answer` | Один input, прощает опечатки (0/1/2 по длине) |
| Собрать из блоков | `assemble_chunks` ≥ 2 | Цепочка из блоков + 2 дистрактора из категории |
| Найди пары | ≥4 due-карточек категории с `short_answer` | 4 термина ↔ 4 коротких ответа |

**Алгоритм повторения**
- Старт: `correct_streak=0`, `required_correct=1`
- Правильный ответ: `correct_streak++`, при достижении `required_correct` — `is_learned=true`
- Ошибка: `correct_streak=0`, `required_correct++` — нужно правильно ответить ещё раз

**Сидер** — 160 карточек с реальных middle/senior собеседований. Категории: PHP, Laravel, Database, OOP, System Design.

## Установка

```bash
make install     # composer + npm + .env + key + sqlite + миграции
make dev         # server + queue + logs + vite одной командой
php artisan db:seed
```

## Маршруты

```
GET    /flashcards                   список + фильтры (?q, ?status, ?category)
GET    /flashcards/create            форма создания
POST   /flashcards                   создание
GET    /flashcards/{id}/edit         форма редактирования
PATCH  /flashcards/{id}              обновление (прогресс сохраняется)
DELETE /flashcards/{id}              удаление
POST   /flashcards/reset             сброс прогресса всех карточек

GET    /study                        случайный режим под случайную карточку
POST   /study/{id}/answer            результат correct/incorrect
POST   /study/matching               пакетная проверка пар
```

## Команды

```bash
make test        # pest, 35 тестов
make lint        # pint + eslint --fix + prettier
make lint-check  # без правок
make ci          # полный пайплайн
```
