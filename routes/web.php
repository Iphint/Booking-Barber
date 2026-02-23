<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// ─── Landing Page ─────────────────────────────────────────────────────────
Route::get('/', [BookingController::class, 'index'])->name('home');

// ─── Booking Store (AJAX - return JSON) ──────────────────────────────────
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// ─── Halaman hasil pembayaran (dipanggil Midtrans setelah bayar) ──────────
Route::get('/booking/finish',  [BookingController::class, 'finish'])->name('booking.finish');
Route::get('/booking/pending', [BookingController::class, 'pending'])->name('booking.pending');
Route::get('/booking/error',   [BookingController::class, 'error'])->name('booking.error');

// ─── Midtrans Webhook — WAJIB exclude CSRF ────────────────────────────────
Route::post('/midtrans/notification', [BookingController::class, 'notification'])
    ->name('midtrans.notification');

// ─── Schedule ─────────────────────────────────────────────────────────────
// GET /schedule/check?date=2026-02-23&barber=Dawam → slot yang sudah dipesan
Route::get('/schedule/check', [\App\Http\Controllers\ScheduleController::class, 'check'])
    ->name('schedule.check');

// GET /schedule/available?date=2026-02-23&barber=Dawam → slot yang tersedia
Route::get('/schedule/available', [\App\Http\Controllers\ScheduleController::class, 'available'])
    ->name('schedule.available');

// ─── Admin Panel (semua route dilindungi auth) ────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('dashboard');

    // Redirect /admin → /admin/dashboard
    Route::get('/', fn() => redirect()->route('admin.dashboard'));

    // Bookings CRUD
    Route::get('/bookings',                [\App\Http\Controllers\Admin\BookingController::class, 'index'])  ->name('bookings.index');
    Route::get('/bookings/{booking}',      [\App\Http\Controllers\Admin\BookingController::class, 'show'])   ->name('bookings.show');
    Route::patch('/bookings/{booking}',    [\App\Http\Controllers\Admin\BookingController::class, 'update']) ->name('bookings.update');
    Route::delete('/bookings/{booking}',   [\App\Http\Controllers\Admin\BookingController::class, 'destroy'])->name('bookings.destroy');

    // Schedule
    Route::get('/schedule', [\App\Http\Controllers\Admin\ScheduleController::class, 'index'])
        ->name('schedule');
});




require __DIR__.'/auth.php';