<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFlashcardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category' => ['nullable', 'string', 'max:64'],
            'question' => ['required', 'string', 'max:2000'],
            'answer' => ['required', 'string', 'max:5000'],
            'code_example' => ['nullable', 'string', 'max:10000'],
            'code_language' => ['nullable', 'string', 'max:32'],
            'cloze_text' => ['nullable', 'string', 'max:5000'],
            'short_answer' => ['nullable', 'string', 'max:255'],
            'assemble_chunks' => ['nullable', 'array', 'min:2', 'max:20'],
            'assemble_chunks.*' => ['required', 'string', 'max:200'],
        ];
    }
}
