<?php

namespace Database\Seeders\Data\Categories\Laravel;

class StorageFiles
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example?: ?string, code_language?: ?string, difficulty?: int, topic?: string}>
     */
    public static function all(): array
    {
        return [
            [
                'category' => 'Laravel',
                'question' => 'Что такое File Storage и какие есть disks?',
                'answer' => 'File Storage - абстракция над файловыми хранилищами через Flysystem. Disks: local (storage/app), public (storage/app/public, доступен через symlink), s3 (Amazon S3), ftp, sftp. Один интерфейс - разные хранилища.',
                'code_example' => 'Storage::disk(\'s3\')->put(\'avatars/1.jpg\', $contents);
$url = Storage::disk(\'public\')->url(\'avatars/1.jpg\');
$content = Storage::get(\'file.txt\');
Storage::delete(\'file.txt\');

// Создать симлинк public
php artisan storage:link',
                'code_language' => 'php',
                'difficulty' => 2,
                'topic' => 'laravel.storage_files',
            ],
        ];
    }
}
