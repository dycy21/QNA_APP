@extends('layouts.app')

@section('header_title', 'Admin Registration')

@section('content')
    <div class="glossy-card" style="max-width: 400px; margin: 30px auto; padding: 40px;">
        <h2 class="gradient-text" style="text-align: center; margin-bottom: 30px;">Register New User</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                @error('name') <small style="color: yellow; opacity: 0.8;">{{ $message }}</small> @enderror
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <small style="color: yellow; opacity: 0.8;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
                @error('password') <small style="color: yellow; opacity: 0.8;">{{ $message }}</small> @enderror
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
                <button type="submit" class="glossy-btn success">Register</button>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('login') }}" style="color: white; opacity: 0.8;">Already registered? Log in here.</a>
            </div>
        </form>
    </div>
@endsection