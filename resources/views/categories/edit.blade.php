@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">แก้ไขหมวดหมู่: {{ $category->name }}</h4>
            </div>
            <div class="card-body">
                
                {{-- ฟอร์มสำหรับแก้ไขหมวดหมู่ --}}
                <form action="{{ route('categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- ใช้ method PUT สำหรับการอัปเดตตามมาตรฐาน RESTful --}}
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">ชื่อหมวดหมู่</label>
                        <input 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $category->name) }}" 
                            required>
                        
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        {{-- ปุ่มยกเลิก/ย้อนกลับ --}}
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> ยกเลิก
                        </a>
                        
                        {{-- ปุ่มบันทึกการแก้ไข --}}
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> บันทึกการแก้ไข
                        </button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
@endsection
