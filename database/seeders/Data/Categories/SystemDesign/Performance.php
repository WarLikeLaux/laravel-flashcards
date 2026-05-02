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
                'answer' => 'Distributed tracing - отслеживание прохождения одного запроса через множество микросервисов. Каждый запрос получает trace_id, каждый шаг - span_id с родителем. На выходе видно: запрос пошёл в gateway → auth-service (5мс) → user-service (20мс) → db (15мс). Сразу видно где тормозит. Стандарт - W3C Trace Context, инструменты: Jaeger, Zipkin, OpenTelemetry, Datadog APM.',
                'code_example' => null,
                'code_language' => null,
                'difficulty' => 4,
                'topic' => 'system_design.performance',
            ],
        ];
    }
}
