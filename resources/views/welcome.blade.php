@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Welcome to WANFAHSAI Forum</h1>

    <p>นี่คือรายชื่อผู้ใช้งานทั้งหมด:</p>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>ชื่อ-นามสกุล</th>
                <th>Email</th>
                <th>เบอร์โทรศัพท์</th>
                <th>เพศ</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone ?? '-' }}</td>
                <td>{{ ucfirst($user->gender) }}</td>
                <td>{{ ucfirst($user->role) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">ยังไม่มีผู้ใช้งาน</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
