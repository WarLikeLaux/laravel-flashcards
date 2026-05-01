import { BrainCircuit } from 'lucide-react';

export default function AppLogo() {
    return (
        <>
            <div className="flex aspect-square size-8 items-center justify-center rounded-lg bg-gradient-to-br from-violet-500 to-fuchsia-500 text-white shadow-sm">
                <BrainCircuit className="size-5" />
            </div>
            <div className="ml-1 grid flex-1 text-left">
                <span className="truncate text-sm leading-tight font-semibold">
                    LaraCards
                </span>
                <span className="truncate text-[10px] leading-tight text-muted-foreground">
                    тренажёр карточек
                </span>
            </div>
        </>
    );
}
