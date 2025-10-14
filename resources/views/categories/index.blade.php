@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2 class="mb-4">จัดการหมวดหมู่</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- ฟอร์มสำหรับสร้างหมวดหมู่ใหม่ --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white">สร้างหมวดหมู่ใหม่</div>
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="ชื่อหมวดหมู่" required>
                            <button type="submit" class="btn btn-success">สร้าง</button>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>

            {{-- ตารางแสดงรายการหมวดหมู่ --}}
            <div class="card">
                <div class="card-header">รายการหมวดหมู่ที่มีอยู่</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ชื่อหมวดหมู่</th>
                                <th>จำนวนกระทู้</th>
                                <th>การจัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->posts_count }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning me-2">แก้ไข</a>
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบหมวดหมู่นี้?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" {{ $category->posts_count > 0 ? 'disabled' : '' }}>ลบ</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">ยังไม่มีหมวดหมู่</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection