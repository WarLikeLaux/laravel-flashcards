export type Flashcard = {
    id: number;
    category: string | null;
    question: string;
    answer: string;
    code_example: string | null;
    code_language: string | null;
    correct_streak: number;
    required_correct: number;
    is_learned: boolean;
};

export type FlashcardStats = {
    total: number;
    learned: number;
    due: number;
};

export type StudyMode = 'reveal' | 'true_false' | 'multiple_choice';

export type StudyShown = {
    answer: string;
    is_correct: boolean;
};

export type StudyOption = {
    id: number;
    answer: string;
    is_correct: boolean;
};
