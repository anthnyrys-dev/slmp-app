<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::prefix('users')
        ->name('users.')
        ->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

    Route::prefix('posts')
        ->name('posts.')
        ->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('index');
            Route::get('/{post}', [PostController::class, 'show'])->name('show');
            Route::post('/', [PostController::class, 'store'])->name('store');
            Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
        });
});
