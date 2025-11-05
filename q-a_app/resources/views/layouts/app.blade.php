<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guest Check-in</title>
    <style>
        /* 1. Base Reset & Layout */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #f4f4f4; 
            margin: 0; padding: 0; 
            color: white; 
        }
        .container { max-width: 960px; margin: 40px auto; padding: 20px; }
        
        /* 2. Dynamic Glossy Background */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #cca3e4ff 0%, #4f037aff 100%);
            opacity: 0.9;
            z-index: -2;
        }
        .container, .glossy-card {
            /* Frosted Glass Effect */
            background-color: rgba(255, 255, 255, 0.15); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2); 
        }

        /* 3. Navigation Bar Styling (Sticky and Animated) */
        .navbar {
            background: rgba(86, 7, 133, 0.9); 
            padding: 15px 0;
            margin-bottom: 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: padding 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
        }
        .navbar.scrolled {
            padding: 8px 0; 
            background: rgba(85, 7, 158, 0.95); 
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5); 
        }
        .navbar-content {
            max-width: 960px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;
        }
        .navbar-brand {
            font-size: 1.5em; font-weight: bold; color: white; text-decoration: none; margin-right: 20px; transition: font-size 0.3s ease;
        }
        .navbar.scrolled .navbar-brand {
             font-size: 1.2em;
        }
        .nav-links a, .nav-links button {
            color:white; text-decoration: none; padding: 8px 15px; border-radius: 20px; transition: all 0.2s ease-in-out; cursor: pointer;
            border: none; background-color: rgba(20, 110, 138, 1);
        }
        .nav-links a:hover, .nav-links button:hover, .nav-links a.active, .nav-links button.active {
            transform: scale(1.05); 
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.8), 0 5px 10px rgba(0, 0, 0, 0.5); 
            background: rgba(255, 255, 255, 0.3);
            text-shadow: 0 0 8px rgba(18, 3, 46, 1);
        }
        
        /* 4. Glossy Transparent Buttons and Forms */
        .glossy-card { padding: 20px; margin-bottom: 20px; }
        .btn, .glossy-btn {
            padding: 10px 20px; border-radius: 25px; cursor: pointer; text-decoration: none;
            background: rgba(255, 255, 255, 0.2); color: white; 
            border: 1px solid rgba(255, 255, 255, 0.4); text-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            transition: all 0.2s ease-in-out;
        }
        .glossy-btn:hover {
            transform: scale(1.05); 
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.9), 0 5px 15px rgba(0, 0, 0, 0.6); 
            text-shadow: 0 0 10px rgba(255, 255, 255, 1);
        }
        .glossy-btn.primary { background: rgba(52, 144, 220, 0.8); }
        .glossy-btn.success { background: rgba(56, 193, 114, 0.8); }

        /* 5. Gradient Text */
        .gradient-text {
            background: linear-gradient(90deg, #6a82fb, #fc5c7d); 
            -webkit-background-clip: text; background-clip: text;
            color: transparent; font-weight: 800;
        }

        /* 6. Forms and Tables */
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; } 
        .form-group input, .form-group select, .form-group textarea { 
            width: 100%; padding: 10px; box-sizing: border-box; 
            background: rgba(0, 0, 0, 0.2); color: white; border-radius: 8px;
        }
        table { width: 100%; border-collapse: separate; border-spacing: 0; } 
        th, td { border: none; padding: 12px; text-align: left; color: white; }
        th { background-color: rgba(0, 0, 0, 0.3); }

        /* 7. Profile Icon/Dropdown Styling */
        .profile-dropdown {
            position: relative;
            cursor: pointer;
            margin-left: 20px;
        }
        .profile-icon {
            height: 35px;
            width: 35px;
            background: #ffc107; /* Yellow/Amber color */
            color: #333;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1em;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
        .profile-details {
            display: none;
            position: absolute;
            right: 0;
            top: 45px;
            min-width: 180px;
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 1001;
            color: #333;
        }
        /* Show dropdown on hover */
        .profile-dropdown:hover .profile-details {
            display: block;
        }
        .profile-details p {
            margin: 0;
            padding: 0;
            color: #333; /* Ensure text is dark and visible */
            font-weight: normal;
            font-size: 0.9em;
        }
        .profile-details .role {
            font-weight: bold;
            color: #3490dc;
            text-transform: capitalize;
            margin-top: 5px;
        }
        .profile-details .logout-btn {
            width: 100%;
            margin-top: 10px;
            background: #dc3545; /* Red color */
            color: white;
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            transition: background 0.2s;
        }
        .profile-details .logout-btn:hover {
            background: #c82333;
        }


        /* Alerts need contrasting background */
        .alert { background-color: rgba(255, 255, 255, 0.8); color: black; border-color: rgba(0, 0, 0, 0.2); }
        .alert * { color: black !important; }

        /* Optional: Cleanup for layout */
        .min-h-screen { min-height: 100vh; }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="navbar">
        <div class="navbar-content">
            
            @auth
                {{-- CONTENT FOR LOGGED-IN USERS (Full Navigation and Profile) --}}
                <a href="/dashboard" class="navbar-brand">
                    Check-in System
                </a>
                <div style="display: flex; align-items: center;">
                    <div class="nav-links">
                        <button onclick="window.location.href='/dashboard'" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</button>
                        <button onclick="window.location.href='{{ route('properties.index') }}'" class="{{ request()->routeIs('properties.*', 'questions.*', 'answers.*') ? 'active' : '' }}">Properties</button>
                        <button onclick="window.location.href='{{ route('instruction-pages.index') }}'" class="{{ request()->routeIs('instruction-pages.*', 'steps.*') ? 'active' : '' }}">Instructions</button>
                        <button onclick="window.location.href='{{ route('guests.index') }}'" class="{{ request()->routeIs('guests.*') && !request()->routeIs('guest.checkin') ? 'active' : '' }}">Guests</button>
                        
                        {{-- User Management Link (Based on prior RBAC implementation) --}}
                        @if (Auth::user()->role === 'admin')
                            <button onclick="window.location.href='{{ route('admin.users.index') }}'" class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">Users</button>
                        @endif
                    </div>

                    <div class="profile-dropdown">
                        <div class="profile-icon" title="Logged in as {{ Auth::user()->name }}">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="profile-details">
                            <p>Hi, **{{ Auth::user()->name }}**</p>
                            <p class="role">Role: {{ ucfirst(Auth::user()->role) }}</p>
                            <p style="font-size: 0.8em; opacity: 0.7;">{{ Auth::user()->email }}</p>
                            
                            <form method="POST" action="{{ route('logout') }}" style="margin-top: 10px;">
                                @csrf
                                <button type="submit" class="logout-btn">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                {{-- CONTENT FOR PUBLIC/GUEST USERS (Simplified Navigation) --}}
                <a href="{{ route('login') }}" class="navbar-brand">
                    Check-in System
                </a>
                <div class="nav-links">
                    <a href="{{ route('login') }}" class="active">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                </div>
            @endauth
        </div>
    </div>
    
    <div class="container">
        {{-- Messages and Error handling --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('status'))
            <div class="alert" style="color: #155724; background-color: #d4edda; border-color: #c3e6cb;">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert" style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        {{-- Page Content Injection --}}
        <main>
            {{-- FIX: Use $slot for Auth views, and @yield('content') for custom views --}}
            @isset($slot)
                {{ $slot }}
            @endisset
            
            @yield('content') 
        </main>
    </div>

    {{-- JavaScript for Sticky Scroll Animation (Keep at end of body) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');
            
            function toggleNavbarScroll() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
            toggleNavbarScroll();
            window.addEventListener('scroll', toggleNavbarScroll);
        });
    </script>
</body>
</html>