<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormFieldController;

Route::inertia('/', 'Home')->name('home');

// Form management API routes
Route::prefix('api')->group(function () {
    // Form routes
    Route::apiResource('forms', FormController::class);

    // Form field routes (nested under forms)
    Route::prefix('forms/{form}')->group(function () {
        Route::apiResource('fields', FormFieldController::class)
            ->except(['show']);
    });
});
