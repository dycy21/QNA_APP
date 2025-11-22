@extends('layouts.app')

@section('header_title', 'Add Step to: ' . $instructionPage->title)

@section('content')
    <h2>Add New Step (Step #{{ $nextOrder }})</h2>
    
    <form action="{{ route('instruction-pages.steps.store', $instructionPage) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="order">Step Order:</label>
            <input type="number" name="order" id="order" required min="1" value="{{ old('order', $nextOrder) }}">
            <small>This determines the order the steps appear in.</small>
        </div>

        <div class="form-group">
            <label for="heading">Step Heading/Title:</label>
            <input type="text" name="heading" id="heading" required value="{{ old('heading') }}">
        </div>

        <div class="form-group">
            <label for="content">Step Instructions/Content:</label>
            <textarea name="content" id="content" rows="6" required>{{ old('content') }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Step Image (Optional, Max 5MB):</label>
            <input type="file" name="image" id="image" accept="image/*">
        </div>
        
        <button type="submit" class="glossy-btn success">Save Step</button>
        <a href="{{ route('instruction-pages.show', $instructionPage) }}" class="glossy-btn primary" style="background-color: #6c757d;">Cancel</a>
    </form>
@endsection