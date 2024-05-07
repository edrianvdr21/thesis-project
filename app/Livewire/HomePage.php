<?php

namespace App\Livewire;
use App\Models\UserProfile;
use App\Models\User;

use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        return view('livewire.home-page');
    }

    public $user;

    protected $listeners = ['userLoggedIn'];

    public function userLoggedIn($user)
    {
        $this->user = $user;
    }

    public $userProfiles;

    public function mount()
    {
        // Fetch all user profiles
        // $this->userProfiles = UserProfile::all();

        // Fetch Clients
        // $this->userProfiles = UserProfile::where('role_id', 2)->get();

        // Retrieve user details using the userId passed from the route
        // $this->user = User::findOrFail($userId);

        $this->userProfiles = UserProfile::where('role_id', 2)->get()->map(function ($profile) {
            // Convert gender_id
            switch ($profile->gender_id) {
                case 1:
                    $profile->gender_id = 'Female';
                    break;
                case 2:
                    $profile->gender_id = 'Male';
                    break;
                case 3:
                    $profile->gender_id = 'Others';
                    break;
            }

            // Convert marital_status_id
            switch ($profile->marital_status_id) {
                case 1:
                    $profile->marital_status_id = 'Single';
                    break;
                case 2:
                    $profile->marital_status_id = 'Married';
                    break;
                case 3:
                    $profile->marital_status_id = 'Divorced';
                    break;
                case 4:
                    $profile->marital_status_id = 'Widowed';
                    break;
                case 5:
                    $profile->marital_status_id = 'Separated';
                    break;
            }

            return $profile;
        });

    }
}
