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
        
        <div style="padding-bottom: 10px;" class="form-group">
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
            <small></small>
        </div>

        <button type="submit" class="glossy-btn success">Save Answer & Link</button>
        <a href="{{ route('questions.show', $question) }}" class="glossy-btn" style="background-color: #3490dc;">Cancel</a>
    </form>
@endsection