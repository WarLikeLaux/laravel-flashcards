<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('flashcards', function (Blueprint $table) {
            $table->text('code_example')->nullable()->after('answer');
            $table->string('code_language', 32)->nullable()->after('code_example');
        });
    }

    public function down(): void
    {
        Schema::table('flashcards', function (Blueprint $table) {
            $table->dropColumn(['code_example', 'code_language']);
        });
    }
};
