<?php

namespace App\Http\Controllers;

use App\Models\InstructionPage;
use Illuminate\Http\Request;

class InstructionPageController extends Controller
{
    public function index()
    {
        $pages = InstructionPage::latest()->get();
        return view('instruction_index', compact('pages'));
    }

    public function create()
    {
        return view('instruction_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255|unique:instruction_pages',
            'description' => 'nullable|string',
        ]);

        InstructionPage::create($validated);

        return redirect()->route('instruction-pages.index')
                         ->with('success', 'Instruction Page created successfully.');
    }

    public function show(InstructionPage $instructionPage)
    {
        // Eager load steps to display them
        $instructionPage->load('steps'); 
        return view('instruction_show', compact('instructionPage'));
    }
    
    // For simplicity, we omit edit/update/destroy, but they follow the standard pattern.
}