<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // สำหรับ hash password
use Illuminate\Support\Facades\Storage;

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
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // เพิ่ม validation รูป
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

        $user = new User();
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->password = Hash::make($validated['password']); // hash password
        $user->birthday = $validated['birthday'];
        $user->phone = $validated['phone'] ?? null;
        $user->gender = $validated['gender'];
        $user->role = 'member'; // บังคับเป็น member

        // ตรวจสอบและอัปโหลด avatar
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
}
