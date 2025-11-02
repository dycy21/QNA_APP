@extends('layouts.app')

@section('header_title', 'Welcome, ' . $guest->name)

@section('content')
    <h2 style="color: #3490dc;">Check-in for {{ $guest->property->name }}</h2>
    
    <p>
        **Your Booking:** {{ $guest->property->name }} <br>
        **Check-in Date:** <span style="font-weight: bold; color: #38c172;">{{ $guest->check_in_date->format('F j, Y') }}</span>
    </p>

    <h3>1. Confirm Your Details & Upload ID</h3>
    <form action="{{ route('guest.update', $guest) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Name:</label>
            <p style="font-weight: bold;">{{ $guest->name }}</p>
        </div>

        <div class="form-group">
            <label for="email">Email (Edit if needed):</label>
            <input type="email" name="email" id="email" value="{{ old('email', $guest->email) }}">
        </div>
        
        <div class="form-group">
            <label for="phone">Phone (Edit if needed):</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $guest->phone) }}">
        </div>
        
        <div class="form-group">
            <label for="id_photo">Upload Government ID Photo (Passport/Driver's License):</label>
            <input type="file" name="id_photo" id="id_photo">
            @if ($guest->idPhoto)
                <p style="color: #38c172; margin-top: 5px;">✅ ID Photo already uploaded.</p>
            @endif
        </div>
        
        <button type="submit" class="btn">Update & Save Details</button>
    </form>

    <hr>
    <h3>2. Check-in Instructions</h3>

    @if (!$isCheckInDayOrPast)
        <div style="border: 2px solid #ffc107; padding: 20px; border-radius: 5px; background-color: #fff3cd;">
            <p style="font-weight: bold; color: #856404;">
                Thank you! Please come back to this page on your check-in date 
                ({{ $guest->check_in_date->format('F j, Y') }}) for your check-in instructions.
            </p>
        </div>

    @elseif (!$guest->info_updated)
        <div style="border: 2px solid #ffc107; padding: 20px; border-radius: 5px; background-color: #fff3cd;">
            <p style="color: #856404; font-weight: bold;">
                You are checked-in! Please **complete Step 1 (Update Details/Upload ID)** above before proceeding to instructions.
            </p>
        </div>

    @elseif (!$question)
        <div style="border: 2px solid #ffc107; padding: 20px; border-radius: 5px; background-color: #fff3cd;">
            <p style="color: #856404; font-weight: bold;">
                Welcome! There are no specific instructions required for your booking. Please contact the property manager if you need immediate assistance.
            </p>
        </div>

    @else
        <div style="border: 2px solid #38c172; padding: 20px; border-radius: 5px; background-color: #e6ffed;">
            <p style="font-weight: bold; color: #155724;">🎉 Your check-in is today! Please answer the question below to get your final instructions.</p>
            
            <form action="{{ route('guest.answer', $guest) }}" method="POST">
                @csrf
                <p>
                    <strong style="font-size: 1.2em;">{{ $question->text }}</strong>
                </p>
                
                @foreach ($question->answers as $answer)
                    <button 
                        type="submit" 
                        name="answer_id" 
                        value="{{ $answer->id }}" 
                        class="btn btn-success" 
                        style="margin-right: 10px; margin-top: 10px;">
                        {{ $answer->text }}
                    </button>
                @endforeach
            </form>
        </div>
    @endif
    
    

@endsection