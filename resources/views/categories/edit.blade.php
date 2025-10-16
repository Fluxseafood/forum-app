@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-lg" style="border: 2px solid #de9151;">
            <div class="card-header text-white" style="background-color: #de9151;">
                <h4 class="mb-0">
                    <i class="bi bi-pencil-square me-2"></i>
                    แก้ไขหมวดหมู่: {{ $category->name }}
                </h4>
            </div>
            <div class="card-body">
                
                {{-- ฟอร์มสำหรับแก้ไขหมวดหมู่ --}}
                <form action="{{ route('categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
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
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        {{-- ปุ่มยกเลิก --}}
                        <a href="{{ route('categories.index') }}" 
                           class="btn" 
                           style="border: 1px solid #de9151; color: #de9151;">
                           <i class="bi bi-arrow-left me-1"></i> ยกเลิก
                        </a>
                        
                        {{-- ปุ่มบันทึก --}}
                        <button type="submit" 
                                class="btn text-white" 
                                style="background-color: #de9151; border: 1px solid #de9151;">
                            <i class="bi bi-save me-1"></i> บันทึกการแก้ไข
                        </button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>

<style>
    .btn:hover {
        background-color: #c88140 !important; /* โทนเข้มเวลาฮัว */
        color: white !important;
        transition: 0.3s;
    }
    .card-header i {
        vertical-align: middle;
    }
</style>
@endsection
