<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // nanti kalo mau nambahin routes buat user,
    // tambahin di dalam only() itu, sesuaiin sama nama function di UserController
    // orang terakhir yang baca tolong hapus comment ini, yang udah baca:
    // 1. Tristan
    Route::apiResource('users', UserController::class)->only(['destroy']);
    Route::apiResource('tasks', UserController::class)->only(['store, destroy, index']);
    Route::patch('/update-user/{id}', [UserController::class, 'update']);
});
Route::post('/post-user', [UserController::class, 'create']);
