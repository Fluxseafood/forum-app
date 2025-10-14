@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 600px;">
        <h2 class="mb-4">แก้ไขโปรไฟล์</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

            <div class="mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>New Password (optional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="mb-3">
                <label>Avatar</label><br>
                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" width="100" class="rounded mb-2">
                @endif
                <input type="file" name="avatar" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('profile') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
