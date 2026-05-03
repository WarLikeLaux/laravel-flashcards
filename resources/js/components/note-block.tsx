import { StickyNote } from 'lucide-react';

export function NoteBlock({ note }: { note: string | null }) {
    if (!note) {
        return null;
    }

    return (
        <div className="flex flex-col gap-1.5 rounded-md border border-amber-500/30 bg-amber-500/5 p-3">
            <span className="flex items-center gap-1.5 text-[10px] font-semibold tracking-wide text-amber-700 uppercase dark:text-amber-300">
                <StickyNote className="size-3" />
                Заметка
            </span>
            <p className="text-sm whitespace-pre-line">{note}</p>
        </div>
    );
}
