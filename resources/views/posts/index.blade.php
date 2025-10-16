@extends('layouts.app')

@section('content')
<div class="container py-6">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">
        <h1 class="fw-bold mb-3 mb-md-0 text-dark">
            <i class="bi bi-chat-left-text-fill me-2 text-primary"></i> เว็บบอร์ด: กระทู้ล่าสุด
        </h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary btn-lg rounded-pill shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> สร้างกระทู้ใหม่
        </a>
    </div>

    <div class="card-list">
        @forelse ($posts as $post)
        <a href="{{ route('posts.show', $post) }}" class="card post-card border-0 rounded-0 shadow-sm lift-on-hover">
            <div class="card-body p-4 d-flex flex-column">
                <h5 class="fw-bold text-dark mb-2">
                    {{ $post->title }}
                </h5>
                <div class="d-flex w-100 justify-content-between align-items-end">
                    <div class="d-flex align-items-center text-muted">
                        <small class="me-2">
                            โพสต์โดย <strong class="text-dark me-1">{{ $post->user->name }}</strong> เมื่อ {{ $post->created_at->diffForHumans() }}
                        </small>
                        <span class="badge category-pill-muted">{{ $post->category->name ?? 'ไม่มีหมวดหมู่' }}</span>
                    </div>
                    <small class="text-muted d-flex align-items-center">
                        <i class="bi bi-chat-left-text me-1"></i> {{ $post->comments->count() }}
                    </small>
                </div>
            </div>
        </a>
        @empty
        <div class="col-12">
            <div class="alert alert-light text-center py-4">
                <h4 class="alert-heading text-dark">💡 ยังไม่มีกระทู้!</h4>
                <p class="mb-0">ลองสร้างกระทู้แรกของคุณเพื่อเริ่มการสนทนาได้เลย</p>
            </div>
        </div>
        @endforelse
    </div>

    @if ($posts->lastPage() > 1)
        <div class="mt-5 d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    @endif
</div>

<style>
    :root {
        --primary: #FF5722;
    }
    
    body {
        background-color: #f0f2f5;
        font-family: 'Kanit', sans-serif;
    }

    /* Buttons */
    .btn-primary {
        background-color: var(--primary) !important;
        border-color: var(--primary) !important;
        transition: all 0.2s ease-in-out;
    }
    .btn-primary:hover {
        background-color: #e64a19 !important;
        border-color: #e64a19 !important;
        box-shadow: 0 4px 15px rgba(255, 87, 34, 0.3);
    }
    
    /* Card List */
    .card-list .post-card:not(:last-child) {
        border-bottom: 1px solid #e9ecef;
    }
    .card-list .post-card {
        background-color: #fff;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        color: inherit;
    }
    .lift-on-hover:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    
    /* Category Badge */
    .category-pill-muted {
        background-color: #e9ecef;
        color: #6c757d;
        font-weight: 500;
        padding: 0.2rem 0.6rem;
        border-radius: 50px;
        font-size: 0.75rem;
    }

    /* Pagination */
    .pagination .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    .pagination .page-link {
        color: var(--primary);
        border-radius: 0.5rem;
        margin: 0 0.2rem;
        transition: all 0.2s;
    }
    .pagination .page-link:hover {
        background-color: var(--primary);
        color: #fff;
    }
</style>
@endsection