@extends('layouts.app')

@section('header_title', 'Property Management')

@section('content')
    <div class="glossy-card">
        <h2>Property List</h2>
        
        {{-- 🛑 Only Admins can create new properties 🛑 --}}
        @if (Auth::user()->role === 'admin')
            <p><a href="{{ route('properties.create') }}" class="glossy-btn success">Add New Property</a></p>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Q&A Setup</th>
                    {{-- Only show Delete column if user is an admin --}}
                    @if (Auth::user()->role === 'admin')
                        <th>Delete</th> 
                    @endif
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

                        {{-- 🛑 Only show Delete button if user is an admin 🛑 --}}
                        @if (Auth::user()->role === 'admin')
                            <td>
                                <form action="{{ route('properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this property?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="glossy-btn" style="background: rgba(255, 0, 0, 0.7); padding: 5px 10px;">Delete</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ Auth::user()->role === 'admin' ? '4' : '3' }}">No properties found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <hr style="border-top: 1px solid rgba(255, 255, 255, 0.5);">
    <h3><a href="/dashboard" class="glossy-btn primary">Back to Dashboard</a></h3>
@endsection