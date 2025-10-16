@extends('layouts.app')

@section('content')
<style>
    /* 🍊 Edit Post Theme */
    body {
        background-color: #f0f2f5;
        color: #333;
        font-family: Arial, sans-serif;
    }

    .card-edit {
        border: 2px solid #de9151;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(222, 145, 81, 0.3);
        margin-top: 30px;
    }

    .card-edit h1 {
        color: #de9151;
        font-weight: 700;
        margin-bottom: 25px;
    }

    .form-label {
        font-weight: 500;
        color: #333;
    }

    .form-control, .form-select {
        border: 1px solid #de9151;
        border-radius: 6px;
        color: #333;
    }

    .form-control:focus, .form-select:focus {
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

    img.img-thumbnail {
        border: 2px solid #de9151;
        border-radius: 6px;
    }

    .invalid-feedback {
        font-weight: 500;
    }
</style>

<div class="container">
    <div class="card-edit">
        <h1>แก้ไขกระทู้: {{ $post->title }}</h1>

        <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">หัวข้อกระทู้</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                       id="title" name="title" value="{{ old('title', $post->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">หมวดหมู่</label>
                <select class="form-select @error('category_id') is-invalid @enderror" 
                        id="category_id" name="category_id" required>
                    <option value="">เลือกหมวดหมู่</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="body" class="form-label">รายละเอียดคำถาม</label>
                <textarea class="form-control @error('body') is-invalid @enderror" 
                          id="body" name="body" rows="8" required>{{ old('body', $post->body) }}</textarea>
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">รูปภาพประกอบ (อัปโหลดเพื่อแทนที่รูปเดิม)</label>
                @if ($post->image_path)
                    <div class="mb-2">
                        **รูปภาพปัจจุบัน:** <img src="{{ Storage::url($post->image_path) }}" style="max-height: 100px;" class="img-thumbnail" alt="Current Image">
                    </div>
                @endif
                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                       id="image" name="image" accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-save">บันทึกการแก้ไข</button>
            <a href="{{ route('posts.show', $post) }}" class="btn btn-cancel">ยกเลิก</a>
        </form>
    </div>
</div>
@endsection
