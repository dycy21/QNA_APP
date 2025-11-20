@extends('layouts.app')

@section('header_title', 'Create New Instruction Page')

@section('content')
    <h2>Define a New Instruction Page</h2>
    <form action="{{ route('instruction-pages.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Page Title (e.g., "Standard Parking Instructions"):</label>
            <input type="text" name="title" id="title" required value="{{ old('title') }}">
        </div>
        <div class="form-group">
            <label for="description">Page Introduction/Description:</label>
            <textarea name="description" id="description" rows="3">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="glossy-btn success">Save Page</button>
        <a href="{{ route('instruction-pages.index') }}"  class="glossy-btn primary" style="background-color: #6c757d;">Cancel</a>
    </form>
@endsection