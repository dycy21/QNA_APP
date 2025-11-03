@extends('layouts.app')

@section('header_title', 'Check-in Instruction Pages')

@section('content')
    <h2>Instruction Pages List</h2>
    <p><a href="{{ route('instruction-pages.create') }}" class="glossy-btn success">Create New Page</a></p>

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
                        <a href="{{ route('instruction-pages.show', $page) }}"  class="glossy-btn primary" style="padding: 5px 10px; background-color: #ae9fb8ff;">View Steps</a>
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
        <a href="{{ route('properties.index') }}" class="glossy-btn primary">Properties</a> | 
        <a href="{{ route('guests.index') }}" class="glossy-btn success">Guests</a>
    </p>
@endsection