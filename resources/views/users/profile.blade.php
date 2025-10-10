@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card shadow">
            <div class="card-header text-center">
                <h4>Profile</h4>
            </div>
            <div class="card-body text-center">
            @if($user->avatar)
                <img src="{{ asset('storage/avatars/'.$user->avatar) }}" alt="Avatar" class="rounded-circle mb-3">
            @else
                <img src="https://via.placeholder.com/120" alt="Default Avatar" class="rounded-circle mb-3">
            @endif

                <h5>{{ $user->username }}</h5>
                <p>{{ $user->first_name }} {{ $user->last_name }}</p>

                <ul class="list-group list-group-flush text-start mt-3">
                    <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                    <li class="list-group-item"><strong>Birthday:</strong> {{ $user->birthday }}</li>
                    <li class="list-group-item"><strong>Phone:</strong> {{ $user->phone ?? '-' }}</li>
                    <li class="list-group-item"><strong>Gender:</strong> {{ ucfirst($user->gender) }}</li>
                    <li class="list-group-item"><strong>Role:</strong> {{ ucfirst($user->role) }}</li>
                    
                </ul>

                <div class="mt-3">
                    <a href="" class="btn btn-primary">Edit Profile</a>
                    <a href="{{ route('home') }}" class="btn btn-secondary">Back to Welcome</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
