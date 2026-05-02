<?php

namespace Database\Seeders\Data\Categories;

use Database\Seeders\Data\Categories\SystemDesign\Api;
use Database\Seeders\Data\Categories\SystemDesign\Architecture;
use Database\Seeders\Data\Categories\SystemDesign\Caching;
use Database\Seeders\Data\Categories\SystemDesign\DesignTasks;
use Database\Seeders\Data\Categories\SystemDesign\Devops;
use Database\Seeders\Data\Categories\SystemDesign\Distributed;
use Database\Seeders\Data\Categories\SystemDesign\MessagingQueues;
use Database\Seeders\Data\Categories\SystemDesign\Performance;
use Database\Seeders\Data\Categories\SystemDesign\Security;

class SystemDesignQuestions
{
    /**
     * @return array<int, array{category: string, question: string, answer: string, code_example: ?string, code_language: ?string, difficulty: int, topic: string}>
     */
    public static function all(): array
    {
        return array_merge(
            Architecture::all(),
            Caching::all(),
            MessagingQueues::all(),
            Distributed::all(),
            Api::all(),
            Security::all(),
            Performance::all(),
            Devops::all(),
            DesignTasks::all(),
        );
    }
}
