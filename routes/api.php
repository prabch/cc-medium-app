<?php

use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'posts', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [PostController::class, 'index']);
    Route::post('publish', [PostController::class, 'publish']);
});

Route::group(['prefix' => 'profile', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('update', [UserController::class, 'update']);
});
