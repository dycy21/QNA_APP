@extends('layouts.app')

@section('header_title', 'User Role Management')

@section('content')
    <div class="glossy-card">
        <h2 class="gradient-text">Manage User Roles</h2>
        <p style="opacity: 0.8;">Use this page to view current user roles and adjust permissions.</p>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Current Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        
                        {{-- Form handles the role update --}}
                        <form method="POST" action="{{ route('admin.users.update', $user) }}">
                            @csrf
                            @method('PUT')
                            
                            <td>
                                <span style="text-transform: capitalize; font-weight: bold; color: {{ $user->role === 'admin' ? '#ffc107' : 'white' }};">
                                    {{ $user->role }}
                                </span>
                            </td>

                            <td>
                                <select name="role" required style="width: 150px; margin-right: 10px;">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>
                                            {{ ucfirst($role) }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                <button type="submit" class="glossy-btn primary" style="padding: 5px 10px;">Update</button>
                            </td>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <hr style="border-top: 1px solid rgba(255, 255, 255, 0.5);">
    <a href="/dashboard" class="glossy-btn">Back to Dashboard</a>
@endsection