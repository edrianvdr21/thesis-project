<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class Login extends Component
{
    public function render()
    {
        return view('livewire.login');
    }

    public $username;
    public $password;

    public function login()
    {
        $credentials = [
            'username' => $this->username,
            'password' => $this->password,
        ];

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // $user = Auth::user();
            // $this->emit('userLoggedIn', $user);
            return redirect('/home-page');
        } else {
            // Authentication failed
            // You can handle failed login attempts here, such as showing an error message
            // or emitting an event to update the UI
            $this->addError('loginError', 'Invalid username or password.');
        }
    }

    // Method to retrieve authenticated user's details
    public function userDetails()
    {
        // Check if user is authenticated
        if (Auth::check()) {
            // Get authenticated user
            $user = Auth::user();

            // Access user's details
            $firstName = $user->first_name;
            $lastName = $user->last_name;

            // You can return the user's details or use them as needed
            return [
                'first_name' => $firstName,
                'last_name' => $lastName,
            ];
        }
    }

}
