<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource (GET /properties) with pagination.
     */
    public function index()
    {
        $properties = Property::latest()->paginate(10); 
        return view('properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource (GET /properties/create).
     */
    public function create()
    {
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage (POST /properties).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:properties|max:255',
            'address' => 'nullable',
        ]);

        Property::create($validated);

        return redirect()->route('properties.index')
                         ->with('success', 'Property created successfully.');
    }

    /**
     * Display the specified property's details (GET /properties/{property}).
     */
    public function show(Property $property)
    {
        // Eager load the question to check setup status
        $property->load('question');

        return view('properties.show', compact('property'));
    }
    
    /**
     * Show the form for editing the specified resource (GET /properties/{property}/edit).
     */
    public function edit(Property $property)
    {
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage (PUT/PATCH /properties/{property}).
     */
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            // Ensure name is unique, ignoring the current property's ID
            'name' => 'required|max:255|unique:properties,name,' . $property->id,
            'address' => 'nullable',
        ]);

        $property->update($validated);

        return redirect()->route('properties.show', $property)
                         ->with('success', 'Property details updated successfully.');
    }

    /**
     * Remove the specified resource from storage (DELETE /properties/{property}).
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('properties.index')
                         ->with('success', 'Property deleted successfully.');
    }
}