import { Check, Eye, X } from 'lucide-react';
import { useState } from 'react';
import { AnswerForm } from '@/components/study/answer-form';
import { CardCode } from '@/components/study/card-code';
import { Badge } from '@/components/ui/badge';
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
            <CardHeader>
                {flashcard.category && (
                    <Badge variant="secondary" className="self-start">
                        {flashcard.category}
                    </Badge>
                )}
                <CardTitle className="text-xl leading-snug">
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
                        Show answer
                    </Button>
                )}
            </CardContent>
            {revealed && (
                <>
                    <Separator />
                    <CardFooter className="flex justify-end gap-2">
                        <AnswerForm
                            flashcardId={flashcard.id}
                            result="incorrect"
                            variant="destructive"
                            label="Wrong"
                            icon={<X />}
                        />
                        <AnswerForm
                            flashcardId={flashcard.id}
                            result="correct"
                            label="Right"
                            icon={<Check />}
                        />
                    </CardFooter>
                </>
            )}
        </Card>
    );
}
