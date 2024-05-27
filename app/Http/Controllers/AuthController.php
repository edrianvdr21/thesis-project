<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\UserProfile;
use App\Models\User;
use App\Models\WorkerProfile;
use App\Models\WorkerProfileView;

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

    // Go to sign up and Become a Worker
    public function signUpAndBecomeAWorker()
    {
        return view('auth.sign-up-and-become-a-worker');
    }

    // Login
    public function login(Request $request)
    {

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $workers = WorkerProfile::with('user')->get();

            return redirect()->route('home');
        }

        $user = User::where('username', $credentials['username'])->first();

        // Username doesn't exist
        if (!$user) {
            return redirect()->back()->withInput($request->only('username'))->withErrors(['error' => 'Account does not exist.']);
        }

        // Incorrect password
        return redirect()->back()->withInput($request->only('username'))->withErrors(['error' => 'Incorrect password.']);
    }

    // Home
    public function home()
    {
        // $workers = WorkerProfile::with(['user.userProfile', 'bookings'])->get();

        // $workers->each(function ($worker) {
        //     $worker->average_rating = $worker->bookings()->avg('rating');
        // });

        // $bookings = Booking::all();

        // return view('home', [
        //     'workers' => $workers,
        //     'bookings' => $bookings
        // ]);

        return view('home');

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

        $working_days_string = implode(',', array_map(function ($day) {
            return $day ? '1' : '0';
        }, $this->working_days));

        // Insert into worker_profiles
        $user->workerprofile()->create([
            'user_id' => $user->id,
            'category_id' => $this->category,
            'service_id' => $this->service,
            'description' => $this->description,
            'pricing' => $this->pricing,
            'minimum_duration' => $this->minimum_duration,
            'maximum_duration' => $this->maximum_duration,
            'working_days' => $working_days_string,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'valid_id' => $this->valid_id,
            'resume' => $this->resume,
        ]);

        // Update the role_id to 3 in the user_profiles table
        $user->profile()->update(['role_id' => 3]);

        // dd([
        //     'user_id' => $user->id,
        //     'category_id' => $this->category,
        //     'service_id' => $this->service,
        //     'description' => $this->description,
        //     'pricing' => $this->pricing,
        //     'minimum_duration' => $this->minimum_duration,
        //     'maximum_duration' => $this->maximum_duration,
        //     'working_days' => $working_days_string,
        //     'start_time' => $this->start_time,
        //     'end_time' => $this->end_time,
        //     'valid_id' => $this->valid_id,
        //     'resume' => $this->resume,
        // ]);

        // Create a new worker record associated with the user
        // $userWorker = UserWorker::create([
        //     'user_id' => $user->id,
        //     'category_id' => $request->input('category'),
        //     'service_id' => $request->input('service'),
        //     'description' => $request->input('description'),
        //     'pricing' => $request->input('pricing'),
        //     'minimum_duration' => $request->input('minimum_duration'),
        //     'maximum_duration' => $request->input('maximum_duration'),
        //     'working_days' => $request->input('working_days'),
        //     'start_time' => $request->input('start_time'),
        //     'end_time' => $request->input('end_time'),
        //     'valid_id' => $request->input('valid_id'),
        //     'resume' => $request->input('resume'),
        // ]);

        // Redirect the user to a success page or any other appropriate destination
        return redirect('home');
    }












    /**
     * Display the specified worker profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showWorkerProfile($userId, $workerProfileId)
    {
        $user = Auth::user();
        $worker = User::findOrFail($userId);

        // Fetch the worker's details from user_profiles table
        $userProfile = UserProfile::where('user_id', $userId)->first();

        // Fetch the worker's details from worker_profiles table
        $workerProfile = WorkerProfile::where('id', $workerProfileId)->first();

        // Assuming the working_days column contains a string like "1,1,1,0,0,0,0"
        $workingDaysArray = explode(',', $workerProfile->working_days);

        $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $availableDays = [];

        foreach ($workingDaysArray as $index => $isAvailable) {
            if ($isAvailable == 1) {
                $availableDays[] = $daysOfWeek[$index];
            }
        }

        return view('worker-profile', compact('user', 'worker', 'userProfile', 'workerProfile', 'availableDays'));
    }

    // Tracking of Viewing a Worker's Profile
    public function trackView(Request $request)
    {
        $userId = auth()->id();
        $workerId = $request->worker_id;

        // Get the last view for the current user and worker
        $lastView = WorkerProfileView::where('user_id', $userId)
                    ->where('worker_id', $workerId)
                    ->latest('viewed_at')
                    ->first();

        // Check if the last view was more than 15 minutes ago
        if ($lastView && $lastView->viewed_at->gt(Carbon::now()->subMinutes(15))) {
            // If less than 15 minutes, redirect without inserting
            return redirect()->route('worker.profile', ['userId' => $request->user_id, 'workerProfileId' => $workerId]);
        }

        // Insert new view record
        WorkerProfileView::create([
            'user_id' => $userId,
            'worker_id' => $workerId,
            'category_id' => $request->category_id,
            'service_id' => $request->service_id,
            'viewed_at' => now(),
        ]);

        return redirect()->route('worker.profile', ['userId' => $request->user_id, 'workerProfileId' => $workerId]);
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
            $booking->booked_datetime = Carbon::now();
            $booking->save();

            return redirect()->back()->with('success', 'You\'ve successfully booked a service!');
        }
    }
