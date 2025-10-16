<?php

namespace App\Http\Controllers;

use App\Models\Post;         // ต้องมี: เพื่อใช้ในการรับค่า Post ID
use App\Models\Comment;       // ต้องมี: เพื่อใช้ในการสร้างและลบคอมเมนต์
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // ต้องมี: เพื่อใช้ในการลบรูปภาพ

class CommentController extends Controller
{
    // ----------------------------------------------------
    // CREATE (สร้าง/บันทึกคอมเมนต์ใหม่)
    // ----------------------------------------------------
    public function store(Request $request, Post $post) 
    {
        $validated = $request->validate([
            'body' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('comments', 'public'); 
        }

        Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(), 
            'body' => $validated['body'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'คอมเมนต์ถูกส่งเรียบร้อยแล้ว');
    }

    public function edit(Comment $comment)
{
    // ตรวจสอบสิทธิ์: เจ้าของคอมเมนต์หรือ admin
    if (auth()->id() !== $comment->user_id && auth()->user()->role !== 'admin') {
        abort(403, 'คุณไม่มีสิทธิ์แก้ไขคอมเมนต์นี้');
    }

    return view('comments.edit', compact('comment'));
}

public function update(Request $request, Comment $comment)
{
    // ตรวจสอบสิทธิ์อีกครั้ง: เจ้าของคอมเมนต์หรือ admin
    if (auth()->id() !== $comment->user_id && auth()->user()->role !== 'admin') {
        abort(403, 'คุณไม่มีสิทธิ์แก้ไขคอมเมนต์นี้');
    }

    $validated = $request->validate([
        'body' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // อัปโหลดรูปใหม่ถ้ามี
    if ($request->hasFile('image')) {
        // ลบรูปเก่า
        if ($comment->image_path) {
            Storage::disk('public')->delete($comment->image_path);
        }
        // บันทึกรูปใหม่
        $comment->image_path = $request->file('image')->store('comments', 'public');
    }

    // อัปเดตข้อความ
    $comment->body = $validated['body'];
    $comment->save();

    return redirect()->route('posts.show', $comment->post_id)
                     ->with('success', 'คอมเมนต์ถูกแก้ไขเรียบร้อยแล้ว');
}

public function destroy(Comment $comment)
{
    // ตรวจสอบสิทธิ์: เจ้าของคอมเมนต์หรือ admin
    if (auth()->id() !== $comment->user_id && auth()->user()->role !== 'admin') {
        abort(403, 'คุณไม่มีสิทธิ์ลบคอมเมนต์นี้');
    }

    $postId = $comment->post_id;

    // ลบรูปภาพถ้ามี
    if ($comment->image_path) {
        Storage::disk('public')->delete($comment->image_path);
    }

    // ลบคอมเมนต์
    $comment->delete();

    return redirect()->route('posts.show', $postId)
                     ->with('success', 'คอมเมนต์ถูกลบเรียบร้อยแล้ว');
}


}