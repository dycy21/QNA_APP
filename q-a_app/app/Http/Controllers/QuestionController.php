<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Show the question (and its answers) for a specific property
    public function show(Question $question)
    {
        $question->load('answers.instructionPage');
        $property = $question->property;
        return view('admin.questions.show', compact('question', 'property'));
    }

    // Show form to create/edit the question for a property
    public function create(Property $property)
    {
        // Check if a question already exists for this property
        if ($property->question) {
            return redirect()->route('questions.show', $property->question);
        }
        return view('admin.questions.create', compact('property'));
    }

    // Store the new question
    public function store(Request $request, Property $property)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:255|unique:questions,text',
        ]);

        $property->question()->create($validated);

        return redirect()->route('properties.index')
                         ->with('success', 'Question saved for ' . $property->name . '. Now add answers!');
    }
    
   
}