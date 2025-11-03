<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guest Check-in</title>
    <style>
        /* Custom Class for Gradient Headlines */
        .glossy-btn {
        /* ... (other button styles like padding, background, etc.) ... */
           text-decoration: none; 
        }
        /* 1. Base Reset & Layout */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #57066bff; 
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
            background: linear-gradient(135deg, #d09ee6ff 0%, #590274ff 100%);
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

       /* 3. Navigation Bar Styling (Updated for Sticky and Animation) */
        .navbar {
            background: rgba(102, 6, 121, 0.95); 
            padding: 15px 0;
            margin-bottom: 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            
            /* CSS for STICKINESS: Scrolls naturally until it hits the top  */
            position: sticky;
            top: 0;
            z-index: 1000;
            
            /* Transition for smooth animation */
            transition: padding 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
        }
        
        /*  Class for Shrinking/Animation on Scroll (Popping Up Effect)  */
        .navbar.scrolled {
            padding: 8px 0; /* Shrink the vertical padding */
            background: rgba(102, 6, 121, 0.95); /* Slightly less transparent when scrolling */
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5); /* Pop-up visual emphasis */
        }
        
        .navbar-content {
            max-width: 960px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar-brand {
            font-size: 1.5em;
            font-weight: bold;
            color: white;
            text-decoration: none;
            margin-right: 20px;
            /* Transition for smooth shrinking of the logo text */
            transition: font-size 0.3s ease;
        }
        .navbar.scrolled .navbar-brand {
             font-size: 1.2em; /* Shrink the logo size when scrolling */
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 20px;
            transition: background 0.2s;
        }
        .nav-links a:hover, .nav-links a.active {
            background: rgba(255, 255, 255, 0.2);
        }
        .nav-links a, .nav-links button {
        /* Inherit base button styles for non-underline, rounded corners */
        border: none;
        border-radius: 20px;
        transition: all 0.2s ease-in-out; /* Match glossy-btn transition */
        
        /* Ensure cursor pointer is set for better feedback */
        cursor: pointer; 
    }
    
    /* Apply the pop-out and glow effect on hover */
    .nav-links a:hover, 
    .nav-links button:hover,
    .nav-links a.active, 
    .nav-links button.active {
        /* Apply the same scale and shadow as the glossy buttons */
        transform: scale(1.05); 
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.8), 0 5px 10px rgba(0, 0, 0, 0.5); 
        background: rgba(255, 255, 255, 0.3);
        text-shadow: 0 0 8px rgba(255, 255, 255, 1); /* Slightly brighter background */
    }
        
        /* 4. Glossy Transparent Buttons and Forms */
        .glossy-card { padding: 20px; margin-bottom: 20px; }
        .btn, .glossy-btn {
            padding: 10px 20px; border-radius: 25px; cursor: pointer;
            background: rgba(255, 255, 255, 0.2); color: white; 
            border: 1px solid rgba(255, 255, 255, 0.4); text-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }
        
        /* 4. Glossy Transparent Buttons (UPDATED FOR POP-OUT EFFECT) */
    .btn, .glossy-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 25px; 
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-weight: bold;
        transition: all 0.2s ease-in-out; /* 🛑 Shorter transition for snappier pop-out */
        
        background: rgba(255, 255, 255, 0.2);
        color: white; 
        border: 1px solid rgba(255, 255, 255, 0.4);
        text-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }
    
    .glossy-btn:hover {
        background: rgba(255, 255, 255, 0.4);
        /* 🛑 POP-OUT EFFECT: Scale up slightly */
        transform: scale(1.05); 
        /* 🛑 GLOW EFFECT: Stronger shadow for visual punch */
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.9), 0 5px 15px rgba(0, 0, 0, 0.6); 
    }
        .glossy-btn.primary { background: rgba(52, 144, 220, 0.8); }
        .glossy-btn.success { background: rgba(56, 193, 114, 0.8); }

        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; } 
        .form-group input, .form-group select, .form-group textarea { 
            width: 100%; padding: 10px; box-sizing: border-box; 
            background: rgba(202, 198, 198, 0.2); color: rgba(41, 3, 58, 0.95); border-radius: 8px;
        }
        table { width: 100%; border-collapse: separate; border-spacing: 0; } 
        th, td { border: none; padding: 12px; text-align: left; color: white; }
        th { background-color: rgba(99, 6, 107, 1); }

        /* Alerts need contrasting background */
        .alert { background-color: rgba(255, 255, 255, 0.8); color: black; border-color: rgba(0, 0, 0, 0.2); }
        .alert * { color: black !important; }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');
            
            function toggleNavbarScroll() {
                // If scroll position is more than 50 pixels from the top
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }

            // Ensure the function runs on load and scroll
            toggleNavbarScroll();
            window.addEventListener('scroll', toggleNavbarScroll);
        });
    </script>
</head>
<body>
    <div class="navbar">
        <div class="navbar-content">
            <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
                Check-in System
            </a>
            <div class="nav-links">
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                {{-- Properties (Includes Q&A Setup) --}}
                <a href="{{ route('properties.index') }}" class="{{ request()->routeIs('properties.*', 'questions.*', 'answers.*') ? 'active' : '' }}">
                    Properties
                </a>
                {{-- Instructions (Content Management) --}}
                <a href="{{ route('instruction-pages.index') }}" class="{{ request()->routeIs('instruction-pages.*', 'steps.*') ? 'active' : '' }}">
                    Instructions
                </a>
                {{-- Guests (Booking & Links) --}}
                <a href="{{ route('guests.index') }}" class="{{ request()->routeIs('guests.*') && !request()->routeIs('guest.checkin') ? 'active' : '' }}">
                    Guests
                </a>
            </div>
        </div>
    </div>
    
    <div class="container">
        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        {{-- Status/Info Message --}}
        @if (session('status'))
            <div class="alert" style="color: #155724; background-color: #d4edda; border-color: #c3e6cb;">{{ session('status') }}</div>
        @endif
        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert" style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        {{-- Page Heading (from old layout, now used for general content title) --}}
        <h1 style="margin-bottom: 20px;">@yield('header_title', 'Admin Content')</h1>
        
        {{-- Page Content --}}
        @yield('content') 
        
    </div>
</body>
</html>