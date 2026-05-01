<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flashcards', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable()->index();
            $table->text('question');
            $table->text('answer');
            $table->unsignedInteger('correct_streak')->default(0);
            $table->unsignedInteger('required_correct')->default(1);
            $table->boolean('is_learned')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flashcards');
    }
};
