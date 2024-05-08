<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\UserProfile;

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
            $users = UserProfile::with('user')
                    ->whereHas('user', function ($query) {
                        $query->where('role_id', 2);
                    })
                    ->get();
    return view('home', ['users' => $users]);

        }

        // Authentication failed...
        // return redirect('/');
    }

    // Home
    public function home()
    {
        $users = UserProfile::with('user')
                    ->where('role_id', 3)
                    ->get();
return view('home', ['users' => $users]);

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

        // Create a new worker record associated with the user
        UserWorker::create([
            'user_id' => $user->id,
            // Add any additional fields you need for the worker record
        ]);

        // Redirect the user to a success page or any other appropriate destination
        return redirect()->route('worker_success');
    }
}
