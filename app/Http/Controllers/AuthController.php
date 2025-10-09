<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // เพิ่ม Storage สำหรับจัดการไฟล์

class AuthController extends Controller
{
    // -------------------
    // Register
    // -------------------
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|max:50|unique:users',
            'email' => 'required|email|unique:users',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'password' => 'required|min:8|confirmed',
            'birthday' => 'required|date',
            'phone' => 'nullable|max:20',
            'gender' => 'required|in:male,female,unspecified,other',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // **จุดสำคัญ:** ตรวจสอบว่าเป็น User คนแรกหรือไม่
        $isFirstUser = User::count() === 0;

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'password' => Hash::make($validated['password']), // hash ครั้งเดียว
            'birthday' => $validated['birthday'],
            'phone' => $validated['phone'] ?? null,
            'gender' => $validated['gender'],
            // กำหนด role: ถ้าเป็นคนแรก -> admin, ถ้าไม่ใช่ -> member
            'role' => $isFirstUser ? 'admin' : 'member', 
        ]);

        // อัปโหลด avatar ถ้ามี
        if ($request->hasFile('avatar')) {
            // ใช้ฟังก์ชัน uploadAvatar และ Storage::disk('public')->url() เพื่อเก็บ path
            $user->avatar = $this->uploadAvatar($request->file('avatar'));
            $user->save();
        }

        // แก้ไข Route เป็น 'login' ที่ถูกต้อง
        return redirect()->route('login')->with('success', 'สมัครสมาชิกสำเร็จ กรุณาล็อคอินด้วยครับ/ค่ะ.');
    }

    // -------------------
    // Login
    // -------------------
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            // Redirect ไปที่หน้า home (PostController@index)
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    // -------------------
    // Logout
    // -------------------
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // แก้ไข Route เป็น 'login' ที่ถูกต้อง
        return redirect()->route('login');
    }

    // -------------------
    // Profile
    // -------------------
    public function showProfile()
    {
        $user = auth()->user();
        return view('users.profile', compact('user'));

    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|max:20',
            'birthday' => 'required|date',
            'gender' => 'required|in:male,female,unspecified,other',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // อัปเดตข้อมูลผู้ใช้
        $user->fill($validated);


        // อัปโหลด avatar ถ้ามี
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // ใช้ Storage แทน public_path เพื่อให้ใช้งานร่วมกับ S3 หรือ Local ได้ดีขึ้น
            $path = $file->storeAs('avatars', $filename, 'public'); 

            // ลบไฟล์เก่า (ถ้ามี)
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = 'avatars/' . $filename;
        }

        $user->save();

        // แก้ไข Route เป็น 'profile' ที่ถูกต้อง
        return redirect()->route('profile')->with('success', 'อัปเดตโปรไฟล์สำเร็จ');
    }

    // -------------------
    // Private method for avatar upload
    // -------------------
    private function uploadAvatar($file, $oldFile = null)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        // ใช้ 'avatars' เป็นโฟลเดอร์ใน public disk
        $path = $file->storeAs('avatars', $filename, 'public');

        // ลบไฟล์เก่า (ถ้ามี)
        if ($oldFile) {
             Storage::disk('public')->delete('avatars/' . $oldFile);
        }

        // คืนค่า path สำหรับเก็บในฐานข้อมูล
        return 'avatars/' . $filename;
    }
}
