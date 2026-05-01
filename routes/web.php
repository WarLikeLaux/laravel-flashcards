<?php

use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\StudyController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/flashcards');

Route::get('flashcards', [FlashcardController::class, 'index'])->name('flashcards.index');
Route::get('flashcards/create', [FlashcardController::class, 'create'])->name('flashcards.create');
Route::post('flashcards', [FlashcardController::class, 'store'])->name('flashcards.store');
Route::delete('flashcards/{flashcard}', [FlashcardController::class, 'destroy'])->name('flashcards.destroy');
Route::post('flashcards/reset', [FlashcardController::class, 'reset'])->name('flashcards.reset');

Route::get('study', [StudyController::class, 'show'])->name('study.show');
Route::post('study/{flashcard}/answer', [StudyController::class, 'answer'])->name('study.answer');
