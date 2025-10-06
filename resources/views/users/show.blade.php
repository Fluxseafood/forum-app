@extends('layouts.app')

@section('content')
<div class="container">
    <h1>โปรไฟล์ของ {{ $user->username }}</h1>

    <div class="card" style="width: 18rem;">
    <img src="{{ asset('storage/avatars/'.$user->avatar) }}" alt="Avatar">
        <div class="card-body">
            <p><strong>ชื่อ:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>เบอร์โทร:</strong> {{ $user->phone ?? '-' }}</p>
            <p><strong>วันเกิด:</strong> {{ $user->birthday->format('d/m/Y') }}</p>
            <p><strong>Role:</strong> {{ $user->role }}</p>
            <p><strong>Gender:</strong> {{ $user->gender }}</p>

            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">แก้ไขโปรไฟล์</a>
        </div>
    </div>
</div>
@endsection