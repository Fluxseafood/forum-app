@extends('layouts.app')

@section('content')
<div class="container">
    <h1>แก้ไขโปรไฟล์</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
        </div>

        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}">
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
        </div>

        <div class="mb-3">
            <label>Password (เว้นว่างถ้าไม่เปลี่ยน)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Birthday</label>
            <input type="date" name="birthday" class="form-control" value="{{ old('birthday', $user->birthday->format('Y-m-d')) }}">
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="mb-3">
            <label>Avatar</label>
            <input type="file" name="avatar" class="form-control">
        </div>

        <div class="mb-3">
            <label>Gender</label>
            <select name="gender" class="form-control">
                @foreach(['male','female','unspecified','other'] as $gender)
                    <option value="{{ $gender }}" @if($user->gender == $gender) selected @endif>{{ ucfirst($gender) }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>
</div>
@endsection
