@extends('layouts.app')

@section('content')
<style>
    /* 🍊 Theme for Post & Comments */
    body {
        background-color: #f0f2f5;
        color: #333;
        font-family: Arial, sans-serif;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(222, 145, 81, 0.2);
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #de9151 !important;
        color: #fff !important;
        font-weight: 600;
        font-size: 1.25rem;
    }

    .card-body {
        font-size: 1rem;
    }

    .badge-category {
        background-color: #de9151;
        color: #fff;
        font-weight: 500;
    }

    .btn-warning-custom {
        background-color: #de9151;
        color: #fff;
        border: none;
        transition: 0.3s;
    }

    .btn-warning-custom:hover {
        background-color: #f29359;
        color: #fff;
    }

    .btn-primary-custom {
        background-color: #de9151;
        color: #fff;
        border: none;
        transition: 0.3s;
    }

    .btn-primary-custom:hover {
        background-color: #f29359;
        color: #fff;
    }

    textarea.form-control, input.form-control {
        border: 1px solid #de9151;
    }

    textarea.form-control:focus, input.form-control:focus {
        border-color: #de9151;
        box-shadow: 0 0 5px #de9151;
    }

    .text-muted {
        color: #666 !important;
    }

    img.rounded {
        border-radius: 12px;
        max-width: 100%;
    }

    .comment-card {
        border: 1px solid #de9151;
    }

    .comment-header {
        font-weight: 600;
        color: #de9151;
    }

    a {
        color: #de9151;
        font-weight: 500;
    }

    a:hover {
        color: #f29359;
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .d-flex.gap-2 {
            flex-direction: column;
        }
    }
</style>

<div class="container">
    {{-- โพสต์หลัก --}}
    <div class="card mb-4">
        <div class="card-header">
            {{ $post->title }}
        </div>
        <div class="card-body">
            <p class="text-muted mb-2">
                โพสต์โดย <strong>{{ $post->user->name }}</strong> 
                ในหมวดหมู่ <span class="badge badge-category">{{ $post->category->name ?? 'N/A' }}</span>
                เมื่อ {{ $post->created_at->format('d M Y, H:i') }}
            </p>

            @if ($post->image_path)
                <div class="mb-3 text-center">
                    <img src="{{ Storage::url($post->image_path) }}" class="img-fluid rounded" alt="รูปภาพกระทู้" style="max-height: 400px;">
                </div>
            @endif

            <div class="card-text fs-5">
                {!! nl2br(e($post->body)) !!}
            </div>

            @if (auth()->check() && (auth()->user()->id === $post->user_id || auth()->user()->role === 'admin'))
                <div class="mt-3 d-flex gap-2">
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning-custom btn-sm">แก้ไข</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบโพสต์นี้?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary-custom btn-sm">ลบ</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    {{-- ความคิดเห็น --}}
    <h3 class="mt-5 mb-3" style="color:#de9151;">{{ $post->comments->count() }} ความคิดเห็น</h3>

    @forelse ($post->comments as $comment)
        <div class="card comment-card mb-3">
            <div class="card-body">
                <p class="card-text">{!! nl2br(e($comment->body)) !!}</p>

                @if ($comment->image_path)
                    <div class="mb-2 text-center">
                        <img src="{{ Storage::url($comment->image_path) }}" class="img-fluid rounded" alt="รูปภาพคอมเมนต์" style="max-height: 200px;">
                    </div>
                @endif

                <small class="text-muted">
                    โดย <strong class="comment-header">{{ $comment->user->name }}</strong>
                    เมื่อ {{ $comment->created_at->diffForHumans() }}
                </small>

                @if (auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->role === 'admin'))
                    <div class="mt-2 d-flex gap-2">
                        <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-warning-custom btn-sm">แก้ไข</a>
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('ลบความคิดเห็นนี้หรือไม่?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary-custom btn-sm">ลบ</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <p class="text-info">ยังไม่มีใครตอบกระทู้นี้เลย</p>
    @endforelse

    {{-- ฟอร์มเพิ่มคอมเมนต์ --}}
    @auth
        <div class="card mt-5">
            <div class="card-header">เพิ่มความคิดเห็นของคุณ</div>
            <div class="card-body">
                <form method="POST" action="{{ route('comments.store', $post) }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <textarea class="form-control @error('body') is-invalid @enderror" 
                                  name="body" rows="4" placeholder="พิมพ์คำตอบของคุณที่นี่..." required>{{ old('body') }}</textarea>
                        @error('body')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="comment_image" class="form-label">รูปภาพประกอบ (ถ้ามี)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="comment_image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary-custom">ส่งคำตอบ</button>
                </form>
            </div>
        </div>
    @else
        <p class="text-center mt-4">
            <a href="{{ route('login') }}">เข้าสู่ระบบ</a> เพื่อตอบกระทู้นี้
        </p>
    @endauth
</div>
@endsection
