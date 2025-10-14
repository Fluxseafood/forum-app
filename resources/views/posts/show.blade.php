@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h1 class="mb-0">{{ $post->title }}</h1>
        </div>
        <div class="card-body">
            {{-- ข้อมูลผู้โพสต์และวันเวลา --}}
            <p class="text-muted">
                โพสต์โดย <strong>{{ $post->user->name }}</strong> 
                ในหมวดหมู่ <span class="badge bg-info">{{ $post->category->name ?? 'N/A' }}</span>
                เมื่อ {{ $post->created_at->format('d M Y, H:i') }}
            </p>

            {{-- รูปภาพกระทู้ --}}
            @if ($post->image_path)
                <div class="mb-3 text-center">
                    <img src="{{ Storage::url($post->image_path) }}" class="img-fluid rounded" alt="รูปภาพกระทู้" style="max-height: 400px;">
                </div>
            @endif

            {{-- เนื้อหากระทู้ --}}
            <div class="card-text fs-5">
                {!! nl2br(e($post->body)) !!}
            </div>

            {{-- ✅ ปุ่มแก้ไข/ลบ สำหรับเจ้าของโพสต์หรือ admin --}}
            @if (auth()->check() && (auth()->user()->id === $post->user_id || auth()->user()->role === 'admin'))
                <div class="mt-3 d-flex gap-2">
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบโพสต์นี้?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">ลบ</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
    
    {{-- ส่วนแสดงคอมเมนต์ --}}
    <h3 class="mt-5 mb-3">{{ $post->comments->count() }} ความคิดเห็น</h3>
    
    @forelse ($post->comments as $comment)
    <div class="card mb-3">
        <div class="card-body">
            <p class="card-text">{!! nl2br(e($comment->body)) !!}</p>

            @if ($comment->image_path)
                <div class="mb-2">
                    <img src="{{ Storage::url($comment->image_path) }}" class="img-fluid rounded" alt="รูปภาพคอมเมนต์" style="max-height: 200px;">
                </div>
            @endif

            <small class="text-muted">
                โดย <strong>{{ $comment->user->name }}</strong>
                เมื่อ {{ $comment->created_at->diffForHumans() }}
            </small>

            {{-- ✅ ปุ่มแก้ไข/ลบ สำหรับเจ้าของหรือ admin --}}
            @if (auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->role === 'admin'))
                <div class="mt-2 d-flex gap-2">
                    {{-- ปุ่มแก้ไข --}}
                    <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-warning">แก้ไข</a>

                    {{-- ปุ่มลบ --}}
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('ลบความคิดเห็นนี้หรือไม่?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">ลบ</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@empty
    <p class="text-info">ยังไม่มีใครตอบกระทู้นี้เลย</p>
@endforelse


    {{-- ฟอร์มคอมเมนต์ (เฉพาะสมาชิก) --}}
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

                    <button type="submit" class="btn btn-primary">ส่งคำตอบ</button>
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
