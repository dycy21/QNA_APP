<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\GuestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| The routes for your application. We'll start with basic admin CRUD.
|
*/

// --- Admin Section ---

// Guests CRUD
Route::resource('guests', 'GuestController'::class);

// Instruction Pages CRUD
Route::resource('instruction-pages', 'App\Http\Controllers\InstructionPageController'::class);

// Nested Steps CRUD (Steps belong to an InstructionPage)
Route::resource('instruction-pages.steps', 'App\Http\Controllers\StepController')
    ->shallow(); // Use 'shallow' to keep step routes cleaner (e.g., /steps/{step})


// Properties CRUD
Route::resource('properties', PropertyController::class);

// Guests CRUD
Route::resource('guests', GuestController::class);

// This is where the guest lands after clicking the link.
Route::get('check-in/{token}', [GuestController::class, 'showCheckIn'])->name('guest.checkin');
Route::post('check-in/{guest}', [GuestController::class, 'updateCheckIn'])->name('guest.update');
Route::post('check-in/{guest}/answer', [GuestController::class, 'processAnswer'])->name('guest.answer');


// Optional Homepage (You can replace this later)
Route::get('/', function () {
    return redirect()->route('properties.index');
});

// routes/web.php

// ... (Existing admin routes for Properties, Guests, Instruction Pages)

// Questions CRUD (Linked to Property)
Route::resource('properties.questions', App\Http\Controllers\QuestionController::class)
    ->shallow(); 
    
// Answers CRUD (Linked to Question)
Route::resource('questions.answers', App\Http\Controllers\AnswerController::class)
    ->shallow(); 
    

