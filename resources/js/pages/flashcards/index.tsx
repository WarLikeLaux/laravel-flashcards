import { Form, Head, Link } from '@inertiajs/react';
import { GraduationCap, Plus, RotateCcw, Trash2 } from 'lucide-react';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import flashcards from '@/routes/flashcards';
import study from '@/routes/study';
import type { Flashcard, FlashcardStats } from '@/types';

type Props = {
    flashcards: Flashcard[];
    stats: FlashcardStats;
};

export default function FlashcardsIndex({ flashcards: cards, stats }: Props) {
    return (
        <>
            <Head title="Cards" />

            <div className="flex flex-1 flex-col gap-6 p-6">
                <header className="flex flex-wrap items-end justify-between gap-4">
                    <div className="flex flex-col gap-1">
                        <h1 className="text-2xl font-semibold tracking-tight">
                            Flashcards
                        </h1>
                        <p className="text-sm text-muted-foreground">
                            {stats.total} cards · {stats.learned} learned ·{' '}
                            {stats.due} due
                        </p>
                    </div>

                    <div className="flex flex-wrap items-center gap-2">
                        <Button asChild variant="default">
                            <Link href={study.show().url}>
                                <GraduationCap />
                                Study
                            </Link>
                        </Button>
                        <Button asChild variant="outline">
                            <Link href={flashcards.create().url}>
                                <Plus />
                                Add card
                            </Link>
                        </Button>
                        {stats.total > 0 && (
                            <Form action={flashcards.reset().url} method="post">
                                <Button type="submit" variant="ghost">
                                    <RotateCcw />
                                    Reset progress
                                </Button>
                            </Form>
                        )}
                    </div>
                </header>

                {cards.length === 0 ? (
                    <Card>
                        <CardContent className="flex flex-col items-center gap-3 py-16 text-center">
                            <CardTitle>No cards yet</CardTitle>
                            <CardDescription>
                                Add your first card to start studying.
                            </CardDescription>
                            <Button asChild>
                                <Link href={flashcards.create().url}>
                                    <Plus />
                                    Add card
                                </Link>
                            </Button>
                        </CardContent>
                    </Card>
                ) : (
                    <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        {cards.map((card) => (
                            <Card key={card.id} className="flex flex-col">
                                <CardHeader>
                                    <div className="flex items-center justify-between gap-2">
                                        {card.category ? (
                                            <Badge variant="secondary">
                                                {card.category}
                                            </Badge>
                                        ) : (
                                            <span />
                                        )}
                                        {card.is_learned ? (
                                            <Badge>learned</Badge>
                                        ) : (
                                            <Badge variant="outline">
                                                {card.correct_streak}/
                                                {card.required_correct}
                                            </Badge>
                                        )}
                                    </div>
                                    <CardTitle className="text-base leading-snug">
                                        {card.question}
                                    </CardTitle>
                                </CardHeader>
                                <CardContent className="flex flex-1 flex-col gap-4">
                                    <p className="text-sm whitespace-pre-line text-muted-foreground">
                                        {card.answer}
                                    </p>
                                    <Form
                                        action={flashcards.destroy(card.id).url}
                                        method="delete"
                                        className="mt-auto flex justify-end"
                                    >
                                        <Button
                                            type="submit"
                                            variant="ghost"
                                            size="sm"
                                        >
                                            <Trash2 />
                                            Delete
                                        </Button>
                                    </Form>
                                </CardContent>
                            </Card>
                        ))}
                    </div>
                )}
            </div>
        </>
    );
}
