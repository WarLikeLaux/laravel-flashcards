import { Form } from '@inertiajs/react';
import { Check, X } from 'lucide-react';
import { useState } from 'react';
import { Badge } from '@/components/ui/badge';
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
            <CardHeader>
                <Badge variant="secondary" className="self-start">
                    {matching.category}
                </Badge>
                <CardTitle className="text-xl leading-snug">
                    Match each term with its short answer
                </CardTitle>
                <CardDescription>
                    Tap a question on the left, then its match on the right.
                </CardDescription>
            </CardHeader>
            <CardContent className="grid gap-4 md:grid-cols-2">
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
                                    'rounded-md border p-3 text-left text-sm transition-colors',
                                    'disabled:cursor-default',
                                    active && 'border-ring bg-accent',
                                    matched && !active && 'opacity-70',
                                    correct &&
                                        'border-emerald-500/60 bg-emerald-500/5 opacity-100',
                                    wrong &&
                                        'border-destructive/60 bg-destructive/5 opacity-100',
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
                                    'rounded-md border p-3 text-left font-mono text-sm transition-colors',
                                    'disabled:cursor-default',
                                    taken && 'opacity-70',
                                    correct &&
                                        'border-emerald-500/60 bg-emerald-500/5 opacity-100',
                                    wrong &&
                                        'border-destructive/60 bg-destructive/5 opacity-100',
                                )}
                            >
                                {a.text}
                            </button>
                        );
                    })}
                </div>
            </CardContent>
            <Separator />
            <CardFooter className="flex items-center justify-between">
                <span className="text-sm text-muted-foreground">
                    {checked
                        ? `${correctCount}/${matching.questions.length} correct`
                        : `${Object.keys(pairs).length}/${matching.questions.length} matched`}
                </span>
                {!checked ? (
                    <Button
                        type="button"
                        onClick={() => setChecked(true)}
                        disabled={!allMatched}
                    >
                        Check
                    </Button>
                ) : (
                    <Form action={study.matching().url} method="post">
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
                        >
                            {correctCount === matching.questions.length ? (
                                <Check />
                            ) : (
                                <X />
                            )}
                            Continue
                        </Button>
                    </Form>
                )}
            </CardFooter>
        </Card>
    );
}
