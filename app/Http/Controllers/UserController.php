<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function __construct()
    {
        // ต้องมีบรรทัดนี้เท่านั้น (อยู่ใน class)
        $this->middleware('auth');
    }
    /**
     * แสดงรายการผู้ใช้งาน (เฉพาะ admin)
     */
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * แสดงโปรไฟล์ผู้ใช้
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

    // อนุญาตเฉพาะ Admin หรือเจ้าของโปรไฟล์เท่านั้น
    if (auth()->user()->role !== 'admin' && auth()->id() !== $user->id) {
        return redirect()->route('home')->with('error', 'Unauthorized');
    }

    return view('users.show', compact('user')); 
    }

    public function edit($id)
{
    $user = User::findOrFail($id);

    // อนุญาตเฉพาะ Admin หรือเจ้าของโปรไฟล์เท่านั้น
    if (auth()->user()->role !== 'admin' && auth()->id() !== $user->id) {
        return redirect()->route('home')->with('error', 'Unauthorized');
    }

    return view('users.edit', compact('user'));
}


    /**
     * ลงทะเบียนผู้ใช้งานใหม่
     */
    public function store(Request $request)
{
    // อนุญาตเฉพาะ admin เท่านั้น
    if (auth()->user()->role !== 'admin') {
        return redirect()->back()->with('error', 'Unauthorized');
    }

    $validated = $request->validate([
        'username'   => 'required|unique:users|max:50',
        'email'      => 'required|email|unique:users',
        'first_name' => 'required|max:50',
        'last_name'  => 'required|max:50',
        'password'   => 'required|min:8|confirmed',
        'birthday'   => 'required|date',
        'phone'      => 'nullable|string|max:20',
        'gender'     => 'required|in:male,female,unspecified,other',
    ]);

    User::create([
        'username'   => $validated['username'],
        'email'      => $validated['email'],
        'first_name' => $validated['first_name'],
        'last_name'  => $validated['last_name'],
        'password'   => Hash::make($validated['password']),
        'birthday'   => $validated['birthday'],
        'phone'      => $validated['phone'] ?? null,
        'gender'     => $validated['gender'],
        'role'       => 'member',
    ]);

    return redirect()->route('users.index')->with('success', 'ผู้ใช้ถูกสร้างเรียบร้อยแล้ว');
}


    /**
     * แก้ไขโปรไฟล์ผู้ใช้
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->id !== $user->id && auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'username'   => ['required', 'max:50', Rule::unique('users')->ignore($user->id)],
            'email'      => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'first_name' => 'required|max:50',
            'last_name'  => 'required|max:50',
            'password'   => 'nullable|min:8|confirmed',
            'birthday'   => 'required|date',
            'phone'      => 'nullable|string|max:20',
            'gender'     => 'required|in:male,female,unspecified,other',
        ]);

        $user->update([
            'username'   => $validated['username'],
            'email'      => $validated['email'],
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'password'   => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            'birthday'   => $validated['birthday'],
            'phone'      => $validated['phone'] ?? $user->phone,
            'gender'     => $validated['gender'],
        ]);

        return redirect()->route('users.show', $user->id)->with('success', 'โปรไฟล์ถูกอัปเดตเรียบร้อยแล้ว');
    }

    /**
     * ลบผู้ใช้ (เฉพาะ admin)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'ผู้ใช้ถูกลบเรียบร้อยแล้ว');
    }
    
}


