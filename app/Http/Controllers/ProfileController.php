<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // -------------------
    // แสดง profile ของผู้ใช้งานปัจจุบัน
    // -------------------
    public function show()
    {
        $user = Auth::user();
        return view('users.show', compact('user'));
    }

    // -------------------
    // แสดงฟอร์มแก้ไข profile
    // -------------------
    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    // -------------------
    // อัปเดต profile
    // -------------------
    public function update(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'first_name' => 'required|string|max:50',
        'last_name'  => 'required|string|max:50',
        'email'      => 'required|email|unique:users,email,' . $user->id,
        'password'   => 'nullable|min:6|confirmed',
        'phone'      => 'nullable|string|max:20',
        'avatar'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

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

    $user->first_name = $validated['first_name'];
    $user->last_name  = $validated['last_name'];
    $user->email      = $validated['email'];
    $user->phone      = $validated['phone'] ?? $user->phone;

    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    $user->save();

    return redirect()->route('profile')->with('success', 'อัปเดตโปรไฟล์เรียบร้อยแล้ว!');
}

}
