@extends('layouts.app')

@section('content')
<style>
    /* ===== สไตล์เฉพาะหน้านี้ ===== */
    
    .create-post-container {
        background: #f0f2f5;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 4px 15px rgba(222, 145, 81, 0.15);
        transition: 0.3s;
    }

    .create-post-container:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(222, 145, 81, 0.25);
    }

    h2 {
        color: #DE9151;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    h2 i {
        color: #DE9151;
        font-size: 1.5rem;
    }

    label {
        font-weight: 600;
        color: #444;
    }

    .form-control,
    .form-select {
        border: 2px solid #ffe1c4;
        border-radius: 10px;
        transition: 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #DE9151;
        box-shadow: 0 0 5px rgba(222, 145, 81, 0.5);
    }

    /* ปุ่มหลัก */
    .btn-primary {
        background-color: #DE9151;
        border: none;
        font-weight: 600;
        border-radius: 10px;
        transition: 0.3s;
        padding: 10px 20px;
    }

    .btn-primary:hover {
        background-color: #c76f28;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(222, 145, 81, 0.3);
    }

    /* ปุ่มยกเลิก */
    .btn-secondary {
        background-color: #fff;
        color: #DE9151;
        border: 2px solid #DE9151;
        font-weight: 600;
        border-radius: 10px;
        transition: 0.3s;
        padding: 10px 20px;
    }

    .btn-secondary:hover {
        background-color: #DE9151;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(222, 145, 81, 0.3);
    }

    .form-label i {
        color: #DE9151;
        margin-right: 6px;
    }

    .invalid-feedback {
        color: #d9534f;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="create-post-container mt-4">
            <h2><i class="bi bi-pencil-square"></i> สร้างกระทู้ใหม่</h2>
            <hr class="mb-4" style="border-top: 3px solid #DE9151; opacity: 0.6;">

            <!-- ฟอร์มสร้างกระทู้ -->
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label"><i class="bi bi-chat-left-text-fill"></i> ชื่อกระทู้:</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                        value="{{ old('title') }}" placeholder="พิมพ์ชื่อกระทู้ของคุณ..." required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label for="category_id" class="form-label"><i class="bi bi-folder2-open"></i> หมวดหมู่:</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                        name="category_id" required>
                        <option value="">-- เลือกหมวดหมู่ --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Body -->
                <div class="mb-3">
                    <label for="body" class="form-label"><i class="bi bi-file-text"></i> เนื้อหา:</label>
                    <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="8"
                        placeholder="เขียนสิ่งที่คุณอยากแชร์..." required>{{ old('body') }}</textarea>
                    @error('body')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-4">
                    <label for="image" class="form-label"><i class="bi bi-image"></i> รูปภาพ (ถ้ามี):</label>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-send-fill me-1"></i> สร้างกระทู้</button>
                    <a href="{{ route('home') }}" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i> ยกเลิก</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
