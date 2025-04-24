<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecordController;

Route::prefix('record')->group(function () {
    Route::get('/', [RecordController::class, 'index'])->name('record.index');
    Route::get('/show/{id}', [RecordController::class, 'show'])->name('record.show');
    Route::delete('/record/delete/{id}', [RecordController::class, 'delete'])->name('record.delete');
    Route::post('/update', [RecordController::class, 'update'])->name('record.update');
    Route::put('/update', [RecordController::class, 'update'])->name('record.update');
});
