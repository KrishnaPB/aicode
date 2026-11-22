<?php

use App\Modules\Apps\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/apps/create', [AppController::class, 'create'])->name('apps.create');
    Route::post('/apps', [AppController::class, 'store'])->name('apps.store');
});
