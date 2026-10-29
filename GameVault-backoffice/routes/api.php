<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MultiplayerModeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserFavoriteController;
use App\Http\Controllers\VideogameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/consoles', [ConsoleController::class, 'index']);
Route::get('/genres', [GenreController::class, 'index']);
Route::get('/multi-modes', [MultiplayerModeController::class, 'index']);
Route::get('/videogames', [VideogameController::class, 'index']);
Route::get('/videogames/{slug}', [VideogameController::class, 'show']);
Route::get('/devs', [DeveloperController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/user/wishlist', [UserFavoriteController::class, 'index']);
    Route::post('/user/wishlist', [UserFavoriteController::class, 'store']);
    Route::delete('/user/wishlist', [UserFavoriteController::class, 'destroy']);

    Route::post("/new-user-review", [ReviewController::class, 'store']);

    Route::resource('admin', AdminController::class);
});
