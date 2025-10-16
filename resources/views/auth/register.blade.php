@extends('layouts.app')

@section('content')
<style>
    /* 🌙 Pornhub-style Register Page */
    body {
        background-color: #111;
        color: #fff;
    }

    .register-card {
        background-color: #1a1a1a;
        border: 1px solid #ffa31a;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 0 15px rgba(255, 163, 26, 0.2);
    }

    .register-card h4 {
        color: #ffa31a;
        font-weight: 700;
        text-align: center;
        margin-bottom: 20px;
    }

    .form-label,
    label {
        color: #ddd;
    }

    .form-control,
    .form-select {
        background-color: #2a2a2a;
        border: 1px solid #444;
        color: #fff;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #ffa31a;
        box-shadow: 0 0 5px #ffa31a;
        background-color: #1f1f1f;
    }

    .btn-register {
        background-color: #ffa31a;
        color: #000;
        font-weight: 600;
        border: none;
        width: 100%;
        transition: 0.2s;
    }

    .btn-register:hover {
        background-color: #ffb84d;
        color: #000;
    }

    a {
        color: #ffa31a;
        text-decoration: none;
    }

    a:hover {
        color: #ffb84d;
        text-decoration: underline;
    }
</style>

<div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="register-card" style="width: 100%; max-width: 520px;">
        <h4>Register for <span style="background-color:#ffa31a; color:#000; padding:2px 8px; border-radius:3px;"> Talk</span> Space</h4>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if($errors->any()) 
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.perform') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="birthday" class="form-label">Birthday</label>
                <input type="date" name="birthday" id="birthday" class="form-control" value="{{ old('birthday') }}" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" id="gender" class="form-select" required>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="unspecified" {{ old('gender') == 'unspecified' ? 'selected' : '' }}>Unspecified</option>
                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Profile Picture</label>
                <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-register">Register</button>

            <p class="mt-3 text-center">
                Already have an account? <a href="{{ route('login') }}">Login here</a>
            </p>
        </form>
    </div>
</div>
@endsection
