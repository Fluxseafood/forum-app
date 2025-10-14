<?php

namespace App\Http\Controllers; 

use App\Models\Post;            
use App\Models\Category;        
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use App\Http\Controllers\Controller; 

class PostController extends Controller
{
    // READ: แสดงรายการกระทู้ทั้งหมด
    public function index() 
    { 
        $posts = Post::with(['user', 'category', 'comments'])
                    ->latest() 
                    ->paginate(15);
        
        return view('posts.index', compact('posts'));
    }

    // CREATE: แสดงฟอร์มสร้างกระทู้
    public function create() 
    { 
        $categories = Category::all();
        return view('posts.create', compact('categories')); 
    }

    // CREATE: บันทึกกระทู้ใหม่
    public function store(Request $request) 
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'body' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'body' => $validated['body'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'กระทู้ใหม่ถูกสร้างเรียบร้อยแล้ว');
    }
    
    // READ: แสดงกระทู้เดียว
    public function show(Post $post) 
    { 
        $post->load(['user', 'category', 'comments.user']); 
        return view('posts.show', compact('post'));
    }

    // UPDATE: แสดงฟอร์มแก้ไข
    public function edit(Post $post)
    {
        $user = auth()->user();

        // ✅ admin แก้ได้ทุกโพสต์ / user แก้ได้เฉพาะของตัวเอง
        if ($user->id !== $post->user_id && $user->role !== 'admin') {
            abort(403, 'คุณไม่มีสิทธิ์แก้ไขกระทู้นี้');
        }

        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    // UPDATE: อัปเดตข้อมูลในฐานข้อมูล
    public function update(Request $request, Post $post)
    {
        $user = auth()->user();

        if ($user->id !== $post->user_id && $user->role !== 'admin') {
            abort(403, 'คุณไม่มีสิทธิ์แก้ไขกระทู้นี้');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'body' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $imagePath = $post->image_path;
        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post->update(array_merge($validated, ['image_path' => $imagePath]));

        return redirect()->route('posts.show', $post)->with('success', 'กระทู้ถูกแก้ไขเรียบร้อยแล้ว');
    }

    // DELETE: ลบกระทู้
    public function destroy(Post $post)
    {
        $user = auth()->user();

        if ($user->id !== $post->user_id && $user->role !== 'admin') {
            abort(403, 'คุณไม่มีสิทธิ์ลบกระทู้นี้');
        }

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'กระทู้ถูกลบเรียบร้อยแล้ว');
    }
}
