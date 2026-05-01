import { Highlight, themes } from 'prism-react-renderer';
import type { Language } from 'prism-react-renderer';
import { cn } from '@/lib/utils';

type Props = {
    code: string;
    language?: string | null;
    className?: string;
};

export function CodeBlock({ code, language, className }: Props) {
    const lang = (language ?? 'php') as Language;

    return (
        <Highlight code={code.trim()} language={lang} theme={themes.vsDark}>
            {({
                className: prismClass,
                style,
                tokens,
                getLineProps,
                getTokenProps,
            }) => (
                <pre
                    className={cn(
                        prismClass,
                        'overflow-x-auto rounded-md border p-4 text-sm leading-relaxed',
                        className,
                    )}
                    style={style}
                >
                    {tokens.map((line, i) => (
                        <div key={i} {...getLineProps({ line })}>
                            {line.map((token, key) => (
                                <span key={key} {...getTokenProps({ token })} />
                            ))}
                        </div>
                    ))}
                </pre>
            )}
        </Highlight>
    );
}
