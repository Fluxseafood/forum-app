@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>โปรไฟล์ของ {{ $user->username }}</h1>

        <div class="card" style="width: 18rem;">
            @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle mb-3">
            @else
                <img src="https://via.placeholder.com/120" alt="Default Avatar" class="rounded-circle mb-3">
            @endif
            <div class="card-body">
                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                    <li class="list-group-item"><strong>Birthday:</strong> {{ $user->birthday }}</li>
                    <li class="list-group-item"><strong>Phone:</strong> {{ $user->phone ?? '-' }}</li>
                    <li class="list-group-item"><strong>Gender:</strong> {{ ucfirst($user->gender) }}</li>
                    <li class="list-group-item"><strong>Role:</strong> {{ ucfirst($user->role) }}</li>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">แก้ไขโปรไฟล์</a>
            </div>
        </div>
    </div>
@endsection
