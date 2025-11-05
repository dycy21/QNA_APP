@extends('layouts.app')

@section('header_title', 'Admin Login')

@section('content')
    <div class="glossy-card" style="max-width: 400px; margin: 60px auto; padding: 40px;">
        <h2 class="gradient-text" style="text-align: center; margin-bottom: 30px;">Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email') <small style="color: yellow; opacity: 0.8;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
                @error('password') <small style="color: yellow; opacity: 0.8;">{{ $message }}</small> @enderror
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
                <button type="submit" class="glossy-btn primary">Log in</button>
            </div>
        </form>
    </div>
@endsection