import { Form, Head, Link } from '@inertiajs/react';
import {
    GraduationCap,
    Layers,
    PencilLine,
    Plus,
    Puzzle,
    RotateCcw,
    Spline,
    Trash2,
} from 'lucide-react';
import { CategoryBadge } from '@/components/category-badge';
import { CodeBlock } from '@/components/code-block';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import flashcards from '@/routes/flashcards';
import study from '@/routes/study';
import type { Flashcard, FlashcardStats } from '@/types';

type Props = {
    flashcards: Flashcard[];
    stats: FlashcardStats;
};

export default function FlashcardsIndex({ flashcards: cards, stats }: Props) {
    const dueCount = stats.due;
    const learnedPercent =
        stats.total === 0 ? 0 : Math.round((stats.learned / stats.total) * 100);

    return (
        <>
            <Head title="Карточки" />

            <div className="flex flex-1 flex-col gap-5 px-4 pt-4 pb-24 sm:gap-6 sm:px-6 sm:pt-6 sm:pb-12">
                <div className="overflow-hidden rounded-2xl border bg-gradient-to-br from-violet-500/10 via-background to-fuchsia-500/10 p-5 sm:p-7">
                    <div className="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between sm:gap-6">
                        <div className="flex flex-col gap-1">
                            <h1 className="text-2xl font-semibold tracking-tight sm:text-3xl">
                                Карточки
                            </h1>
                            <p className="text-sm text-muted-foreground">
                                Тренажёр для подготовки к собеседованиям. Семь
                                режимов изучения чередуются автоматически.
                            </p>
                        </div>

                        <div className="flex flex-wrap items-center gap-2">
                            <Button
                                asChild
                                size="lg"
                                className="bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white shadow-md hover:from-violet-700 hover:to-fuchsia-700"
                            >
                                <Link href={study.show().url}>
                                    <GraduationCap />
                                    Учить
                                    {dueCount > 0 && (
                                        <Badge
                                            variant="secondary"
                                            className="ml-1 bg-white/20 text-white"
                                        >
                                            {dueCount}
                                        </Badge>
                                    )}
                                </Link>
                            </Button>
                            <Button asChild variant="outline" size="lg">
                                <Link href={flashcards.create().url}>
                                    <Plus />
                                    Добавить
                                </Link>
                            </Button>
                        </div>
                    </div>

                    <div className="mt-5 grid grid-cols-3 gap-3 sm:max-w-md">
                        <Stat label="Всего" value={stats.total} />
                        <Stat label="К повтору" value={stats.due} />
                        <Stat
                            label="Выучено"
                            value={`${stats.learned} (${learnedPercent}%)`}
                        />
                    </div>

                    {stats.total > 0 && (
                        <div className="mt-5">
                            <Form action={flashcards.reset().url} method="post">
                                <Button
                                    type="submit"
                                    variant="ghost"
                                    size="sm"
                                    className="text-muted-foreground"
                                >
                                    <RotateCcw />
                                    Сбросить прогресс
                                </Button>
                            </Form>
                        </div>
                    )}
                </div>

                {cards.length === 0 ? (
                    <Card className="border-dashed">
                        <CardContent className="flex flex-col items-center gap-3 py-16 text-center">
                            <div className="flex size-12 items-center justify-center rounded-xl bg-muted">
                                <Plus className="size-6 text-muted-foreground" />
                            </div>
                            <CardTitle>Пока нет карточек</CardTitle>
                            <CardDescription className="max-w-sm">
                                Добавь первую карточку — можно сразу с кодом,
                                пропусками или порядком блоков для разных
                                режимов.
                            </CardDescription>
                            <Button asChild>
                                <Link href={flashcards.create().url}>
                                    <Plus />
                                    Добавить карточку
                                </Link>
                            </Button>
                        </CardContent>
                    </Card>
                ) : (
                    <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        {cards.map((card) => (
                            <FlashcardCard key={card.id} card={card} />
                        ))}
                    </div>
                )}
            </div>
        </>
    );
}

function Stat({ label, value }: { label: string; value: number | string }) {
    return (
        <div className="rounded-xl border bg-background/60 p-3 backdrop-blur">
            <p className="text-[11px] tracking-wide text-muted-foreground uppercase">
                {label}
            </p>
            <p className="mt-1 text-lg font-semibold tabular-nums">{value}</p>
        </div>
    );
}

function FlashcardCard({ card }: { card: Flashcard }) {
    return (
        <Card className="flex flex-col overflow-hidden transition-shadow hover:shadow-md">
            <CardHeader className="gap-2">
                <div className="flex items-center justify-between gap-2">
                    <CategoryBadge category={card.category} />
                    {card.is_learned ? (
                        <Badge className="border-emerald-500/30 bg-emerald-500/15 text-emerald-700 dark:text-emerald-300">
                            выучено
                        </Badge>
                    ) : (
                        <Badge
                            variant="outline"
                            className="font-mono tabular-nums"
                        >
                            {card.correct_streak}/{card.required_correct}
                        </Badge>
                    )}
                </div>
                <CardTitle className="text-base leading-snug">
                    {card.question}
                </CardTitle>
                <FlashcardModes card={card} />
            </CardHeader>
            <CardContent className="flex flex-1 flex-col gap-4">
                <p className="text-sm whitespace-pre-line text-muted-foreground">
                    {card.answer}
                </p>
                {card.code_example && (
                    <CodeBlock
                        code={card.code_example}
                        language={card.code_language}
                    />
                )}
                <Form
                    action={flashcards.destroy(card.id).url}
                    method="delete"
                    className="mt-auto flex justify-end"
                >
                    <Button
                        type="submit"
                        variant="ghost"
                        size="sm"
                        className="text-muted-foreground hover:text-destructive"
                    >
                        <Trash2 />
                        Удалить
                    </Button>
                </Form>
            </CardContent>
        </Card>
    );
}

function FlashcardModes({ card }: { card: Flashcard }) {
    const modes: { label: string; icon: typeof PencilLine }[] = [];

    if (card.code_example) {
        modes.push({ label: 'код', icon: Layers });
    }

    if (card.cloze_text) {
        modes.push({ label: 'пропуски', icon: PencilLine });
    }

    if (card.short_answer) {
        modes.push({ label: 'ввод', icon: Spline });
    }

    if (card.assemble_chunks) {
        modes.push({ label: 'сборка', icon: Puzzle });
    }

    if (modes.length === 0) {
        return null;
    }

    return (
        <div className="flex flex-wrap gap-1">
            {modes.map(({ label, icon: Icon }) => (
                <Badge
                    key={label}
                    variant="secondary"
                    className="gap-1 px-1.5 py-0 text-[10px] font-normal"
                >
                    <Icon className="size-3" />
                    {label}
                </Badge>
            ))}
        </div>
    );
}
