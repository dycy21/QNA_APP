<?php


namespace App\Http\Controllers;

use App\Models\InstructionPage;
use App\Models\Step;
use Illuminate\Http\Request;

class StepController extends Controller
{
    // Shows the form to create a new step for a specific instruction page.
    public function create(InstructionPage $instructionPage)
    {
        // This method is called via /instruction-pages/{instruction_page}/steps/create
        $nextOrder = $instructionPage->steps()->max('order') + 1;
        return view('instruction_steps_create', compact('instructionPage', 'nextOrder'));
    }

    // Stores the newly created step.
    public function store(Request $request, InstructionPage $instructionPage)
    {
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'required|integer|min:1',
            'image' => 'nullable|image|max:5000', // Max 5MB image
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Store the file in 'storage/app/public/instructions'
            // The storage:link command ensures this is web accessible via /storage/instructions/...
            $imagePath = $request->file('image')->store('instructions', 'public');
        }

        $instructionPage->steps()->create([
            'heading' => $validated['heading'],
            'content' => $validated['content'],
            'order' => $validated['order'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('instruction-pages.show', $instructionPage)
                         ->with('success', 'Step added successfully.');
    }
    
    // For simplicity, we omit edit/update/destroy, but they follow the standard pattern.
}