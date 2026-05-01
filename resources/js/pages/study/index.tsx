import { Form, Head, Link, router } from '@inertiajs/react';
import {
    Check,
    Eye,
    PartyPopper,
    Plus,
    RotateCcw,
    Sparkles,
    X,
} from 'lucide-react';
import { useEffect, useState } from 'react';
import { CodeBlock } from '@/components/code-block';
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
import flashcards from '@/routes/flashcards';
import study from '@/routes/study';
import type {
    Flashcard,
    FlashcardStats,
    StudyMode,
    StudyOption,
    StudyShown,
} from '@/types';

type StudyFlashcard = Pick<
    Flashcard,
    | 'id'
    | 'category'
    | 'question'
    | 'answer'
    | 'code_example'
    | 'code_language'
    | 'correct_streak'
    | 'required_correct'
>;

type Props = {
    mode: StudyMode | null;
    flashcard: StudyFlashcard | null;
    shown: StudyShown | null;
    options: StudyOption[] | null;
    stats: FlashcardStats;
};

const modeLabels: Record<StudyMode, string> = {
    reveal: 'Reveal',
    true_false: 'True / False',
    multiple_choice: 'Multiple choice',
};

export default function StudyIndex({
    mode,
    flashcard,
    shown,
    options,
    stats,
}: Props) {
    if (!flashcard || !mode) {
        return <EmptyState stats={stats} />;
    }

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
                    <span>
                        progress {flashcard.correct_streak}/
                        {flashcard.required_correct}
                    </span>
                </header>

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

function CardCode({ flashcard }: { flashcard: StudyFlashcard }) {
    if (!flashcard.code_example) {
        return null;
    }

    return (
        <div className="flex flex-col gap-2">
            <p className="text-xs font-medium tracking-wide text-muted-foreground uppercase">
                Code example
            </p>
            <CodeBlock
                code={flashcard.code_example}
                language={flashcard.code_language}
            />
        </div>
    );
}

function RevealMode({ flashcard }: { flashcard: StudyFlashcard }) {
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
                        <CardCode flashcard={flashcard} />
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

function TrueFalseMode({
    flashcard,
    shown,
}: {
    flashcard: StudyFlashcard;
    shown: StudyShown;
}) {
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
                        <CardCode flashcard={flashcard} />
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

function MultipleChoiceMode({
    flashcard,
    options,
}: {
    flashcard: StudyFlashcard;
    options: StudyOption[];
}) {
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
                        <CardCode flashcard={flashcard} />
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

type AnswerFormProps = {
    flashcardId: number;
    result: 'correct' | 'incorrect';
    label: string;
    variant?: 'default' | 'destructive';
    icon?: React.ReactNode;
};

function AnswerForm({
    flashcardId,
    result,
    label,
    variant = 'default',
    icon,
}: AnswerFormProps) {
    useEffect(() => {
        router.prefetch(study.show().url, { method: 'get' });
    }, []);

    return (
        <Form action={study.answer(flashcardId).url} method="post">
            <input type="hidden" name="result" value={result} />
            <Button type="submit" variant={variant}>
                {icon}
                {label}
            </Button>
        </Form>
    );
}
