<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// --- Controller Imports ---
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstructionPageController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- PUBLIC ROUTES ---

// Public gateway page for Login/Register options
Route::get('/auth-gateway', function () {
    return view('auth_gateway');
})->name('auth.gateway');

// Guest Magic Link Flow (Must remain public for check-in)
Route::get('check-in/{token}', [GuestController::class, 'showCheckIn'])->name('guest.checkin');
Route::post('check-in/{guest}', [GuestController::class, 'updateCheckIn'])->name('guest.update');
Route::post('check-in/{guest}/answer', [GuestController::class, 'processAnswer'])->name('guest.answer');


// --- MINIMAL AUTH ROUTES ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);


// --- PROTECTED ADMIN SECTION (STABLE) ---
Route::middleware(['auth'])->group(function () {
    
    // Dashboard is accessed via the stable /dashboard path and named 'admin.dashboard'
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard'); 
    
    // Set the root of the protected section to the dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); 

    // User Management
    Route::resource('user-management', UserController::class)
        ->names('admin.users')
        ->only(['index', 'update']);

    // Properties CRUD (Full Access)
    Route::resource('properties', PropertyController::class);
    Route::resource('guests', GuestController::class);
    Route::resource('instruction-pages', InstructionPageController::class);
    Route::resource('instruction-pages.steps', StepController::class)->shallow();
    Route::resource('properties.questions', QuestionController::class)->shallow();
    Route::resource('questions.answers', AnswerController::class)->shallow();
});


// --- FINAL HOMEPAGE FALLBACKS (Redirect Loop Prevention) ---

// Final stable check for the root path ('/')
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard'); 
    }
    return redirect()->route('login');
})->name('home');