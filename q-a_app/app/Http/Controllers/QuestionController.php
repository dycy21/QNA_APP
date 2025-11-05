<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function show(Question $question)
    {
        $question->load('answers.instructionPage');
        $property = $question->property;
        return view('admin.questions.show', compact('question', 'property'));
    }

    // CREATE - Reverted: Any authenticated user can create
    public function create(Property $property)
    {
        if ($property->question) {
            return redirect()->route('questions.show', $property->question);
        }
        return view('admin.questions.create', compact('property'));
    }

    // STORE - Reverted: Any authenticated user can store
    public function store(Request $request, Property $property)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:255|unique:questions,text',
        ]);

        $property->question()->create($validated);

        return redirect()->route('properties.index')
                         ->with('success', 'Question saved for ' . $property->name . '. Now add answers!');
    }
    
    // DESTROY (Delete) - Reverted: Any authenticated user can delete
    public function destroy(Question $question)
    {
        $question->delete();
        return back()->with('success', 'Question deleted successfully.');
    }
}