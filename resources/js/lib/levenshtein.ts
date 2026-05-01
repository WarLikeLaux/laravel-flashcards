export function levenshtein(a: string, b: string): number {
    if (a === b) {
        return 0;
    }

    const m = a.length;
    const n = b.length;

    if (m === 0) {
        return n;
    }

    if (n === 0) {
        return m;
    }

    const dp: number[] = new Array(n + 1).fill(0).map((_, i) => i);

    for (let i = 1; i <= m; i++) {
        let prev = dp[0];
        dp[0] = i;

        for (let j = 1; j <= n; j++) {
            const temp = dp[j];
            dp[j] =
                a[i - 1] === b[j - 1]
                    ? prev
                    : Math.min(prev, dp[j - 1], dp[j]) + 1;
            prev = temp;
        }
    }

    return dp[n];
}

export function looseEquals(a: string, b: string, tolerance = 1): boolean {
    const norm = (s: string) => s.trim().toLowerCase();

    return levenshtein(norm(a), norm(b)) <= tolerance;
}
