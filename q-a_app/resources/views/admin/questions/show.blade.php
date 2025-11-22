@extends('layouts.app')

@section('header_title', 'Manage Q&A: ' . $property->name)

@section('content')
    <h2>Check-in Question for {{ $property->name }}:</h2>
    <h3 style="color: #086b5eff">{{ $question->text }}</h3>
    
    <hr>
    
    <h3>Linked Answers</h3>
    <p>
        <a href="{{ route('questions.answers.create', $question) }}"  class="glossy-btn primary">➕ Add New Answer Option</a>
    </p>

    <table>
        <thead>
            <tr>
                <th>Answer Text</th>
                <th>Redirects To Instruction Page</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($question->answers as $answer)
                <tr>
                    <td>{{ $answer->text }}</td>
                    <td>
                        @if ($answer->instructionPage)
                            <a href="{{ route('instruction-pages.show', $answer->instructionPage) }}" style="color: #38c172; font-weight: bold;">
                                {{ $answer->instructionPage->title }}
                            </a>
                        @else
                            <span style="color: red;">ERROR: No Page Linked!</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No answers defined yet. You must add at least two answers to give the guest a choice.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <hr>


    <a href="{{ route('properties.index') }}"  class="glossy-btn success" style="background-color: cadetblue; padding-top: 5px;">Back to Properties</a>
@endsection