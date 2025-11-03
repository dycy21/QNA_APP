@extends('layouts.app')

@section('header_title', 'Welcome')

@section('content')
    <div class="row justify-content-center text-center">
        <div class="col-lg-8">
            <h1 class="display-3 text-primary">Guest Check-in System</h1>
            <p class="lead mb-4">
                Seamless self-check-in flows customized for your properties. 
                Generate unique links for guests, collect necessary details, and provide guided instructions based on their needs.
            </p>
            <hr class="my-4">
            
            <p class="mb-4">
                This is a private administration area. Please proceed to the login (once authentication is added) or the setup pages if you have access.
            </p>
            
            <a href="{{ route('properties.index') }}" class="btn btn-success btn-lg shadow">
                Go to Admin Setup ⚙️
            </a>
        </div>
    </div>
@endsection