<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\FormFieldController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');

// Admin Form Management Routes
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Web Interface Routes
    Route::prefix('admin/forms')->group(function () {
        Route::get('/', [FormController::class, 'index'])->name('forms.index');
        Route::get('/create', [FormController::class, 'create'])->name('forms.create');
        Route::post('/', [FormController::class, 'store'])->name('forms.store');
        Route::get('/{form}', [FormController::class, 'show'])->name('forms.show');
        Route::get('/{form}/view', [FormController::class, 'view'])->name('forms.view');
        Route::get('/{form}/edit', [FormController::class, 'edit'])->name('forms.edit');
        Route::put('/{form}', [FormController::class, 'update'])->name('forms.update');
        Route::delete('/{form}', [FormController::class, 'destroy'])->name('forms.destroy');
    });

    // API Routes
    Route::prefix('api')->group(function () {
        // API routes here
        Route::get('/forms/config', [FormController::class, 'getFormConfig'])->name('api.forms.config');
    });

    Route::get('/dashboard', function () {
        return redirect()->route('forms.index');
    })->name('dashboard');

    Route::prefix('forms/{form}')->group(function () {
        Route::apiResource('fields', FormFieldController::class)
            ->except(['show']);
    });
});
