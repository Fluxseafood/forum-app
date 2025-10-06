<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::all(); // ดึงผู้ใช้งานทั้งหมด
        return view('welcome', compact('users'));
    }
}
