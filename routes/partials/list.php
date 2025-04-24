<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListAdminController;

Route::get('/validate', [ListAdminController::class, 'index'])->name('validate.index');
Route::get('/validate/createAdmin', [ListAdminController::class, 'createAdmin'])->name('validate.createAdmin');
