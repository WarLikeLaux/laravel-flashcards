import { Link, useForm } from '@inertiajs/react';
import { Code2, PencilLine, Puzzle, Spline, StickyNote } from 'lucide-react';
import type { FormEvent, ReactNode } from 'react';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import { Textarea } from '@/components/ui/textarea';
import { knownCategories } from '@/lib/category-colors';
import { cn } from '@/lib/utils';
import flashcards from '@/routes/flashcards';
import type { Flashcard } from '@/types';

type FormData = {
    category: string;
    topic: string;
    difficulty: string;
    question: string;
    answer: string;
    code_example: string;
    code_language: string;
    cloze_text: string;
    short_answer: string;
    assemble_chunks_text: string;
    note: string;
    [key: string]: string;
};

type Props = {
    initial?: Flashcard;
    mode: 'create' | 'edit';
    submitLabel: string;
};

export function FlashcardForm({ initial, mode, submitLabel }: Props) {
    const form = useForm<FormData>({
        category: initial?.category ?? '',
        topic: initial?.topic ?? '',
        difficulty: String(initial?.difficulty ?? 1),
        question: initial?.question ?? '',
        answer: initial?.answer ?? '',
        code_example: initial?.code_example ?? '',
        code_language: initial?.code_language ?? 'php',
        cloze_text: initial?.cloze_text ?? '',
        short_answer: initial?.short_answer ?? '',
        assemble_chunks_text: initial?.assemble_chunks?.join('\n') ?? '',
        note: initial?.note ?? '',
    });

    const submit = (e: FormEvent) => {
        e.preventDefault();
        form.transform((data) => {
            const chunks = data.assemble_chunks_text
                .split('\n')
                .map((s) => s.replace(/\s+$/u, ''))
                .filter((s) => s.length > 0);

            const difficulty = Math.max(
                1,
                Math.min(5, Number(data.difficulty) || 1),
            );

            return {
                category: data.category || null,
                topic: data.topic || null,
                difficulty,
                question: data.question,
                answer: data.answer,
                code_example: data.code_example || null,
                code_language: data.code_example
                    ? data.code_language || 'php'
                    : null,
                cloze_text: data.cloze_text || null,
                short_answer: data.short_answer || null,
                assemble_chunks: chunks.length > 0 ? chunks : null,
                note: data.note || null,
            };
        });

        if (mode === 'create') {
            form.post(flashcards.store().url, {
                preserveScroll: true,
                onSuccess: () => form.reset(),
            });
        } else if (initial) {
            form.patch(flashcards.update(initial.id).url, {
                preserveScroll: true,
            });
        }
    };

    return (
        <form onSubmit={submit} className="flex flex-col gap-4">
            <Card>
                <CardHeader>
                    <CardTitle className="text-base">Основа карточки</CardTitle>
                    <CardDescription>
                        Минимум — вопрос и ответ. Категория группирует карточки
                        и используется в режимах с дистракторами.
                    </CardDescription>
                </CardHeader>
                <CardContent className="flex flex-col gap-4">
                    <div className="flex flex-col gap-2">
                        <Label htmlFor="category">Категория</Label>
                        <Input
                            id="category"
                            list="category-options"
                            value={form.data.category}
                            onChange={(e) =>
                                form.setData('category', e.target.value)
                            }
                            placeholder="PHP, Laravel, OOP, Database…"
                            autoComplete="off"
                        />
                        <datalist id="category-options">
                            {knownCategories.map((c) => (
                                <option key={c} value={c} />
                            ))}
                        </datalist>
                        {form.errors.category && (
                            <p className="text-sm text-destructive">
                                {form.errors.category}
                            </p>
                        )}
                    </div>

                    <div className="grid gap-4 sm:grid-cols-[1fr_140px]">
                        <div className="flex flex-col gap-2">
                            <Label htmlFor="topic">Подкатегория (topic)</Label>
                            <Input
                                id="topic"
                                value={form.data.topic}
                                onChange={(e) =>
                                    form.setData('topic', e.target.value)
                                }
                                placeholder="php.basic_syntax"
                                autoComplete="off"
                                className="font-mono"
                            />
                            {form.errors.topic && (
                                <p className="text-sm text-destructive">
                                    {form.errors.topic}
                                </p>
                            )}
                        </div>
                        <div className="flex flex-col gap-2">
                            <Label htmlFor="difficulty">Сложность 1–5</Label>
                            <Input
                                id="difficulty"
                                type="number"
                                min={1}
                                max={5}
                                value={form.data.difficulty}
                                onChange={(e) =>
                                    form.setData('difficulty', e.target.value)
                                }
                                className="font-mono tabular-nums"
                            />
                            {form.errors.difficulty && (
                                <p className="text-sm text-destructive">
                                    {form.errors.difficulty}
                                </p>
                            )}
                        </div>
                    </div>

                    <div className="flex flex-col gap-2">
                        <Label htmlFor="question">
                            Вопрос
                            <span className="text-destructive">*</span>
                        </Label>
                        <Textarea
                            id="question"
                            value={form.data.question}
                            onChange={(e) =>
                                form.setData('question', e.target.value)
                            }
                            rows={3}
                            required
                        />
                        {form.errors.question && (
                            <p className="text-sm text-destructive">
                                {form.errors.question}
                            </p>
                        )}
                    </div>

                    <div className="flex flex-col gap-2">
                        <Label htmlFor="answer">
                            Развёрнутый ответ
                            <span className="text-destructive">*</span>
                        </Label>
                        <Textarea
                            id="answer"
                            value={form.data.answer}
                            onChange={(e) =>
                                form.setData('answer', e.target.value)
                            }
                            rows={6}
                            required
                        />
                        {form.errors.answer && (
                            <p className="text-sm text-destructive">
                                {form.errors.answer}
                            </p>
                        )}
                    </div>
                </CardContent>
            </Card>

            <SectionCard
                icon={<Code2 className="size-4" />}
                title="Пример кода"
                description="Покажется после ответа в любом режиме. Язык влияет только на подсветку."
            >
                <div className="grid gap-4 md:grid-cols-[1fr_160px]">
                    <div className="flex flex-col gap-2">
                        <Label htmlFor="code_example">Код</Label>
                        <Textarea
                            id="code_example"
                            value={form.data.code_example}
                            onChange={(e) =>
                                form.setData('code_example', e.target.value)
                            }
                            rows={6}
                            spellCheck={false}
                            placeholder={'<?php\n$x = 1;'}
                            className="font-mono"
                        />
                        {form.errors.code_example && (
                            <p className="text-sm text-destructive">
                                {form.errors.code_example}
                            </p>
                        )}
                    </div>
                    <div className="flex flex-col gap-2">
                        <Label htmlFor="code_language">Язык</Label>
                        <Input
                            id="code_language"
                            value={form.data.code_language}
                            onChange={(e) =>
                                form.setData('code_language', e.target.value)
                            }
                            placeholder="php"
                            autoComplete="off"
                        />
                        {form.errors.code_language && (
                            <p className="text-sm text-destructive">
                                {form.errors.code_language}
                            </p>
                        )}
                    </div>
                </div>
            </SectionCard>

            <SectionCard
                icon={<PencilLine className="size-4 text-cyan-500" />}
                title="Заполни пропуски (cloze)"
                description={
                    'Оборачивай слова в {{двойные фигурные}} — каждое станет полем ввода. Пример: php artisan {{make:controller}} {{--resource}}'
                }
            >
                <div className="flex flex-col gap-2">
                    <Label htmlFor="cloze_text">Шаблон с пропусками</Label>
                    <Textarea
                        id="cloze_text"
                        value={form.data.cloze_text}
                        onChange={(e) =>
                            form.setData('cloze_text', e.target.value)
                        }
                        rows={5}
                        spellCheck={false}
                        className="font-mono"
                        placeholder={
                            'php artisan {{make:controller}} UserController {{--resource}}'
                        }
                    />
                    {form.errors.cloze_text && (
                        <p className="text-sm text-destructive">
                            {form.errors.cloze_text}
                        </p>
                    )}
                </div>
            </SectionCard>

            <SectionCard
                icon={<Spline className="size-4 text-violet-500" />}
                title="Точный ввод (type-in)"
                description="Короткий ответ для дословного ввода — название функции, ключевое слово, команда. Опечатки прощаются по Левенштейну (0–2 символа в зависимости от длины)."
            >
                <div className="flex flex-col gap-2">
                    <Label htmlFor="short_answer">Короткий ответ</Label>
                    <Input
                        id="short_answer"
                        value={form.data.short_answer}
                        onChange={(e) =>
                            form.setData('short_answer', e.target.value)
                        }
                        spellCheck={false}
                        autoComplete="off"
                        className="font-mono"
                        placeholder="explode"
                    />
                    {form.errors.short_answer && (
                        <p className="text-sm text-destructive">
                            {form.errors.short_answer}
                        </p>
                    )}
                    <p className="text-xs text-muted-foreground">
                        Это поле также включает карточку в режим «Найди пары»,
                        когда в категории наберётся 4+ таких карточек.
                    </p>
                </div>
            </SectionCard>

            <SectionCard
                icon={<Puzzle className="size-4 text-fuchsia-500" />}
                title="Сборка из блоков (assemble)"
                description={
                    'По одному блоку на строку — пользователь будет собирать цепочку в правильном порядке. Сервер добавит 2 случайных дистрактора из соседних карточек той же категории.'
                }
            >
                <div className="flex flex-col gap-2">
                    <Label htmlFor="assemble_chunks_text">
                        Блоки (по строке)
                    </Label>
                    <Textarea
                        id="assemble_chunks_text"
                        value={form.data.assemble_chunks_text}
                        onChange={(e) =>
                            form.setData('assemble_chunks_text', e.target.value)
                        }
                        rows={6}
                        spellCheck={false}
                        className="font-mono"
                        placeholder={"User::\nwhere('active', 1)\n->\nget()"}
                    />
                    {form.errors.assemble_chunks && (
                        <p className="text-sm text-destructive">
                            {form.errors.assemble_chunks}
                        </p>
                    )}
                    <p className="text-xs text-muted-foreground">
                        Минимум 2 блока. Соседние блоки склеиваются подряд при
                        отображении.
                    </p>
                </div>
            </SectionCard>

            <SectionCard
                icon={<StickyNote className="size-4 text-amber-500" />}
                title="Личная заметка"
                description="Мнемоника, ассоциация, ссылка — что угодно своё. Показывается в /learn и /review."
            >
                <div className="flex flex-col gap-2">
                    <Label htmlFor="note">Заметка</Label>
                    <Textarea
                        id="note"
                        value={form.data.note}
                        onChange={(e) => form.setData('note', e.target.value)}
                        rows={3}
                        placeholder="Своими словами, ассоциация, ссылка…"
                    />
                    {form.errors.note && (
                        <p className="text-sm text-destructive">
                            {form.errors.note}
                        </p>
                    )}
                </div>
            </SectionCard>

            <Separator />

            <div
                className={cn(
                    'sticky bottom-0 -mx-4 flex flex-row-reverse gap-2 border-t bg-background/95 px-4 py-3 backdrop-blur',
                    'sm:relative sm:mx-0 sm:border-none sm:bg-transparent sm:px-0 sm:py-0 sm:backdrop-blur-none',
                )}
            >
                <Button
                    type="submit"
                    disabled={form.processing}
                    className="flex-1 sm:flex-none"
                >
                    {submitLabel}
                </Button>
                <Button
                    asChild
                    type="button"
                    variant="ghost"
                    className="hidden sm:inline-flex"
                >
                    <Link href={flashcards.index().url}>Отмена</Link>
                </Button>
            </div>
        </form>
    );
}

function SectionCard({
    icon,
    title,
    description,
    children,
}: {
    icon: ReactNode;
    title: string;
    description: string;
    children: ReactNode;
}) {
    return (
        <Card>
            <CardHeader>
                <CardTitle className="flex items-center gap-2 text-base">
                    {icon}
                    {title}
                </CardTitle>
                <CardDescription>{description}</CardDescription>
            </CardHeader>
            <CardContent>{children}</CardContent>
        </Card>
    );
}
