<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// หน้า Welcome
Route::get('/', [AuthController::class, 'welcome'])->name('welcome');

// -------------------
// Routes สำหรับ Login / Register
// -------------------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.perform');

// -------------------
// Profile & Logout
// -------------------
Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile')->middleware('auth');
Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


