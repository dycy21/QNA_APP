<?php

namespace App\Http\Controllers;

use App\Models\InstructionPage;
use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Needed for image handling

class StepController extends Controller
{
    // ... (create method is handled by redirect, show is handled by edit) ...
    
    /**
     * Stores the newly created step.
     * POST /instruction-pages/{instruction_page}/steps
     */
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
            $imagePath = $request->file('image')->store('instructions', 'railway_volume');
        }

        $instructionPage->steps()->create([
            'heading' => $validated['heading'],
            'content' => $validated['content'],
            'order' => $validated['order'],
            'image_path' => $imagePath,
        ]);
        
        // Redirect back to the integrated edit page
        return redirect()->route('instruction-pages.edit', $instructionPage)
                         ->with('success', 'Step added successfully.');
    }
    
    /**
     * Handles AJAX request to update the order of steps (Drag & Drop).
     * POST /steps/reorder
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:steps,id', 
        ]);
        
        foreach ($request->order as $index => $stepId) {
            Step::where('id', $stepId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Steps reordered successfully.']);
    }

    /**
     * Remove the specified step from storage.
     * DELETE /steps/{step}
     */
    public function destroy(InstructionPage $instructionPage, Step $step)
    {
        if ($step->image_path) {
            Storage::disk('railway_volume')->delete($step->image_path);
        }
        
        $step->delete();
        
        return redirect()->route('instruction-pages.edit', $instructionPage)
                         ->with('success', 'Step deleted successfully.');
    }
}