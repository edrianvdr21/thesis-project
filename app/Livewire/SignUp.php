<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Region;
use App\Models\Province;
use App\Models\City;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;

class SignUp extends Component
{
    public function render()
    {
        return view('livewire.sign-up');
    }

    public $regions;
    public $provinces;
    public $cities;

    public function mount()
    {
        $this->regions = Region::all();
        $this->provinces = collect();
        $this->cities = collect();
    }

    // Load province options when region changes
    public function loadProvinces()
    {
        $this->provinces = Province::where('region_id', $this->region)->get();
    }

    // Load city options when province changes
    public function loadCities()
    {
        $this->cities = City::where('province_id', $this->province)->get();
    }

    // Wire model binding
    public $first_name;
    public $middle_name;
    public $last_name;
    public $suffix;
    public $birthdate;
    public $gender;
    public $marital_status;

    public $home_address;
    public $region;
    public $province;
    public $city;
    public $email_address;
    public $mobile_number;

    public $username;
    public $password;
    public $confirm_password;

    public function sign_up()
    {
        // Validate data if needed

        // Insert into users table
        $user = User::create([
            'username' => $this->username,
            'password' => Hash::make($this->password),
        ]);

        // Get the ID of the just created user
        $user_id = $user->id;

        // Insert into user_profiles table
        $user->profile()->create([
            'user_id' => $user_id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'suffix' => $this->suffix,
            'birthdate' => $this->birthdate,
            'gender_id' => $this->gender,
            'marital_status_id' => $this->marital_status,
            'email_address' => $this->email_address,
            'mobile_number' => $this->mobile_number,
            'role_id' => 2,
        ]);

        // Insert into addresses table
        $user->address()->create([
            'user_id' => $user_id,
            'region_id' => $this->region,
            'province_id' => $this->province,
            'city_id' => $this->city,
            'home_address' => $this->home_address,
        ]);

        return redirect('/');
    }
}
