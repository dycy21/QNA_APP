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
        // 🛑 CRITICAL CHANGE: Use paginate() instead of all()
        $properties = Property::latest()->paginate(10); 
        
        return view('properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage.
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
     * Remove the specified resource from storage (DELETE /properties/{property}).
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('properties.index')
                         ->with('success', 'Property deleted successfully.');
    }
}