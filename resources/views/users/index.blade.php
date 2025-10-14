@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>รายการผู้ใช้</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Gender</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>
                            {{-- เฉพาะ Admin ถึงเห็นปุ่ม View/Edit/Delete --}}
                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('ลบผู้ใช้นี้?')">Delete</button>
                                </form>
                            @else
                                {{-- ถ้าไม่ใช่แอดมิน อาจให้ดูได้เฉพาะของตัวเอง --}}
                                @if (auth()->id() === $user->id)
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">View</a>
                                @endif
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
