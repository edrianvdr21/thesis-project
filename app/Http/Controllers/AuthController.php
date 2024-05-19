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
        $workers = WorkerProfile::with('user.userProfile')->get();
        return view('home', ['workers' => $workers]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Go to My Bookings (Client Navbar)
    public function my_bookings(Request $request)
    {
        $user = Auth::user();
        $my_bookings_as_role = $request->query('my_bookings_as_role');
        $filter_by_status = $request->query('filter_by_status');

        // Clients - My Bookings
        $clientBookingsQuery = Booking::with('user')->where('user_id', auth()->user()->id);

        // Fetch bookings based on the filter
        if ($filter_by_status) {
            $clientBookingsQuery->where('status', $filter_by_status);
        }

        $bookings = $clientBookingsQuery->get();

        // Initialize status counts
        $totalCount = 0;
        $pendingCount = 0;
        $acceptedCount = 0;
        $completedCount = 0;
        $cancelledCount = 0;

        // Clients - Count statuses
        if ($my_bookings_as_role == "as Client") {
            $statusCounts = Booking::where('user_id', $user->id)
                ->selectRaw('COUNT(*) as total')
                ->selectRaw('SUM(case when status = "Pending" then 1 else 0 end) as pending_count')
                ->selectRaw('SUM(case when status = "Accepted" then 1 else 0 end) as accepted_count')
                ->selectRaw('SUM(case when status = "Completed" then 1 else 0 end) as completed_count')
                ->selectRaw('SUM(case when status = "Cancelled" then 1 else 0 end) as cancelled_count')
                ->first();

            // Assign counts
            $totalCount = $statusCounts->total ?? 0;
            $pendingCount = $statusCounts->pending_count ?? 0;
            $acceptedCount = $statusCounts->accepted_count ?? 0;
            $completedCount = $statusCounts->completed_count ?? 0;
            $cancelledCount = $statusCounts->cancelled_count ?? 0;
        }

        // Workers - My Bookings
        $workerBookingsQuery = Booking::with('workerProfile.user')
            ->whereHas('workerProfile.user', function ($query) use ($user) {
                $query->where('id', $user->id);
            });

        // Fetch bookings based on the filter
        if ($filter_by_status) {
            $workerBookingsQuery->where('status', $filter_by_status);
        }

        $workerBookings = $workerBookingsQuery->orderBy('id', 'desc')->get();

        // Workers - Count statuses
        if ($my_bookings_as_role == "as Worker") {
            // $statusCounts = Booking::whereHas('workerProfile.user', function ($query) use ($user) {
            //         $query->where('id', $user->id);
            //     })
            //     ->when($filter_by_status, function ($query, $status) {
            //         $query->where('status', $status);
            //     })
            //     ->selectRaw('COUNT(*) as total')
            //     ->selectRaw('SUM(case when status = "Pending" then 1 else 0 end) as pending_count')
            //     ->selectRaw('SUM(case when status = "Accepted" then 1 else 0 end) as accepted_count')
            //     ->selectRaw('SUM(case when status = "Completed" then 1 else 0 end) as completed_count')
            //     ->selectRaw('SUM(case when status = "Cancelled" then 1 else 0 end) as cancelled_count')
            //     ->first();

            // // Assign counts
            // $totalCount = $statusCounts->total ?? 0;
            // $pendingCount = $statusCounts->pending_count ?? 0;
            // $acceptedCount = $statusCounts->accepted_count ?? 0;
            // $completedCount = $statusCounts->completed_count ?? 0;
            // $cancelledCount = $statusCounts->cancelled_count ?? 0;

            $totalCount = Booking::whereHas('workerProfile.user', function ($query) use ($user) {
                $query->where('id', $user->id);
            })->count();

            $pendingCount = Booking::whereHas('workerProfile.user', function ($query) use ($user) {
                $query->where('id', $user->id);
            })->where('status', 'Pending')->count();

            $acceptedCount = Booking::whereHas('workerProfile.user', function ($query) use ($user) {
                $query->where('id', $user->id);
            })->where('status', 'Accepted')->count();

            $completedCount = Booking::whereHas('workerProfile.user', function ($query) use ($user) {
                $query->where('id', $user->id);
            })->where('status', 'Completed')->count();

            $cancelledCount = Booking::whereHas('workerProfile.user', function ($query) use ($user) {
                $query->where('id', $user->id);
            })->where('status', 'Cancelled')->count();
        }

        return view('my-bookings', [
            'user' => $user,
            'bookings' => $bookings,
            'workerBookings' => $workerBookings,
            'my_bookings_as_role' => $my_bookings_as_role,
            'totalCount' => $totalCount,
            'pendingCount' => $pendingCount,
            'acceptedCount' => $acceptedCount,
            'completedCount' => $completedCount,
            'cancelledCount' => $cancelledCount,
            'filter_by_status' => $filter_by_status,
        ]);
    }


    // Cancel booking
    public function cancelBooking(Request $request, Booking $booking)
    {
        $user = Auth::user();

    // Updating the booking status
    $booking->status = 'Cancelled';
    $booking->save();

    // Redirect back to the previous page
    return redirect()->back();

    }

    // Accept booking
    public function acceptBooking(Request $request, Booking $booking)
    {
        $user = Auth::user();

        // Updating the booking status
        $booking->status = 'Accepted';
        $booking->save();

        // Redirect back to the previous page
        return redirect()->back();
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
        $users = UserProfile::with('user')
                    ->where('role_id', 3)
                    ->get();
        return view('home', ['users' => $users]);
    }


}
