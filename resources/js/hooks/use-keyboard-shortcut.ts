import { useEffect } from 'react';

function isTypingTarget(target: EventTarget | null): boolean {
    if (!(target instanceof HTMLElement)) {
        return false;
    }

    if (target.isContentEditable) {
        return true;
    }

    const tag = target.tagName;

    return tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT';
}

/**
 * Fires `handler` when the user presses `key` outside of editable elements.
 * Pass `enabled = false` to suspend without unmounting.
 */
export function useKeyboardShortcut(
    key: string,
    handler: () => void,
    enabled: boolean = true,
): void {
    useEffect(() => {
        if (!enabled) {
            return;
        }

        const onKey = (event: KeyboardEvent) => {
            if (event.altKey || event.ctrlKey || event.metaKey) {
                return;
            }

            if (isTypingTarget(event.target)) {
                return;
            }

            if (event.key !== key) {
                return;
            }

            event.preventDefault();
            handler();
        };

        window.addEventListener('keydown', onKey);

        return () => window.removeEventListener('keydown', onKey);
    }, [key, handler, enabled]);
}
