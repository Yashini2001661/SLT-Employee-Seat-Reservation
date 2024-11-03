<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as Pdf;
use Illuminate\Support\Facades\Log;

// Root URL redirect
Route::get('/', function () {
    return redirect()->route('home'); // Redirect to home
});

// Regular Login Routes
Route::get('/loginRoute', function () {
    return view('user'); // User login view
})->name('login.view');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Facebook Login Routes
Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('facebook.login');
Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback'])->name('facebook.callback');

// Facebook Seat Booking Route
Route::get('/facebook-seat-booking', function () {
    return view('system-fb'); // Facebook-specific seat booking page
})->name('facebook.seat.booking');
// Google Login Routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

// Google Seat Booking Route
Route::get('/google-seat-booking', function () {
    return view('system-google'); // Google-specific seat booking page
})->name('google.seat.booking');



// Admin Routes
Route::get('/admin-login', [AdminController::class, 'showLoginForm'])->name('admin-login');
Route::post('/admin-login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin-dashboard', [AdminController::class, 'show'])->name('admin.show');
Route::post('/admin/download-excel', [AdminController::class, 'downloadExcel'])->name('admin.download.excel');
Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');

Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendance/mark', [AttendanceController::class, 'mark'])->name('attendance.mark');
Route::get('/attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');

// Seat Booking Routes
Route::get('/seat-booking', [BookingController::class, 'index'])->name('seat.booking');
Route::get('/get-seats', [BookingController::class, 'getSeats'])->name('get.seats');
Route::post('/book-seat', [BookingController::class, 'bookSeat'])->name('book.seat');
Route::get('/user-bookings', [BookingController::class, 'userBookings'])->name('user.bookings');
Route::delete('/cancel-booking/{id}', [BookingController::class, 'cancelBooking'])->name('cancelBooking');

// Password Reset Routes
Route::get('/forgot-password', [PasswordController::class, 'showForgotPasswordForm'])->name('changepw');
Route::post('/forgot-password', [PasswordController::class, 'resetPassword'])->name('changepw.reset');

// Home Route
Route::get('/homeRoute', function () {
    return view('home'); // Home page view
})->name('home');


