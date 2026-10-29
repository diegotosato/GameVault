<?php

use App\Http\Controllers\Admin\Web\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\Web\ConsoleController as AdminConsoleController;
use App\Http\Controllers\Admin\Web\DeveloperController as AdminDeveloperController;
use App\Http\Controllers\Admin\Web\GenreController as AdminGenreController;
use App\Http\Controllers\Admin\Web\MultiplayerModeController as AdminMultiplayerModeController;
use App\Http\Controllers\Admin\Web\VideogameController as AdminVideogameController;
use Illuminate\Support\Facades\Route;

// --- Admin auth (non protette da middleware) ---
Route::get('/admin', [AdminAuthController::class, 'showLogin']);
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// --- Pannello admin protetto ---
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::resource('videogames', AdminVideogameController::class);
    Route::resource('consoles', AdminConsoleController::class);
    Route::resource('genres', AdminGenreController::class);
    Route::resource('developers', AdminDeveloperController::class);
    Route::resource('multiplayer_modes', AdminMultiplayerModeController::class);
});


Route::get("/esercizio", function () {
    return view('esercizio');
});
