# LaraCards

Тренажёр карточек для подготовки к собеседованиям по PHP, Laravel, ООП, базам данных и архитектуре систем.

## Стек

Laravel 13 · Inertia 3 · React 19 · TypeScript · Tailwind 4 · shadcn/ui (Radix) · Pest 4 · SQLite · prism-react-renderer · Vite 8 · SSR

## Поток обучения

```
/learn   →   /study   →   /review
ознакомление    проверка    повторение
```

1. **`/learn`** — карточка показывает вопрос **и** ответ сразу. Кнопка «Изучил» ставит `studied=true`, после чего карточка попадает в проверку.
2. **`/study`** — 7 режимов чередуются автоматически. Карточка считается выученной, когда правильно отвечена в **3 разных режимах**.
3. **`/review`** — выученные карточки прогоняются один раз за сессию (состояние в `review.seen` в session). Кнопка «Помню» отмечает просмотр, «Забыл» откатывает прогресс полностью.

## Функционал

**Карточки**
- CRUD: создание, редактирование, удаление
- Поля: `category`, `topic`, `difficulty` (1–5), `question`, `answer`, опциональный `code_example` + `code_language`
- Поля для режимов: `cloze_text`, `short_answer`, `assemble_chunks` (2–20 элементов)

**Список `/flashcards`**
- Пагинация по 24 карточки на страницу с сохранением фильтров в URL
- Сортировка по `difficulty` ↑, затем по id ↑ — лёгкие первыми
- Поиск по вопросу/ответу/категории/`short_answer` (debounce 250 мс)
- Фильтр статуса: Все / К повтору / Выучено
- Фильтр по категории через цветные чипы с прогресс-барами
- Сброс прогресса всей колоды одним кликом
- Меню действий на карточке: Редактировать / Удалить

**Ознакомление `/learn`**
- Показывает вопрос + полный ответ + код одновременно
- Берёт unstudied-карточки с минимальной `difficulty` среди отфильтрованных
- Фильтры по категории и `topic`
- Кнопка «Изучил» помечает карточку как `studied=true` и переходит к следующей

**Проверка `/study`** — 7 режимов:

| Режим | Условие | Описание |
|---|---|---|
| Открыть ответ | всегда | Самооценка Знал / Не знал |
| Правда / Ложь | ≥1 соседа в `topic` или категории | Реальный или чужой ответ |
| Выбор варианта | ≥3 соседей | 1 правильный + 3 дистрактора |
| Заполни пропуски | есть `cloze_text` | Inputs прямо в шаблоне `{{…}}`, levenshtein-tolerance 1 |
| Точный ввод | есть `short_answer` | Один input, прощает опечатки (0/1/2 по длине) |
| Собрать из блоков | `assemble_chunks` ≥ 2 | Цепочка из блоков + 2 дистрактора из соседей |
| Найди пары | ≥4 due-карточек в `topic`/категории с `short_answer` | 4 термина ↔ 4 коротких ответа, шанс показа 1/5 |

- Очередная карточка выбирается из колоды с минимальной `difficulty` среди due (`studied=true` ∧ (`is_learned=false` ∨ `next_review_at <= now()`))
- Соседями считаются карточки с тем же `topic`, иначе — с той же категорией
- Каждой карточке режим выбирается **из ещё не пройденных** ею (по `correct_modes`), пока пул не исчерпан
- Verdict-баннер после ответа: «Повторить» (пропустить без зачёта, `?exclude={id}`) или «Дальше» (зачесть результат)

**Повторение `/review`**
- Прогоняет один раз за сессию все выученные карточки в случайном порядке
- Состояние просмотра в session-ключе `review.seen` — список id показанных карточек
- «Помню» добавляет id в `review.seen`, «Забыл» дополнительно вызывает `markIncorrect()` (сброс)
- Кнопка `POST /review/reset` чистит сессионный список

## Алгоритм заучивания

```
unstudied (studied=false)
   │  /learn → markStudied()
   ▼
studied (studied=true, is_learned=false)
   │  /study, 3 правильных в РАЗНЫХ режимах (correct_modes)
   ▼
learned (is_learned=true, srs_step=0, next_review_at=now()+1д)
   │  spaced repetition: SRS_INTERVALS_DAYS = [1, 3, 5, 7]
   ▼
mastered (srs_step≥4, next_review_at=null) — больше не всплывает
```

- `LEARN_THRESHOLD = 3` — нужно столько разных режимов
- При каждом правильном ответе на учебной карточке режим добавляется в `correct_modes` (только уникальные)
- Когда количество разных режимов достигает `required_correct` — карточка `is_learned=true`, `srs_step=0`, `next_review_at = now()+1 день`
- Каждый последующий правильный ответ продвигает SRS: `+3 → +5 → +7 → mastered (next_review_at=null)`
- Любая ошибка на любом этапе обнуляет всё: `correct_streak=0`, `correct_modes=[]`, `is_learned=false`, `srs_step=0`, `next_review_at=null`
- На странице `/review` кнопка «Забыл» делает то же самое

## Сидер

650 карточек по реальным middle/senior собеседованиям, разбиты по 90 топикам:

| Категория | Карточек | Топиков |
|---|---|---|
| Laravel | 169 | 27 |
| PHP | 136 | 17 |
| Базы данных | 130 | 16 |
| ООП | 109 | 21 |
| Архитектура систем | 106 | 9 |

Структура: `database/seeders/Data/Categories/{Php,Oop,Laravel,Database,SystemDesign}/<Topic>.php`. Топики (`php.arrays`, `laravel.eloquent_basics`, `oop.solid`, `database.indexes`, `system_design.distributed`…) дают точное соседство для режимов Правда/Ложь, Выбор варианта и Найди пары.

## Установка

```bash
make install     # composer + npm + .env + key + sqlite + миграции
make seed        # 650 карточек
make dev         # server + queue + logs + vite одной командой
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

GET    /learn                        unstudied-карточка (Q+A одновременно)
POST   /learn/{id}/studied           отметить как изученную

GET    /study                        случайный режим под случайную due-карточку
POST   /study/{id}/answer            результат correct/incorrect (+ mode)
POST   /study/matching               пакетная проверка пар

GET    /review                       выученная карточка из session-выборки
POST   /review/{id}/remember         «Помню» — отметить как просмотренную в сессии
POST   /review/{id}/forgot           «Забыл» — отметить + откатить прогресс
POST   /review/reset                 сбросить session-список просмотренных
```

## Команды

```bash
make test        # pest, 57 тестов
make lint        # pint + eslint --fix + prettier
make lint-check  # без правок (pint + eslint + prettier + tsc)
make ci          # полный пайплайн
```
