export type Flashcard = {
    id: number;
    category: string | null;
    question: string;
    answer: string;
    code_example: string | null;
    code_language: string | null;
    cloze_text: string | null;
    short_answer: string | null;
    assemble_chunks: string[] | null;
    correct_streak: number;
    required_correct: number;
    is_learned: boolean;
};

export type FlashcardStats = {
    total: number;
    learned: number;
    due: number;
};

export type StudyMode =
    | 'reveal'
    | 'true_false'
    | 'multiple_choice'
    | 'cloze'
    | 'type_in'
    | 'assemble'
    | 'matching';

export type StudyShown = {
    answer: string;
    is_correct: boolean;
};

export type StudyOption = {
    id: number;
    answer: string;
    is_correct: boolean;
};

export type StudyAssemble = {
    pool: string[];
};

export type StudyMatchingItem = {
    id: number;
    text: string;
};

export type StudyMatching = {
    category: string;
    questions: StudyMatchingItem[];
    answers: StudyMatchingItem[];
};
