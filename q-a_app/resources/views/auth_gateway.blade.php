@extends('layouts.app')

@section('header_title', 'Access Admin Panel')

@section('content')
    <div class="glossy-card" style="text-align: center; max-width: 400px; margin: 60px auto; padding: 40px;">
        <h2 class="gradient-text" style="margin-bottom: 30px;">Admin Access Required</h2>
        
        <p style="margin-bottom: 30px;">
            To manage properties, bookings, and instructions, please log in or register a new user account.
        </p>

        <div style="display: flex; justify-content: space-around;">
            
            {{-- Login Button --}}
            <a href="{{ route('login') }}" class="glossy-btn primary" style="padding: 12px 25px; font-size: 1.1em;">
                Log In
            </a>

            {{-- Registration Button --}}
            <a href="{{ route('register') }}" class="glossy-btn success" style="padding: 12px 25px; font-size: 1.1em;">
                Register
            </a>
            
        </div>
    </div>
@endsection