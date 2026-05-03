<?php

namespace Database\Seeders\Data\Categories\Laravel;

class RequestsValidation
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Как получить данные из Request в Laravel?',
                'answer' => 'Через объект Illuminate\Http\Request. Методы: input("name"), all(), only(["a", "b"]), except(["c"]), has("name"), filled("name"), get(), post(), query(), file("avatar"). Заголовки: header(). Cookie: cookie().',
                'code_example' => 'public function store(Request $request) {
    $name = $request->input(\'name\');
    $email = $request->input(\'email\', \'default@mail.com\');
    $only = $request->only([\'name\', \'email\']);
    $hasName = $request->has(\'name\');
    $token = $request->header(\'Authorization\');
    $file = $request->file(\'avatar\');
}',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'laravel.requests_validation',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие способы вернуть Response в Laravel?',
                'answer' => 'response($content), response()->json($data), response()->view("name"), response()->download($path), response()->stream(), redirect()->route(), back(), abort(404). Можно установить статус и заголовки.',
                'code_example' => 'return response(\'Hello\', 200)->header(\'X-Custom\', \'value\');
return response()->json([\'user\' => $user], 201);
return response()->download($path, \'file.pdf\');
return redirect()->route(\'home\')->with(\'success\', \'Готово\');
abort(404, \'Не найдено\');',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'laravel.requests_validation',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое FormRequest и зачем он нужен?',
                'answer' => 'FormRequest - это специальный класс для валидации входящих данных, отдельно от контроллера. Когда вы указываете FormRequest в типе параметра контроллера, Laravel автоматически запустит валидацию ДО выполнения метода. Если валидация не прошла - вернётся ошибка 422 (или редирект с ошибками).',
                'code_example' => 'class StoreUserRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            \'name\' => [\'required\', \'string\', \'max:255\'],
            \'email\' => [\'required\', \'email\', \'unique:users\'],
        ];
    }
}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.requests_validation',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Какие методы есть у FormRequest для кастомизации валидации?',
                'answer' => 'rules() - правила. messages() - кастомные сообщения. attributes() - читаемые имена полей. authorize() - проверка прав. prepareForValidation() - изменить данные ПЕРЕД валидацией. withValidator() - добавить кастомные правила/after-callback. passedValidation() - после успешной валидации. failedValidation() - переопределить поведение при ошибке.',
                'code_example' => 'public function prepareForValidation(): void {
    $this->merge([\'slug\' => Str::slug($this->title)]);
}

public function withValidator($validator): void {
    $validator->after(function ($v) {
        if ($this->title === $this->body) {
            $v->errors()->add(\'body\', \'Заголовок и текст одинаковые\');
        }
    });
}',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.requests_validation',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как создать кастомное правило валидации?',
                'answer' => 'Через artisan make:rule создать класс, реализующий ValidationRule (Laravel 10+) с методом validate. Также можно использовать closure-правило прямо в массиве rules. Класс Rule предоставляет готовые сложные правила: Rule::unique, Rule::exists, Rule::in, Rule::when.',
                'code_example' => 'class Uppercase implements ValidationRule {
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (strtoupper($value) !== $value) {
            $fail(\'Значение должно быть в верхнем регистре.\');
        }
    }
}

// Использование
$request->validate([\'code\' => [\'required\', new Uppercase()]]);',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.requests_validation',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Form Request и какие у него этапы валидации?',
                'answer' => 'FormRequest - типизированный request с инкапсулированной валидацией и авторизацией. Контейнер резолвит его и через ValidatesWhenResolvedTrait::validateResolved() запускает фиксированную последовательность: 1) prepareForValidation() (нормализация входа - merge/replace ДО авторизации и правил), 2) passesAuthorization() → authorize() (если false → failedAuthorization), 3) getValidatorInstance() - создание валидатора, внутри которого читаются rules()/messages()/attributes() и вызывается withValidator() для after-rules, 4) если валидатор fails → failedValidation, иначе passedValidation() для пост-обработки. failedValidation/failedAuthorization можно переопределять для кастомных ответов. Тонкий момент: prepareForValidation() выполняется ДО authorize(), поэтому authorize() уже видит нормализованные данные ($this->input()).',
                'code_example' => '<?php
class StoreUserRequest extends FormRequest {
    protected function prepareForValidation(): void {
        $this->merge(["email" => strtolower($this->email ?? "")]);
    }
    public function rules(): array {
        return ["email" => ["required", "email", Rule::unique("users")]];
    }
    public function authorize(): bool { return $this->user()->can("create-user"); }
}',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.requests_validation',
            ],
        ];
    }
}
