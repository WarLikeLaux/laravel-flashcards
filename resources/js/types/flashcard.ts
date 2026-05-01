export type Flashcard = {
    id: number;
    category: string | null;
    question: string;
    answer: string;
    correct_streak: number;
    required_correct: number;
    is_learned: boolean;
};

export type FlashcardStats = {
    total: number;
    learned: number;
    due: number;
};
