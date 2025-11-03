@extends('layouts.app')

@section('header_title', 'Admin Overview')

@section('content')
    <h2>System Overview and Quick Access</h2>
    
    <div style="text-align: center; margin-bottom: 40px;">
        <a href="{{ route('properties.index') }}" class="glossy-btn primary">Manage Properties</a>
        <a href="{{ route('instruction-pages.index') }}" class="glossy-btn success">Manage Instructions</a>
        <a href="{{ route('guests.index') }}" class="glossy-btn primary">Manage Guest Bookings</a>
    </div>

    <h3 style="margin-bottom: 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding-bottom: 10px;">Properties Setup Status</h3>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
        @forelse ($properties as $property)
            @php
                // Link property card to Q&A setup or Q&A management
                $link = $property->question 
                    ? route('questions.show', $property->question) 
                    : route('properties.questions.create', $property);
            @endphp

            <a href="{{ $link }}" style="text-decoration: none; color: inherit;">
                <div class="glossy-card" style="padding: 25px; min-height: 180px; transition: transform 0.2s; cursor: pointer;">
                    <style>
                        /* Inline style block to apply hover effect reliably */
                        .glossy-card:hover { transform: translateY(-5px); box-shadow: 0 12px 40px 0 rgba(0, 0, 0, 0.4); }
                    </style>

                    <h4 style="color: yellow; margin-bottom: 10px;">{{ $property->name }}</h4>
                    <p style="opacity: 0.8; font-size: 0.9em;">{{ $property->address ?? 'Address not specified.' }}</p>

                    <p style="margin-top: 15px;">
                        <strong style="color: {{ $property->question ? '#38c172' : '#ffc107' }};">
                            Status: {{ $property->question ? 'Q&A Active' : 'Q&A Missing' }}
                        </strong>
                    </p>
                </div>
            </a>
        @empty
             <div class="glossy-card" style="grid-column: 1 / -1; text-align: center; background-color: rgba(255, 255, 255, 0.25);">
                <p>No properties found. Please <a href="{{ route('properties.create') }}" class="glossy-btn primary" style="padding: 5px 10px; margin-left: 10px;">Add Your First Property</a>.</p>
             </div>
        @endforelse
    </div>

    <h3 style="margin-top: 40px; border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding-bottom: 10px;">Key Metrics</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px;">
        
        @php
            $stat_links = [
                'total_guests' => route('guests.index'),
                'total_properties' => route('properties.index'),
                'checking_in_today' => route('guests.index'), 
                'upcoming_check_ins' => route('guests.index'),
                'info_incomplete' => route('guests.index'), 
            ];
        @endphp

        @foreach ($stats as $key => $value)
            @php
                $link = $stat_links[$key] ?? '#';
            @endphp
            
            <a href="{{ $link }}" style="text-decoration: none; color: inherit;">
                <div class="glossy-card" style="text-align: center; padding: 20px; border-radius: 15px; transition: transform 0.2s; cursor: pointer;">
                     <style>
                        .glossy-card:hover { transform: translateY(-5px); box-shadow: 0 12px 40px 0 rgba(0, 0, 0, 0.4); }
                    </style>
                    <h4 style="font-size: 2em; margin-bottom: 5px;">{{ $value }}</h4>
                    <p style="text-transform: capitalize; opacity: 0.8; font-size: 0.9em;">{{ str_replace('_', ' ', $key) }}</p>
                </div>
            </a>
        @endforeach
    </div>
@endsection