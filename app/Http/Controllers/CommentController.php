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

    // ----------------------------------------------------
    // DELETE (ลบคอมเมนต์)
    // ----------------------------------------------------
    public function destroy(Comment $comment)
    {
        // **ตรวจสอบความเป็นเจ้าของพื้นฐาน**
        if (auth()->id() !== $comment->user_id) {
             abort(403, 'คุณไม่มีสิทธิ์ลบคอมเมนต์นี้');
        }

        $postId = $comment->post_id; 

        // ต้องเรียกใช้ Storage:: เพื่อใช้ delete()
        if ($comment->image_path) {
            Storage::disk('public')->delete($comment->image_path);
        }

        $comment->delete();

        return redirect()->route('posts.show', $postId)->with('success', 'คอมเมนต์ถูกลบเรียบร้อยแล้ว');
    }
}