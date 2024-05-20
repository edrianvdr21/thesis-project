<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\UserProfile;
use App\Models\User;
use App\Models\WorkerProfile;
use App\Models\Booking;

class HomePage extends Component
{
    public $workers;
    public $same_city_workers;

    public function mount()
    {
        // // Fetch workers with user, address, and bookings
        // $this->workers = WorkerProfile::with(['user.userProfile', 'address', 'bookings'])->get();

        // // Calculate average rating for each worker
        // $this->workers->each(function ($worker) {
        //     $bookings = $worker->bookings;
        //     if ($bookings->isNotEmpty()) {
        //         $worker->average_rating = $bookings->avg('rating');
        //         $worker->bookings_count = $worker->bookings()->count();
        //     } else {
        //         $worker->average_rating = null;
        //     }
        // });

        $this->workers = WorkerProfile::withRatings();
        $this->same_city_workers = WorkerProfile::inSameCityAsLoggedInUser();
    }

    public function render()
    {
        return view('livewire.home-page', [
            'workers' => $this->workers,
        ]);
    }

}
