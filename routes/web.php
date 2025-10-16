<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ------------------------------------------------------
// 🏠 หน้าหลัก (แสดงโพสต์ทั้งหมด)
// ------------------------------------------------------
Route::get('/', [PostController::class, 'index'])->name('home');

// ------------------------------------------------------
// 🔐 Login / Register
// ------------------------------------------------------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.perform');

// ------------------------------------------------------
// 👤 ต้องล็อกอินเท่านั้น
// ------------------------------------------------------
Route::middleware(['auth'])->group(function () {

    // 📝 Posts (กระทู้)
    Route::resource('posts', PostController::class)->except(['index']); 

    // 💬 Comments (ความคิดเห็น)
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // 🙍‍♂️ Profile
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Categories (สำหรับ Admin จัดการหมวดหมู่)
    Route::resource('categories', CategoryController::class);

    // Users (สำหรับ Admin จัดการผู้ใช้)
    Route::resource('users', UserController::class);

    // 🚪 Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ------------------------------------------------------
// 🛠️ เฉพาะ ADMIN เท่านั้น
// ------------------------------------------------------
// Route::middleware(['auth', 'admin'])->group(function () {
//     // 📂 Categories (เพิ่ม / ลบ / แก้ไข ได้)
//     Route::resource('categories', CategoryController::class);

//     // 👥 Users (จัดการผู้ใช้)
//     Route::resource('users', UserController::class);
// });
