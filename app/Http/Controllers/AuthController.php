<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // -------------------
    // หน้า Welcome
    // -------------------
    public function welcome()
    {
        $users = User::all();
        return view('welcome', compact('users'));
    }

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

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'password' => Hash::make($validated['password']), // hash ครั้งเดียว
            'birthday' => $validated['birthday'],
            'phone' => $validated['phone'] ?? null,
            'gender' => $validated['gender'],
            'role' => 'member',
        ]);

        // อัปโหลด avatar ถ้ามี
        if ($request->hasFile('avatar')) {
            $user->avatar = $this->uploadAvatar($request->file('avatar'));
            $user->save();
        }

        return redirect()->route('login.form')->with('success', 'สมัครสมาชิกสำเร็จ กรุณาล็อคอินด้วยครับ/ค่ะ.');
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

        // ใช้ $credentials ตรง ๆ
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/profile');
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
        return redirect()->route('login.form');
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

        // อัปโหลด avatar ถ้ามี
        if ($request->hasFile('avatar')) {
        $file = $request->file('avatar');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $destinationPath = public_path('storage/avatars');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $filename);

        $user->avatar = 'avatars/' . $filename;
    }

    $user->save();

    Auth::login($user);

    return redirect('/')->with('success', 'สมัครสมาชิกสำเร็จและเข้าสู่ระบบแล้ว');

    }

    // -------------------
    // Private method for avatar upload
    // -------------------
    private function uploadAvatar($file, $oldFile = null)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/avatars', $filename);

        // ลบไฟล์เก่า
        if ($oldFile) {
            \Storage::delete('public/avatars/' . $oldFile);
        }

        return $filename;
    }
}
