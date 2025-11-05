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
                    <th>Q&A Setup</th>
                    <th>Delete</th> 
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

                        <td>
                            <form action="{{ route('properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this property?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="glossy-btn" style="background: rgba(255, 0, 0, 0.7); padding: 5px 10px;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No properties found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div style="margin-top: 20px; text-align: center;">
            {{ $properties->links('pagination::simple-bootstrap-4') }}
            <p style="opacity: 0.7; font-size: 0.9em; margin-top: 10px;">
                Showing {{ $properties->firstItem() }} to {{ $properties->lastItem() }} of {{ $properties->total() }} properties
            </p>
        </div>
        
    </div> 
    
    <hr style="border-top: 1px solid rgba(255, 255, 255, 0.5);">
    <h3><a href="/dashboard" class="glossy-btn primary">Back to Dashboard</a></h3>
@endsection