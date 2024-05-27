<main>

    <h1 >Create an Account</h1>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <h2>Personal Information</h2>

        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" required wire:model="first_name">


        <label for="middle_name">Middle Name</label>
        <input type="text" name="middle_name" id="middle_name" required wire:model="middle_name">


        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" required wire:model="last_name">



        <label for="suffix">Suffix</label>
        <select name="suffix" id="suffix" wire:model="suffix">
            <option value="">Select Suffix</option>
            <option value="Jr.">Jr.</option>
            <option value="Sr.">Sr.</option>
            <option value="II">II</option>
            <option value="III">III</option>
            <option value="IV">IV</option>
            <option value="V">V</option>
            <option value="">Not Applicable</option>
        </select>


        <label for="birthdate">Birthdate</label>
        <input type="date" name="birthdate" id="birthdate" required wire:model="birthdate">


        <label for="gender">Gender</label>
        <select name="gender" id="gender" required wire:model="gender">
            <option value="">Select Gender</option>
            @foreach($genders as $gender)
                <option value="{{ $gender->id }}">{{ $gender->gender }}</option>
            @endforeach
        </select>



        <label for="marital_status">Marital Status</label>
        <select name="marital_status" id="marital_status" required wire:model="marital_status">
            <option value="">Select Marital Status</option>
            @foreach($marital_statuses as $marital_status)
                <option value="{{ $marital_status->id }}">{{ $marital_status->marital_status }}</option>
            @endforeach
        </select>


    <h2>Contact Information</h2>

        <label for="home_address">Home Address (House No. / Street / Barangay)</label>
        <input type="text" name="home_address" id="home_address" required wire:model="home_address">



        <label for="region">Region</label>
        <select name="region" id="region" required wire:model="region" wire:change="loadProvinces">
            <option value="" selected>Select Region</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}">{{ $region->region }}</option>
            @endforeach
        </select>


        <label for="province">Province</label>
        <select name="province" id="province" required wire:model="province" wire:change="loadCities">
            <option value="" selected>Select Province</option>
            @foreach($provinces as $province)
                <option value="{{ $province->id }}">{{ $province->province }}</option>
            @endforeach
        </select>


        <label for="city">City</label>
        <select name="city" id="city" required wire:model="city">
            <option value="" selected>Select City</option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}">{{ $city->city }}</option>
            @endforeach
        </select>



        <label for="email_address">Email Address</label>
        <input type="email" name="email_address" id="email_address" required wire:model="email_address">


        <label for="mobile_number">Mobile Number</label>
        <input type="text" name="mobile_number" id="mobile_number" required wire:model="mobile_number">


    <h2>Login Information</h2>

        <label for="username">Username</label>
        <input type="text" name="username" id="username" required wire:model="username">


        <label for="password">Password</label>
        <input type="password" name="password" id="password" required wire:model="password">


        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" id="confirm_password" required wire:model="confirm_password">


    <button type="submit" wire:click="sign_up">Sign Up</button>
    <a href="/">Already have an account?</a>
</main>
