import { Head, Link } from '@inertiajs/react';
import { ArrowLeft } from 'lucide-react';
import { FlashcardForm } from '@/components/flashcard-form';
import { Button } from '@/components/ui/button';
import flashcards from '@/routes/flashcards';
import type { Flashcard } from '@/types';

type Props = {
    flashcard: Flashcard;
};

export default function FlashcardEdit({ flashcard }: Props) {
    return (
        <>
            <Head title="Редактирование карточки" />

            <div className="mx-auto flex w-full max-w-3xl flex-col gap-4 px-4 pt-4 pb-24 sm:px-6 sm:pt-6 sm:pb-12">
                <Button
                    asChild
                    variant="ghost"
                    size="sm"
                    className="self-start"
                >
                    <Link href={flashcards.index().url}>
                        <ArrowLeft />К карточкам
                    </Link>
                </Button>

                <div className="flex flex-col gap-1">
                    <h1 className="text-2xl font-semibold tracking-tight sm:text-3xl">
                        Редактирование карточки
                    </h1>
                    <p className="text-sm text-muted-foreground">
                        Измени любые поля. Прогресс обучения карточки не
                        сбрасывается.
                    </p>
                </div>

                <FlashcardForm
                    mode="edit"
                    initial={flashcard}
                    submitLabel="Сохранить изменения"
                />
            </div>
        </>
    );
}
