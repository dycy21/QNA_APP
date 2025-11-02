<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $properties = Property::all();
        return view('properties.index', compact('properties'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('properties.create');
    }

    // Store a newly created resource in storage.
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

    // You can add edit/update/destroy methods here if needed, 
    // but the basics above will get the system running.
}