<?php

use App\Http\Controllers\API\PublicationController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\MediumController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'publications', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [PublicationController::class, 'index']);
});

Route::group(['prefix' => 'posts', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [PostController::class, 'index']);
    Route::get('read/{id}', [PostController::class, 'read']);
    Route::post('save', [PostController::class, 'save']);
    Route::post('publish/{id}', [PostController::class, 'publish']);
});

Route::group(['prefix' => 'medium', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [MediumController::class, 'index']);
    Route::post('update', [MediumController::class, 'update']);
});
