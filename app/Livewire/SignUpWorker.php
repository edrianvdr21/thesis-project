<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Service;

use App\Models\UserProfile;
use App\Models\User;

class SignUpWorker extends Component
{

    // For initial load
    public $categories;
    public $services;

    public $category;
    public $service;

    // Load services options based on selected category
    public function loadServices()
    {
        $this->services = Service::where('category_id', $this->category)->get();
    }

    // For logged in user
    public $userId;
    public $userProfile;

    public function mount()
    {
        // For category and service select tags
        $this->categories = Category::all();
        $this->services = collect();

        // Initialize the working_days array with default values
        $this->working_days = [
            'sunday' => false,
            'monday' => false,
            'tuesday' => false,
            'wednesday' => false,
            'thursday' => false,
            'friday' => false,
            'saturday' => false,
        ];
    }

    public function render()
    {
        // Retrieve the authenticated user using the user_id
        $user = Auth::user();

        // Retrieve the user's details, perform any other logic as needed
        return view('livewire.sign-up-worker', [
            'user' => $user,
            'userProfile' => $this->userProfile,
        ]);
    }

    // Wir model binding
    public $description;
    public $pricing;
    public $minimum_duration;
    public $maximum_duration;
    public $working_days = [];
    public $start_time;
    public $end_time;
    public $valid_id;
    public $resume;
    public $working_days_string;


    public function sign_up_as_a_worker()
    {
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

        dd([
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

        // dd("Method triggered successfully!");
    }
}
