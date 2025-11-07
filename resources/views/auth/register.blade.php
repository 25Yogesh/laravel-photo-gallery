@extends('layouts.app')
@section('title','Register')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h3>Register</h3>
        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="mb-3">
                <label>Full Name</label>
                <input name="full_name" value="{{ old('full_name') }}" class="form-control" required>
                @error('full_name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label>Phone</label>
                <input name="phone" value="{{ old('phone') }}" class="form-control">
                @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input name="email" value="{{ old('email') }}" type="email" class="form-control" required>
                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                @error('address')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label>User ID (unique)</label>
                <input name="user_id" value="{{ old('user_id') }}" class="form-control" required>
                @error('user_id')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input name="password" type="password" class="form-control" required>
                @error('password')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input name="password_confirmation" type="password" class="form-control" required>
            </div>
            <button class="btn btn-primary">Register</button>
        </form>
    </div>
</div>
@endsection