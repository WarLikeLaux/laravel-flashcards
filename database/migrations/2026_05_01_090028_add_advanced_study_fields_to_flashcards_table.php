<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('flashcards', function (Blueprint $table) {
            $table->text('cloze_text')->nullable()->after('answer');
            $table->string('short_answer', 255)->nullable()->after('cloze_text');
            $table->json('assemble_chunks')->nullable()->after('short_answer');
        });
    }

    public function down(): void
    {
        Schema::table('flashcards', function (Blueprint $table) {
            $table->dropColumn(['cloze_text', 'short_answer', 'assemble_chunks']);
        });
    }
};
