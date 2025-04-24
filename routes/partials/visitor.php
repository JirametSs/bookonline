<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitorController;

Route::prefix('api')->group(function () {
    Route::get('/visitor-stats', [VisitorController::class, 'stats'])->name('api.visitor-stats');
});
