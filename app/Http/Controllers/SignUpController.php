<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignUpController extends Controller
{
    public function index()
    {
        return view('landing');
    }

    public function sign_up()
    {
        return view('auth.sign-up');
    }

    public function sign_up_worker()
    {
        return view('auth.sign-up-worker');
    }
    // public function sign_up_worker(Request $request)
    // {
    //     $userId = $request->query('user_id');

    //     // Pass the user ID to the view
    //     return view('auth.sign-up-worker', compact('userId'));
    // }

}
