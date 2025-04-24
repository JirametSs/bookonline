<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('circulars.index');
});

// Include all route files
require __DIR__ . '/partials/auth.php';
require __DIR__ . '/partials/circulars.php';
require __DIR__ . '/partials/record.php';
require __DIR__ . '/partials/validate.php';
require __DIR__ . '/partials/book.php';
require __DIR__ . '/partials/visitor.php';
require __DIR__ . '/partials/user.php';
require __DIR__ . '/partials/data.php';
require __DIR__ . '/partials/list.php';
