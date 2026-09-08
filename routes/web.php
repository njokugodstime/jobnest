<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [JobListingController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Job listings (employer actions)
    Route::get('/jobs/create', [JobListingController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobListingController::class, 'store'])->name('jobs.store');
    Route::get('/my-listings', [JobListingController::class, 'myListings'])->name('jobs.my-listings');
    Route::get('/jobs/{job}/edit', [JobListingController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{job}', [JobListingController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{job}', [JobListingController::class, 'destroy'])->name('jobs.destroy');
    Route::get('/jobs/{job}/applicants', [JobListingController::class, 'applicants'])->name('jobs.applicants');

    // Applications (candidate actions)
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('applications.my-applications');
    Route::patch('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.update-status');
});

// Public job listing view (must come after /jobs/create to avoid route conflicts)
Route::get('/jobs/{job}', [JobListingController::class, 'show'])->name('jobs.show');

require __DIR__.'/auth.php';