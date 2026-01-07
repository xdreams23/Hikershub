<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\MountainController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PageController;

// User Controllers
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\ReviewController as UserReviewController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MountainController as AdminMountainController;
use App\Http\Controllers\Admin\TripController as AdminTripController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (No Authentication Required)
|--------------------------------------------------------------------------
*/

// Homepage
// 1. Welcome Page (Halaman Depan / Landing Page)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 2. Home Page (Halaman Utama Konten)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Trips (Public browsing)
Route::get('/trips', [TripController::class, 'index'])->name('trips.index');
Route::get('/trips/{trip}', [TripController::class, 'show'])->name('trips.show');

// Mountains (Public browsing)
Route::get('/mountains', [MountainController::class, 'index'])->name('mountains.index');
Route::get('/mountains/{mountain}', [MountainController::class, 'show'])->name('mountains.show');

// Gallery (Public)
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

// FAQ (Public)
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

// About & Contact (Public)
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| USER ROUTES (Authenticated Users Only)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Bookings
    Route::get('/bookings', [UserBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{trip}', [UserBookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/create/{trip}', [UserBookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [UserBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/upload-payment', [UserBookingController::class, 'uploadPayment'])->name('bookings.upload-payment');
    Route::post('/bookings/{booking}/cancel', [UserBookingController::class, 'cancel'])->name('bookings.cancel');
    
    // Profile
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password');
    
    // Reviews
    Route::get('/reviews/create/{trip}', [UserReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews/{trip}', [UserReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [UserReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [UserReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [UserReviewController::class, 'destroy'])->name('reviews.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Admin Only)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Mountains Management
    Route::resource('mountains', AdminMountainController::class);
    
    // Trips Management
    Route::resource('trips', AdminTripController::class);
    Route::post('/trips/{trip}/update-status', [AdminTripController::class, 'updateStatus'])->name('trips.update-status');
    
    // Bookings Management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/update-status', [AdminBookingController::class, 'updateStatus'])->name('bookings.update-status');
    Route::post('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    
    // Payments Management
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/pending', [AdminPaymentController::class, 'pending'])->name('payments.pending');
    Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/verify', [AdminPaymentController::class, 'verify'])->name('payments.verify');
    
    // Users Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
    
    // Reviews Management
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{review}', [AdminReviewController::class, 'show'])->name('reviews.show');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Gallery Management
    Route::resource('galleries', AdminGalleryController::class);
    
    // FAQ Management
    Route::resource('faqs', AdminFaqController::class);
    
    // Reports
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/revenue', [AdminReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('/reports/bookings', [AdminReportController::class, 'bookings'])->name('reports.bookings');
    Route::get('/reports/trips', [AdminReportController::class, 'trips'])->name('reports.trips');
    Route::get('/reports/mountains', [AdminReportController::class, 'mountains'])->name('reports.mountains');
    Route::get('/reports/participants', [AdminReportController::class, 'participants'])->name('reports.participants');
});

/*
|--------------------------------------------------------------------------
| BREEZE AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';