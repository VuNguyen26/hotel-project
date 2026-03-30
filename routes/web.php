<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicRoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PublicBookingController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\PublicContactController;
use App\Http\Controllers\AdminContactMessageController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/our-rooms', [PublicRoomController::class, 'index'])->name('public.rooms.index');
Route::get('/our-rooms/{room}', [PublicRoomController::class, 'show'])->name('public.rooms.show');
Route::get('/our-rooms/{room}/book', [PublicBookingController::class, 'create'])->name('public.bookings.create');
Route::post('/our-rooms/{room}/book', [PublicBookingController::class, 'store'])->name('public.bookings.store');
Route::get('/booking-success', [PublicBookingController::class, 'success'])->name('public.bookings.success');
Route::get('/booking-lookup', [PublicBookingController::class, 'lookupForm'])->name('public.bookings.lookup');
Route::post('/booking-lookup', [PublicBookingController::class, 'lookupResult'])->name('public.bookings.lookup.submit');

Route::get('/about', [PublicPageController::class, 'about'])->name('public.about');
Route::get('/news', [PublicPageController::class, 'news'])->name('public.news.index');
Route::get('/news/{slug}', [PublicPageController::class, 'newsShow'])->name('public.news.show');

Route::get('/contact', [PublicContactController::class, 'index'])->name('public.contact');
Route::post('/contact', [PublicContactController::class, 'store'])->name('public.contact.store');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('room-types', RoomTypeController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('customers', CustomerController::class);

    Route::get('/bookings/export/excel', [BookingController::class, 'exportExcel'])->name('bookings.export-excel');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');
    Route::resource('bookings', BookingController::class);

    Route::get('/payments/export/pdf', [PaymentController::class, 'exportPdf'])->name('payments.export-pdf');
    Route::resource('payments', PaymentController::class)->only(['index', 'create', 'store']);

    Route::get('/contact-messages', [AdminContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::get('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'show'])->name('contact-messages.show');
    Route::patch('/contact-messages/{contactMessage}/read', [AdminContactMessageController::class, 'markRead'])->name('contact-messages.read');
    Route::patch('/contact-messages/{contactMessage}/unread', [AdminContactMessageController::class, 'markUnread'])->name('contact-messages.unread');
    Route::delete('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
});