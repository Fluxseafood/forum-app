<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    // -------------------
    // แสดง profile ของผู้ใช้งานปัจจุบัน
    // -------------------
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    // -------------------
    // แสดงฟอร์มแก้ไข profile
    // -------------------
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // -------------------
    // อัปเดต profile
    // -------------------
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
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
}
