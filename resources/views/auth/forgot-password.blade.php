@extends('layouts.app')
@section('title', 'Forgot Password')
@section('content')

<div class="container mt-5" style="max-width: 500px;">
    <h3 class="mb-4 text-center">Forgot Password</h3>

    @if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    {{-- Step 1: Check Email --}}
    @if(!isset($emailFound))
    <form method="POST" action="{{ route('password.handle') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Enter your email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            @error('email')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button name="check_email" value="1" class="btn btn-primary w-100">Check Email</button>
    </form>

    {{-- Step 2: Reset Password --}}
    @else
    <form method="POST" action="{{ route('password.handle') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="password" class="form-control" required>
            @error('password')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button name="reset_password" value="1" class="btn btn-success w-100">Update Password</button>
    </form>
    @endif
</div>

@endsection