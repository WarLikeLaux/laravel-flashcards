import { Form } from '@inertiajs/react';
import type { ReactNode } from 'react';
import { Button } from '@/components/ui/button';
import study from '@/routes/study';

type Props = {
    flashcardId: number;
    result: 'correct' | 'incorrect';
    label: string;
    variant?: 'default' | 'destructive';
    icon?: ReactNode;
};

export function AnswerForm({
    flashcardId,
    result,
    label,
    variant = 'default',
    icon,
}: Props) {
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
