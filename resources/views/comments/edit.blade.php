@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <h3 class="mb-3">แก้ไขคอมเมนต์</h3>

    <form action="{{ route('comments.update', $comment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="body" class="form-label">ข้อความ</label>
            <textarea name="body" id="body" class="form-control" rows="4" required>{{ old('body', $comment->body) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">อัปโหลดรูป (ถ้ามี)</label>
            <input type="file" name="image" class="form-control">

            @if ($comment->image_path)
                <div class="mt-2">
                    <p>รูปเดิม:</p>
                    <img src="{{ asset('storage/' . $comment->image_path) }}" alt="comment image" width="150">
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('posts.show', $comment->post_id) }}" class="btn btn-secondary">ย้อนกลับ</a>
            <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
        </div>
    </form>
</div>
@endsection
