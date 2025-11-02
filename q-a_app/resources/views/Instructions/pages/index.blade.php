@extends('layouts.app')

@section('header_title', 'Check-in Instruction Pages')

@section('content')
    <h2>Instruction Pages List</h2>
    <p><a href="{{ route('instruction-pages.create') }}" class="btn">Create New Page</a></p>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pages as $page)
                <tr>
                    <td>{{ $page->title }}</td>
                    <td>{{ Str::limit($page->description, 50) ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('instruction-pages.show', $page) }}" class="btn" style="padding: 5px 10px; background-color: #ffc107;">View Steps</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No instruction pages found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <hr>
    <p>Admin Navigation: 
        <a href="{{ route('properties.index') }}">Properties</a> | 
        <a href="{{ route('guests.index') }}">Guests</a>
    </p>
@endsection