@extends('layouts.app')

@section('header_title', 'Check-in Instruction Pages')

@section('content')
    <div class="glossy-card">
        <h2 class="gradient-text">Instruction Pages List</h2>
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
                            <a href="{{ route('instruction-pages.show', $page) }}" class="glossy-btn primary" style="padding: 5px 10px;">View Steps</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: yellow;">No instruction pages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <hr style="border-top: 1px solid rgba(255, 255, 255, 0.5);">
    <a href="/dashboard" class="glossy-btn">Back to Dashboard</a>
@endsection