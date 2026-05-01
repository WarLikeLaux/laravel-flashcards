import { CodeBlock } from '@/components/code-block';

type Props = {
    code: string | null;
    language: string | null;
};

export function CardCode({ code, language }: Props) {
    if (!code) {
        return null;
    }

    return (
        <div className="flex flex-col gap-2">
            <p className="text-xs font-medium tracking-wide text-muted-foreground uppercase">
                Code example
            </p>
            <CodeBlock code={code} language={language} />
        </div>
    );
}
