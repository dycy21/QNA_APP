@extends('layouts.app')

@section('header_title', 'Define New Instruction Page')

@section('content')
    <div class="card" style="padding: 30px; max-width: 600px; margin: 30px auto;">
        <h2 class="gradient-text" style="margin-bottom: 25px;">Create New Instruction Page Details</h2>
        
        {{-- Form submits to InstructionPageController@store --}}
        <form action="{{ route('instruction-pages.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="title">Page Title:</label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}">
                @error('title') <p style="color: red; margin-top: 5px;">{{ $message }}</p> @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Introduction:</label>
                <textarea name="description" id="description" rows="3">{{ old('description') }}</textarea>
                @error('description') <p style="color: red; margin-top: 5px;">{{ $message }}</p> @enderror
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="glossy-btn success">Create Page</button>
                <a href="{{ route('instruction-pages.index') }}" class="glossy-btn primary" style="background-color: cadetblue;">Cancel</a>
            </div>
        </form>
    </div>
@endsection