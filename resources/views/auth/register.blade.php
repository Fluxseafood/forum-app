@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f0f2f5;
        color: #333;
        font-family: Arial, sans-serif;
    }

    .register-card {
        background-color: #fff;
        border: 2px solid #de9151;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 0 25px rgba(222, 145, 81, 0.3);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .register-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 35px rgba(222, 145, 81, 0.5);
    }

    .register-card h4 {
        color: #de9151;
        font-weight: 700;
        text-align: center;
        margin-bottom: 25px;
    }

    .form-label {
        color: #333;
        font-weight: 500;
    }

    .form-control, .form-select {
        background-color: #fff;
        border: 1px solid #de9151;
        color: #333;
        border-radius: 6px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #de9151;
        box-shadow: 0 0 5px #de9151;
    }

    .btn-register {
        background-color: #de9151;
        color: #fff;
        font-weight: 600;
        border: none;
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        transition: 0.3s;
    }

    .btn-register:hover {
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

    @media (max-width: 768px) {
        .form-col {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>

<div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="register-card" style="width: 100%; max-width: 800px;">
        <h4>Register for <span style="background-color:#de9151; color:#fff; padding:3px 10px; border-radius:4px;">Talk Space</span></h4>

        @if(session('success'))
            <div class="alert alert-success text-center mt-3">{{ session('success') }}</div>
        @endif

        @if($errors->any()) 
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.perform') }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="row g-3">
                <div class="col-md-6 form-col">
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
                        <label for="avatar" class="form-label">Profile Picture</label>
                        <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="col-md-6 form-col">
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
                </div>
            </div>

            <button type="submit" class="btn btn-register mt-3">Register</button>

            <p class="mt-3 text-center">
                Already have an account? <a href="{{ route('login') }}">Login here</a>
            </p>
        </form>
    </div>
</div>
@endsection
