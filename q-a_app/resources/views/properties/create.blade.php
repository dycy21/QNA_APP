@extends('layouts.app')

@section('header_title', 'Create New Property')

@section('content')
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
        <button type="submit" class="btn btn-success">Save Property</button>
        <a href="{{ route('properties.index') }}" class="btn" style="background-color: #6c757d;">Cancel</a>
    </form>
@endsection

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
        
        <button type="submit" class="btn btn-success">Save Question & Add Answers</button>
        <a href="{{ route('properties.index') }}" class="btn" style="background-color: #6c757d;">Cancel</a>
    </form>
@endsection
@extends('layouts.app')

@section('header_title', 'Add Answer for Question')

@section('content')
    <h2>Add Answer Option for:</h2>
    <p style="font-weight: bold; color: #3490dc;">{{ $question->text }}</p>

    <form action="{{ route('questions.answers.store', $question) }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="text">Answer Text (What the guest sees):</label>
            <input type="text" name="text" id="text" required value="{{ old('text') }}" placeholder="e.g., 'Yes, I have a large van.'">
        </div>
        
        <div class="form-group">
            <label for="instruction_page_id">Redirect Guest to this Instruction Page:</label>
            <select name="instruction_page_id" id="instruction_page_id" required>
                <option value="">-- Select a Target Page --</option>
                @foreach ($instructionPages as $page)
                    <option value="{{ $page->id }}" {{ old('instruction_page_id') == $page->id ? 'selected' : '' }}>
                        {{ $page->title }}
                    </option>
                @endforeach
            </select>
            @error('instruction_page_id')<small style="color:red;">{{ $message }}</small>@enderror
            <small>This page contains the steps/images for this specific scenario.</small>
        </div>

        <button type="submit" class="btn btn-success">Save Answer & Link</button>
        <a href="{{ route('questions.show', $question) }}" class="btn" style="background-color: #6c757d;">Cancel</a>
    </form>
@endsection