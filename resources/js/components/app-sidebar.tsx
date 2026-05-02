import { Link } from '@inertiajs/react';
import {
    BarChart3,
    BookOpen,
    GraduationCap,
    Layers,
    Plus,
    Repeat,
} from 'lucide-react';
import AppLogo from '@/components/app-logo';
import { NavMain } from '@/components/nav-main';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import flashcards from '@/routes/flashcards';
import learn from '@/routes/learn';
import review from '@/routes/review';
import stats from '@/routes/stats';
import study from '@/routes/study';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Карточки',
        href: flashcards.index().url,
        icon: Layers,
    },
    {
        title: 'Новая карточка',
        href: flashcards.create().url,
        icon: Plus,
    },
    {
        title: 'Изучение',
        href: learn.show().url,
        icon: BookOpen,
    },
    {
        title: 'Проверка',
        href: study.show().url,
        icon: GraduationCap,
    },
    {
        title: 'Повторение',
        href: review.show().url,
        icon: Repeat,
    },
    {
        title: 'Статистика',
        href: stats.show().url,
        icon: BarChart3,
    },
];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={flashcards.index().url} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter />
        </Sidebar>
    );
}
