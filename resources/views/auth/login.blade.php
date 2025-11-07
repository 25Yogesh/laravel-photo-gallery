@extends('layouts.app')
@section('title','Login')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <h3>Login</h3>
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
                <label>User ID</label>
                <input name="user_id" value="{{ old('user_id') }}" class="form-control" required>
                @error('user_id')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input name="password" type="password" class="form-control" required>
                @error('password')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <a href="{{ route('password.request') }}">Forgot your password?</a>
            </div>
            <button class="btn btn-primary">Login</button>
        </form>
    </div>
</div>
@endsection