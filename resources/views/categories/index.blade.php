@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center" style="color: #de9151;">
        <i class="bi bi-folder-fill me-2" style="color: #de9151;"></i>จัดการหมวดหมู่
    </h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ฟอร์มสร้างหมวดหมู่ใหม่ --}}
    <div class="card mb-4 shadow-sm" style="border: 2px solid #de9151;">
        <div class="card-header text-white" style="background-color: #de9151;">
            <i class="bi bi-plus-circle me-2"></i>สร้างหมวดหมู่ใหม่
        </div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="ชื่อหมวดหมู่" required>
                    <button type="submit" class="btn text-white" style="background-color: #de9151;">สร้าง</button>
                </div>
                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </form>
        </div>
    </div>

    {{-- ตารางรายการหมวดหมู่ --}}
    <div class="card shadow-sm" style="border: 2px solid #de9151;">
        <div class="card-header text-white" style="background-color: #de9151;">
            <i class="bi bi-list-ul me-2"></i>รายการหมวดหมู่ที่มีอยู่
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead style="background-color: #de9151; color: white;">
                    <tr>
                        <th>#</th>
                        <th>ชื่อหมวดหมู่</th>
                        <th>จำนวนกระทู้</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="align-middle">
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $category->name }}</td>
                            <td><span class="badge" style="background-color: #de9151; color:white;">{{ $category->posts_count }}</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm" style="border: 1px solid #de9151; color: #de9151;">
                                        <i class="bi bi-pencil-square me-1"></i>แก้ไข
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบหมวดหมู่นี้?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="border: 1px solid #de9151; color: #de9151;" {{ $category->posts_count > 0 ? 'disabled' : '' }}>
                                            <i class="bi bi-trash me-1"></i>ลบ
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">ยังไม่มีหมวดหมู่</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #ffe6cc; /* โทนอ่อนของ #de9151 */
        transition: 0.3s;
    }
    .card-header i {
        vertical-align: middle;
    }
    .btn:hover {
        background-color: #de9151 !important;
        color: white !important;
    }
</style>
@endsection
