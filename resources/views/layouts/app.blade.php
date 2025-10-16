<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Talk Space</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai+Looped:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
            font-family: "IBM Plex Sans Thai Looped", sans-serif;
            color: #333;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(180deg, #de9151, #ffb84d);
            color: white;
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.15);
            padding: 25px 10px;
            transition: all 0.3s ease;
            z-index: 1050;
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .navbar-brand span {
            display: none;
        }

        .sidebar .nav-link {
            color: #fff;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            padding: 12px 16px;
            margin: 8px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .sidebar .nav-link i {
            font-size: 1.2rem;
            min-width: 24px;
            text-align: center;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.9);
            color: #de9151;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background: #fff;
            color: #de9151;
            font-weight: 600;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }

        .btn-logout {
            color: #fff;
            border: none;
            background: transparent;
            border-radius: 8px;
            width: 100%;
            text-align: left;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: #fff;
            color: #de9151;
            transform: translateX(5px);
        }

        .sidebar.collapsed .btn-logout {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed .btn-logout span {
            display: none;
        }

        /* ===== Topbar ===== */
        .topbar {
            height: 60px;
            background: #fff;
            border-bottom: 3px solid #de9151;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            transition: all 0.3s ease;
            margin-left: 250px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .sidebar.collapsed~.topbar {
            margin-left: 80px;
        }

        .toggle-btn {
            font-size: 1.8rem;
            color: #de9151;
            cursor: pointer;
        }

        .topbar h5 {
            color: #de9151;
            font-weight: 600;
            margin: 0;
        }

        /* ===== Main Content ===== */
        .main-content {
            padding: 40px;
            transition: all 0.3s ease;
            margin-left: 250px;
        }

        .sidebar.collapsed~.main-content {
            margin-left: 80px;
        }

        .card {
            border: 1px solid #ffe0b3;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .card:hover {
            border-color: #de9151;
            box-shadow: 0 0 12px rgba(255, 153, 0, 0.3);
        }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
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
    <div class="sidebar" id="sidebar">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-chat-heart-fill"></i> <span>Talk Space</span>
        </a>

        <ul class="nav flex-column">
            @guest
                <li>
                    <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">
                        <i class="bi bi-box-arrow-in-right"></i> <span>ล็อกอิน</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('register.form') }}" class="nav-link {{ request()->routeIs('register.form') ? 'active' : '' }}">
                        <i class="bi bi-person-plus-fill"></i> <span>ลงทะเบียน</span>
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i> <span>โปรไฟล์</span>
                    </a>
                </li>

                @if (auth()->user()->role === 'admin')
                    <li>
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                            <i class="bi bi-people-fill"></i> <span>จัดการผู้ใช้</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                            <i class="bi bi-folder-plus"></i> <span>เพิ่มหมวดหมู่</span>
                        </a>
                    </li>
                @endif
            @endguest
        </ul>

        @auth
            <form action="{{ route('logout') }}" method="POST" class="mt-auto">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i> <span>ออกจากระบบ</span>
                </button>
            </form>
        @endauth
    </div>

    <!-- Topbar -->
    <div class="topbar">
        <div class="toggle-btn" id="toggleBtn"><i class="bi bi-list"></i></div>
        <h5>Talk Space Forum — ชุมชนแห่งการสนทนา</h5>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleBtn');

        toggleBtn.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
            }
        });
    </script>
</body>

</html>
