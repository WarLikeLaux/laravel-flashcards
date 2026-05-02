# LaraCards

Тренажёр карточек для подготовки к собеседованиям по PHP, Laravel, ООП, базам данных и архитектуре систем.

## Стек

Laravel 13 · Inertia 3 · React 19 · TypeScript · Tailwind 4 · shadcn/ui · Pest 4 · SQLite · prism-react-renderer

## Функционал

**Карточки**
- CRUD: создание, редактирование, удаление
- Поля: вопрос, развёрнутый ответ, категория, `topic`, `difficulty` (1–5), пример кода с подсветкой
- Дополнительные поля для режимов: `cloze_text`, `short_answer`, `assemble_chunks`

**Список `/flashcards`**
- Пагинация по 24 карточки на страницу с сохранением фильтров в URL
- Сортировка по `difficulty` ↑, затем по id ↑ — лёгкие появляются первыми
- Поиск по вопросу/ответу/категории/`short_answer` (debounce 250 мс)
- Фильтр статуса: Все / К повтору / Выучено
- Фильтр по категории через цветные чипы с прогресс-барами
- Сброс прогресса всей колоды
- Меню действий на карточке: Редактировать / Удалить

**Изучение `/study`** — 7 режимов, чередуются автоматически:

| Режим | Условие | Описание |
|---|---|---|
| Открыть ответ | всегда | Самооценка Знал / Не знал |
| Правда / Ложь | ≥1 соседа в `topic` или категории | Реальный или чужой ответ |
| Выбор варианта | ≥3 соседей | 1 правильный + 3 дистрактора |
| Заполни пропуски | есть `cloze_text` | Inputs прямо в шаблоне `{{…}}`, levenshtein-tolerance 1 |
| Точный ввод | есть `short_answer` | Один input, прощает опечатки (0/1/2 по длине) |
| Собрать из блоков | `assemble_chunks` ≥ 2 | Цепочка из блоков + 2 дистрактора из соседей |
| Найди пары | ≥4 due-карточек в `topic`/категории с `short_answer` | 4 термина ↔ 4 коротких ответа, 1/5 шанс на показе |

Очередная карточка выбирается из колоды с минимальной `difficulty` среди due-карточек (`is_learned=false`). Соседями считаются карточки с тем же `topic`, иначе — с той же категорией.

**Алгоритм повторения**
- Старт: `correct_streak=0`, `correct_modes=[]`, `required_correct=3` (`Flashcard::LEARN_THRESHOLD`)
- Правильный ответ: `correct_streak++`, режим добавляется в `correct_modes` (только уникальные)
- Карточка считается выученной (`is_learned=true`), когда количество **разных режимов** в `correct_modes` достигло `required_correct` — нужно правильно ответить в трёх разных режимах
- Ошибка: `correct_streak=0`, `correct_modes=[]`, `is_learned=false` — обнуление полностью

**Сидер** — 650 карточек по реальным middle/senior собеседованиям, разбиты по категориям и `topic`:

| Категория | Кол-во |
|---|---|
| Laravel | 169 |
| PHP | 136 |
| Базы данных | 130 |
| ООП | 109 |
| Архитектура систем | 106 |

Каждая категория поделена на 15–25 топиков (`php.arrays`, `laravel.eloquent_basics`, `oop.solid`, `database.indexes`, `system_design.distributed` и т. п.) — это даёт более точное соседство для режимов Правда/Ложь, Выбор варианта, Найди пары.

## Установка

```bash
make install     # composer + npm + .env + key + sqlite + миграции
make dev         # server + queue + logs + vite одной командой
make seed        # 650 карточек
```

## Маршруты

```
GET    /flashcards                   список + пагинация (?page, ?q, ?status, ?category)
GET    /flashcards/create            форма создания
POST   /flashcards                   создание
GET    /flashcards/{id}/edit         форма редактирования
PATCH  /flashcards/{id}              обновление (прогресс сохраняется)
DELETE /flashcards/{id}              удаление
POST   /flashcards/reset             сброс прогресса всех карточек

GET    /study                        случайный режим под случайную карточку
POST   /study/{id}/answer            результат correct/incorrect (+ mode)
POST   /study/matching               пакетная проверка пар
```

## Команды

```bash
make test        # pest, 35 тестов
make lint        # pint + eslint --fix + prettier
make lint-check  # без правок (pint + eslint + prettier + tsc)
make ci          # полный пайплайн
```
