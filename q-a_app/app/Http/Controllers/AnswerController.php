<?php   


namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\InstructionPage;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    // Show form to create a new answer for a question
    public function create(Question $question)
    {
        $instructionPages = InstructionPage::all();
        return view('admin.answers.create', compact('question', 'instructionPages'));
    }

    // Store the new answer
    public function store(Request $request, Question $question)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:255',
            'instruction_page_id' => 'required|exists:instruction_pages,id',
        ]);

        $question->answers()->create($validated);

        return redirect()->route('questions.show', $question)
                         ->with('success', 'Answer added and linked successfully!');
    }
    
    
}