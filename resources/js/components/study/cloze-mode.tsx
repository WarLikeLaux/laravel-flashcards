import { Check, X } from 'lucide-react';
import { useMemo, useState } from 'react';
import { CategoryBadge } from '@/components/category-badge';
import { AnswerForm } from '@/components/study/answer-form';
import { CardCode } from '@/components/study/card-code';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Separator } from '@/components/ui/separator';
import { looseEquals } from '@/lib/levenshtein';
import { cn } from '@/lib/utils';
import type { Flashcard } from '@/types';

type Segment =
    | { kind: 'text'; value: string }
    | { kind: 'blank'; index: number; expected: string };

function parseCloze(template: string): Segment[] {
    const segments: Segment[] = [];
    const regex = /\{\{(.+?)\}\}/g;
    let lastIndex = 0;
    let blankIndex = 0;
    let match: RegExpExecArray | null;

    while ((match = regex.exec(template)) !== null) {
        if (match.index > lastIndex) {
            segments.push({
                kind: 'text',
                value: template.slice(lastIndex, match.index),
            });
        }

        segments.push({
            kind: 'blank',
            index: blankIndex++,
            expected: match[1],
        });
        lastIndex = regex.lastIndex;
    }

    if (lastIndex < template.length) {
        segments.push({ kind: 'text', value: template.slice(lastIndex) });
    }

    return segments;
}

export function ClozeMode({ flashcard }: { flashcard: Flashcard }) {
    const segments = useMemo(
        () => parseCloze(flashcard.cloze_text ?? ''),
        [flashcard.cloze_text],
    );
    const blanks = useMemo(
        () =>
            segments.filter((s) => s.kind === 'blank') as Extract<
                Segment,
                { kind: 'blank' }
            >[],
        [segments],
    );

    const [values, setValues] = useState<string[]>(() =>
        new Array(blanks.length).fill(''),
    );
    const [checked, setChecked] = useState(false);

    const correctness = blanks.map((b, i) =>
        looseEquals(values[i] ?? '', b.expected, 1),
    );
    const allCorrect = checked && correctness.every(Boolean);

    return (
        <Card>
            <CardHeader className="gap-2">
                <CategoryBadge category={flashcard.category} />
                <CardTitle className="text-lg leading-snug sm:text-xl">
                    {flashcard.question}
                </CardTitle>
                <CardDescription>Заполни пропуски.</CardDescription>
            </CardHeader>
            <CardContent className="flex flex-col gap-4">
                <div className="overflow-x-auto rounded-md border bg-muted/30 p-4 font-mono text-sm leading-relaxed">
                    {segments.map((seg, i) => {
                        if (seg.kind === 'text') {
                            return (
                                <span key={i} className="whitespace-pre-wrap">
                                    {seg.value}
                                </span>
                            );
                        }

                        const ok = checked && correctness[seg.index];
                        const wrong = checked && !correctness[seg.index];

                        return (
                            <Input
                                key={i}
                                value={values[seg.index] ?? ''}
                                onChange={(e) => {
                                    const next = [...values];
                                    next[seg.index] = e.target.value;
                                    setValues(next);
                                }}
                                disabled={checked}
                                spellCheck={false}
                                autoComplete="off"
                                className={cn(
                                    'mx-1 inline-block h-7 w-32 px-2 align-baseline font-mono sm:w-40',
                                    ok &&
                                        'border-emerald-500/60 bg-emerald-500/5',
                                    wrong &&
                                        'border-destructive/60 bg-destructive/5',
                                )}
                            />
                        );
                    })}
                </div>

                {checked && (
                    <div className="flex flex-col gap-2 rounded-md border p-3 text-sm">
                        <p className="font-medium">Ожидалось:</p>
                        <ol className="list-decimal pl-5 font-mono">
                            {blanks.map((b, i) => (
                                <li
                                    key={i}
                                    className={cn(
                                        correctness[i]
                                            ? 'text-emerald-600 dark:text-emerald-400'
                                            : 'text-destructive',
                                    )}
                                >
                                    {b.expected}
                                </li>
                            ))}
                        </ol>
                        <p className="mt-2 text-base whitespace-pre-line text-foreground">
                            {flashcard.answer}
                        </p>
                        <CardCode
                            code={flashcard.code_example}
                            language={flashcard.code_language}
                        />
                    </div>
                )}
            </CardContent>
            <Separator />
            <CardFooter className="flex justify-end">
                {!checked ? (
                    <Button
                        type="button"
                        onClick={() => setChecked(true)}
                        disabled={values.some((v) => v.trim() === '')}
                        className="w-full sm:w-auto"
                    >
                        Проверить
                    </Button>
                ) : (
                    <AnswerForm
                        flashcardId={flashcard.id}
                        result={allCorrect ? 'correct' : 'incorrect'}
                        label={
                            allCorrect ? 'Верно · Дальше' : 'Ошибка · Дальше'
                        }
                        variant={allCorrect ? 'default' : 'destructive'}
                        icon={allCorrect ? <Check /> : <X />}
                        fullWidthOnMobile
                    />
                )}
            </CardFooter>
        </Card>
    );
}
