<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // แสดงฟอร์มล็อกอิน
    public function showLoginForm()
    {
        return view('login.form');
    }

    // ดำเนินการล็อกอิน
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required','string'],
            'password' => ['required','string'],
        ]);

        $remember = $request->has('remember');

        // ทดลองล็อกอินด้วย username + password
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $remember)) {
            // ป้องกัน session fixation
            $request->session()->regenerate();

            // เปลี่ยนไปหน้า intended หรือหน้า default
            return redirect()->intended('/home');
        }

        // ล้มเหลว -> คืนค่า error
        return back()->withErrors([
            'username' => 'ข้อมูลล็อกอินไม่ถูกต้อง',
        ])->onlyInput('username');
    }

    // ออกจากระบบ
    public function logout(Request $request)
    {
        Auth::logout();

        // ทำลาย session แล้ว regen token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
