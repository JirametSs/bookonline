<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CircularController;
use App\Http\Controllers\VisitorController;

Route::prefix('circulars')->group(function () {
    Route::get('/', [CircularController::class, 'index'])->name('circulars.index');
    Route::get('/create', [CircularController::class, 'create'])->name('circulars.create');
    Route::post('/', [CircularController::class, 'store'])->name('circulars.store');
    Route::get('/record', [CircularController::class, 'record'])->name('circulars.record');
    Route::get('/{id}/edit', [CircularController::class, 'edit'])->name('circulars.edit');
    Route::put('/{id}', [CircularController::class, 'update'])->name('circulars.update');
    Route::delete('/{id}', [CircularController::class, 'destroy'])->name('circulars.destroy');
    Route::get('/api/visitor-stats', [VisitorController::class, 'stats'])->name('api.visitor-stats');
    Route::get('/circulars/record', [CircularController::class, 'record'])->name('circulars.record');
    Route::get('/circulars/{id}', [CircularController::class, 'show'])->name('circulars.show');
    Route::get('/open-pdf/{id}', [CircularController::class, 'openPdf'])->name('circulars.openPdf');
    Route::get('/circulars/{id}/download', [CircularController::class, 'downloadPdf'])->name('circulars.download');
    Route::get('/circulars/read/{id}', [CircularController::class, 'show'])->name('circulars.read');
    Route::get('/images/{id}', [CircularController::class, 'showImage'])->name('circulars.image');
    Route::get('/circulars/download/{id}', [\App\Http\Controllers\CircularController::class, 'downloadPdf'])->name('circulars.downloadPdf');
    Route::get('/circulars/pdfview/{id}', [CircularController::class, 'pdfView'])->name('circulars.pdfView');
    Route::get('/circulars/image/view/{id}', [\App\Http\Controllers\CircularController::class, 'viewImage'])->name('circulars.viewImage');
    Route::get('/circulars/image/{id}', [CircularController::class, 'showImage'])->name('circulars.showImage');
    Route::get('/circulars/{id}', [CircularController::class, 'show'])->name('circulars.show');
    Route::get('/highlight-carousel', [CircularController::class, 'highlightBooks'])->name('circulars.highlight');
});
