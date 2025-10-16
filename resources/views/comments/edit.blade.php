@extends('layouts.app')

@section('content')
<style>
    /* 🍊 Edit Comment Theme */
    body {
        background-color: #fff;
        color: #333;
        font-family: Arial, sans-serif;
    }

    .comment-card {
        border: 2px solid #de9151;
        border-radius: 12px;
        padding: 25px 20px;
        box-shadow: 0 4px 15px rgba(222, 145, 81, 0.3);
        margin-top: 30px;
    }

    .comment-card h3 {
        color: #de9151;
        font-weight: 700;
        margin-bottom: 20px;
        text-align: center;
    }

    .form-label {
        font-weight: 500;
        color: #333;
    }

    .form-control {
        border: 1px solid #de9151;
        border-radius: 6px;
        color: #333;
    }

    .form-control:focus {
        border-color: #de9151;
        box-shadow: 0 0 5px #de9151;
    }

    .btn-save {
        background-color: #de9151;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-save:hover {
        background-color: #f29359;
        color: #fff;
    }

    .btn-cancel {
        background-color: #aaa;
        color: #fff;
        border-radius: 6px;
    }

    img {
        border: 2px solid #de9151;
        border-radius: 6px;
    }
</style>

<div class="container" style="max-width: 600px;">
    <div class="comment-card">
        <h3>แก้ไขคอมเมนต์</h3>

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
                <a href="{{ route('posts.show', $comment->post_id) }}" class="btn btn-cancel">ย้อนกลับ</a>
                <button type="submit" class="btn btn-save">บันทึกการแก้ไข</button>
            </div>
        </form>
    </div>
</div>
@endsection
