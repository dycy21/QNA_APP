<?php

namespace App\Http\Controllers;

use App\Models\InstructionPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 

class InstructionPageController extends Controller
{
    public function index()
    {
        // Eager load only the first step for image preview on the index page
        $pages = InstructionPage::with(['steps' => function ($query) {
            $query->orderBy('order')->limit(1);
        }])->latest()->get();
        
        return view('instruction_index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource (Loads the edit view with null data).
     * GET /instruction-pages/create
     */
    public function create()
    {
        // Load the integrated editor immediately, setting the isNew flag
        return view('instructions_create', [
            'instructionPage' => (object)['id' => null, 'title' => null, 'description' => null],
            'steps' => collect([]),
            'isNew' => true 
        ]);
    }

    /**
     * Store a newly created resource and redirect to its editing page.
     * POST /instruction-pages
     */
    public function store(Request $request)
    {
        // Stores the page and immediately redirects to its EDIT URL
        $validated = $request->validate([
            'title' => 'required|max:255|unique:instruction_pages',
            'description' => 'nullable',
        ]);
        $page = InstructionPage::create($validated);
        
        // This is the single, streamlined redirect: go straight to step management
        return redirect()->route('instruction-pages.edit', $page)
                         ->with('success', 'Instruction Page created. You can now add and reorder steps below.');
    }
    
    /**
     * Display the specified resource and its steps (Read-Only View).
     * GET /instruction-pages/{instruction_page}
     */
    public function show(InstructionPage $instructionPage)
    {
        // Loads the read-only view
        $instructionPage->load('steps');
        return view('instruction_show', compact('instructionPage'));
    }

    /**
     * Show the form for editing the specified resource, including all steps.
     * GET /instruction-pages/{instruction_page}/edit
     */
    public function edit(InstructionPage $instructionPage)
    {
        // This is the main method that loads the integrated administrator editor
        $instructionPage->load('steps');
        return view('instruction_edit', [
            'instructionPage' => $instructionPage,
            'steps' => $instructionPage->steps,
            'isNew' => false
        ]);
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /instruction-pages/{instruction_page}
     */
    public function update(Request $request, InstructionPage $instructionPage)
    {
        $validated = $request->validate([
            'title' => 'required|max:255|unique:instruction_pages,title,' . $instructionPage->id,
            'description' => 'nullable',
        ]);
        $instructionPage->update($validated);

        return redirect()->route('instruction-pages.edit', $instructionPage)
                         ->with('success', 'Page details updated successfully.');
    }
    
    public function destroy(InstructionPage $instructionPage)
{
    // The database constraints should automatically handle deleting related steps and answers.
    // However, if steps contained uploaded images, we should delete them first.

    // Optional: Delete related images (assuming you have this logic set up in the Step model or here)
    // For simplicity, we trust CASCADE DELETE on the database side for steps/answers.
    
    $instructionPage->delete();
    
    return redirect()->route('instruction-pages.index')
                     ->with('success', 'Instruction Page and all associated steps/links deleted successfully.');
}
}