import { Form, Head, Link } from '@inertiajs/react';
import { PartyPopper, Plus, RotateCcw, Sparkles } from 'lucide-react';
import { AssembleMode } from '@/components/study/assemble-mode';
import { ClozeMode } from '@/components/study/cloze-mode';
import { MatchingMode } from '@/components/study/matching-mode';
import { MultipleChoiceMode } from '@/components/study/multiple-choice-mode';
import { RevealMode } from '@/components/study/reveal-mode';
import { TrueFalseMode } from '@/components/study/true-false-mode';
import { TypeInMode } from '@/components/study/type-in-mode';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardTitle,
} from '@/components/ui/card';
import flashcards from '@/routes/flashcards';
import type {
    Flashcard,
    FlashcardStats,
    StudyAssemble,
    StudyMatching,
    StudyMode,
    StudyOption,
    StudyShown,
} from '@/types';

type Props = {
    mode: StudyMode | null;
    flashcard: Flashcard | null;
    shown: StudyShown | null;
    options: StudyOption[] | null;
    assemble: StudyAssemble | null;
    matching: StudyMatching | null;
    stats: FlashcardStats;
};

const modeLabels: Record<StudyMode, string> = {
    reveal: 'Reveal',
    true_false: 'True / False',
    multiple_choice: 'Multiple choice',
    cloze: 'Cloze',
    type_in: 'Type-in',
    assemble: 'Assemble',
    matching: 'Matching',
};

export default function StudyIndex({
    mode,
    flashcard,
    shown,
    options,
    assemble,
    matching,
    stats,
}: Props) {
    if (!mode) {
        return <EmptyState stats={stats} />;
    }

    if (mode === 'matching' && matching) {
        return (
            <Wrapper mode={mode} stats={stats}>
                <MatchingMode matching={matching} />
            </Wrapper>
        );
    }

    if (!flashcard) {
        return <EmptyState stats={stats} />;
    }

    return (
        <Wrapper mode={mode} stats={stats} flashcard={flashcard}>
            {mode === 'reveal' && (
                <RevealMode flashcard={flashcard} key={flashcard.id} />
            )}
            {mode === 'true_false' && shown && (
                <TrueFalseMode
                    flashcard={flashcard}
                    shown={shown}
                    key={flashcard.id}
                />
            )}
            {mode === 'multiple_choice' && options && (
                <MultipleChoiceMode
                    flashcard={flashcard}
                    options={options}
                    key={flashcard.id}
                />
            )}
            {mode === 'cloze' && (
                <ClozeMode flashcard={flashcard} key={flashcard.id} />
            )}
            {mode === 'type_in' && (
                <TypeInMode flashcard={flashcard} key={flashcard.id} />
            )}
            {mode === 'assemble' && assemble && (
                <AssembleMode
                    flashcard={flashcard}
                    assemble={assemble}
                    key={flashcard.id}
                />
            )}
        </Wrapper>
    );
}

function Wrapper({
    mode,
    stats,
    flashcard,
    children,
}: {
    mode: StudyMode;
    stats: FlashcardStats;
    flashcard?: Flashcard;
    children: React.ReactNode;
}) {
    return (
        <>
            <Head title="Study" />
            <div className="mx-auto flex w-full max-w-2xl flex-col gap-4 p-6">
                <header className="flex flex-wrap items-center justify-between gap-2 text-sm text-muted-foreground">
                    <Badge variant="outline" className="gap-1">
                        <Sparkles className="size-3" />
                        {modeLabels[mode]}
                    </Badge>
                    <span>
                        {stats.due} due · {stats.learned}/{stats.total} learned
                    </span>
                    {flashcard && (
                        <span>
                            progress {flashcard.correct_streak}/
                            {flashcard.required_correct}
                        </span>
                    )}
                </header>
                {children}
            </div>
        </>
    );
}

function EmptyState({ stats }: { stats: FlashcardStats }) {
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
