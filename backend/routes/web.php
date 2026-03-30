<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/post-user', [UserController::class, 'create']);

Route::get('/login', function () {
    // vue pae
});

