@extends('layouts.app')

@section('header_title', 'Welcome, ' . $guest->name)

@section('content')
    <h2 class="text-primary mb-4">Check-in for {{ $guest->property->name }}</h2>
    
    <div class="mb-4 p-3 bg-light border rounded">
        <p class="mb-0">
            **Your Booking:** {{ $guest->property->name }} <br>
            **Check-in Date:** <span class="fw-bold text-success">{{ $guest->check_in_date->format('F j, Y') }}</span>
        </p>
    </div>

    <div class="card shadow-sm mb-5">
        <div class="card-header bg-info text-white">
            <h3 class="h5 mb-0">1. Confirm Your Details & Upload ID</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('guest.update', $guest) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <p class="fw-bold">{{ $guest->name }}</p>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email (Edit if needed):</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $guest->email) }}">
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone (Edit if needed):</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $guest->phone) }}">
                </div>
                
                <div class="mb-3">
                    <label for="id_photo" class="form-label">Upload Government ID Photo:</label>
                    <input type="file" name="id_photo" id="id_photo" class="form-control" accept="image/*">
                    @if ($guest->idPhoto)
                        <p class="text-success mt-1"><i class="bi bi-check-circle-fill"></i> ID Photo already uploaded.</p>
                    @endif
                </div>
                
                <button type="submit" class="btn btn-primary">Update & Save Details</button>
            </form>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h3 class="h5 mb-0">2. Check-in Instructions</h3>
        </div>
        <div class="card-body">

            @if (!$isCheckInDayOrPast)
                <div class="alert alert-warning">
                    <p class="fw-bold mb-0">
                        Thank you! Please come back to this page on your check-in date 
                        ({{ $guest->check_in_date->format('F j, Y') }}) for your instructions.
                    </p>
                </div>

            @elseif (!$guest->info_updated)
                <div class="alert alert-warning">
                    <p class="fw-bold mb-0">
                        You are checked-in! Please **complete Step 1 (Update Details/Upload ID)** above before proceeding.
                    </p>
                </div>

            @elseif (!$question)
                <div class="alert alert-info">
                    <p class="fw-bold mb-0">
                        Welcome! No specific instructions required.
                    </p>
                </div>

            @else
                <div class="alert alert-success">
                    <p class="fw-bold mb-2">🎉 Your check-in is today! Please answer the question below:</p>
                    
                    <form action="{{ route('guest.answer', $guest) }}" method="POST">
                        @csrf
                        <p class="fs-5 fw-bold text-primary">{{ $question->text }}</p>
                        
                        @foreach ($question->answers as $answer)
                            <button 
                                type="submit" 
                                name="answer_id" 
                                value="{{ $answer->id }}" 
                                class="btn btn-outline-success me-2 mt-2">
                                {{ $answer->text }}
                            </button>
                        @endforeach
                    </form>
                </div>
            @endif

        </div>
    </div>
@endsection