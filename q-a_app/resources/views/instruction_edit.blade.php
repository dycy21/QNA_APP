@extends('layouts.app')

@section('header_title', $instructionPage && $instructionPage->id ? 'Edit: ' . $instructionPage->title : 'Create New Instruction Page')

@section('content')

    <div class="card">
        <h2 style="margin-bottom: 20px;">{{ $isNew ? 'Create New' : 'Edit' }} Page Details</h2>
        
        {{--Form dynamically targets STORE (POST) or UPDATE (PUT) --}}
        <form action="{{ $isNew ? route('instruction-pages.store') : route('instruction-pages.update', $instructionPage) }}" 
              method="POST"></form>
            @csrf
            {{-- Use PUT method only if we are UPDATING (i.e., not new) --}}
            @if (!$isNew) @method('PUT') @endif

            <div class="form-group">
                <label for="title">Page Title:</label>
                <input type="text" name="title" id="title" required value="{{ old('title', $instructionPage->title ?? '') }}">
            </div>
            <div class="form-group" style="padding-bottom: 10px; padding-top: 10px;">
                <label for="description">Introduction:</label>
                <textarea name="description" id="description">{{ old('description', $instructionPage->description ?? '') }}</textarea>
            </div>
            <div style="display: flex; gap: 10px; align-items: center; margin-top: 2px; margin-bottom: 2px;">
            <button type="submit" class="glossy-btn success">
                {{-- Button text reflects the creation/saving action --}}
                {{ $isNew ? 'Create Page' : 'Save Details' }}
            </button>
            @if (!$isNew)
                    <a href="{{ route('instruction-pages.show', $instructionPage) }}" 
                       class="glossy-btn primary" 
                       style="background-color: #3498db;">
                        View Page
                    </a>
                @endif

            <a href="{{ route('instruction-pages.index') }}" class="glossy-btn primary" style="background-color: #e74c3c;">Back to List</a>
            </div>
        </form>
    </div>

    @if (!$isNew)
        {{-- STEP MANAGEMENT SECTION - Only visible after the page is initially created --}}
        
        <h3 style="margin-top: 30px;">Add New Step</h3>
        
        <div class="card" style="border-left: 5px solid #1abc9c;"> 
            <form id="add-step-form" action="{{ route('instruction-pages.steps.store', $instructionPage) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div style="display: flex; gap: 30px;">
                    
                    {{-- COLUMN 1: IMAGE UPLOAD AND PREVIEW (DRAG & DROP) --}}
                    <div id="drag-drop-zone" style="flex-basis: 35%; flex-shrink: 0; position: relative;">
                        <div class="card" id="image-preview-card" style="border: 2px dashed #3498db; padding: 10px; text-align: center; height: 180px; display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 6px; cursor: pointer;">
                            <p style="margin: 0; color: #3498db; font-weight: bold;">Drag & Drop Image Here</p>
                            <p style="margin: 5px 0 0;">or Click to Browse</p>

                            <div class="card" style="padding: 0; text-align: center; height: 100%; width: 100%; position: absolute; top: 0; left: 0; display: none; align-items: center; justify-content: center; background: rgba(255, 255, 255, 0.9);" id="image-preview-wrapper">
                                <img id="image-preview" src="" style="max-width: 100%; max-height: 100%; border-radius: 4px; display: none;">
                            </div>
                        </div>

                        <input type="file" name="image" id="image-input" accept="image/*" style="display: none;">
                    </div>

                    {{-- COLUMN 2: HEADING, ORDER, and CONTENT --}}
                    <div style="flex-basis: 65%; flex-grow: 1;">
                        <div style="display: flex; gap: 20px;">
                            <div class="form-group" style="flex: 1;">
                                <label for="heading">Heading</label>
                                <input type="text" name="heading" required>
                            </div>
                            <div class="form-group" style="width: 150px;">
                                <label for="order">Order</label>
                                <input type="number" name="order" value="{{ $steps->max('order') + 1 }}" required readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content">Instructions</label>
                            <textarea name="content" required rows="4"></textarea>
                        </div>
                        <button type="submit" class="glossy-btn success">Add Step</button>
                    </div>
                </div>
                
            </form>
        </div>


        <h3 style="margin-top: 30px;">Step Management (Drag to Reorder)</h3>
        
        <div id="step-list-container">
            <div id="steps-draggable-list">
                @foreach ($steps as $step)
                    <div class="card step-item" data-id="{{ $step->id }}" style="cursor: grab; border: 1px dashed #34495e; margin-bottom: 10px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="font-weight: bold;">
                                #{{ $step->order }} - {{ $step->heading }}
                            </div>
                            <div style="font-size: 0.9em; opacity: 0.7;">
                                {{ Str::limit($step->content, 50) }}
                                @if($step->image_path) <span style="color: #1abc9c;">[Image Present]</span> @endif
                            </div>
                            <button onclick="deleteStep({{ $step->id }})" class="glossy-btn primary" style="background-color: #e74c3c; padding: 5px 10px;">Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <form id="reorder-form" method="POST" action="{{ route('steps.reorder') }}">
            @csrf
            <input type="hidden" name="order" id="order-input">
            <button type="submit" id="save-order-btn" class="glossy-btn primary" style="display: none; margin-top: 20px;">Save New Order</button>
        </form>

    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dropZone = document.getElementById('drag-drop-zone');
                const imageInput = document.getElementById('image-input');
                const imagePreview = document.getElementById('image-preview');
                const imagePreviewWrapper = document.getElementById('image-preview-wrapper');
                
                // --- 1. Image Preview & Drag-and-Drop Logic ---
                function handleFile(file) {
                    if (file && file.type.match('image.*')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.style.display = 'block';
                            imagePreviewWrapper.style.display = 'flex'; // Show wrapper
                        };
                        reader.readAsDataURL(file);
                        
                        // Assign file to the hidden input for form submission
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        imageInput.files = dataTransfer.files;

                    } else {
                        imagePreview.src = '';
                        imagePreview.style.display = 'none';
                        imagePreviewWrapper.style.display = 'none';
                        imageInput.files = null;
                    }
                }

                // --- Event Listeners for Drag/Drop ---
                
                // Clicks on the zone open the file input
                dropZone.addEventListener('click', () => imageInput.click());

                // Prevent default browser behavior
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                    }, false);
                });

                // Handle the actual drop event
                dropZone.addEventListener('drop', (e) => {
                    const files = e.dataTransfer.files;
                    handleFile(files[0]);
                }, false);
                
                // Handle file selection from the click/browse dialog
                imageInput.addEventListener('change', (e) => {
                    handleFile(e.target.files[0]);
                });
                
                // --- 2. SortableJS Logic ---
                if (document.getElementById('steps-draggable-list')) {
                    const el = document.getElementById('steps-draggable-list');
                    const saveBtn = document.getElementById('save-order-btn');
                    
                    const sortable = Sortable.create(el, {
                        animation: 150,
                        onEnd: function (evt) {
                            const order = [];
                            const stepItems = el.querySelectorAll('.step-item');
                            
                            stepItems.forEach((item) => {
                                order.push(item.getAttribute('data-id'));
                            });
                            
                            document.getElementById('order-input').value = JSON.stringify(order);
                            saveBtn.style.display = 'inline-block';
                            
                            // Re-number the step headings visually 
                            stepItems.forEach((item, index) => {
                                 const heading = item.querySelector('div:first-child');
                                 heading.innerHTML = `#${index + 1} - ${item.getAttribute('data-id')}`; 
                            });
                        }
                    });
                }
                
                // --- 3. Custom Delete Function ---
                // Expose the deleteStep function globally for the HTML button click
                window.deleteStep = function(stepId) {
                    if (confirm('Are you sure you want to delete this step? This cannot be undone.')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/instruction-pages/' + {{ $instructionPage->id }} + '/steps/' + stepId;
                        
                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = document.querySelector('input[name="_token"]').value;
                        form.appendChild(csrf);

                        const method = document.createElement('input');
                        method.type = 'hidden';
                        method.name = '_method';
                        method.value = 'DELETE';
                        form.appendChild(method);
                        
                        document.body.appendChild(form);
                        form.submit();
                    }
                };
            });
        </script>
    @endif

@endsection