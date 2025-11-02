@extends('layouts.app')

@section('header_title', 'Guest Bookings Management')

@section('content')
    <h2>Guest Bookings</h2>
    <p><a href="{{ route('guests.create') }}" class="btn">Add New Guest Booking</a></p>

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
                    <td>{{ $guest->name }}<br><small>{{ $guest->email }} | {{ $guest->phone }}</small></td>
                    <td>{{ $guest->property->name }}</td>
                    <td>{{ $guest->check_in_date->format('M j') }} - {{ $guest->check_out_date->format('M j') }}</td>
                    <td>
                        <input type="text" 
                               style="width: 250px;"
                               value="{{ route('guest.checkin', $guest->magic_link_token) }}" 
                               readonly
                               onclick="this.select(); document.execCommand('copy'); alert('Link copied!');">
                        <button onclick="this.parentNode.querySelector('input').select(); document.execCommand('copy'); alert('Link copied!');" class="btn" style="padding: 5px 10px;">Copy</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No guest bookings found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <hr>
    <h3><a href="{{ route('properties.index') }}">Go to Property Setup</a></h3>
@endsection