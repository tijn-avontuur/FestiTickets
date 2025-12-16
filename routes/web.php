<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('home');
})->name('home');

// Public event viewing (for all users, auth and guest)
Route::get('events', [\App\Http\Controllers\EventController::class, 'index'])->name('events.index');
Route::get('events/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
});

// Admin routes (only for admins) - separate middleware group
Route::middleware(['auth', 'verified', 'can:admin'])->prefix('admin')->group(function () {
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class)->names([
        'index' => 'admin.events.index',
        'create' => 'admin.events.create',
        'store' => 'admin.events.store',
        'edit' => 'admin.events.edit',
        'update' => 'admin.events.update',
        'destroy' => 'admin.events.destroy',
    ]);
});
