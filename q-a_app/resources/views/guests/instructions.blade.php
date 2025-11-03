@extends('layouts.app')

@section('header_title', 'Your Check-in Instructions')

@section('content')
    <h2 class="text-success mb-4">{{ $instructionPage->title }}</h2>
    <p class="lead text-muted">Welcome, {{ $guest->name }}! Please follow these steps to complete your check-in for {{ $guest->property->name }}.</p>
    
    @if ($instructionPage->description)
        <p>{{ $instructionPage->description }}</p>
    @endif

    <hr class="my-4">
    
    @forelse ($instructionPage->steps as $step)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light">
                <h3 class="h5 mb-0 text-success">STEP {{ $step->order }}: {{ $step->heading }}</h3>
            </div>
            <div class="card-body row">
                
                <div class="col-md-8">
                    <p class="card-text">{!! nl2br(e($step->content)) !!}</p>
                </div>

                @if ($step->image_url)
                    <div class="col-md-4 text-center">
                        <img src="{{ $step->image_url }}" alt="Step {{ $step->order }} Image" class="img-fluid rounded border shadow-sm" style="max-height: 250px; object-fit: cover;">
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="alert alert-danger">
            <p class="fw-bold mb-0">No instructions found for this scenario. Please contact support.</p>
        </div>
    @endforelse
    
    <p class="text-center mt-5 fs-5">Thank you for checking in!</p>
@endsection