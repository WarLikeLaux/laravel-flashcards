import { Check, Eye, X } from 'lucide-react';
import { useState } from 'react';
import { CategoryBadge } from '@/components/category-badge';
import { AnswerForm } from '@/components/study/answer-form';
import { CardCode } from '@/components/study/card-code';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Separator } from '@/components/ui/separator';
import type { Flashcard } from '@/types';

export function RevealMode({ flashcard }: { flashcard: Flashcard }) {
    const [revealed, setRevealed] = useState(false);

    return (
        <Card>
            <CardHeader className="gap-2">
                <CategoryBadge category={flashcard.category} />
                <CardTitle className="text-lg leading-snug sm:text-xl">
                    {flashcard.question}
                </CardTitle>
            </CardHeader>
            <CardContent className="flex flex-col gap-4">
                {revealed ? (
                    <>
                        <p className="text-base whitespace-pre-line">
                            {flashcard.answer}
                        </p>
                        <CardCode
                            code={flashcard.code_example}
                            language={flashcard.code_language}
                        />
                    </>
                ) : (
                    <Button
                        type="button"
                        variant="outline"
                        onClick={() => setRevealed(true)}
                        className="w-full"
                    >
                        <Eye />
                        Показать ответ
                    </Button>
                )}
            </CardContent>
            {revealed && (
                <>
                    <Separator />
                    <CardFooter className="grid grid-cols-2 gap-2 sm:flex sm:justify-end">
                        <AnswerForm
                            flashcardId={flashcard.id}
                            result="incorrect"
                            variant="destructive"
                            label="Не знал"
                            icon={<X />}
                            fullWidthOnMobile
                        />
                        <AnswerForm
                            flashcardId={flashcard.id}
                            result="correct"
                            label="Знал"
                            icon={<Check />}
                            fullWidthOnMobile
                        />
                    </CardFooter>
                </>
            )}
        </Card>
    );
}
