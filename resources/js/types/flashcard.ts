export type Flashcard = {
    id: number;
    category: string | null;
    topic: string | null;
    difficulty: number;
    question: string;
    answer: string;
    code_example: string | null;
    code_language: string | null;
    cloze_text: string | null;
    short_answer: string | null;
    assemble_chunks: string[] | null;
    note: string | null;
    correct_streak: number;
    correct_modes: string[] | null;
    required_correct: number;
    is_learned: boolean;
    next_review_at: string | null;
    srs_step: number;
};

export type FlashcardStats = {
    total: number;
    learned: number;
    due: number;
};

export type Paginated<T> = {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    from: number | null;
    to: number | null;
    total: number;
    prev_page_url: string | null;
    next_page_url: string | null;
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
