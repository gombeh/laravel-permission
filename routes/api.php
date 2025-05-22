<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index')
        ->middleware('checkPermission:users.index');;
    Route::get('/teams', [TeamController::class, 'index'])
        ->name('teams.index')
        ->middleware('checkPermission:teams.index');


    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index')
        ->middleware('checkPermission:products.index');

    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->name('products.show')
        ->middleware(['checkPermission:products.show', 'checkProductPermission']);
});

Route::post('login', [AuthenticateController::class, 'login'])->name('login');
