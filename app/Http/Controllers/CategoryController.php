<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // ไม่ต้องมี __construct() เพราะเราย้าย middleware ไปตรวจสอบใน routes/web.php แล้ว

    // READ: แสดงรายการหมวดหมู่ทั้งหมด
    public function index()
    {
        // โค้ดที่นี่จะทำงานได้ถูกต้อง เพราะการตรวจสอบสิทธิ์ ADMIN อยู่ใน Route แล้ว
        $categories = Category::withCount('posts')->get();
        return view('categories.index', compact('categories'));
    }

    // CREATE: แสดงฟอร์มสร้างหมวดหมู่ (ใช้ฟอร์มใน index แล้ว)
    public function create() 
    {
        // โค้ดนี้ไม่ถูกเรียกใช้ เพราะเราใช้ฟอร์มในหน้า index
    }

    // CREATE: บันทึกหมวดหมู่ใหม่
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories',
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'สร้างหมวดหมู่ใหม่สำเร็จ');
    }

    // READ: แสดงหมวดหมู่เดียว (ไม่จำเป็นต้องใช้ใน Resource นี้ แต่มีไว้ตามมาตรฐาน)
    public function show(Category $category)
    {
        abort(404);
    }

    // UPDATE: แสดงฟอร์มแก้ไข
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // UPDATE: อัปเดตข้อมูลในฐานข้อมูล
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'แก้ไขหมวดหมู่สำเร็จ');
    }

    // DELETE: ลบหมวดหมู่
    public function destroy(Category $category)
    {
        // **ป้องกันการลบหมวดหมู่ที่มีกระทู้อยู่**
        if ($category->posts()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'ไม่สามารถลบได้: มีกระทู้ ' . $category->posts()->count() . ' รายการอยู่ในหมวดหมู่นี้');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'ลบหมวดหมู่สำเร็จ');
    }
}
