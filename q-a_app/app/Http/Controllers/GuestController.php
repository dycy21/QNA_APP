<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Property;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; // Ensure Storage is imported

class GuestController extends Controller
{
    // --- Admin CRUD Methods ---

    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $guests = Guest::with('property')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        return view('guests.index', compact('guests', 'search'));
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
    
    /**
     * Display the specified guest's details (GET /guests/{guest}).
     */
    public function show(Guest $guest)
    {
        // Eager load related data: property, ID photo record, and the final answer page
        $guest->load(['property', 'idPhoto', 'answer.instructionPage']);

        return view('guests.show', compact('guest'));
    }
    
    // --- Guest Facing Methods ---

    public function showCheckIn($token)
    {
        // ... (Guest check-in logic remains unchanged) ...
        $guest = Guest::where('magic_link_token', $token)->firstOrFail();
    
        $today = Carbon::today();
        $checkInDate = Carbon::parse($guest->check_in_date);
        $isCheckInDayOrPast = $today->greaterThanOrEqualTo($checkInDate);
        
        if ($guest->answer_id) { 
            $instructionPage = $guest->answer->instructionPage; 
            return view('guests.instructions', compact('guest', 'instructionPage'));
        }
        
        $question = $guest->property->question;

        return view('guests.check_in', compact(
            'guest', 
            'isCheckInDayOrPast', 
            'question'
        ));
    }

    public function updateCheckIn(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'id_photo' => 'nullable|image|max:5000',
        ]);

        $guest->update([
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'info_updated' => true,
        ]);

        if ($request->hasFile('id_photo')) {
            $path = $request->file('id_photo')->store('ids', 'volume');
            $guest->idPhoto()->create(['file_path' => $path]);
        }

        return redirect()->route('guest.checkin', $guest->magic_link_token)
                         ->with('status', 'Your details have been updated and ID uploaded successfully!');
    }
    
    public function processAnswer(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'answer_id' => 'required|exists:answers,id',
        ]);
        
        $answer = Answer::findOrFail($validated['answer_id']);

        if ($answer->question->property_id !== $guest->property_id) {
            abort(403, 'Invalid answer selection.');
        }
        
        $guest->update(['answer_id' => $validated['answer_id']]);

        return redirect()->route('guest.checkin', $guest->magic_link_token);
    }
}