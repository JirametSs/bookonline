<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidateController;

Route::prefix('validate')->group(function () {
    Route::get('/', [ValidateController::class, 'index'])->name('validate.index');
    Route::post('/update', [ValidateController::class, 'update'])->name('validate.update');
    // Route::get('/create', [ValidateController::class, 'create'])->name('validate.create');
    Route::post('/store', [ValidateController::class, 'store'])->name('validate.store');
    Route::get('/validate/edit/{idx}', [ValidateController::class, 'edit'])->name('validate.edit');
    Route::put('/update/{idx}', [ValidateController::class, 'updateEdit'])->name('validate.updateEdit');
    Route::get('/validate/autocomplete', [ValidateController::class, 'get_nameEmp'])->name('validate.get_nameEmp');
    Route::post('/validate/get_emp_detail', [ValidateController::class, 'get_emp_detail']);
    Route::delete('/validate/{id}', [ValidateController::class, 'destroy'])->name('validate.destroy');
});
