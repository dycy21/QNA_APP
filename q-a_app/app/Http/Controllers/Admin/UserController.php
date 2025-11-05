<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // Fetch all users to display their roles
        $users = User::orderBy('name')->get(); 
        
        // Define available roles for the dropdown
        $roles = ['admin', 'manager', 'basic']; 

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Update the role of the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,manager,basic',
        ]);

        $user->update(['role' => $validated['role']]);

        return redirect()->route('admin.users.index')->with('success', "Role for {$user->name} updated to {$validated['role']}.");
    }
}