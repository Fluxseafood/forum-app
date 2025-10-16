@extends('layouts.app')

@section('content')
<style>
    /* 🎨 Pornhub-style Login Page */
    body {
        background-color: #111;
        color: #fff;
    }

    .login-card {
        background-color: #1a1a1a;
        border: 1px solid #ffa31a;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 0 15px rgba(255, 163, 26, 0.2);
    }

    .login-card h3 {
        color: #ffa31a;
        font-weight: 700;
        text-align: center;
        margin-bottom: 20px;
    }

    .form-label {
        color: #ddd;
    }

    .form-control {
        background-color: #2a2a2a;
        border: 1px solid #444;
        color: #fff;
    }

    .form-control:focus {
        border-color: #ffa31a;
        box-shadow: 0 0 5px #ffa31a;
        background-color: #1f1f1f;
    }

    .btn-login {
        background-color: #ffa31a;
        color: #000;
        font-weight: 600;
        border: none;
        width: 100%;
        transition: 0.2s;
    }

    .btn-login:hover {
        background-color: #ffb84d;
        color: #000;
    }

    .form-check-label {
        color: #ccc;
    }

    a {
        color: #ffa31a;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
        color: #ffb84d;
    }
</style>

<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="login-card" style="width: 100%; max-width: 420px;">
        <h3>Login to <span style="background-color: #ffa31a; color: #000; padding: 2px 8px; border-radius: 3px;"> Talk</span> Space</h3>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if($errors->any()) 
            <div class="alert alert-danger text-center">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.perform') }}">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" 
                       value="{{ old('username') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" id="remember" name="remember" class="form-check-input">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn btn-login">Login</button>
        </form>

        <p class="mt-3 text-center">
            Don't have an account? 
            <a href="{{ route('register.form') }}">Register here</a>
        </p>
    </div>
</div>
@endsection
