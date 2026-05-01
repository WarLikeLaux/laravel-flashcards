import { useState } from 'react';
import { AnswerForm } from '@/components/study/answer-form';
import { CardCode } from '@/components/study/card-code';
import { Badge } from '@/components/ui/badge';
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
import type { Flashcard, StudyOption } from '@/types';

type Props = {
    flashcard: Flashcard;
    options: StudyOption[];
};

export function MultipleChoiceMode({ flashcard, options }: Props) {
    const [selectedId, setSelectedId] = useState<number | null>(null);

    const userResult: 'correct' | 'incorrect' | null =
        selectedId === null
            ? null
            : selectedId === flashcard.id
              ? 'correct'
              : 'incorrect';

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
                <CardDescription>Pick the correct answer.</CardDescription>
            </CardHeader>
            <CardContent className="flex flex-col gap-2">
                {options.map((option) => {
                    const picked = selectedId === option.id;
                    const showState = selectedId !== null;

                    return (
                        <button
                            key={option.id}
                            type="button"
                            disabled={showState}
                            onClick={() => setSelectedId(option.id)}
                            className={cn(
                                'rounded-md border p-3 text-left text-sm whitespace-pre-line transition-colors',
                                'hover:border-ring',
                                'disabled:cursor-default disabled:hover:border-input',
                                showState &&
                                    option.is_correct &&
                                    'border-emerald-500/60 bg-emerald-500/5',
                                showState &&
                                    picked &&
                                    !option.is_correct &&
                                    'border-destructive/60 bg-destructive/5',
                            )}
                        >
                            {option.answer}
                        </button>
                    );
                })}

                {selectedId !== null && flashcard.code_example && (
                    <div className="mt-2">
                        <CardCode
                            code={flashcard.code_example}
                            language={flashcard.code_language}
                        />
                    </div>
                )}
            </CardContent>
            {userResult && (
                <>
                    <Separator />
                    <CardFooter className="flex justify-end">
                        <AnswerForm
                            flashcardId={flashcard.id}
                            result={userResult}
                            label={
                                userResult === 'correct'
                                    ? 'Correct · Next'
                                    : 'Wrong · Next'
                            }
                            variant={
                                userResult === 'correct'
                                    ? 'default'
                                    : 'destructive'
                            }
                        />
                    </CardFooter>
                </>
            )}
        </Card>
    );
}
