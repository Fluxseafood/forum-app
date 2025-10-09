@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>เว็บบอร์ด: กระทู้ล่าสุด</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            + สร้างกระทู้ใหม่
        </a>
    </div>

    @forelse ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                </h5>
                
                {{-- แสดงหมวดหมู่ --}}
                <span class="badge bg-secondary">{{ $post->category->name ?? 'ไม่มีหมวดหมู่' }}</span>

                <p class="card-text text-muted">
                    โพสต์โดย **{{ $post->user->name }}**
                    เมื่อ {{ $post->created_at->diffForHumans() }}
                    | {{ $post->comments->count() }} ความคิดเห็น
                </p>

                {{-- แสดงตัวอย่างเนื้อหาเพียงเล็กน้อย --}}
                <p class="card-text">{{ Str::limit($post->body, 150) }}</p>
                
                <a href="{{ route('posts.show', $post) }}" class="card-link">อ่านต่อ...</a>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            ยังไม่มีกระทู้ในขณะนี้ ลองสร้างกระทู้แรกของคุณสิ!
        </div>
    @endforelse

    {{-- การแบ่งหน้า (Pagination) --}}
    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection