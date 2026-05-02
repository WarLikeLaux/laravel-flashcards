<?php

use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\LearnController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StudyController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/flashcards');

Route::get('flashcards', [FlashcardController::class, 'index'])->name('flashcards.index');
Route::get('flashcards/create', [FlashcardController::class, 'create'])->name('flashcards.create');
Route::post('flashcards', [FlashcardController::class, 'store'])->name('flashcards.store');
Route::post('flashcards/reset', [FlashcardController::class, 'reset'])->name('flashcards.reset');
Route::get('flashcards/{flashcard}/edit', [FlashcardController::class, 'edit'])->name('flashcards.edit');
Route::patch('flashcards/{flashcard}', [FlashcardController::class, 'update'])->name('flashcards.update');
Route::delete('flashcards/{flashcard}', [FlashcardController::class, 'destroy'])->name('flashcards.destroy');

Route::get('learn', [LearnController::class, 'show'])->name('learn.show');
Route::post('learn/{flashcard}/studied', [LearnController::class, 'studied'])->name('learn.studied');

Route::get('study', [StudyController::class, 'show'])->name('study.show');
Route::post('study/{flashcard}/answer', [StudyController::class, 'answer'])->name('study.answer');
Route::post('study/matching', [StudyController::class, 'matching'])->name('study.matching');

Route::get('review', [ReviewController::class, 'show'])->name('review.show');
Route::post('review/reset', [ReviewController::class, 'reset'])->name('review.reset');
Route::post('review/{flashcard}/remember', [ReviewController::class, 'remember'])->name('review.remember');
Route::post('review/{flashcard}/forgot', [ReviewController::class, 'forgot'])->name('review.forgot');
