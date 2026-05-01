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
import { Separator } from '@/components/ui/separator';
import { cn } from '@/lib/utils';
import type { Flashcard, StudyShown } from '@/types';

type Props = {
    flashcard: Flashcard;
    shown: StudyShown;
};

export function TrueFalseMode({ flashcard, shown }: Props) {
    const [verdict, setVerdict] = useState<'true' | 'false' | null>(null);

    const userResult: 'correct' | 'incorrect' | null = verdict
        ? (verdict === 'true') === shown.is_correct
            ? 'correct'
            : 'incorrect'
        : null;

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
                <CardDescription>Is this answer correct?</CardDescription>
            </CardHeader>
            <CardContent className="flex flex-col gap-4">
                <p
                    className={cn(
                        'rounded-md border p-4 text-base whitespace-pre-line',
                        verdict !== null &&
                            (shown.is_correct
                                ? 'border-emerald-500/40 bg-emerald-500/5'
                                : 'border-destructive/40 bg-destructive/5'),
                    )}
                >
                    {shown.answer}
                </p>

                {verdict !== null && (
                    <>
                        <p className="text-sm">
                            {shown.is_correct
                                ? 'This is the correct answer.'
                                : 'This was a distractor. Real answer:'}
                        </p>
                        {!shown.is_correct && (
                            <p className="text-base whitespace-pre-line">
                                {flashcard.answer}
                            </p>
                        )}
                        <CardCode
                            code={flashcard.code_example}
                            language={flashcard.code_language}
                        />
                    </>
                )}
            </CardContent>
            <Separator />
            <CardFooter className="flex justify-end gap-2">
                {verdict === null ? (
                    <>
                        <Button
                            type="button"
                            variant="outline"
                            onClick={() => setVerdict('false')}
                        >
                            <X />
                            False
                        </Button>
                        <Button
                            type="button"
                            onClick={() => setVerdict('true')}
                        >
                            <Check />
                            True
                        </Button>
                    </>
                ) : (
                    userResult && (
                        <AnswerForm
                            flashcardId={flashcard.id}
                            result={userResult}
                            label={
                                userResult === 'correct'
                                    ? 'Got it · Next'
                                    : 'Got it wrong · Next'
                            }
                            variant={
                                userResult === 'correct'
                                    ? 'default'
                                    : 'destructive'
                            }
                        />
                    )
                )}
            </CardFooter>
        </Card>
    );
}
