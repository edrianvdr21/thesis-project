<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MyBookingsController;
use App\Http\Controllers\SignUpController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('landing');
// });

// Route::get('/', [SignUpController::class, 'index']);
// Route::get(uri: '/', [AuthController::class, 'index']);

// Landing page
Route::get('/', [AuthController::class, 'index']);
// Go to Sign Up
Route::get('/sign-up', [AuthController::class, 'sign_up'])->name('sign_up');
// Go to Sign Up and Become a Worker
Route::get('/sign-up-and-become-a-worker', [AuthController::class, 'signUpAndBecomeAWorker'])->name('sign_up_and_become_a_worker');


// Login
Route::post('/login', [AuthController::class, 'login']);
// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Home page - landing page after Login
Route::get('/home', [AuthController::class, 'home'])->name('home');

    // Client Navbar
    // Go to Sign Up Worker page
    Route::get('/become-a-worker', [AuthController::class, 'sign_up_worker'])->name('sign_up_worker');
    // Go to My Bookings
    Route::get('/my-bookings', [MyBookingsController::class, 'my_bookings'])->name('my_bookings');
        // Cancel Booking
        Route::post('/cancel-booking/{booking}', [MyBookingsController::class, 'cancelBooking'])->name('cancel.booking');
        // Accept Booking
        Route::post('/accept-booking/{booking}', [MyBookingsController::class, 'acceptBooking'])->name('accept.booking');
        // Complete Booking
        Route::post('/complete-booking/{booking}', [MyBookingsController::class, 'completeBooking'])->name('complete.booking');
        // Submit Rating
        Route::post('/submit-rating/{booking}', [MyBookingsController::class, 'submitRating'])->name('submit.rating');



// Go to Worker Profile
Route::get('/worker/profile/{userId}/{workerProfileId}', [AuthController::class, 'showWorkerProfile'])->name('worker.profile');
    // Track Viewing
    // Route::post('/track/worker/profile/view', 'AuthController@trackView')->name('track.worker.profile.view');
    Route::post('/track/worker/profile/view', [AuthController::class, 'trackView'])->name('track.worker.profile.view');
// Book a Service
Route::post('/book', [AuthController::class, 'book'])->name('book');
