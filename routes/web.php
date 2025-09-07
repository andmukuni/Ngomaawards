<?php

use App\Http\Controllers\NominationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/event', function () {
    return view('eventdetail');
});

// routes/web.php
Route::view('/about', 'about')->name('about');


Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


// Categories page route
Route::get('/categories', function () {
    return view('categories.index');
})->name('categories.index');

// Public nomination routes
Route::post('/nominations', [NominationController::class, 'store'])->name('nominations.store');
Route::get('/nominations', [NominationController::class, 'index'])->name('nominations.index');
Route::get('/nominations/{nomination}', [NominationController::class, 'show'])->name('nominations.show');
Route::get('nominations/category/{category}', [NominationController::class, 'byCategory'])->name('nominations.byCategory');

// DataTables route (MUST be placed before the resource route)
Route::get('nominations/data', [NominationController::class, 'index'])->name('nominations.data');

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth middleware group
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Admin nomination routes
    Route::get('nominations/export', [NominationController::class, 'export'])
        ->name('nominations.export');
    Route::patch('/nominations/{nomination}/status', [NominationController::class, 'updateStatus'])
        ->name('nominations.updateStatus');
    Route::get('nominations/cluster', [NominationController::class, 'cluster'])
        ->name('nominations.cluster');
    
    // Resource routes (excluding store as it's public)
    // This should come AFTER the specific routes to avoid conflicts
    Route::resource('nominations', NominationController::class)
        ->except(['store', 'index']) // exclude both store and index since we have custom ones
        ->where(['nomination' => '[0-9]+']);
});

Route::get('nominationdata', [NominationController::class, 'dataPage'])
    ->name('nominationdata.index');

require __DIR__.'/auth.php';