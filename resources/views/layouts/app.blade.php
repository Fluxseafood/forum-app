<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Talk Space</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        /* ===== Global ===== */
        body {
            background: #fffaf5;
            color: #333;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            transition: background 0.3s;
        }

        a {
            text-decoration: none;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #DE9151, #ffb84d);
            color: white;
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.15);
            padding: 25px 15px;
            transition: all 0.4s ease;
            z-index: 1050;
        }

        .sidebar.active {
            transform: translateX(-100%);
        }

        .sidebar .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            text-align: center;
            color: #fff;
            display: block;
            margin-bottom: 40px;
            letter-spacing: 1px;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.6);
        }

        .sidebar .nav-link {
            color: #fff;
            font-weight: 500;
            margin: 10px 0;
            border-radius: 8px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background: rgba(236, 236, 236, 0.8);
            color: #DE9151;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background: #fff;
            color: #DE9151 !important;
            font-weight: 600;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transform: translateX(5px);
        }


        .sidebar .nav-link i {
            color: fff;
            font-size: 1.2rem;
        }

        .sidebar .btn-logout {
            color: #fff;
            border-radius: 8px;
            width: 100%;
            margin-top: 10px;
        }

        .sidebar .btn-logout:hover {
            background: #ffffff;
            color: #DE9151;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            transform: translateX(5px);
        }

        /* ===== Topbar ===== */
        .topbar {
            height: 60px;
            background: #fff;
            border-bottom: 3px solid #DE9151;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-left: 250px;
            transition: all 0.4s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .topbar.collapsed {
            margin-left: 0;
        }

        .topbar h5 {
            margin: 0;
            color: #DE9151;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .toggle-btn {
            font-size: 1.8rem;
            color: #DE9151;
            cursor: pointer;
            transition: 0.3s;
        }

        .toggle-btn:hover {
            color: #DE9151;
            transform: scale(1.1);
        }

        /* ===== Main Content ===== */
        .main-content {
            margin-left: 250px;
            padding: 40px;
            transition: all 0.4s ease;
        }

        .main-content.collapsed {
            margin-left: 0;
        }

        .card {
            background: #fff;
            border: 1px solid #ffe0b3;
            color: #333;
            border-radius: 12px;
            transition: 0.3s;
        }

        .card:hover {
            border-color: #DE9151;
            box-shadow: 0 0 15px rgba(255, 153, 0, 0.2);
            transform: translateY(-2px);
        }

        /* ===== Buttons ===== */
        .btn-primary {
            background-color: #DE9151;
            border: none;
            font-weight: 600;
        }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .topbar,
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column justify-content-between" id="sidebar">
        <div>
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-chat-heart-fill"></i> Talk Space
            </a>

            <ul class="nav flex-column">
                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> ล็อกอิน
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register.form') ? 'active' : '' }}"
                            href="{{ route('register.form') }}">
                            <i class="bi bi-person-plus-fill"></i> ลงทะเบียน
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}"
                            href="{{ route('profile') }}">
                            <i class="bi bi-person-circle"></i> โปรไฟล์
                        </a>
                    </li>

                    @if (auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                                href="{{ route('users.index') }}">
                                <i class="bi bi-people-fill"></i> จัดการผู้ใช้
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                                href="{{ route('categories.index') }}">
                                <i class="bi bi-folder-plus"></i> เพิ่มหมวดหมู่ 
                            </a>
                        </li>
                    @endif
                @endguest
            </ul>
        </div>

        @auth
            <!-- Logout ด้านล่างสุด -->
            <div class="mt-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link btn-logout w-100 text-start">
                        <i class="bi bi-box-arrow-right"></i> ออกจากระบบ
                    </button>
                </form>
            </div>
        @endauth
    </div>


    <!-- Topbar -->
    <div class="topbar" id="topbar">
        <div class="toggle-btn" id="toggleBtn"><i class="bi bi-list"></i></div>
        <h5>Welcome to Talk Space Forum</h5>
    </div>

    <!-- Main content -->
    <div class="main-content container" id="mainContent">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const topbar = document.getElementById('topbar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('toggleBtn');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            topbar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
        });
    </script>
</body>

</html>
