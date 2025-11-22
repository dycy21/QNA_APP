@extends('layouts.app')

@section('header_title', 'Check-in Instruction Pages')

@section('content')
    <div class="card" style="padding-bottom: 10px;">
        <h2 class="gradient-text">Instruction Page Library</h2>
        <p style="margin-bottom: 20px;">
            <a href="{{ route('instruction-pages.create') }}" class="glossy-btn success">➕ Create New Instructions</a>
        </p>
        <table>
            <thead>
                <tr>
                    <th>Page Title</th>
                    <th>Introduction Summary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pages as $page)
                    <tr>
                        <td style="font-weight: bold; color: #34495e;">{{ $page->title }}</td>
                        <td style="font-weight: bold; color: #34495e;">{{ Str::limit($page->description, 70) ?? 'No description.' }}</td>
                        <td style="white-space: nowrap;">
                            {{-- Link 1: View Steps (Read-Only) --}}
                            <a href="{{ route('instruction-pages.show', $page) }}" class=" glossy-btn primary" style="padding: 5px 10px; margin-right: 5px; background-color: #3498db;">View</a>
                            
                            {{-- Link 2: Edit Steps (Admin Management) --}}
                            <a href="{{ route('instruction-pages.edit', $page) }}" class="glossy-btn success" style="padding: 5px 10px; background-color: #2ecc71;">Edit</a>

                        </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #777;">No instruction pages found. Click above to create one!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
    </div>
    
    <a href="/dashboard" class="button: glossy-btn primary" style="margin-top: 20px;">Back to Dashboard</a>
@endsection