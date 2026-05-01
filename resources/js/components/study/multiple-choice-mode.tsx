import { useState } from 'react';
import { CategoryBadge } from '@/components/category-badge';
import { AnswerForm } from '@/components/study/answer-form';
import { CardCode } from '@/components/study/card-code';
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
            <CardHeader className="gap-2">
                <CategoryBadge category={flashcard.category} />
                <CardTitle className="text-lg leading-snug sm:text-xl">
                    {flashcard.question}
                </CardTitle>
                <CardDescription>Выбери правильный ответ.</CardDescription>
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
                                'rounded-lg border p-3 text-left text-sm whitespace-pre-line transition-colors',
                                'hover:border-ring hover:bg-accent/50',
                                'disabled:cursor-default disabled:hover:border-input disabled:hover:bg-transparent',
                                showState &&
                                    option.is_correct &&
                                    'border-emerald-500/60 bg-emerald-500/10',
                                showState &&
                                    picked &&
                                    !option.is_correct &&
                                    'border-destructive/60 bg-destructive/10',
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
                                    ? 'Верно · Дальше'
                                    : 'Ошибка · Дальше'
                            }
                            variant={
                                userResult === 'correct'
                                    ? 'default'
                                    : 'destructive'
                            }
                            fullWidthOnMobile
                        />
                    </CardFooter>
                </>
            )}
        </Card>
    );
}
