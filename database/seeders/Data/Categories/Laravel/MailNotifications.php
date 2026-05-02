<?php

namespace Database\Seeders\Data\Categories\Laravel;

class MailNotifications
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Что такое Notifications в Laravel?',
                'answer' => 'Notifications - это унифицированный способ отправлять уведомления через разные каналы: mail, database, broadcast, slack, sms (vonage), и кастомные. Один класс уведомления, метод via() выбирает каналы.',
                'code_example' => 'class InvoicePaid extends Notification {
    public function via($notifiable): array {
        return [\'mail\', \'database\', \'broadcast\'];
    }
    public function toMail($notifiable): MailMessage {
        return (new MailMessage)->line(\'Оплата получена\');
    }
    public function toArray($notifiable): array {
        return [\'invoice_id\' => $this->invoice->id];
    }
}

$user->notify(new InvoicePaid($invoice));',
                'code_language' => 'php',
                'difficulty' => 3,
                'topic' => 'laravel.mail_notifications',
            ],
            [
                'category' => 'Laravel',
                'question' => 'Как отправлять Mail в Laravel?',
                'answer' => 'Создаётся Mailable-класс через make:mail. Он описывает заголовок (envelope), содержимое (content) и вложения (attachments). Шаблон может быть Blade-вьюшкой, markdown-шаблоном или обычным текстом. Отправка через Mail фасад. Драйверы SMTP, Mailgun, SES, Postmark, log, array.',
                'code_example' => 'php artisan make:mail OrderShipped --markdown=mail.orders.shipped

class OrderShipped extends Mailable {
    public function envelope(): Envelope {
        return new Envelope(subject: \'Заказ отправлен\');
    }
    public function content(): Content {
        return new Content(markdown: \'mail.orders.shipped\');
    }
}

Mail::to($user)->send(new OrderShipped($order));
Mail::to($user)->queue(new OrderShipped($order));',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'laravel.mail_notifications',
            ],
        ];
    }
}
