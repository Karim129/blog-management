@extends('layouts.app2')

@section('content')
    <div class="container">
        <h1>User Details</h1>

        <div class="card">
            <div class="card-header">
                {{ $user->name }}
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Roles:</strong> {{ implode(', ', $user->roles->pluck('name')->toArray()) }}</p>
                @if($user->image)
                    <p><strong>Profile Image:</strong></p>
                    <img src="{{ asset( $user->image) }}" alt="Profile Image" width="150">
                @endif
            </div>
        </div>

        <a href="{{ route('users.index') }}" class="btn btn-primary mt-3">Back to Users List</a>
    </div>
@endsection
