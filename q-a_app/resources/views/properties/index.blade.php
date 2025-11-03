@extends('layouts.app')

@section('header_title', 'Property Management')

@section('content')
    <div class="glossy-card">
        <h2>Property List</h2>
        <p><a href="{{ route('properties.create') }}" class="glossy-btn success">Add New Property</a></p>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Actions</th> 
                </tr>
            </thead>
            <tbody>
                @forelse ($properties as $property)
                    <tr>
                        <td>{{ $property->name }}</td>
                        <td>{{ $property->address ?? 'N/A' }}</td>
                        <td>
                            @if ($property->question)
                                <a href="{{ route('questions.show', $property->question) }}" class="glossy-btn success" style="padding: 5px 10px;">Manage Q&A</a>
                            @else
                                <a href="{{ route('properties.questions.create', $property) }}" class="glossy-btn primary" style="padding: 5px 10px;">Add Question</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No properties found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <hr style="border-top: 1px solid rgba(255, 255, 255, 0.5);">
    <h3><a href="{{ route('guests.index') }}" class="glossy-btn primary">Go to Guest Bookings</a></h3>
@endsection