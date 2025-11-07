@extends('layouts.app')
@section('title','Reset Password')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <h3>Reset Password</h3>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3">
                <label>Email</label>
                <input name="email" value="{{ $email ?? old('email') }}" type="email" class="form-control" required>
                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label>New Password</label>
                <input name="password" type="password" class="form-control" required>
                @error('password')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input name="password_confirmation" type="password" class="form-control" required>
            </div>
            <button class="btn btn-primary">Reset Password</button>
        </form>
    </div>
</div>
@endsection