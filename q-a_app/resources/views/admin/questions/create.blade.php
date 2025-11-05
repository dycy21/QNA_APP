@extends('layouts.app')

@section('header_title', 'Add Check-in Question')

@section('content')
    <h2>Add Check-in Question for: {{ $property->name }}</h2> 
    <p>This is the question the guest will see on their check-in date.</p>
    
    <form action="{{ route('properties.questions.store', $property) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="text">Question Text:</label>
            <input type="text" name="text" id="text" required value="{{ old('text') }}" placeholder="e.g., 'Are you traveling by car?'">
        </div>
        
        <button type="submit" class="glossy-btn primary">Save Question & Add Answers</button>
        <a href="{{ route('properties.index') }}" class="glossy-btn submit" style="background-color: #6c757d;">Cancel</a>
    </form>
@endsection