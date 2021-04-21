<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EanController;
use App\Http\Controllers\OriginalCodeController;
use App\Http\Controllers\RelatedNumberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('articles.index'));
});

Route::pattern('id', '[0-9]+');
Route::pattern('article', '[0-9]+');

Route::resource('articles', ArticleController::class)->except(['show']);

Route::prefix('articles/{article}')->group(function () {
    Route::post('original_codes', [OriginalCodeController::class, 'store'])->name('original_codes.store');
    Route::delete('original_codes/{id}', [OriginalCodeController::class, 'destroy'])->name('original_codes.destroy');

    Route::post('related_numbers', [RelatedNumberController::class, 'store'])->name('related_numbers.store');
    Route::delete('related_numbers/{id}', [RelatedNumberController::class, 'destroy'])->name('related_numbers.destroy');

    Route::post('eans', [EanController::class, 'store'])->name('eans.store');
    Route::delete('eans/{id}', [EanController::class, 'destroy'])->name('eans.destroy');
});
