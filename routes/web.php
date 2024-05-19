<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
// Route::get('/sign_up', [AuthController::class, 'sign_up']);
Route::get('/sign-up', [AuthController::class, 'sign_up'])->name('sign_up');
// Login
Route::post('/login', [AuthController::class, 'login']);
    // Home page - landing page after Login
    Route::get('/home', [AuthController::class, 'home'])->name('home');

        // Client Navbar
        // Go to Sign Up Worker page
        Route::get('/become-a-worker', [AuthController::class, 'sign_up_worker'])->name('sign_up_worker');
        // Go to My Bookings
        Route::get('/my-bookings', [AuthController::class, 'my_bookings'])->name('my_bookings');
            // Cancel Booking
            Route::post('/cancel-booking/{booking}', [AuthController::class, 'cancelBooking'])->name('cancel.booking');
            // Accept Booking
            Route::post('/accept-booking/{booking}', [AuthController::class, 'acceptBooking'])->name('accept.booking');



// Go to Worker Profile
Route::get('/worker/profile/{userId}/{workerProfileId}', [AuthController::class, 'showWorkerProfile'])->name('worker.profile');
// Book a Service
Route::post('/book', [AuthController::class, 'book'])->name('book');






// Route::get('/index', [SignUpController::class, 'index'])->name('index');
// Route::get('/sign_up', [SignUpController::class, 'sign_up'])->name('sign_up');
// Route::get('/sign_up_worker', [SignUpController::class, 'sign_up_worker'])->name('sign_up_worker');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
