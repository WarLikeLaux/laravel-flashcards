import { Head, Link } from '@inertiajs/react';
import { AlertTriangle, BookOpen, Pencil } from 'lucide-react';
import { CategoryBadge } from '@/components/category-badge';
import { CodeBlock } from '@/components/code-block';
import { NoteBlock } from '@/components/note-block';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { topicLabel } from '@/lib/topic-labels';
import { cn } from '@/lib/utils';
import flashcards from '@/routes/flashcards';
import learn from '@/routes/learn';
import type { Flashcard } from '@/types';

type Metrics = {
    total: number;
    bad: number;
    incorrect: number;
    matching_incorrect: number;
    forgot: number;
    skipped: number;
    error_rate: number;
    last_seen: string;
};

type Row = {
    flashcard: Flashcard;
    metrics: Metrics;
};

type Props = {
    rows: Row[];
    window_days: number;
    min_events: number;
};

export default function TroubledIndex({
    rows,
    window_days,
    min_events,
}: Props) {
    return (
        <>
            <Head title="Проблемные" />
            <div className="mx-auto flex w-full max-w-4xl flex-col gap-4 px-4 pt-4 pb-6 sm:px-6 sm:pt-6">
                <Header rows={rows.length} windowDays={window_days} />

                {rows.length === 0 ? (
                    <EmptyState minEvents={min_events} />
                ) : (
                    <div className="flex flex-col gap-3">
                        {rows.map((row) => (
                            <TroubledRow key={row.flashcard.id} row={row} />
                        ))}
                    </div>
                )}
            </div>
        </>
    );
}

function Header({ rows, windowDays }: { rows: number; windowDays: number }) {
    return (
        <div className="flex flex-col gap-3 rounded-2xl border border-rose-500/30 bg-rose-500/10 p-3 sm:flex-row sm:items-center sm:justify-between sm:p-4">
            <div className="flex items-center gap-3">
                <div className="flex size-9 shrink-0 items-center justify-center rounded-xl bg-background/80 text-rose-600 ring-1 ring-rose-500/40 dark:text-rose-300">
                    <AlertTriangle className="size-5" />
                </div>
                <div className="flex flex-col">
                    <span className="text-sm leading-tight font-semibold">
                        Проблемные карточки
                    </span>
                    <span className="text-xs text-muted-foreground">
                        Худшие за {windowDays} дней — высокий error rate, частые
                        ошибки и пропуски.
                    </span>
                </div>
            </div>
            <Badge
                variant="outline"
                className="bg-background/60 tabular-nums"
                title="Всего проблемных в выборке"
            >
                {rows} карточек
            </Badge>
        </div>
    );
}

function TroubledRow({ row }: { row: Row }) {
    const { flashcard, metrics } = row;
    const errorPct = Math.round(metrics.error_rate * 100);

    return (
        <Card className="overflow-hidden">
            <CardHeader className="gap-2">
                <div className="flex flex-wrap items-center gap-2">
                    <CategoryBadge category={flashcard.category} />
                    <DifficultyBadge level={flashcard.difficulty} />
                    {flashcard.topic && (
                        <Badge
                            variant="outline"
                            className="text-[10px]"
                            title={flashcard.topic}
                        >
                            {topicLabel(flashcard.topic)}
                        </Badge>
                    )}
                    <ErrorRateBadge percent={errorPct} />
                </div>
                <CardTitle className="text-base leading-snug">
                    {flashcard.question}
                </CardTitle>
                <MetricsRow metrics={metrics} />
            </CardHeader>
            <CardContent className="flex flex-col gap-4">
                <p className="text-sm whitespace-pre-line text-muted-foreground">
                    {flashcard.answer}
                </p>
                {flashcard.code_example && (
                    <CodeBlock
                        code={flashcard.code_example}
                        language={flashcard.code_language}
                    />
                )}
                <NoteBlock note={flashcard.note} />
                <div className="flex flex-wrap gap-2">
                    <Button asChild size="sm" variant="outline">
                        <Link href={flashcards.edit(flashcard.id).url}>
                            <Pencil />
                            Редактировать
                        </Link>
                    </Button>
                    <Button asChild size="sm" variant="outline">
                        <Link href={learn.show().url}>
                            <BookOpen />К изучению
                        </Link>
                    </Button>
                </div>
            </CardContent>
        </Card>
    );
}

function MetricsRow({ metrics }: { metrics: Metrics }) {
    const items: { label: string; value: number; tone: string }[] = [];

    if (metrics.incorrect > 0) {
        items.push({
            label: 'неверно',
            value: metrics.incorrect,
            tone: 'text-rose-700 dark:text-rose-300',
        });
    }

    if (metrics.matching_incorrect > 0) {
        items.push({
            label: 'matching ошибки',
            value: metrics.matching_incorrect,
            tone: 'text-rose-700 dark:text-rose-300',
        });
    }

    if (metrics.forgot > 0) {
        items.push({
            label: 'забыл',
            value: metrics.forgot,
            tone: 'text-rose-700 dark:text-rose-300',
        });
    }

    if (metrics.skipped > 0) {
        items.push({
            label: 'пропусков',
            value: metrics.skipped,
            tone: 'text-amber-700 dark:text-amber-300',
        });
    }

    return (
        <div className="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-muted-foreground tabular-nums">
            <span>
                {metrics.bad}/{metrics.total} событий
            </span>
            {items.map((it) => (
                <span key={it.label} className={cn('font-medium', it.tone)}>
                    {it.value} {it.label}
                </span>
            ))}
        </div>
    );
}

function ErrorRateBadge({ percent }: { percent: number }) {
    const tone =
        percent >= 60
            ? 'border-rose-500/40 bg-rose-500/15 text-rose-700 dark:text-rose-300'
            : percent >= 40
              ? 'border-amber-500/40 bg-amber-500/15 text-amber-700 dark:text-amber-300'
              : 'border-amber-500/30 bg-amber-500/10 text-amber-700 dark:text-amber-300';

    return (
        <Badge
            variant="outline"
            className={cn('font-mono tabular-nums', tone)}
            title="Доля плохих событий за окно"
        >
            {percent}%
        </Badge>
    );
}

function DifficultyBadge({ level }: { level: number }) {
    const clamped = Math.max(1, Math.min(5, level));
    const tone =
        clamped <= 2
            ? 'border-emerald-500/30 bg-emerald-500/10 text-emerald-700 dark:text-emerald-300'
            : clamped === 3
              ? 'border-amber-500/30 bg-amber-500/10 text-amber-700 dark:text-amber-300'
              : 'border-rose-500/30 bg-rose-500/10 text-rose-700 dark:text-rose-300';

    return (
        <Badge
            variant="outline"
            className={cn('font-mono tabular-nums', tone)}
            title="Сложность"
        >
            {'★'.repeat(clamped)}
        </Badge>
    );
}

function EmptyState({ minEvents }: { minEvents: number }) {
    return (
        <Card>
            <CardContent className="flex flex-col items-center gap-3 py-12 text-center">
                <CardTitle>Проблемных пока нет</CardTitle>
                <CardDescription>
                    Карточка попадает сюда, когда у неё минимум {minEvents}{' '}
                    событий за 30 дней и хотя бы одно из них — ошибка, «забыл»
                    или пропуск.
                </CardDescription>
            </CardContent>
        </Card>
    );
}
