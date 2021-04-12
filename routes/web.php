<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EanController;
use App\Http\Controllers\OriginalCodeController;
use App\Http\Controllers\RelatedNumberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('articles.index'));
});

Route::resource('articles', ArticleController::class)->except(['show']);

Route::prefix('articles')->group(function () {
    Route::post('{article_id}/original_codes', [OriginalCodeController::class, 'store'])->name('original_codes.store');
    Route::delete('{article_id}/original_codes/{id}', [OriginalCodeController::class, 'destroy'])->name('original_codes.destroy');

    Route::post('{article_id}/related_numbers', [RelatedNumberController::class, 'store'])->name('related_numbers.store');
    Route::delete('{article_id}/related_numbers/{id}', [RelatedNumberController::class, 'destroy'])->name('related_numbers.destroy');

    Route::post('{article_id}/eans', [EanController::class, 'store'])->name('eans.store');
    Route::delete('{article_id}/eans/{id}', [EanController::class, 'destroy'])->name('eans.destroy');
});
