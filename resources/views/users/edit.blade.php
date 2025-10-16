@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px;">
    <h2 class="mb-4 text-center text-warning">
        <i class="bi bi-person-circle me-2" style="color: #de9151;">แก้ไขโปรไฟล์</i>
    </h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-warning">
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" 
                           class="form-control @error('first_name') is-invalid @enderror" required>
                    @error('first_name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" 
                           class="form-control @error('last_name') is-invalid @enderror" required>
                    @error('last_name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                           class="form-control @error('phone') is-invalid @enderror">
                    @error('phone')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">New Password (optional)</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Avatar</label><br>
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" width="100" class="rounded mb-2">
                    @endif
                    <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror">
                    @error('avatar')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('profile') }}" class="btn" 
                       style="border: 1px solid #de9151; color: #de9151;">
                       <i class="bi bi-arrow-left me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn text-white" style="background-color: #de9151; border: 1px solid #de9151;">
                        <i class="bi bi-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn:hover {
        background-color: #c88140 !important;
        color: white !important;
        transition: 0.3s;
    }
    .card-header i, h2 i {
        vertical-align: middle;
    }
</style>
@endsection
