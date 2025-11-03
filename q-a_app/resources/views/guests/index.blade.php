@extends('layouts.app')

@section('header_title', 'Guest Bookings Management')

@section('content')
    <div class="glossy-card">
        <h2>Guest Bookings</h2>
        <p><a href="{{ route('guests.create') }}" class="glossy-btn success">Add New Guest Booking</a></p>

        <form action="{{ route('guests.index') }}" method="GET" class="form-group" style="display: flex; gap: 10px; margin-bottom: 20px;">
            <input type="text" name="search" placeholder="Search by name, email, or phone..." 
                   value="{{ $search ?? '' }}" 
                   style="flex-grow: 1; margin-bottom: 0;">
            <button type="submit" class="glossy-btn primary" style="padding: 8px 15px;">Search</button>
            @if (isset($search) && $search)
                <a href="{{ route('guests.index') }}" class="glossy-btn" style="padding: 8px 15px;">Clear</a>
            @endif
        </form>

        <table>
            <thead>
                <tr>
                    <th>Guest</th>
                    <th>Property</th>
                    <th>Dates</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($guests as $guest)
                    <tr>
                        <td>{{ $guest->name }}<br><small style="color: rgba(255, 255, 255, 0.8);">{{ $guest->email }} | {{ $guest->phone }}</small></td>
                        <td>{{ $guest->property->name }}</td>
                        <td>{{ $guest->check_in_date->format('M j') }} - {{ $guest->check_out_date->format('M j') }}</td>
                        <td>
                            <input type="text" 
                                   style="width: 250px; background: rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.4); color: white;"
                                   value="{{ route('guest.checkin', $guest->magic_link_token) }}" 
                                   readonly
                                   onclick="this.select(); document.execCommand('copy'); alert('Link copied!');">
                            <button onclick="this.parentNode.querySelector('input').select(); document.execCommand('copy'); alert('Link copied!');" class="glossy-btn" style="padding: 5px 10px; margin-left: 5px;">Copy</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: yellow;">
                            @if (isset($search) && $search)
                                No guests found matching "{{ $search }}".
                            @else
                                No guest bookings found. Add a new guest above!
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <hr style="border-top: 1px solid rgba(255, 255, 255, 0.5);">
    <h3><a href="{{ route('properties.index') }}" class="glossy-btn primary">Go to Property Setup</a></h3>
@endsection