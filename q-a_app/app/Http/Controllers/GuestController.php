<?php

namespace App\Http\Controllers;
use App\Models\Answer; // Add this line
use App\Models\Guest;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GuestController extends Controller
{
    // --- Admin CRUD Methods ---

    public function index()
    {
        $guests = Guest::with('property')->latest()->get();
        return view('guests.index', compact('guests'));
    }

    public function create()
    {
        $properties = Property::all();
        return view('guests.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $validated['magic_link_token'] = Str::random(60);

        $guest = Guest::create($validated);

        return redirect()->route('guests.index')
                         ->with('success', 'Guest booking created. Magic link available below.');
    }
    
    // --- Guest Facing Methods ---


    /**
     * Handles the guest updating their info and uploading their ID.
     */
    public function updateCheckIn(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'id_photo' => 'nullable|image|max:5000', // 5MB max
        ]);

        $guest->update([
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'info_updated' => true,
        ]);

        if ($request->hasFile('id_photo')) {
            // Store the file in 'storage/app/public/ids'
            $path = $request->file('id_photo')->store('ids', 'public');
            
            // Create a record for the ID Photo
            $guest->idPhoto()->create(['file_path' => $path]);
        }

        return redirect()->route('guest.checkin', $guest->magic_link_token)
                         ->with('status', 'Your details have been updated and ID uploaded successfully!');
    }
    
    
    // The `processAnswer` method will be implemented in the next step when we add Questions/Answers.
    public function showCheckIn($token)
    {
        $guest = Guest::where('magic_link_token', $token)->firstOrFail();
        
        $today = Carbon::today();
        $checkInDate = Carbon::parse($guest->check_in_date);

        
        $isCheckInDayOrPast = $today->greaterThanOrEqualTo($checkInDate);

        // Check if the guest has already answwered and has a linked instruction page
        if ($guest->answered_answer_id) {
            $instructionPage = $guest->answeredAnswer->instructionPage;
            return view('guests.instruction_page', compact('guest', 'instructionPage'));
            
        }
        // load the property's question and answers for the form
        $question = $guest->property->question;

        return view('guests.check_in', compact(
            'guest', 
            'isCheckInDayOrPast', 
            'today', 
            'checkInDate',
            'question'
        ));
    }
    public function processAnswer(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'answer_id' => 'required|exists:answers,id',
        ]);

        $answer = Answer::findOrFail($validated['answer_id']);

        // check if the selected answer belongs to the property's question
        if ($answer->question->property_id !== $guest->property_id) {
            abort(403, 'Invalid answer selection for this property.');
        }
        // Update the guest's answered_answer_id
        $guest->update([
            'answered_answer_id' => $answer->id,
        ]);

        // Redirect back to the check-in link, which will now take them to the instruction page
        return redirect()->route('guest.checkin', $guest->magic_link_token);

        
    }
}