@extends('layout.app')
@section('title', 'Profile')
@section('content')
<div class="container mt-4">
    <h2>Profile</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $user->role }}</p>
            <p><strong>Department:</strong> {{ $user->department->name ?? 'N/A' }}</p>
        </div>
    </div>
</div>
@endsection
