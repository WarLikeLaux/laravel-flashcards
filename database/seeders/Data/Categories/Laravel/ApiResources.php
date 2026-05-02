<?php

namespace Database\Seeders\Data\Categories\Laravel;

class ApiResources
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Что такое API Resources в Laravel?',
                'answer' => 'API Resource - это класс трансформации модели в JSON для API. Простыми словами: вместо того чтобы возвращать модель напрямую, мы оборачиваем её в Resource, где явно указываем, какие поля и как форматировать. Помогает скрыть лишние данные и формировать стабильный контракт API.',
                'code_example' => 'class UserResource extends JsonResource {
    public function toArray($request): array {
        return [
            \'id\' => $this->id,
            \'name\' => $this->name,
            \'email\' => $this->when($request->user()->is_admin, $this->email),
            \'posts\' => PostResource::collection($this->whenLoaded(\'posts\')),
        ];
    }
}

return new UserResource($user);
return UserResource::collection(User::all());',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.api_resources',
            ],
        ];
    }
}
