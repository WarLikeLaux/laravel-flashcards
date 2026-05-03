import { Form, router } from '@inertiajs/react';
import { Check, X } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { useKeyboardShortcut } from '@/hooks/use-keyboard-shortcut';
import { cn } from '@/lib/utils';
import study from '@/routes/study';
import type { StudyMode } from '@/types';

type Props = {
    flashcardId: number;
    mode: StudyMode;
    result: 'correct' | 'incorrect';
};

export function VerdictActions({ flashcardId, mode, result }: Props) {
    useKeyboardShortcut('1', () => router.post(study.skip(flashcardId).url));
    useKeyboardShortcut('Enter', () =>
        router.post(study.answer(flashcardId).url, { result, mode }),
    );

    return (
        <div className="flex w-full flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <VerdictBanner result={result} />
            <div className="flex w-full gap-2 sm:w-auto">
                <Form
                    action={study.skip(flashcardId).url}
                    method="post"
                    className="flex-1 sm:flex-none"
                >
                    <Button
                        type="submit"
                        variant="outline"
                        className="w-full sm:w-auto"
                        title="Не засчитывать ответ, перейти к следующей"
                    >
                        Повторить
                    </Button>
                </Form>
                <Form
                    action={study.answer(flashcardId).url}
                    method="post"
                    className="flex-1 sm:flex-none"
                >
                    <input type="hidden" name="result" value={result} />
                    <input type="hidden" name="mode" value={mode} />
                    <Button type="submit" className="w-full sm:w-auto">
                        Дальше
                    </Button>
                </Form>
            </div>
        </div>
    );
}

export function VerdictBanner({ result }: { result: 'correct' | 'incorrect' }) {
    return (
        <div
            className={cn(
                'flex items-center gap-2 rounded-lg border px-3 py-2 text-sm font-medium',
                result === 'correct'
                    ? 'border-emerald-500/40 bg-emerald-500/10 text-emerald-700 dark:text-emerald-300'
                    : 'border-destructive/40 bg-destructive/10 text-destructive',
            )}
        >
            {result === 'correct' ? (
                <Check className="size-4" />
            ) : (
                <X className="size-4" />
            )}
            <span>{result === 'correct' ? 'Верно' : 'Ошибка'}</span>
        </div>
    );
}
