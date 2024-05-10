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

Route::get('/home', function () {
    return view('home');
});

// Route::get('/', [SignUpController::class, 'index']);
// Route::get(uri: '/', [AuthController::class, 'index']);

// Landing page
Route::get('/', [AuthController::class, 'index']);
// Route::get('/', [AuthController::class, 'index'])->name('landing');
// Route::get('/sign_up', [AuthController::class, 'sign_up']);
Route::get('/sign-up', [AuthController::class, 'sign_up'])->name('sign_up');
// Login
Route::post('/login', [AuthController::class, 'login']);
// Home page - landing page after Login
Route::get('/home', [AuthController::class, 'home'])->name('home');
// Go to Sign Up Worker page
Route::get('/become-a-worker', [AuthController::class, 'sign_up_worker'])->name('sign_up_worker');
// Go to Worker Profile
Route::get('/worker/{id}', [AuthController::class, 'showWorkerProfile'])->name('worker.profile');
// Book a Service
Route::post('/book', [AuthController::class, 'book'])->name('book');






// Route::get('/index', [SignUpController::class, 'index'])->name('index');
// Route::get('/sign_up', [SignUpController::class, 'sign_up'])->name('sign_up');
// Route::get('/sign_up_worker', [SignUpController::class, 'sign_up_worker'])->name('sign_up_worker');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
