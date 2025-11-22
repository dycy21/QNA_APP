@extends('layouts.app')

@section('header_title', 'Guest Details: ' . $guest->name)

@section('content')
    <div class="glossy-card">
        <h2 class="gradient-text" style="margin-bottom: 25px;">Booking Details for {{ $guest->name }}</h2>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            
            {{-- COLUMN 1: Booking & Contact Info --}}
            <div>
                <h3 style="border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding-bottom: 5px;">Booking & Contact</h3>
                <p><strong>Property:</strong> {{ $guest->property->name }}</p>
                <p><strong>Check-in:</strong> {{ $guest->check_in_date->format('M j, Y') }}</p>
                <p><strong>Check-out:</strong> {{ $guest->check_out_date->format('M j, Y') }}</p>
                <p><strong>Email:</strong> {{ $guest->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $guest->phone ?? 'N/A' }}</p>
                <p><strong>Magic Link:</strong> <a href="{{ route('guest.checkin', $guest->magic_link_token) }}" style="color: lightseagreen;">View Check-in Page</a></p>
            </div>
            
            {{-- COLUMN 2: Status & Compliance --}}
            <div>
                <h3 style="border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding-bottom: 5px;">Compliance & Status</h3>
                
                <p><strong>Info Updated:</strong> 
                    <span style="color: {{ $guest->info_updated ? 'green' : 'red' }}; font-weight: bold;">
                        {{ $guest->info_updated ? 'Yes' : 'Pending' }}
                    </span>
                </p>

                <p><strong>ID Photo Status:</strong>
                    @if ($guest->idPhoto)
                        <span style="color: #2b5da8ff; font-weight: bold;">Uploaded!</span>
                        <br>
                        <a href="{{ Storage::url($guest->idPhoto->file_path) }}" target="_blank" class="glossy-btn success" style="padding: 5px 10px; font-size: 0.8em; margin-top: 5px;">View ID Scan</a>
                    @else
                        <span style="color: green ; font-weight: bold;">Not Uploaded</span>
                    @endif
                </p>

                <h4 style="margin-top: 20px;">Final Instructions</h4>
                @if ($guest->answer)
                    <p><strong>Answer Selected:</strong> {{ $guest->answer->text }}</p>
                    <p><strong>Redirect Page:</strong> 
                        <a href="{{ route('instruction-pages.show', $guest->answer->instructionPage) }}" style="color: #ffc107;">
                            {{ $guest->answer->instructionPage->title }}
                        </a>
                    </p>
                @else
                    <p>Awaiting guest response to check-in question.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="{{ route('guests.index') }}" class="glossy-btn primary">← Back to Guest List</a>
    </div>
@endsection