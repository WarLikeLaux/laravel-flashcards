import { Form } from '@inertiajs/react';
import { Check, X } from 'lucide-react';
import { useState } from 'react';
import { CategoryBadge } from '@/components/category-badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Separator } from '@/components/ui/separator';
import { cn } from '@/lib/utils';
import study from '@/routes/study';
import type { StudyMatching } from '@/types';

export function MatchingMode({ matching }: { matching: StudyMatching }) {
    const [pairs, setPairs] = useState<Record<number, number>>({});
    const [pickedQ, setPickedQ] = useState<number | null>(null);
    const [checked, setChecked] = useState(false);

    const usedAnswers = new Set(Object.values(pairs));
    const allMatched = matching.questions.every((q) => q.id in pairs);

    const isPairCorrect = (qId: number) => pairs[qId] === qId;

    const setPair = (qId: number, aId: number) => {
        const next = { ...pairs, [qId]: aId };
        setPairs(next);
        setPickedQ(null);
    };

    const togglePickQuestion = (qId: number) => {
        if (checked) {
            return;
        }

        if (pickedQ === qId) {
            setPickedQ(null);

            return;
        }

        if (qId in pairs) {
            const next = { ...pairs };
            delete next[qId];
            setPairs(next);
            setPickedQ(qId);

            return;
        }

        setPickedQ(qId);
    };

    const onClickAnswer = (aId: number) => {
        if (checked) {
            return;
        }

        if (pickedQ === null) {
            return;
        }

        setPair(pickedQ, aId);
    };

    const correctCount = Object.keys(pairs).filter((qId) =>
        isPairCorrect(Number(qId)),
    ).length;

    return (
        <Card>
            <CardHeader className="gap-2">
                <CategoryBadge category={matching.category} />
                <CardTitle className="text-lg leading-snug sm:text-xl">
                    Сопоставь термины с короткими ответами
                </CardTitle>
                <CardDescription>
                    Нажми вопрос слева, потом подходящий ответ справа.
                </CardDescription>
            </CardHeader>
            <CardContent className="grid gap-3 sm:grid-cols-2 sm:gap-4">
                <div className="flex flex-col gap-2">
                    {matching.questions.map((q) => {
                        const matched = q.id in pairs;
                        const correct = checked && isPairCorrect(q.id);
                        const wrong = checked && matched && !correct;
                        const active = pickedQ === q.id;

                        return (
                            <button
                                key={q.id}
                                type="button"
                                disabled={checked}
                                onClick={() => togglePickQuestion(q.id)}
                                className={cn(
                                    'rounded-lg border p-3 text-left text-sm transition-colors',
                                    'hover:border-ring hover:bg-accent/40',
                                    'disabled:cursor-default disabled:hover:border-input disabled:hover:bg-transparent',
                                    active && 'border-ring bg-accent',
                                    matched && !active && 'opacity-70',
                                    correct &&
                                        'border-emerald-500/60 bg-emerald-500/10 opacity-100',
                                    wrong &&
                                        'border-destructive/60 bg-destructive/10 opacity-100',
                                )}
                            >
                                {q.text}
                            </button>
                        );
                    })}
                </div>

                <div className="flex flex-col gap-2">
                    {matching.answers.map((a) => {
                        const taken = usedAnswers.has(a.id);
                        const matchedQId = Object.entries(pairs).find(
                            ([, v]) => v === a.id,
                        )?.[0];
                        const correct =
                            checked &&
                            matchedQId !== undefined &&
                            Number(matchedQId) === a.id;
                        const wrong =
                            checked &&
                            matchedQId !== undefined &&
                            Number(matchedQId) !== a.id;

                        return (
                            <button
                                key={a.id}
                                type="button"
                                disabled={
                                    checked || (taken && pickedQ === null)
                                }
                                onClick={() => onClickAnswer(a.id)}
                                className={cn(
                                    'rounded-lg border p-3 text-left font-mono text-sm transition-colors',
                                    'hover:border-ring hover:bg-accent/40',
                                    'disabled:cursor-default disabled:hover:border-input disabled:hover:bg-transparent',
                                    taken && 'opacity-70',
                                    correct &&
                                        'border-emerald-500/60 bg-emerald-500/10 opacity-100',
                                    wrong &&
                                        'border-destructive/60 bg-destructive/10 opacity-100',
                                )}
                            >
                                {a.text}
                            </button>
                        );
                    })}
                </div>
            </CardContent>
            <Separator />
            <CardFooter className="flex flex-col items-stretch gap-2 sm:flex-row sm:items-center sm:justify-between">
                <span className="text-sm text-muted-foreground">
                    {checked
                        ? `Верно: ${correctCount}/${matching.questions.length}`
                        : `Сопоставлено: ${Object.keys(pairs).length}/${matching.questions.length}`}
                </span>
                {!checked ? (
                    <Button
                        type="button"
                        onClick={() => setChecked(true)}
                        disabled={!allMatched}
                        className="w-full sm:w-auto"
                    >
                        Проверить
                    </Button>
                ) : (
                    <Form
                        action={study.matching().url}
                        method="post"
                        className="w-full sm:w-auto"
                    >
                        {Object.entries(pairs).map(([qId, aId]) => (
                            <span key={qId}>
                                <input
                                    type="hidden"
                                    name={`pairs[${qId}][question_id]`}
                                    value={qId}
                                />
                                <input
                                    type="hidden"
                                    name={`pairs[${qId}][answer_id]`}
                                    value={aId}
                                />
                            </span>
                        ))}
                        <Button
                            type="submit"
                            variant={
                                correctCount === matching.questions.length
                                    ? 'default'
                                    : 'destructive'
                            }
                            className="w-full sm:w-auto"
                        >
                            {correctCount === matching.questions.length ? (
                                <Check />
                            ) : (
                                <X />
                            )}
                            Дальше
                        </Button>
                    </Form>
                )}
            </CardFooter>
        </Card>
    );
}
