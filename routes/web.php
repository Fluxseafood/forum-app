<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\UserController; // ต้องมี
use App\Models\User; 

// -------------------
// Route หน้าหลัก
// -------------------
// หน้าหลักจะแสดงรายการ Posts และใช้ชื่อว่า 'home'
Route::get('/', [PostController::class, 'index'])->name('home');

// -------------------
// Routes สำหรับ Login / Register
// -------------------
// Route ที่ถูกต้อง
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.perform');

// -------------------
// กลุ่ม Route ที่ต้องล็อกอินเท่านั้น
// -------------------
Route::middleware(['auth'])->group(function () {
    // Posts
    Route::resource('posts', PostController::class)->except(['index']);

    // Comments
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    
    // Profile & Logout
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Categories (สำหรับ Admin จัดการหมวดหมู่)
    Route::resource('categories', CategoryController::class);

    // Users (สำหรับ Admin จัดการผู้ใช้)
    Route::resource('users', UserController::class);
});
