import { Link } from '@inertiajs/react';
import { GraduationCap, Layers, Plus } from 'lucide-react';
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
import study from '@/routes/study';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Cards',
        href: flashcards.index().url,
        icon: Layers,
    },
    {
        title: 'Add card',
        href: flashcards.create().url,
        icon: Plus,
    },
    {
        title: 'Study',
        href: study.show().url,
        icon: GraduationCap,
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
