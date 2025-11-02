@extends('layouts.app')

@section('header_title', 'Property Management')

@section('content')
    <h2>Property List</h2>
    <p><a href="{{ route('properties.create') }}" class="btn">Add New Property</a></p>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($properties as $property)
                <tr>
                    <td>{{ $property->name }}</td>
                    <td>{{ $property->address ?? 'N/A' }}</td>
                    <td>{{ $property->created_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No properties found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <tr>
    <td>
        @if ($property->question)
            <a href="{{ route('questions.show', $property->question) }}" class="btn" style="padding: 5px 10px; background-color: #38c172;">Manage Q&A</a>
        @else
            <a href="{{ route('properties.questions.create', $property) }}" class="btn" style="padding: 5px 10px; background-color: #ffc107;">Add Question</a>
        @endif
    </td>
    </tr>
    
    <hr>
    <h3><a href="{{ route('guests.index') }}">Go to Guest Bookings</a></h3>
@endsection