<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Property;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Fetch key statistics
        $stats = [
            'total_guests' => Guest::count(),
            'total_properties' => Property::count(),
            // Counts for today and upcoming based on check-in date
            'checking_in_today' => Guest::whereDate('check_in_date', $today)->count(),
            'upcoming_check_ins' => Guest::whereDate('check_in_date', '>', $today)->count(),
            'info_incomplete' => Guest::where('info_updated', false)->count(),
        ];

        // Fetch all properties to display as cards, loading the question relationship
        $properties = Property::with('question')->get();

        // Fetch recent guests (Optional, kept for the view)
        $recentGuests = Guest::with('property')->latest()->limit(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recentGuests', 'properties'));
    }
}