<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {

    // สมัครสมาชิก
    Route::post('/register', [UserController::class, 'store']);

    // ต้องล็อกอินสำหรับ route ต่อไป
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [UserController::class, 'index']);          // admin
        Route::get('/{id}', [UserController::class, 'show']);       // profile
        Route::put('/{id}', [UserController::class, 'update']);    // update profile
        Route::delete('/{id}', [UserController::class, 'destroy']); // admin
    });
});
