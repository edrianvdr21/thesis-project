<main>
    <h1>Create an Account as a Worker</h1>

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
    <select name="gender" id="gender" wire:model="gender">
        <option value="">Select Gender</option>
        @foreach($genders as $gender)
            <option value="{{ $gender->id }}">{{ $gender->gender }}</option>
        @endforeach
    </select>

    <label for="marital_status">Marital Status</label>
    <select name="marital_status" id="marital_status" wire:model="marital_status">
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

    <h2>Worker Information</h2>
    <label for="category">Category</label>
    <select name="category" id="category" required wire:model="category" wire:change="loadServices">
        <option value="" selected>Select Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->category }}</option>
        @endforeach
    </select>

    <label for="service">Service</label>
    <select name="service" id="service" required wire:model="service">
        <option value="" selected>Select Service</option>
        @foreach($services as $service)
            <option value="{{ $service->id }}">{{ $service->service }}</option>
        @endforeach
    </select>

    <label for="description">Description</label>
    <textarea rows=5 name="description" id="description" required wire:model="description"></textarea>

    <label for="pricing">Pricing</label>
    <input type="number" name="pricing" id="pricing" required wire:model="pricing">

    <label for="minimum_duration">Minimum Duration</label>
    <input type="number" name="minimum_duration" id="minimum_duration" required wire:model="minimum_duration">

    <label for="maximum_duration">Maximum Duration</label>
    <input type="number" name="maximum_duration" id="maximum_duration" required wire:model="maximum_duration">

    <label for="working_days">Working Days</label>
    <input type="checkbox" id="sunday" name="sunday" value="sunday" wire:model="working_days.sunday">
    <label for="sunday">Sunday</label>

    <input type="checkbox" id="monday" name="monday" value="monday" wire:model="working_days.monday">
    <label for="monday">Monday</label>

    <input type="checkbox" id="tuesday" name="tuesday" value="tuesday" wire:model="working_days.tuesday">
    <label for="tuesday">Tuesday</label>

    <input type="checkbox" id="wednesday" name="wednesday" value="wednesday" wire:model="working_days.wednesday">
    <label for="wednesday">Wednesday</label>

    <input type="checkbox" id="thursday" name="thursday" value="thursday" wire:model="working_days.thursday">
    <label for="thursday">Thursday</label>

    <input type="checkbox" id="friday" name="friday" value="friday" wire:model="working_days.friday">
    <label for="friday">Friday</label>

    <input type="checkbox" id="saturday" name="saturday" value="saturday" wire:model="working_days.saturday">
    <label for="saturday">Saturday</label>

    <label for="start_time">Start Time</label>
    <input type="time" name="start_time" id="start_time" required wire:model="start_time">

    <label for="end_time">End Time</label>
    <input type="time" name="end_time" id="end_time" required wire:model="end_time">

    <label for="valid_id">Upload a Picture of Valid ID</label>
    <input type="file" accept="image/*" name="valid_id" id="valid_id" wire:model="valid_id">

    <label for="resume">Upload Resume</label>
    <input type="file" accept=".pdf,.doc,.docx" name="resume" id="resume" wire:model="resume">

    <button type="submit" wire:click="sign_up">Sign Up as a Worker</button>
    <a href="/">Already have an account?</a>
</main>
