@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap');
    body {
        font-family: 'Sarabun', sans-serif;
    }

    /* ===== Styling for User List Card and Table ===== */
    .user-list-card {
        background: #fff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(222, 145, 81, 0.1);
        margin-top: 20px;
        /* ลบ overflow-x: auto ออกจาก card หลัก เพื่อให้มีเฉพาะส่วนตารางที่เลื่อนได้ */
    }

    /* ===== NEW: Container สำหรับทำให้ตารางเลื่อนได้ในแนวตั้ง ===== */
    .scrollable-table-container {
        max-height: 450px; /* กำหนดความสูงสูงสุดของตารางที่มองเห็นได้ */
        overflow-y: auto; /* ทำให้เกิด scrollbar แนวตั้งเมื่อข้อมูลเกิน */
        overflow-x: auto; /* ให้ scrollbar แนวนอนทำงานที่นี่แทน .user-list-card */
        margin-bottom: 15px;
    }

    h1.page-title {
        color: #DE9151; /* สีหลักของโปรเจกต์ */
        font-weight: 700;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Search Input Styling */
    #userSearch {
        border: 2px solid #ffe1c4;
        border-radius: 10px;
        transition: 0.3s;
        padding: 10px 15px;
    }

    #userSearch:focus {
        border-color: #DE9151;
        box-shadow: 0 0 5px rgba(222, 145, 81, 0.5);
    }

    /* Table Styling */
    .table-custom {
        border-radius: 10px;
        overflow: hidden; /* เพื่อให้ขอบของตารางโค้งมนตาม Card */
        border: none;
    }

    /* Table Header */
    .table-custom thead tr th {
        /* สำคัญ: ให้ Header อยู่ที่ตำแหน่งเดิมเมื่อ Scroll */
        position: sticky; 
        top: 0; 
        z-index: 5;
        background-color: #ffb84d; /* สีโทนสว่างจาก Sidebar */
        color: #fff;
        font-weight: 600;
        padding: 15px 12px;
        border: none;
        vertical-align: middle;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1); /* เพิ่มเงาให้ header ดูโดดเด่น */
    }

    /* Table Body */
    .table-custom tbody tr {
        transition: background-color 0.2s;
    }

    .table-custom tbody tr:nth-of-type(odd) {
        background-color: #fffaf5; /* สีพื้นหลังสลับกันเล็กน้อย */
    }

    .table-custom tbody tr:hover {
        background-color: #ffe1c4; /* สีเมื่อนำเมาส์มาวาง */
    }

    .table-custom td {
        vertical-align: middle;
        padding: 12px;
        border-top: 1px solid #ffe0b3;
    }

    .user-details-cell {
        position: relative; /* สำคัญสำหรับตำแหน่ง popover */
    }

    .user-tooltip {
        visibility: hidden;
        opacity: 0;
        position: absolute;
        top: -10px; /* เลื่อนขึ้นเล็กน้อย */
        left: 100%; /* ไปทางขวาของเซลล์ */
        z-index: 1000;
        
        background-color: #333; /* สีพื้นหลังเข้ม */
        color: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        width: 250px;
        transition: opacity 0.3s, visibility 0.3s;
        pointer-events: none; /* เพื่อไม่ให้ขวางการคลิกองค์ประกอบอื่น */
        
        /* Pointer Arrow */
        transform: translateX(10px); /* ขยับออกจากเซลล์ไป 10px */
    }

    .user-tooltip::before {
        content: "";
        position: absolute;
        top: 20px;
        left: -10px;
        border-width: 5px;
        border-style: solid;
        border-color: transparent #333 transparent transparent;
    }


    .user-tooltip p {
        margin: 0;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .user-tooltip hr {
        border-color: rgba(255, 255, 255, 0.2);
    }

    /* ------------------------------------------- */
    /* ===== Button Styling (Existing) ===== */
    /* ------------------------------------------- */
    .btn-action {
        border-radius: 8px;
        font-weight: 500;
        transition: 0.3s;
        margin: 2px;
    }
    
    /* Primary Button (for Create/Submit) */
    .btn-primary {
        background-color: #DE9151;
        border-color: #DE9151;
        font-weight: 600;
        border-radius: 10px;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background-color: #c76f28;
        border-color: #c76f28;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(222, 145, 81, 0.3);
    }
    
    .btn-info {
        background-color: #6a9acb; /* สีน้ำเงินอ่อน */
        border-color: #6a9acb;
    }
    .btn-info:hover {
        background-color: #4a75a7;
        border-color: #4a75a7;
    }

    .btn-warning {
        background-color: #FFC107;
        border-color: #FFC107;
        color: #333;
    }
    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #e0a800;
        color: #333;
    }

    .btn-danger {
        background-color: #d9534f;
        border-color: #d9534f;
    }
    .btn-danger:hover {
        background-color: #c9302c;
        border-color: #c9302c;
    }
</style>

<div class="container">
    <h1 class="page-title"><i class="bi bi-people-fill"></i> รายการผู้ใช้</h1>

    <div class="user-list-card">
        
        <!-- Search Input -->
        <div class="mb-4">
            <input type="text" id="userSearch" class="form-control" placeholder="ค้นหาผู้ใช้ด้วย Username หรือ Email...">
        </div>
        
        <!-- NEW: Scrollable Table Container -->
        <div class="scrollable-table-container">
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Gender</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td class="user-details-cell">
                                    {{ $user->username }}
                                    {{-- แสดง Popover เฉพาะ Admin --}}
                                    @if (auth()->user()->role === 'admin')
                                        <div class="user-tooltip">
                                            <p><strong>ชื่อ:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
                                            <hr class="my-1">
                                            <p><strong>อีเมล:</strong> {{ $user->email }}</p>
                                            <p><strong>วันเกิด:</strong> {{ \Carbon\Carbon::parse($user->birthday)->format('d M Y') }}</p>
                                            @if ($user->phone)
                                                <p><strong>โทร:</strong> {{ $user->phone }}</p>
                                            @endif
                                            <p><strong>เพศ:</strong> {{ $user->gender }}</p>
                                            <hr class="my-1">
                                            <p><strong>Role:</strong> {{ $user->role }}</p>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    {{-- แสดง Role เป็น Badge สีสวยงาม --}}
                                    @if ($user->role === 'admin')
                                        <span class="badge bg-danger text-white">Admin</span>
                                    @elseif ($user->role === 'moderator')
                                        <span class="badge bg-warning text-dark">Moderator</span>
                                    @else
                                        <span class="badge bg-primary">User</span>
                                    @endif
                                </td>
                                <td>{{ $user->gender }}</td>
                                <td class="text-center" style="min-width: 200px;">
                                    {{-- เฉพาะ Admin ถึงเห็นปุ่ม View/Edit/Delete --}}
                                    @if (auth()->user()->role === 'admin')
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm btn-action">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm btn-action">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm btn-action"
                                                onclick="return confirm('คุณต้องการลบผู้ใช้: {{ $user->username }} ใช่หรือไม่?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    @else
                                        {{-- ถ้าไม่ใช่แอดมิน อาจให้ดูได้เฉพาะของตัวเอง --}}
                                        @if (auth()->id() === $user->id)
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm btn-action">
                                                <i class="bi bi-eye"></i> View Profile
                                            </a>
                                        @else
                                            -
                                        @endif
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> <!-- End scrollable-table-container -->
        
        {{-- ส่วนของ Pagination (ถ้ามี) --}}
        @if (isset($users) && method_exists($users, 'links'))
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    // JavaScript สำหรับค้นหา/กรองข้อมูลตารางแบบ Client-side
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('userSearch');
        const tableBody = document.querySelector('.table-custom tbody');
        
        if (searchInput && tableBody) {
            searchInput.addEventListener('keyup', function() {
                const searchText = this.value.toLowerCase();
                const rows = tableBody.querySelectorAll('tr');

                rows.forEach(row => {
                    // ดึงข้อมูลจากคอลัมน์ Username (Index 1) และ Email (Index 2)
                    // ใช้ row.cells[1].textContent เพื่อดึงเฉพาะข้อความไม่รวม HTML ที่ซ่อนอยู่
                    const username = row.cells[1].textContent.toLowerCase();
                    const email = row.cells[2].textContent.toLowerCase();
                    
                    if (username.includes(searchText) || email.includes(searchText)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection
