@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header text-center">
                <h4>Register</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('register.perform') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                                <!-- Username -->
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                    </div>

                     <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                                <!-- First Name -->
                    <div class="mb-3">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                    </div>
                    <!-- Last Name -->
                    <div class="mb-3">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                    <!-- Birthday -->
                     <div class="mb-3">
                        <label>Birthday</label>
                        <input type="date" name="birthday" class="form-control" value="{{ old('birthday') }}" required>
                    </div>
                    <!-- Phone -->
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                    <!-- Gender -->
                            <div class="mb-3">
                                <label>Gender</label>
                                <select name="gender" class="form-select" required>
                                    <option value="male" {{ old('gender')=='male'?'selected':'' }}>Male</option>
                                    <option value="female" {{ old('gender')=='female'?'selected':'' }}>Female</option>
                                    <option value="unspecified" {{ old('gender')=='unspecified'?'selected':'' }}>Unspecified</option>
                                    <option value="other" {{ old('gender')=='other'?'selected':'' }}>Other</option>
                                </select>
                            </div>
    <!-- Avatar input -->
    <div class="mb-3">
        <label for="avatar" class="form-label">Profile Picture</label>
        <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
