@extends('layout.app')
@section('title', 'Settings')
@section('content')
<div class="container mt-4">
    <h2>Settings</h2>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="#">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
                </div>
                <button type="submit" class="btn btn-primary" disabled>Save Changes</button>
            </form>
        </div>
    </div>
</div>
@endsection
