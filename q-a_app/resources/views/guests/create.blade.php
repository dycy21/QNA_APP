@extends('layouts.app')

@section('header_title', 'Create New Guest Booking')

@section('content')
    <h2>Book a Guest</h2>
    <form action="{{ route('guests.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="property_id">Select Property:</label>
            <select name="property_id" id="property_id" required>
                <option value="">-- Select a Property --</option>
                @foreach ($properties as $property)
                    <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>
                        {{ $property->name }}
                    </option>
                @endforeach
            </select>
            @error('property_id')<small style="color:red;">{{ $message }}</small>@enderror
        </div>

        <div class="form-group">
            <label for="name">Guest Name:</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">
        </div>
        
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
            <label for="check_in_date">Check-in Date:</label>
            <input type="date" name="check_in_date" id="check_in_date" required value="{{ old('check_in_date') }}">
        </div>

        <div class="form-group">
            <label for="check_out_date">Check-out Date:</label>
            <input type="date" name="check_out_date" id="check_out_date" required value="{{ old('check_out_date') }}">
        </div>
        
        <button type="submit" class="glossy-btn success">Create Booking</button>
        <a href="{{ route('guests.index') }}" class="glossy-btn primary" >Cancel</a>
    </form>
@endsection