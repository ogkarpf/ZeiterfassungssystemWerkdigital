<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkTimeController;
use App\Http\Controllers\OverviewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\Zeiterfassung;

// API Routen
Route::post('/api/work-time/start', [WorkTimeController::class, 'start']);
Route::post('/api/work-time/stop', [WorkTimeController::class, 'stop']);

//Mail Routes
Route::post('mail/sendmail/{userid}', function($userid) {
    Mail::to('personalabteilung@firma.de')->send(new Zeiterfassung($userid));
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/overview', [OverviewController::class, 'getOverview'])->name('overview');
});

require __DIR__.'/auth.php';
