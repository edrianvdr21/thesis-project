<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\UserProfile;
use App\Models\User;

class HomePage extends Component
{
    public $users;

    public function mount()
    {
        // Display all users
        // $this->users = UserProfile::with('user')->get();

        // Display all workers
        $this->users = UserProfile::with('user')
            ->where('role_id', 3)
            ->get();

    }

    public function render()
    {
        return view('livewire.home-page');
    }

}
