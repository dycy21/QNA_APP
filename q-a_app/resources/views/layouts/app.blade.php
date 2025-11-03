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
        color: blueviolet; /* 🛑 MAJOR CHANGE: Default text color set to white */
    }
    .container { max-width: 960px; margin: 40px auto; padding: 20px; }
    .header { 
        /* Slightly transparent header bar */
        background: rgba(184, 24, 224, 0.9); 
        color: wheat; 
        padding: 15px; 
        text-align: center; 
        margin-bottom: 20px; 
        border-radius: 12px 12px 0 0;
    }
    
    /* 2. Dynamic Glossy Background (Unchanged) */
    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #d0abe6ff 0%, #8b0dc5ff 100%);
        opacity: 0.9;
        z-index: -2;
    }
    .container, .glossy-card {
        /* Frosted Glass Effect (Unchanged) */
        background-color: rgba(255, 255, 255, 0.15); 
        backdrop-filter: blur(10px); 
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2); 
    }

    /* 3. Glossy Transparent Cards */
    .glossy-card {
        padding: 20px;
        margin-bottom: 20px;
    }
    
    /* 4. Glossy Transparent Buttons */
    .btn, .glossy-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 25px; 
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-weight: bold;
        transition: all 0.3s ease;
        
        background: rgba(255, 255, 255, 0.2);
        color: white; 
        border: 1px solid rgba(255, 255, 255, 0.4);
        text-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }
    .glossy-btn:hover {
        background: rgba(255, 255, 255, 0.4);
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.8), 0 0 5px rgba(0, 0, 0, 0.5); 
        transform: translateY(-2px);
    }
    .glossy-btn.primary {
        background: rgba(52, 144, 220, 0.8); 
    }
    .glossy-btn.success {
        background: rgba(56, 193, 114, 0.8); 
    }

    /* 5. Forms and Tables */
    .form-group { margin-bottom: 15px; }
    /* Labels inherit body color (white) */
    .form-group label { display: block; margin-bottom: 5px; font-weight: bold; } 
    .form-group input, .form-group select, .form-group textarea { 
        width: 100%; padding: 10px; box-sizing: border-box; 
        background: rgba(0, 0, 0, 0.2); /* Darker transparent input background */
        border: 1px solid rgba(255, 255, 255, 0.5); 
        color: wheat; /* 🛑 Input text color set to white */
        border-radius: 8px;
    }
    table { width: 100%; border-collapse: separate; border-spacing: 0; } 
    th, td { border: none; padding: 12px; text-align: left; }
    th { background-color: rgba(0, 0, 0, 0.3); color: white; }
    
    /* 6. Alerts need contrasting background */
    .alert { background-color: rgba(255, 255, 255, 0.8); color: black; border-color: rgba(0, 0, 0, 0.2); }
    /* Ensure content inside alerts is legible */
    .alert * { color: black !important; }
</style>
    {{-- Removed @vite directives --}}
</head>
<body>
    <div class="header">
        <h1>@yield('header_title', 'Admin Panel')</h1>
        {{-- You could add a simple header nav here if needed, linking to Properties, Guests, etc. --}}
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
        
        
        @yield('content') 
        
    </div>
    {{-- Removed Bootstrap JS script tag --}}
</body>
</html>