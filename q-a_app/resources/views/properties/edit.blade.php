@extends('layouts.app')

@section('header_title', 'Edit Property: ' . $property->name)

@section('content')
    <div class="glossy-card">
        <h2 class="gradient-text">Edit Property: {{ $property->name }}</h2>
        
        <form action="{{ route('properties.update', $property) }}" method="POST">
            @csrf
            @method('PUT') {{-- Required for the UPDATE route --}}
            
            <div class="form-group">
                <label for="name">Property Name:</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $property->name) }}">
            </div>
            <div class="form-group">
                <label for="address">Address (Optional):</label>
                <textarea name="address" id="address">{{ old('address', $property->address) }}</textarea>
            </div>
            <button type="submit" class="glossy-btn success">Save Changes</button>
            <a href="{{ route('properties.show', $property) }}" class="glossy-btn">Cancel</a>
        </form>
    </div>
@endsection