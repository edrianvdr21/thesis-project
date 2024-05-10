<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\UserProfile;
use App\Models\User;
use App\Models\WorkerProfile;

use App\Models\Booking;

class AuthController extends Controller
{
    // Landing page
    public function index()
    {
        return view('landing');
    }

    // Go to sign up
    public function sign_up()
    {
        return view('auth.sign-up');
    }

    // Login
    public function login(Request $request)
    {

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $users = UserProfile::with('user')
                    ->whereHas('user', function ($query) {
                        $query->where('role_id', 2);
                    })
                    ->get();
            return view('home', ['users' => $users]);
        }

        // Authentication failed...
        // return redirect('/');
    }

    // Home
    public function home()
    {
        $users = UserProfile::with('user')
                    ->where('role_id', 3)
                    ->get();
        return view('home', ['users' => $users]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Go to sign up Worker
    public function sign_up_worker()
    {
        return view('auth.sign-up-worker');
    }

    public function becomeWorker(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Create a new worker record associated with the user
        UserWorker::create([
            'user_id' => $user->id,
            // Add any additional fields you need for the worker record
        ]);

        // Redirect the user to a success page or any other appropriate destination
        return redirect()->route('worker_success');
    }












    /**
     * Display the specified worker profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showWorkerProfile($id)
    {
        $user = Auth::user();

        $worker = User::findOrFail($id);

        // Fetch the worker's details from user_profiles table
        $userProfile = UserProfile::where('user_id', $id)->first();

        // Fetch the worker's details from worker_profiles table
        $workerProfile = WorkerProfile::where('user_id', $id)->first();

        return view('worker-profile', compact('user', 'worker', 'userProfile', 'workerProfile'));
    }

    // Book a Service
    public function book(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'user_id' => 'required',
            'worker_id' => 'required',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'booking_notes' => 'required|string',
        ]);

        // Insert into bookings table
        $booking = new Booking();
        $booking->user_id = $validatedData['user_id'];
        $booking->worker_id = $validatedData['worker_id'];
        $booking->date = $validatedData['booking_date'];
        $booking->time = $validatedData['booking_time'];
        $booking->notes = $validatedData['booking_notes'];
        $booking->status = "Pending";
        $booking->save();

        // Optionally, you can redirect the user after successful submission
        return redirect()->back()->with('success', 'Booking has been created successfully.');
    }


}
