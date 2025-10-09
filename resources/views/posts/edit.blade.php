@extends('layouts.app')

@section('content')
<div class="container">
    <h1>แก้ไขกระทู้: {{ $post->title }}</h1>

    {{-- 1. กำหนด Action ไปที่ route('posts.update') และใช้เมธอด PUT --}}
    <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- สำคัญ: สำหรับการอัปเดตข้อมูลใน Laravel --}}

        {{-- หัวข้อ --}}
        <div class="mb-3">
            <label for="title" class="form-label">หัวข้อกระทู้</label>
            {{-- ใช้ $post->title หรือ old('title', $post->title) เพื่อแสดงค่าเดิม --}}
            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                   id="title" name="title" value="{{ old('title', $post->title) }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- หมวดหมู่ --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">หมวดหมู่</label>
            <select class="form-select @error('category_id') is-invalid @enderror" 
                    id="category_id" name="category_id" required>
                <option value="">เลือกหมวดหมู่</option>
                {{-- วนลูปแสดงหมวดหมู่ และกำหนด 'selected' ถ้าตรงกับค่าเดิม --}}
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

        {{-- รายละเอียดคำถาม --}}
        <div class="mb-3">
            <label for="body" class="form-label">รายละเอียดคำถาม</label>
            <textarea class="form-control @error('body') is-invalid @enderror" 
                      id="body" name="body" rows="8" required>{{ old('body', $post->body) }}</textarea>
            @error('body')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        {{-- รูปภาพปัจจุบันและฟิลด์อัปโหลดใหม่ --}}
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

        <button type="submit" class="btn btn-success">บันทึกการแก้ไข</button>
        <a href="{{ route('posts.show', $post) }}" class="btn btn-secondary">ยกเลิก</a>
    </form>
</div>
@endsection