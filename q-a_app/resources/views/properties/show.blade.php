@extends('layouts.app')

@section('header_title', 'Property Details: ' . $property->name)

@section('content')
    <div class="glossy-card" style="padding: 30px;">
        <h2 class="gradient-text" style="margin-bottom: 25px;">{{ $property->name }}</h2>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <p style="font-size: 1.1em; opacity: 0.9;">**Address:** {{ $property->address ?? 'Address not set.' }}</p>

            {{-- EDIT BUTTON --}}
            <a href="{{ route('properties.edit', $property) }}" class="glossy-btn primary" style="padding: 8px 20px;">
                Edit Details
            </a>
        </div>
        
        <h3 style="border-bottom: 1px solid rgba(255, 255, 255, 0.5); padding-bottom: 5px; margin-top: 30px;">
            Check-in Configuration
        </h3>
        
        @if ($property->question)
            <p><strong>Status:</strong> <span style="color: #38c172; font-weight: bold;">Q&A is Active</span></p>
            <p><strong>Question:</strong> {{ $property->question->text }}</p>
            <a href="{{ route('questions.show', $property->question) }}" class="glossy-btn success" style="padding: 5px 10px;">Manage Q&A Logic</a>
        @else
            <p><strong>Status:</strong> <span style="color: darkslategray; font-weight: bold;">Q&A Setup Pending</span></p>
            <a href="{{ route('properties.questions.create', $property) }}" class="glossy-btn primary" style="padding: 5px 10px;">Setup Check-in Question</a>
        @endif

    </div>
    
    <div style="margin-top: 20px;">
        <a href="{{ route('properties.index') }}" class="glossy-btn">← Back to Property List</a>
    </div>
@endsection