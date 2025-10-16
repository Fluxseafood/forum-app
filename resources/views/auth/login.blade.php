@extends('layouts.app')

@section('content')
<style>
    /* 🎨 Orange & White Login Theme */
    body {
        background-color: #f0f2f5;
        color: #333;
        font-family: Arial, sans-serif;
    }

    .login-card {
        background-color: #fff;
        border: 2px solid #de9151;
        border-radius: 12px;
        padding: 35px 30px;
        box-shadow: 0 0 20px rgba(222, 145, 81, 0.3);
        transition: transform 0.3s, box-shadow 0.3s;
    }


    .login-card h3 {
        color: #de9151;
        font-weight: 700;
        text-align: center;
        margin-bottom: 25px;
    }

    .form-label {
        color: #333;
        font-weight: 500;
    }

    .form-control {
        background-color: #fff;
        border: 1px solid #de9151;
        color: #333;
        border-radius: 6px;
    }

    .form-control:focus {
        border-color: #de9151;
        box-shadow: 0 0 5px #de9151;
    }

    .btn-login {
        background-color: #de9151;
        color: #fff;
        font-weight: 600;
        border: none;
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        transition: 0.3s;
    }

    .btn-login:hover {
        background-color: #f29359;
        color: #fff;
    }

    a {
        color: #de9151;
        text-decoration: none;
        font-weight: 500;
    }

    a:hover {
        text-decoration: underline;
        color: #f29359;
    }

    .alert {
        border-radius: 6px;
        font-weight: 500;
    }
</style>

<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="login-card" style="width: 100%; max-width: 420px;">
        <h3>Login to <span style="background-color: #de9151; color: #fff; padding: 3px 10px; border-radius: 4px;">Talk Space</span></h3>

        @if(session('success'))
            <div class="alert alert-success text-center mt-3">{{ session('success') }}</div>
        @endif

        @if($errors->any()) 
            <div class="alert alert-danger text-center mt-3">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.perform') }}" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required autofocus>
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
