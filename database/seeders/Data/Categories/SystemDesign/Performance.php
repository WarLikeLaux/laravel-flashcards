<?php

namespace Database\Seeders\Data\Categories\SystemDesign;

class Performance
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example: ?string, code_language: ?string, difficulty: int, topic: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Архитектура систем',
                'question' => 'В чём разница между latency и throughput?',
                'answer' => 'Latency - задержка одной операции (сколько ждать ответа на один запрос). Throughput - пропускная способность (сколько запросов в секунду). Простыми словами: автобан с одной полосой и скоростью 100 км/ч - низкая latency, но низкий throughput. Дорога в 10 полос с пробкой 30 км/ч - высокая latency, но высокий throughput. Оптимизировать одно не значит улучшить другое.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.performance',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое перцентили P50, P95, P99 в метриках?',
                'answer' => 'Перцентили - не среднее, а распределение. P50 (медиана) - 50% запросов быстрее этого значения. P95 - 95% быстрее (худшие 5% хуже). P99 - 99% быстрее. Простыми словами: средняя задержка может быть 100мс, но P99=2с означает что у 1% пользователей всё тормозит. Среднее обманывает - перцентили показывают "хвост". Цель SRE - снижать P95/P99, потому что именно они портят UX.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.performance',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое observability и три её столпа?',
                'answer' => 'Observability - возможность понять что происходит внутри системы по её внешним сигналам. Три столпа: 1) Logs - дискретные записи событий ("user 42 logged in"), 2) Metrics - числовые ряды во времени (RPS, CPU, latency), 3) Traces - путь запроса через систему (через какие сервисы прошёл, где сколько времени). Monitoring отвечает "система работает?", observability - "почему так работает?". Инструменты: Prometheus+Grafana, OpenTelemetry, Jaeger.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.performance',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое distributed tracing?',
                'answer' => 'Distributed tracing - отслеживание прохождения одного запроса через множество микросервисов. Каждый запрос получает trace_id, каждый шаг - span_id с родителем. На выходе видно: запрос пошёл в gateway → auth-service (5мс) → user-service (20мс) → db (15мс). Сразу видно где тормозит. Стандарт - W3C Trace Context (заголовки traceparent/tracestate), инструменты: Jaeger, Zipkin, OpenTelemetry, Datadog APM. Часто применяют sampling (1-10% трейсов) - storage и overhead для всех 100% дорог.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.performance',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Чем вертикальное масштабирование отличается от горизонтального?',
                'answer' => 'Vertical scaling (scale up) - увеличиваем мощность одной машины: больше CPU, RAM, NVMe. Просто, не требует изменений в коде, но есть потолок железа и точка отказа одна. Horizontal scaling (scale out) - добавляем больше машин и распределяем нагрузку через load balancer. Почти безлимитно, отказоустойчиво, но требует stateless-приложений, общего хранилища сессий, распределённых кэшей и БД-репликации/шардинга. Правило: stateless web-слой - горизонтально, БД - вертикально до предела, потом read replicas, потом sharding. Cloud-native всегда тяготеет к horizontal.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 3,
                'topic' => 'system_design.performance',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Какие алгоритмы балансировки нагрузки бывают?',
                'answer' => 'Round Robin - по очереди, простой, но не учитывает нагрузку. Weighted Round Robin - с весами (мощные серверы получают больше). Least Connections - на сервер с минимумом активных коннектов, хорош при разной длительности запросов. Least Response Time - на самый быстрый. IP Hash / Consistent Hash - один клиент всегда на тот же бэк (для sticky sessions без cookie). Random with Two Choices (Power of Two) - выбирает 2 случайных, шлёт на менее загруженный, эмпирически близко к Least Connections при O(1). L4 (TCP) балансировщики (HAProxy, AWS NLB) быстрее, L7 (Nginx, Envoy) умнее (могут смотреть в HTTP-заголовки, делать canary).',
                'code_example' => 'upstream backend {
    least_conn;
    server backend1.example.com weight=3 max_fails=2 fail_timeout=10s;
    server backend2.example.com weight=1;
    server backend3.example.com backup;
    keepalive 32;
}',
                'code_language' => 'bash',
                'difficulty' => 3,
                'topic' => 'system_design.performance',
            ],
            [
                'category' => 'Архитектура систем',
                'question' => 'Что такое N+1 запросы и как их избегать?',
                'answer' => 'N+1 - антипаттерн: 1 запрос за списком + N запросов за связанными данными для каждого элемента. Например, $posts = Post::all(); foreach ($posts as $p) echo $p->author->name - 1 SELECT posts + N SELECT users. На 1000 постов - 1001 запрос вместо 2. Решение: eager loading (Post::with("author")->get() даёт 2 запроса через WHERE IN). Диагностика: Laravel Debugbar, Telescope, Pulse, или Model::preventLazyLoading() в проде. В GraphQL аналог - DataLoader (батчит и дедуплицирует загрузки в рамках одного запроса).',
                'code_example' => '<?php
// плохо: N+1
$posts = Post::all();
foreach ($posts as $post) {
    echo $post->author->name; // SELECT для каждого
}

// хорошо: eager loading
$posts = Post::with("author")->get();
// SELECT * FROM posts;
// SELECT * FROM users WHERE id IN (1,2,3,...);

// в проде: ловим lazy loading на старте
Model::preventLazyLoading(! app()->isProduction());',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'system_design.performance',
            ],
        ];
    }
}
