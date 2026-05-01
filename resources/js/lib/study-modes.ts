import {
    Eye,
    Layers,
    PencilLine,
    Puzzle,
    Scale,
    SquareCheckBig,
    Spline,
} from 'lucide-react';
import type { LucideIcon } from 'lucide-react';
import type { StudyMode } from '@/types';

type ModeMeta = {
    label: string;
    description: string;
    icon: LucideIcon;
    accentText: string;
    accentBg: string;
    accentBorder: string;
    accentRing: string;
};

export const studyModeMeta: Record<StudyMode, ModeMeta> = {
    reveal: {
        label: 'Открыть ответ',
        description: 'Покажи ответ и оцени себя',
        icon: Eye,
        accentText: 'text-slate-600 dark:text-slate-300',
        accentBg: 'bg-slate-500/10',
        accentBorder: 'border-slate-500/30',
        accentRing: 'ring-slate-500/30',
    },
    true_false: {
        label: 'Правда / Ложь',
        description: 'Этот ответ верный?',
        icon: Scale,
        accentText: 'text-amber-600 dark:text-amber-400',
        accentBg: 'bg-amber-500/10',
        accentBorder: 'border-amber-500/30',
        accentRing: 'ring-amber-500/30',
    },
    multiple_choice: {
        label: 'Выбор варианта',
        description: 'Выбери правильный ответ',
        icon: SquareCheckBig,
        accentText: 'text-blue-600 dark:text-blue-400',
        accentBg: 'bg-blue-500/10',
        accentBorder: 'border-blue-500/30',
        accentRing: 'ring-blue-500/30',
    },
    cloze: {
        label: 'Заполни пропуски',
        description: 'Впиши пропущенные слова',
        icon: PencilLine,
        accentText: 'text-cyan-600 dark:text-cyan-400',
        accentBg: 'bg-cyan-500/10',
        accentBorder: 'border-cyan-500/30',
        accentRing: 'ring-cyan-500/30',
    },
    type_in: {
        label: 'Точный ввод',
        description: 'Введи ответ вручную',
        icon: Spline,
        accentText: 'text-violet-600 dark:text-violet-400',
        accentBg: 'bg-violet-500/10',
        accentBorder: 'border-violet-500/30',
        accentRing: 'ring-violet-500/30',
    },
    assemble: {
        label: 'Собрать из блоков',
        description: 'Расставь блоки в правильном порядке',
        icon: Puzzle,
        accentText: 'text-fuchsia-600 dark:text-fuchsia-400',
        accentBg: 'bg-fuchsia-500/10',
        accentBorder: 'border-fuchsia-500/30',
        accentRing: 'ring-fuchsia-500/30',
    },
    matching: {
        label: 'Найди пары',
        description: 'Сопоставь термины и короткие ответы',
        icon: Layers,
        accentText: 'text-emerald-600 dark:text-emerald-400',
        accentBg: 'bg-emerald-500/10',
        accentBorder: 'border-emerald-500/30',
        accentRing: 'ring-emerald-500/30',
    },
};
