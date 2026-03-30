<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::post('tasks/create', [TaskController::class, 'store']);
    Route::get('tasks/get', [TaskController::class, 'index']);
    Route::delete('tasks/delete/{task}', [TaskController::class, 'destroy']);
    Route::get('users/me', [UserController::class, 'index']);
    Route::delete('users/delete/{user}', [UserController::class, 'destroy']);
    Route::patch('users/update', [UserController::class, 'update']);
});

Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

