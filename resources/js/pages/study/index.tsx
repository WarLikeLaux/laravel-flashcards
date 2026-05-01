import { Form, Head, Link } from '@inertiajs/react';
import { Check, Eye, PartyPopper, Plus, RotateCcw, X } from 'lucide-react';
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
import flashcards from '@/routes/flashcards';
import study from '@/routes/study';
import type { Flashcard, FlashcardStats } from '@/types';

type Props = {
    flashcard: Pick<
        Flashcard,
        | 'id'
        | 'category'
        | 'question'
        | 'answer'
        | 'correct_streak'
        | 'required_correct'
    > | null;
    stats: FlashcardStats;
};

export default function StudyIndex({ flashcard, stats }: Props) {
    const [revealed, setRevealed] = useState(false);

    if (!flashcard) {
        return (
            <>
                <Head title="Study" />
                <div className="mx-auto flex w-full max-w-xl flex-col items-center gap-4 p-6">
                    <Card className="w-full">
                        <CardContent className="flex flex-col items-center gap-3 py-12 text-center">
                            {stats.total === 0 ? (
                                <>
                                    <CardTitle>Nothing to study yet</CardTitle>
                                    <CardDescription>
                                        Add your first flashcard to begin.
                                    </CardDescription>
                                    <Button asChild>
                                        <Link href={flashcards.create().url}>
                                            <Plus />
                                            Add card
                                        </Link>
                                    </Button>
                                </>
                            ) : (
                                <>
                                    <PartyPopper className="size-10 text-primary" />
                                    <CardTitle>All cards learned</CardTitle>
                                    <CardDescription>
                                        Reset progress to repeat the deck.
                                    </CardDescription>
                                    <div className="flex gap-2">
                                        <Form
                                            action={flashcards.reset().url}
                                            method="post"
                                        >
                                            <Button type="submit">
                                                <RotateCcw />
                                                Reset progress
                                            </Button>
                                        </Form>
                                        <Button asChild variant="outline">
                                            <Link href={flashcards.index().url}>
                                                Back to cards
                                            </Link>
                                        </Button>
                                    </div>
                                </>
                            )}
                        </CardContent>
                    </Card>
                </div>
            </>
        );
    }

    return (
        <>
            <Head title="Study" />

            <div className="mx-auto flex w-full max-w-2xl flex-col gap-4 p-6">
                <header className="flex items-center justify-between gap-2 text-sm text-muted-foreground">
                    <span>
                        {stats.due} due · {stats.learned}/{stats.total} learned
                    </span>
                    <span>
                        progress {flashcard.correct_streak}/
                        {flashcard.required_correct}
                    </span>
                </header>

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
                    <CardContent>
                        {revealed ? (
                            <p className="text-base whitespace-pre-line">
                                {flashcard.answer}
                            </p>
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
                                <Form
                                    action={study.answer(flashcard.id).url}
                                    method="post"
                                    onSuccess={() => setRevealed(false)}
                                >
                                    <input
                                        type="hidden"
                                        name="result"
                                        value="incorrect"
                                    />
                                    <Button type="submit" variant="destructive">
                                        <X />
                                        Wrong
                                    </Button>
                                </Form>
                                <Form
                                    action={study.answer(flashcard.id).url}
                                    method="post"
                                    onSuccess={() => setRevealed(false)}
                                >
                                    <input
                                        type="hidden"
                                        name="result"
                                        value="correct"
                                    />
                                    <Button type="submit">
                                        <Check />
                                        Right
                                    </Button>
                                </Form>
                            </CardFooter>
                        </>
                    )}
                </Card>
            </div>
        </>
    );
}
