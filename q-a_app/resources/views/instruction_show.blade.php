@extends('layouts.app')

@section('header_title', 'View Instructions: ' . $instructionPage->title)

@section('content')
    <div class="card">
        <h2 class="gradient-text">{{ $instructionPage->title }}</h2>
        <p style="font-style: italic; color: #777; border-bottom: 1px solid #eee; padding-bottom: 10px;">
            {{ $instructionPage->description ?? 'No introductory description provided.' }}
        </p>

        <h3 style="margin-top: 30px;">Step-by-Step Guide</h3>

        @forelse ($instructionPage->steps as $step)
            <div class="card" style="margin-bottom: 25px; border-left: 5px solid #3498db; padding: 20px;">
                <h4 style="color: #3498db;">Step {{ $step->order }}: {{ $step->heading }}</h4>
                
                @if ($step->image_path)
    <div style="display: flex; gap: 20px; align-items: flex-start; width: 100%; margin-top: 10px; 
                flex-direction: row-reverse;"> 
        <div class="step-image-container" 
             style="flex-basis: 50%; max-width: 50%; height: 250px; overflow: hidden; border-radius: 8px; /* Added radius */ 
                    transition: transform 0.3s ease; /* For smooth pop-up */"> 
            
            <img src="{{ Storage::url($step->image_path) }}" 
                 alt="Step {{ $step->order }} Visual" 
                 style="width: 100%; 
                        height: 100%; 
                        object-fit: cover; 
                        border-radius: 8px;">
        </div>

        {{-- Instructions (Now on the LEFT side) --}}
        <div style="flex-basis: 50%; flex-grow: 1; min-width: 50%; font-size: 1.05em;">
            <p>{!! nl2br(e($step->content)) !!}</p>
        </div>
    </div>
                @else
                    {{-- Text only --}}
                    <p>{!! nl2br(e($step->content)) !!}</p>
                @endif
            </div>
        @empty
            <p>No steps have been added to this instruction page yet.</p>
        @endforelse
    </div>

    <div style="margin-top: 25px; display: flex; gap: 10px; align-items: center;">
    
    {{-- Button 1: Edit Steps --}}
    <a href="{{ route('instruction-pages.edit', $instructionPage) }}" 
       class="glossy-btn success" 
       style="background-color: #2ecc71;">
        Edit Steps (Admin)
    </a>
    
    {{-- Button 2: Delete Page (Form is now treated as a flex item) --}}
    <form action="{{ route('instruction-pages.destroy', $instructionPage) }}" 
          method="POST" 
          onsubmit="return confirm('WARNING: Are you SURE you want to delete this page? This will break linked Q&A.');"
          style="display: flex;"> @csrf
        @method('DELETE')
        <button type="submit" class="glossy-btn primary" style="background-color: #e74c3c;">
            Delete Page
        </button>
    </form>

    {{-- Button 3: Back to List --}}
    <a href="{{ route('instruction-pages.index') }}" 
       class="glossy-btn primary" 
       style="background-color: aquamarine;">
        Back to List
    </a>
</div>
@endsection