@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth-page">
    <div class="auth-card reveal">
        <h2>Welcome Back</h2>
        <p class="auth-subtitle">Sign in to your ADGON account</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="auth-field">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="auth-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <label class="auth-remember">
                <input type="checkbox" name="remember" id="remember">
                Remember me
            </label>

            <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">
                <span>Sign In</span>
            </button>

            <p class="auth-footer-text">
                Don't have an account? <a href="{{ route('register') }}">Create one</a>
            </p>
        </form>
    </div>
</div>
@endsection
