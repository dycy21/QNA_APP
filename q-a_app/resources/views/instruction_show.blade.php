@extends('layouts.app')

@section('header_title', 'Steps for: ' . $instructionPage->title)

@section('content')
    <h2>Instruction Page: {{ $instructionPage->title }}</h2>
    <p>{{ $instructionPage->description }}</p>
    
    <p>
        <a href="{{ route('instruction-pages.steps.create', $instructionPage) }}" class="btn btn-success">➕ Add New Step</a>
    </p>

    <hr>

    @forelse ($instructionPage->steps as $step)
        <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
            <h3>Step {{ $step->order }}: {{ $step->heading }}</h3>
            
            @if ($step->image_path)
                <p>
                    <strong>Image:</strong><br>
                    <img src="{{ $step->image_url }}" alt="Step Image" style="max-width: 300px; height: auto; border: 1px solid #ccc;">
                </p>
            @endif

            <p>{!! nl2br(e($step->content)) !!}</p>
            </div>
    @empty
        <p>No steps defined for this instruction page yet. Add the first step!</p>
    @endforelse

    <hr>
    <a href="{{ route('instruction-pages.index') }}" class="glossy-btn primary" >Back to Pages</a>
@endsection