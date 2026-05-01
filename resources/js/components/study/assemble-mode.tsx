import { Check, RotateCcw, X } from 'lucide-react';
import { useState } from 'react';
import { AnswerForm } from '@/components/study/answer-form';
import { CardCode } from '@/components/study/card-code';
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
import type { Flashcard, StudyAssemble } from '@/types';

type Props = {
    flashcard: Flashcard;
    assemble: StudyAssemble;
};

export function AssembleMode({ flashcard, assemble }: Props) {
    const correct = flashcard.assemble_chunks ?? [];

    const [picked, setPicked] = useState<number[]>([]);
    const [checked, setChecked] = useState(false);

    const pool = assemble.pool;
    const remaining = pool.map((_, i) => i).filter((i) => !picked.includes(i));

    const assembled = picked.map((i) => pool[i]);
    const isCorrect =
        assembled.length === correct.length &&
        assembled.every((chunk, i) => chunk === correct[i]);

    return (
        <Card>
            <CardHeader>
                {flashcard.category && (
                    <Badge variant="secondary" className="self-start">
                        {flashcard.category}
                    </Badge>
                )}
                <CardTitle className="text-xl leading-snug">
                    {flashcard.question}
                </CardTitle>
                <CardDescription>
                    Tap chunks in the right order.
                </CardDescription>
            </CardHeader>
            <CardContent className="flex flex-col gap-4">
                <div
                    className={cn(
                        'min-h-12 rounded-md border bg-muted/30 p-3 font-mono text-sm',
                        checked &&
                            isCorrect &&
                            'border-emerald-500/60 bg-emerald-500/5',
                        checked &&
                            !isCorrect &&
                            'border-destructive/60 bg-destructive/5',
                    )}
                >
                    {assembled.length === 0 ? (
                        <span className="text-muted-foreground">
                            Pick chunks below…
                        </span>
                    ) : (
                        <span className="break-all">{assembled.join('')}</span>
                    )}
                </div>

                <div className="flex flex-wrap gap-2">
                    {remaining.map((i) => (
                        <Button
                            key={i}
                            type="button"
                            variant="outline"
                            size="sm"
                            disabled={checked}
                            onClick={() => setPicked([...picked, i])}
                            className="font-mono"
                        >
                            {pool[i]}
                        </Button>
                    ))}
                </div>

                {!checked && picked.length > 0 && (
                    <div className="flex flex-wrap gap-2">
                        <Button
                            type="button"
                            variant="ghost"
                            size="sm"
                            onClick={() =>
                                setPicked(picked.slice(0, picked.length - 1))
                            }
                        >
                            Undo
                        </Button>
                        <Button
                            type="button"
                            variant="ghost"
                            size="sm"
                            onClick={() => setPicked([])}
                        >
                            <RotateCcw />
                            Reset
                        </Button>
                    </div>
                )}

                {checked && (
                    <div className="flex flex-col gap-2 rounded-md border p-3 text-sm">
                        {!isCorrect && (
                            <>
                                <p>Expected:</p>
                                <code className="block rounded bg-muted px-2 py-1 font-mono break-all">
                                    {correct.join('')}
                                </code>
                            </>
                        )}
                        <p className="mt-2 text-base whitespace-pre-line">
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
                        disabled={picked.length === 0}
                    >
                        Check
                    </Button>
                ) : (
                    <AnswerForm
                        flashcardId={flashcard.id}
                        result={isCorrect ? 'correct' : 'incorrect'}
                        label={isCorrect ? 'Correct · Next' : 'Wrong · Next'}
                        variant={isCorrect ? 'default' : 'destructive'}
                        icon={isCorrect ? <Check /> : <X />}
                    />
                )}
            </CardFooter>
        </Card>
    );
}
