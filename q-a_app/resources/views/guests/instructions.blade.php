@extends('layouts.app')

@section('header_title', 'Your Check-in Instructions')

@section('content')
    <h2 style="color: #3490dc;">{{ $instructionPage->title }}</h2>
    <p style="font-style: italic;">Welcome, {{ $guest->name }}! Please follow these steps to complete your check-in for {{ $guest->property->name }}.</p>
    
    @if ($instructionPage->description)
        <p>{{ $instructionPage->description }}</p>
    @endif

    <hr>
    
    @forelse ($instructionPage->steps as $step)
        <div style="border: 1px solid #ccc; padding: 20px; margin-bottom: 25px; border-radius: 5px; background-color: #f9f9f9;">
            <h3 style="color: #38c172;">STEP {{ $step->order }}: {{ $step->heading }}</h3>
            
            @if ($step->image_url)
                <div style="margin: 15px 0; text-align: center;">
                    <img src="{{ $step->image_url }}" alt="Step {{ $step->order }} Image" style="max-width: 100%; height: auto; border: 3px solid #ddd; border-radius: 4px;">
                </div>
            @endif

            <p>{!! nl2br(e($step->content)) !!}</p>
        </div>
    @empty
        <p style="color: red; font-weight: bold;">No instructions found for this scenario. Please contact support.</p>
    @endforelse
    
    <p style="text-align: center; margin-top: 30px;">Thank you for checking in!</p>
@endsection