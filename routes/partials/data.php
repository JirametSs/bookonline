<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

Route::put('/circulars/{id}', [DataController::class, 'update'])->name('circulars.update');
Route::delete('/circulars/{id}/delete-image', [DataController::class, 'deleteImage'])->name('circulars.deleteImage');
