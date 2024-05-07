<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\UserProfile;
use App\Models\User;

use Livewire\Component;

class HomePage extends Component
{
    // For logged in user
    public $userId;
    public $userProfile;

    // For displaying workers
    public $userProfiles;

    public function mount(Request $request)
    {
        // Retrieve the user_id query parameter from the request
        $this->userId = $request->query('user_id');

        $this->userProfile = UserProfile::where('user_id', $this->userId)->first();

// Displaying users where role_id = 2 "Client"
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

    public function render()
    {
        // Retrieve the authenticated user using the user_id
        $user = Auth::user();

        // Retrieve the user's details, perform any other logic as needed

        return view('livewire.home-page', [
            'user' => $user,
            'userProfile' => $this->userProfile,
        ]);
    }

}
