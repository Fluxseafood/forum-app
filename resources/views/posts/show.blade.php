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
                โพสต์โดย **{{ $post->user->name }}** ในหมวดหมู่ <span class="badge bg-info">{{ $post->category->name ?? 'N/A' }}</span>
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
                {!! nl2br(e($post->body)) !!} {{-- ใช้ nl2br เพื่อให้ขึ้นบรรทัดใหม่ได้ --}}
            </div>

            {{-- ปุ่มแก้ไข/ลบ (ทำในส่วน 3. สิทธิ์การใช้งาน) --}}
            @if (auth()->check() && auth()->user()->id === $post->user_id)
                <div class="mt-3">
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                    {{-- เพิ่มปุ่มลบ (ต้องใช้ฟอร์ม POST และเมธอด DELETE) --}}
                </div>
            @endif
        </div>
    </div>
    
    {{-- ส่วนแสดงคอมเมนต์ --}}
    <h3 class="mt-5 mb-3">{{ $post->comments->count() }} ความคิดเห็น</h3>
    
    @forelse ($post->comments as $comment)
        <div class="card mb-3">
            <div class="card-body">
                <p class="card-text">
                    {!! nl2br(e($comment->body)) !!}
                </p>
                
                @if ($comment->image_path)
                    <div class="mb-2">
                        <img src="{{ Storage::url($comment->image_path) }}" class="img-fluid rounded" alt="รูปภาพคอมเมนต์" style="max-height: 200px;">
                    </div>
                @endif
                
                <small class="text-muted">
                    โดย **{{ $comment->user->name }}** เมื่อ {{ $comment->created_at->diffForHumans() }}
                </small>
                
                {{-- ปุ่มแก้ไข/ลบคอมเมนต์ (ทำในส่วน 3. สิทธิ์การใช้งาน) --}}
                @if (auth()->check() && auth()->user()->id === $comment->user_id)
                    <small class="ms-2">
                        <a href="#" class="text-danger">ลบ</a>
                    </small>
                @endif
            </div>
        </div>
    @empty
        <p class="text-info">ยังไม่มีใครตอบกระทู้นี้เลย</p>
    @endforelse

    {{-- ฟอร์มคอมเมนต์ (สำหรับสมาชิกเท่านั้น) --}}
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
        <p class="text-center mt-4"><a href="{{ route('login') }}">เข้าสู่ระบบ</a> เพื่อตอบกระทู้นี้</p>
    @endauth
</div>
@endsection