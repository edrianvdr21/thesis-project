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

    // public function mount()
    // {
    //     $this->categories = Category::all();
    //     $this->services = collect();
    // }

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

        // Forretrieving logged in user
        // $this->userId = Request::query('user_id');
        // $this->userId = $request->query('user_id');
        // $this->userProfile = UserProfile::where('user_id', $this->userId)->first();
    }

    // public function render()
    // {
    //     return view('livewire.sign-up-worker');
    // }

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
}
