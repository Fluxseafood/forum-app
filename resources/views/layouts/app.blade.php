<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WANFAHSAI Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <!-- *** แก้ไขที่ 1: เปลี่ยน 'welcome' เป็น 'home' *** -->
        <a class="navbar-brand" href="{{ route('home') }}">WANFAHSAI Forum </a>
        <ul class="navbar-nav ms-auto">
            @guest
                <!-- *** แก้ไขที่ 2: เปลี่ยน 'login.form' เป็น 'login' *** -->
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register.form') }}">Register</a></li>
            @else
                <li class="nav-item"><a class="nav-link" href="{{ route('profile') }}">Profile</a></li>
                @if(auth()->user()->role === 'admin')
                    <!-- สังเกต: Route 'users.index' อาจยังไม่ถูกกำหนด หากยังมีปัญหาหลังการแก้ไขนี้ ให้ตรวจสอบ Route นี้ -->
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Users</a></li>
                @endif
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link" style="padding:0;">Logout</button>
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>

<div class="container">
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Validation errors -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
