<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('flashcards', function (Blueprint $table) {
            $table->unsignedTinyInteger('difficulty')->default(1)->index()->after('category');
            $table->string('topic', 64)->nullable()->index()->after('difficulty');
            $table->json('correct_modes')->nullable()->after('correct_streak');
        });
    }

    public function down(): void
    {
        Schema::table('flashcards', function (Blueprint $table) {
            $table->dropColumn(['difficulty', 'topic', 'correct_modes']);
        });
    }
};
