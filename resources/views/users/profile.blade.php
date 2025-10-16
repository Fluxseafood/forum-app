@extends('layouts.app')

@section('content')
<style>
    /* ===== Profile Card Theme ===== */
    .profile-card {
        background: #fffaf5;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(222, 145, 81, 0.2);
        padding: 30px;
        animation: fadeIn 0.5s ease;
    }

    .profile-card img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 4px solid #de9151;
    }

    .profile-card h5 {
        color: #de9151;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .profile-card p {
        color: #555;
        margin-bottom: 15px;
    }

    .list-group-item {
        border: none;
        padding: 10px 15px;
        background: #fff8f0;
        margin-bottom: 5px;
        border-radius: 10px;
        font-weight: 500;
    }

    .list-group-item strong {
        color: #de9151;
    }

    .btn-primary {
        background: #de9151;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        transition: 0.3s ease;
    }

    .btn-primary:hover {
        background: #ffb84d;
        color: white;
    }

    .btn-secondary {
        border-radius: 10px;
        transition: 0.3s ease;
    }

    .btn-secondary:hover {
        background: #ffe0b3;
        color: #de9151;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card profile-card shadow">
            <div class="card-header text-center bg-transparent border-0">
                <h4 class="fw-bold">โปรไฟล์</h4>
            </div>

            <div class="card-body text-center">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle mb-3">
                @else
                    <img src="https://via.placeholder.com/120" alt="Default Avatar" class="rounded-circle mb-3">
                @endif

                <h5>{{ $user->username }}</h5>
                <p>{{ $user->first_name }} {{ $user->last_name }}</p>

                <ul class="list-group list-group-flush text-start mt-3">
                    <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                    <li class="list-group-item"><strong>Birthday:</strong> {{ $user->birthday }}</li>
                    <li class="list-group-item"><strong>Phone:</strong> {{ $user->phone ?? '-' }}</li>
                    <li class="list-group-item"><strong>Gender:</strong> {{ ucfirst($user->gender) }}</li>
                    <li class="list-group-item"><strong>Role:</strong> {{ ucfirst($user->role) }}</li>
                </ul>

                <div class="mt-3 d-flex justify-content-center gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square me-1"></i> แก้ไขโปรไฟล์
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-secondary">
                        <i class="bi bi-house-door-fill me-1"></i> กลับหน้าหลัก
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
