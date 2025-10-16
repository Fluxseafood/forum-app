@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center" style="color: #de9151;">
        <i class="bi bi-person-circle me-2" style="color: #de9151;"></i>โปรไฟล์ของ {{ $user->username }}
    </h2>

    <div class="card shadow-lg mx-auto" style="max-width: 400px; border: 2px solid #de9151; border-radius: 15px;">
        <div class="card-body text-center">
            {{-- Avatar --}}
            @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle mb-3 border" style="border: 3px solid #de9151; width: 120px; height: 120px; object-fit: cover;">
            @else
                <img src="https://via.placeholder.com/120" alt="Default Avatar" class="rounded-circle mb-3 border" style="border: 3px solid #de9151;">
            @endif

            {{-- Username --}}
            <h4 class="card-title mb-3" style="color: #de9151;">{{ $user->username }}</h4>

            {{-- Info list --}}
            <ul class="list-group list-group-flush text-start mb-3">
                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                <li class="list-group-item"><strong>Birthday:</strong> {{ $user->birthday }}</li>
                <li class="list-group-item"><strong>Phone:</strong> {{ $user->phone ?? '-' }}</li>
                <li class="list-group-item"><strong>Gender:</strong> {{ ucfirst($user->gender) }}</li>
                <li class="list-group-item"><strong>Role:</strong> {{ ucfirst($user->role) }}</li>
            </ul>

            {{-- Buttons --}}
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('users.edit', $user->id) }}" class="btn" style="background-color: #de9151; color: #fff;">
                    <i class="bi bi-pencil-square me-1"></i>แก้ไขโปรไฟล์
                </a>
                <a href="{{ route('home') }}" class="btn btn-secondary">กลับหน้าหลัก</a>
            </div>
        </div>
    </div>
</div>

<style>
    .card:hover {
        transform: translateY(-5px);
        transition: 0.3s;
        box-shadow: 0 8px 20px rgba(222, 145, 81, 0.5);
    }
    .list-group-item {
        border: none;
        padding-left: 0;
    }
</style>
@endsection
