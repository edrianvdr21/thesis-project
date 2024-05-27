<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


use App\Models\UserProfile;
use App\Models\User;
use App\Models\WorkerProfile;

use App\Models\Booking;

class MyBookingsController extends Controller
{
    public function my_bookings(Request $request)
    {
        $user = Auth::user();
        $my_bookings_as_role = $request->query('my_bookings_as_role');
        $filter_by_status = $request->query('filter_by_status');

        // Initialize status counts
        $totalCount = 0;
        $pendingCount = 0;
        $acceptedCount = 0;
        $completedCount = 0;
        $cancelledCount = 0;

        // Fetch client bookings and count statuses if role is client
        if ($my_bookings_as_role == "as Client") {
            $bookings = Booking::clientBookings($user->id, $filter_by_status);
            $statusCounts = Booking::countClientStatuses($user->id);
        } else {
            $bookings = [];
            $statusCounts = [
                'total' => 0,
                'pending_count' => 0,
                'accepted_count' => 0,
                'completed_count' => 0,
                'cancelled_count' => 0,
            ];
        }

        // Fetch worker bookings and count statuses if role is worker
        if ($my_bookings_as_role == "as Worker") {
            $workerBookings = Booking::workerBookings($user->id, $filter_by_status);
            $workerStatusCounts = Booking::countWorkerStatuses($user->id);

            return view('my-bookings', [
                'user' => $user,
                'bookings' => $bookings,
                'workerBookings' => $workerBookings,
                'my_bookings_as_role' => $my_bookings_as_role,
                'totalCount' => $workerStatusCounts['total'] ?? 0,
                'pendingCount' => $workerStatusCounts['pending_count'] ?? 0,
                'acceptedCount' => $workerStatusCounts['accepted_count'] ?? 0,
                'completedCount' => $workerStatusCounts['completed_count'] ?? 0,
                'cancelledCount' => $workerStatusCounts['cancelled_count'] ?? 0,
                'filter_by_status' => $filter_by_status,
            ]);
        } else {
            $workerBookings = [];
            $workerStatusCounts = [
                'total' => 0,
                'pending_count' => 0,
                'accepted_count' => 0,
                'completed_count' => 0,
                'cancelled_count' => 0,
            ];
        }

        return view('my-bookings', [
            'user' => $user,
            'bookings' => $bookings,
            'workerBookings' => $workerBookings,
            'my_bookings_as_role' => $my_bookings_as_role,
            'totalCount' => $statusCounts['total'] ?? 0,
            'pendingCount' => $statusCounts['pending_count'] ?? 0,
            'acceptedCount' => $statusCounts['accepted_count'] ?? 0,
            'completedCount' => $statusCounts['completed_count'] ?? 0,
            'cancelledCount' => $statusCounts['cancelled_count'] ?? 0,
            'filter_by_status' => $filter_by_status,
        ]);
    }



    // Cancel booking
    public function cancelBooking(Request $request, Booking $booking)
    {
        $user = Auth::user();
        $cancelled_by = $request->input('cancelled_by');

        // Updating the booking status
        $booking->status = 'Cancelled';
        $booking->cancelled_datetime = Carbon::now();
        $booking->cancelled_by = $cancelled_by;
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
        $booking->accepted_datetime = Carbon::now();
        $booking->save();

        // Redirect back to the previous page
        return redirect()->back();
    }

    // Complete booking
    public function completeBooking(Request $request, Booking $booking)
    {
        $user = Auth::user();

        // Updating the booking status
        $booking->status = 'Completed';
        $booking->completed_datetime = Carbon::now();
        $booking->save();

        // Redirect back to the previous page
        return redirect()->back();
    }

    // Review
    public function submitRating(Request $request, Booking $booking)
    {
        $user = Auth::user();
        $rating = $request->input('rating');
        $review = $request->input('review');

        // Validate the incoming data
        $validatedData = $request->validate([
            'rating' => 'required',
            'review' => 'required',
        ], [
            'rating.required' => 'Rating is required',
            'review.required' => 'Review is required',
        ]);

        // Updating the booking
        $booking->rating = $rating;
        $booking->review = $review;
        $booking->save();

        // Redirect back to the previous page
        return redirect()->back();
    }












    // Reference and Backup purposes
    // 1st version of Go to My Bookings (Client Navbar)
    public function xmy_sbookings(Request $request)
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
}
