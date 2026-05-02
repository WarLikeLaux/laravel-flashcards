<?php

namespace Database\Seeders\Data\Categories\Laravel;

class QueuesJobs
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Что такое очереди (Queues) в Laravel?',
                'answer' => 'Очереди - это механизм отложенного выполнения задач в фоновом режиме. Простыми словами: тяжёлую задачу (отправка email, обработка изображений) кладём в очередь, чтобы пользователь не ждал. Драйверы: database, redis, sqs, beanstalkd, sync (для отладки), null.',
                'code_example' => 'php artisan make:job ProcessPodcast

class ProcessPodcast implements ShouldQueue {
    use Queueable;
    public function handle(): void { /* работа */ }
}

ProcessPodcast::dispatch($podcast);
ProcessPodcast::dispatch($podcast)->onQueue(\'high\')->delay(now()->addMinutes(5));',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'laravel.queues_jobs',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как работают воркеры очередей и как их запускать в продакшене?',
                'answer' => 'Воркер - это процесс php artisan queue:work, который непрерывно забирает и выполняет задачи из очереди. В продакшене запускается под Supervisor (или systemd, k8s), чтобы автоматически перезапускался при падении. После деплоя нужно делать queue:restart, чтобы воркеры перечитали код.',
                'code_example' => 'php artisan queue:work redis --queue=high,default --tries=3 --timeout=60
php artisan queue:restart

# supervisor config
[program:laravel-worker]
command=php /var/www/artisan queue:work redis --tries=3
autostart=true
autorestart=true
numprocs=4',
                'code_language' => 'bash',
                'difficulty' => 3,
                'topic' => 'laravel.queues_jobs',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое retry, backoff и failed jobs?',
                'answer' => '$tries - максимальное количество попыток. backoff - задержка между попытками (число или массив для прогрессивного backoff). При исчерпании попыток job попадает в таблицу failed_jobs. Можно посмотреть через queue:failed, повторить через queue:retry, удалить через queue:flush.',
                'code_example' => 'class ProcessPodcast implements ShouldQueue {
    public int $tries = 5;
    public array $backoff = [1, 5, 10, 30];

    public function failed(\Throwable $e): void {
        // уведомить, залогировать
    }
}

php artisan queue:retry all
php artisan queue:flush',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.queues_jobs',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое ShouldBeUnique?',
                'answer' => 'ShouldBeUnique - интерфейс, гарантирующий что в очереди в один момент есть только одна копия задачи с тем же ключом. Простыми словами: защита от дубликатов в очереди. Можно реализовать uniqueId() и uniqueFor() (TTL).',
                'code_example' => 'class UpdateSearchIndex implements ShouldQueue, ShouldBeUnique {
    public int $uniqueFor = 3600;

    public function uniqueId(): string {
        return $this->product->id;
    }
}',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.queues_jobs',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что такое Job Batching и Chains?',
                'answer' => 'Chain - последовательное выполнение задач: если одна провалилась, следующие не запускаются. Batch - параллельное выполнение группы задач с общим callback (then/catch/finally) и прогрессом.',
                'code_example' => '// Chain
Bus::chain([
    new ImportCsv,
    new GenerateReport,
    new SendNotification,
])->dispatch();

// Batch
Bus::batch([
    new ProcessFile(\'a.csv\'),
    new ProcessFile(\'b.csv\'),
])->then(fn($batch) => Log::info("Done"))
  ->catch(fn($batch, $e) => Log::error($e))
  ->dispatch();',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.queues_jobs',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как обеспечить идемпотентность Job в очереди и что произойдёт при двойном запуске?',
                'answer' => 'Очередь даёт at-least-once: при таймауте/падении воркера job переехдёт в attempts+1. Для идемпотентности используют ключ операции (заказ id, request id) и проверяют через WithoutOverlapping или БД-запись unique constraint, либо реализуют ShouldBeUnique. Альтернатива - middleware Throttled с уникальным ключом. Также важно ставить retry_after > timeout, чтобы не дублировать запуск из-за таймаута слушателя.',
                'code_example' => '<?php
class ProcessPayment implements ShouldQueue, ShouldBeUnique {
    public int $uniqueFor = 3600;
    public function __construct(public int $orderId) {}
    public function uniqueId(): string { return (string) $this->orderId; }
    public function handle() { /* charge once */ }
}',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.queues_jobs',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как настроить экспоненциальный backoff и максимальное число попыток для Job?',
                'answer' => 'Свойство $tries или метод tries() задаёт число попыток. backoff() возвращает int или массив задержек по каждой попытке (экспоненциальный backoff). retryUntil() задаёт абсолютный дедлайн. Для долгих jobs нужна синхронизация $timeout (sec) и retry_after в конфиге queue, чтобы воркер не считал job упавшим. failed() вызывается после исчерпания tries - место для алертов.',
                'code_example' => '<?php
class SyncCrm implements ShouldQueue {
    public int $tries = 5;
    public int $timeout = 120;
    public function backoff(): array { return [10, 30, 60, 120, 300]; }
    public function failed(Throwable $e): void { Log::critical("CRM sync gave up", ["e" => $e]); }
}',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.queues_jobs',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Что произойдёт при деплое, если воркеры очереди держат старый код?',
                'answer' => 'Воркер бутстрапит фреймворк один раз и держит его в памяти. После деплоя он продолжит обрабатывать jobs со старыми сериализованными моделями и старыми классами. Решение - выполнять php artisan queue:restart, который выставляет таймстамп в кэше; воркеры периодически его проверяют и грейсфул-завершаются. Supervisor поднимет их с новым кодом. Также job-классы нельзя переименовывать без compatibility-shim, иначе сериализованные данные не десериализуются.',
                'code_example' => '# deploy.sh
php artisan queue:restart
php artisan migrate --force
php artisan config:cache route:cache event:cache',
                'code_language' => 'bash',
                'difficulty' => 4,
                'topic' => 'laravel.queues_jobs',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Безопасно ли использовать DB::transaction внутри job очереди и какие нюансы?',
                'answer' => 'Безопасно, но с оговорками. afterCommit() - слушатели/события, диспатченные внутри транзакции, должны выполниться только после её коммита, иначе job стартует и не найдёт данных. С Laravel 8+ можно ставить $afterCommit=true на job или использовать DB::afterCommit(). Длинные транзакции внутри job блокируют строки - лучше делать short-lived транзакции и идемпотентные операции.',
                'code_example' => '<?php
class SendInvoice implements ShouldQueue {
    public bool $afterCommit = true;
}
DB::transaction(function () use ($order) {
    $order->save();
    SendInvoice::dispatch($order); // сработает после COMMIT
});',
                'code_language' => 'php',
                'difficulty' => 4,
                'topic' => 'laravel.queues_jobs',
            ],
        ];
    }
}
