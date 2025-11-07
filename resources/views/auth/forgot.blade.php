@extends('layouts.app')
@section('title','Forgot Password')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <h3>Request password reset</h3>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label>Email</label>
                <input name="email" value="{{ old('email') }}" type="email" class="form-control" required>
                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <button class="btn btn-primary">Send Reset Link</button>
        </form>
    </div>
</div>
@endsection