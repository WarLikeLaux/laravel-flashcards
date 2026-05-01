import { Check, X } from 'lucide-react';
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
import { Input } from '@/components/ui/input';
import { Separator } from '@/components/ui/separator';
import { levenshtein } from '@/lib/levenshtein';
import { cn } from '@/lib/utils';
import type { Flashcard } from '@/types';

function tolerance(target: string): number {
    if (target.length <= 4) {
        return 0;
    }

    if (target.length <= 8) {
        return 1;
    }

    return 2;
}

export function TypeInMode({ flashcard }: { flashcard: Flashcard }) {
    const [value, setValue] = useState('');
    const [checked, setChecked] = useState(false);

    const expected = flashcard.short_answer ?? '';
    const distance = levenshtein(
        value.trim().toLowerCase(),
        expected.trim().toLowerCase(),
    );
    const tol = tolerance(expected);
    const isCorrect = checked && distance <= tol;
    const wasTypo = checked && distance > 0 && distance <= tol;

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
                <CardDescription>Type the answer.</CardDescription>
            </CardHeader>
            <CardContent className="flex flex-col gap-4">
                <Input
                    value={value}
                    onChange={(e) => setValue(e.target.value)}
                    disabled={checked}
                    placeholder="your answer"
                    spellCheck={false}
                    autoComplete="off"
                    className={cn(
                        'font-mono',
                        checked &&
                            isCorrect &&
                            'border-emerald-500/60 bg-emerald-500/5',
                        checked &&
                            !isCorrect &&
                            'border-destructive/60 bg-destructive/5',
                    )}
                    onKeyDown={(e) => {
                        if (e.key === 'Enter' && !checked && value.trim()) {
                            setChecked(true);
                        }
                    }}
                />

                {checked && (
                    <div className="flex flex-col gap-2 rounded-md border p-3 text-sm">
                        <p>
                            Expected:{' '}
                            <span className="font-mono">{expected}</span>
                        </p>
                        {wasTypo && (
                            <p className="text-emerald-600 dark:text-emerald-400">
                                Typo forgiven (distance {distance}).
                            </p>
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
                        disabled={value.trim() === ''}
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
