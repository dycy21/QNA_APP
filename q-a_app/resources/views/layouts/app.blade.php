<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guest Check-in</title>
    <style>
        /* 1. Base Reset, Global Layout, and Colors */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: white; 
            margin: 0; 
            padding-top: 100px; 
            padding-bottom: 40px;
            color: white;
        }
        .container {width: 95%; max-width: 960px; margin: 0 auto; padding: 0 10px; }
        h2, h3 { color:darkslategray; }
        @media (max-width: 768px) {
    /* Hide padding on body for maximum screen space */
    body { padding-top: 50px; } 
    
    /* Ensure navbar contents stack nicely */
    .navbar-content { flex-direction: column; align-items: flex-start; }
    .nav-links { margin-top: 10px; display: flex; flex-wrap: wrap; justify-content: center; }
    .nav-links button, .nav-links a { margin: 2px; }

    /* Make the table responsive by wrapping it */
    .responsive-table-wrapper {
        overflow-x: auto; /* Allows horizontal scrolling of the table */
        width: 100%;
    }
    
    /* Shrink table padding on mobile */
    table th, table td { padding: 8px; font-size: 0.9em; }
}

        /* 2. Dynamic Glossy Background (Adjusted to Grayscale) */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:whitesmoke; 
            opacity: 0.9;
            z-index: -2;
        }

        /* 3. Glass Card Effect */
        .container, .glossy-card {
            background-color: rgba(255, 255, 255, 0.15); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2); 
            color: darkslategray; 
            padding: 40px;
        }

        /* 4. Navigation Bar Styling (Sticky and Animated) */
        .navbar {
            background: #34495e;
            padding: 15px 0;
            margin-bottom: 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            transition: padding 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
        }
        .navbar.scrolled {
            padding: 8px 0; 
            background: #2c3e50; /* Slightly darker when scrolled */
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8); 
        }
        .navbar-content {
            max-width: 960px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;
        }
        .navbar-brand {
            font-size: 1.5em; font-weight: bold; color: #ecf0f1; text-decoration: none; margin-right: 20px; transition: font-size 0.3s ease;
        }
        .navbar.scrolled .navbar-brand {
             font-size: 1.2em;
        }

        /* 5. Navigation Buttons (Crucial for Contrast) */
        .nav-links a, .nav-links button {
            color: white; 
            text-decoration: none; 
            padding: 8px 15px; 
            border-radius: 20px; 
            transition: all 0.2s ease-in-out; 
            cursor: pointer;
            border: none;
            background-color: rgba(26, 188, 156, 0.8); 
            text-shadow: 0 0 3px rgba(0, 0, 0, 0.7); 
        }
        .nav-links a:hover, .nav-links button:hover, .nav-links a.active, .nav-links button.active {
            transform: scale(1.05); 
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.8), 0 5px 10px rgba(0, 0, 0, 0.5); 
            background: rgba(255, 255, 255, 0.3);
            text-shadow: 0 0 10px rgba(255, 255, 255, 1);
        }
        
        /* 6. Glossy Utility Buttons */
        .btn, .glossy-btn {
            padding: 10px 20px; border-radius: 25px; cursor: pointer; text-decoration: none;
            background: rgba(255, 255, 255, 0.2); color: darkslategray; 
            border: 1px solid rgba(255, 255, 255, 0.4); text-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            transition: all 0.2s ease-in-out;
        }
        .glossy-btn:hover {
            transform: scale(1.05); 
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.9), 0 5px 15px rgba(0, 0, 0, 0.6); 
            text-shadow: 0 0 10px rgba(255, 255, 255, 1);
        }
        .glossy-btn.primary { background: rgba(52, 144, 220, 0.8); !important;} 
        .glossy-btn.success { background: rgba(26, 188, 156, 0.8); !important; } /* Teal success for contrast */

        /* 7. Forms and Tables (Contrast within the Card) */
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; } 
        .form-group input, .form-group select, .form-group textarea { 
            width: 100%; padding: 10px; box-sizing: border-box; 
            background: rgba(0, 0, 0, 0.2); /* Darker input background for better visual separation */
            color: darkslategray; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.5);
        }
        table { width: 100%; border-collapse: separate; border-spacing: 0; } 
        th, td { border: none; padding: 12px; text-align: left; color: darkslategray; } /* Table text white */
        th { background-color: rgba(0, 0, 0, 0.3); }

        /* 8. Profile Icon/Dropdown Styling */
        .profile-dropdown { position: relative; cursor: pointer; margin-left: 20px; }
        .profile-icon { 
            height: 35px; width: 35px; background: rgb(29 140 231 / 80%);; color: #eceff5ff; 
            border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.1em; 
        }
        .profile-details {
            display: none; position: absolute; right: 0; top: 45px; min-width: 180px; 
            background-color: #f4f7f9; /* Light background for detail readability */
            backdrop-filter: blur(5px); border-radius: 8px; padding: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); z-index: 1001; 
        }
        .profile-details p, .profile-details .logout-btn { color: #333; } /* Ensure text is dark inside light card */
        .profile-dropdown:hover .profile-details { display: block; }
        .profile-details .logout-btn { background: #e74c3c; color: white; border: none; padding: 8px; border-radius: 4px; cursor: pointer; }

        /* 9. Utility/Layout Cleanup */
        .alert { background-color: rgba(255, 255, 255, 0.8); color: black; border-color: rgba(0, 0, 0, 0.2); border-radius: 6px; }
        .alert * { color: black !important; }
        .min-h-screen { min-height: 100vh; }
        .step-image-container:hover {
         transform: scale(1.05); /* Pop-up effect */
         box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);}

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