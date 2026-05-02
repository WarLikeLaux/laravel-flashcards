import { Form } from '@inertiajs/react';
import type { ReactNode } from 'react';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import study from '@/routes/study';
import type { StudyMode } from '@/types';

type Props = {
    flashcardId: number;
    result: 'correct' | 'incorrect';
    mode: StudyMode;
    label: string;
    variant?: 'default' | 'destructive';
    icon?: ReactNode;
    fullWidthOnMobile?: boolean;
};

export function AnswerForm({
    flashcardId,
    result,
    mode,
    label,
    variant = 'default',
    icon,
    fullWidthOnMobile,
}: Props) {
    return (
        <Form
            action={study.answer(flashcardId).url}
            method="post"
            className={cn(fullWidthOnMobile && 'w-full sm:w-auto')}
        >
            <input type="hidden" name="result" value={result} />
            <input type="hidden" name="mode" value={mode} />
            <Button
                type="submit"
                variant={variant}
                className={cn(fullWidthOnMobile && 'w-full sm:w-auto')}
            >
                {icon}
                {label}
            </Button>
        </Form>
    );
}
