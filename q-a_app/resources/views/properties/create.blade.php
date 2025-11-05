@extends('layouts.app')

@section('header_title', 'Create New Property')

@section('content')
    <div class="glossy-card">
        <h2>Create Property</h2>
        <form action="{{ route('properties.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Property Name:</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="address">Address (Optional):</label>
                <textarea name="address" id="address">{{ old('address') }}</textarea>
            </div>
            <button type="submit" class="glossy-btn success">Save Property</button>
            <a href="{{ route('properties.index') }}" class="glossy-btn primary">Cancel</a>
        </form>
    </div>
@endsection