import { Check, X } from 'lucide-react';
import { useState } from 'react';
import { CategoryBadge } from '@/components/category-badge';
import { CardCode } from '@/components/study/card-code';
import { VerdictActions } from '@/components/study/verdict-actions';
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
            <CardHeader className="gap-2">
                <CategoryBadge category={flashcard.category} />
                <CardTitle className="text-lg leading-snug sm:text-xl">
                    {flashcard.question}
                </CardTitle>
                <CardDescription>Этот ответ верный?</CardDescription>
            </CardHeader>
            <CardContent className="flex flex-col gap-4">
                <p
                    className={cn(
                        'rounded-md border p-4 text-base whitespace-pre-line transition-colors',
                        verdict !== null &&
                            (shown.is_correct
                                ? 'border-emerald-500/40 bg-emerald-500/5'
                                : 'border-destructive/40 bg-destructive/5'),
                    )}
                >
                    {shown.answer}
                </p>

                {verdict !== null && (
                    <div className="flex flex-col gap-2 rounded-md border p-3 text-sm">
                        <p className="font-medium">
                            {shown.is_correct
                                ? 'Это правильный ответ.'
                                : 'Это был дистрактор. Правильный ответ:'}
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
                    </div>
                )}
            </CardContent>
            <Separator />
            <CardFooter
                className={cn(
                    verdict === null
                        ? 'grid grid-cols-2 gap-2 sm:flex sm:justify-end'
                        : '',
                )}
            >
                {verdict === null ? (
                    <>
                        <Button
                            type="button"
                            variant="outline"
                            onClick={() => setVerdict('false')}
                            className="w-full sm:w-auto"
                        >
                            <X />
                            Ложь
                        </Button>
                        <Button
                            type="button"
                            onClick={() => setVerdict('true')}
                            className="w-full sm:w-auto"
                        >
                            <Check />
                            Правда
                        </Button>
                    </>
                ) : (
                    userResult && (
                        <VerdictActions
                            flashcardId={flashcard.id}
                            mode="true_false"
                            result={userResult}
                        />
                    )
                )}
            </CardFooter>
        </Card>
    );
}
