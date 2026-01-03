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
Route::get('events/{event}/checkout', [\App\Http\Controllers\EventController::class, 'checkout'])->middleware('auth')->name('events.checkout');

// Payment routes
Route::middleware('auth')->group(function () {
    Route::post('events/{event}/payment', [\App\Http\Controllers\PaymentController::class, 'create'])->name('payment.create');
    Route::get('payment/{order}/return', [\App\Http\Controllers\PaymentController::class, 'return'])->name('payment.return');
    Route::get('payment/{order}/success', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
    Route::get('payment/{order}/failed', [\App\Http\Controllers\PaymentController::class, 'failed'])->name('payment.failed');
    Route::get('payment/{order}/pending', [\App\Http\Controllers\PaymentController::class, 'pending'])->name('payment.pending');

    // Ticket download routes
    Route::get('orders/{order}/ticket/download', [\App\Http\Controllers\PaymentController::class, 'downloadTicket'])->name('order.ticket.download');
    Route::get('orders/{order}/ticket/preview', [\App\Http\Controllers\PaymentController::class, 'previewTicket'])->name('order.ticket.preview');
});

// Mollie webhook (no auth middleware needed)
Route::post('webhooks/mollie', [\App\Http\Controllers\PaymentController::class, 'webhook'])->name('payment.webhook');

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

    // Category management routes
    Route::post('categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Payment management routes
    Route::get('payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('payments/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('admin.payments.show');
    Route::get('payments/{payment}/ticket/preview', [\App\Http\Controllers\Admin\PaymentController::class, 'previewTicket'])->name('admin.payments.ticket.preview');
});
