import { Badge } from '@/components/ui/badge';
import { categoryStyle } from '@/lib/category-colors';
import { cn } from '@/lib/utils';

type Props = {
    category: string | null;
    className?: string;
};

export function CategoryBadge({ category, className }: Props) {
    if (!category) {
        return null;
    }

    const style = categoryStyle(category);

    return (
        <Badge
            variant="outline"
            className={cn('gap-1.5 font-medium', style.badge, className)}
        >
            <span className={cn('size-1.5 rounded-full', style.dot)} />
            {category}
        </Badge>
    );
}
