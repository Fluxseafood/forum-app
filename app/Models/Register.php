<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // แสดงหน้า Register พร้อม dropdown หรือ pre-fill
    public function showRegister()
    {
        $existingUsers = User::all(); // ดึงข้อมูล user ทั้งหมด
        return view('auth.register', compact('existingUsers'));
    }

    // สมัครสมาชิก
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
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // เพิ่มการ validate รูป
        ]);

        // ถ้ามี existing user id ให้ดึงข้อมูล
        if ($request->filled('existing_user_id')) {
            $existingUser = User::find($request->existing_user_id);
            if ($existingUser) {
                $validated['username'] = $existingUser->username;
                $validated['email'] = $existingUser->email;
                $validated['first_name'] = $existingUser->first_name;
                $validated['last_name'] = $existingUser->last_name;
                $validated['birthday'] = $existingUser->birthday;
                $validated['phone'] = $existingUser->phone;
                $validated['gender'] = $existingUser->gender;
            }
        }

        // ถ้ามีรูป avatar ให้บันทึก
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/avatars', $filename);
            $validated['avatar'] = 'storage/avatars/' . $filename;
        }

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'password' => $validated['password'], // Hash อยู่ใน Model
            'birthday' => $validated['birthday'],
            'phone' => $validated['phone'] ?? null,
            'gender' => $validated['gender'],
            'role' => 'member', 
            'avatar' => $validated['avatar'] ?? null, // กรณีมีรูป
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'สมัครสมาชิกสำเร็จและเข้าสู่ระบบแล้ว');
    }
}
