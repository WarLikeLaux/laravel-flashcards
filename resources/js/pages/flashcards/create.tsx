import { Form, Head, Link } from '@inertiajs/react';
import { ArrowLeft } from 'lucide-react';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import flashcards from '@/routes/flashcards';

export default function FlashcardCreate() {
    return (
        <>
            <Head title="Add card" />

            <div className="mx-auto flex w-full max-w-2xl flex-col gap-4 p-6">
                <Button
                    asChild
                    variant="ghost"
                    size="sm"
                    className="self-start"
                >
                    <Link href={flashcards.index().url}>
                        <ArrowLeft />
                        Back to cards
                    </Link>
                </Button>

                <Card>
                    <CardHeader>
                        <CardTitle>New flashcard</CardTitle>
                        <CardDescription>
                            Create a question and the answer to memorise.
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Form
                            action={flashcards.store().url}
                            method="post"
                            resetOnSuccess
                            className="flex flex-col gap-4"
                        >
                            {({ errors, processing }) => (
                                <>
                                    <div className="flex flex-col gap-2">
                                        <Label htmlFor="category">
                                            Category
                                        </Label>
                                        <Input
                                            id="category"
                                            name="category"
                                            placeholder="PHP, Laravel, OOP…"
                                            autoComplete="off"
                                        />
                                        {errors.category && (
                                            <p className="text-sm text-destructive">
                                                {errors.category}
                                            </p>
                                        )}
                                    </div>

                                    <div className="flex flex-col gap-2">
                                        <Label htmlFor="question">
                                            Question
                                        </Label>
                                        <Textarea
                                            id="question"
                                            name="question"
                                            required
                                            rows={3}
                                        />
                                        {errors.question && (
                                            <p className="text-sm text-destructive">
                                                {errors.question}
                                            </p>
                                        )}
                                    </div>

                                    <div className="flex flex-col gap-2">
                                        <Label htmlFor="answer">Answer</Label>
                                        <Textarea
                                            id="answer"
                                            name="answer"
                                            required
                                            rows={6}
                                        />
                                        {errors.answer && (
                                            <p className="text-sm text-destructive">
                                                {errors.answer}
                                            </p>
                                        )}
                                    </div>

                                    <div className="grid gap-2 md:grid-cols-[1fr_140px]">
                                        <div className="flex flex-col gap-2">
                                            <Label htmlFor="code_example">
                                                Code example (optional)
                                            </Label>
                                            <Textarea
                                                id="code_example"
                                                name="code_example"
                                                rows={6}
                                                placeholder="Shown after the answer to compare with."
                                                spellCheck={false}
                                                className="font-mono"
                                            />
                                            {errors.code_example && (
                                                <p className="text-sm text-destructive">
                                                    {errors.code_example}
                                                </p>
                                            )}
                                        </div>
                                        <div className="flex flex-col gap-2">
                                            <Label htmlFor="code_language">
                                                Language
                                            </Label>
                                            <Input
                                                id="code_language"
                                                name="code_language"
                                                defaultValue="php"
                                                placeholder="php"
                                                autoComplete="off"
                                            />
                                            {errors.code_language && (
                                                <p className="text-sm text-destructive">
                                                    {errors.code_language}
                                                </p>
                                            )}
                                        </div>
                                    </div>

                                    <div className="flex justify-end gap-2">
                                        <Button
                                            asChild
                                            type="button"
                                            variant="ghost"
                                        >
                                            <Link href={flashcards.index().url}>
                                                Cancel
                                            </Link>
                                        </Button>
                                        <Button
                                            type="submit"
                                            disabled={processing}
                                        >
                                            Save card
                                        </Button>
                                    </div>
                                </>
                            )}
                        </Form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
