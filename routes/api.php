<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::prefix('users')->group(function () {

    Route::get('/', [UserController::class, 'get']);

    Route::post('/create', [UserController::class, 'create']);

    Route::post('/login', [UserController::class, 'login']);

    Route::put(
        '/update_username',
        [UserController::class, 'update_username']
    );

    Route::put(
        '/update_email',
        [UserController::class, 'update_email']
    );

    Route::put(
        '/update_password',
        [UserController::class, 'update_password']
    );

    Route::delete(
        '/delete',
        [UserController::class, 'delete']
    );
});