<main class="max-w-screen-lg mx-auto">

    <h1 class="text-3xl font-bold mb-4">Create an Account</h1>

    <h2 class="text-black text-3xl font-semibold font-['Open Sans']">Personal Information</h2>
    <div class="grid grid-cols-3 gap-4 my-4">
        <div>
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" aria-label="First Name" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="first_name">
        </div>
        <div>
            <label for="middle_name">Middle Name</label>
            <input type="text" name="middle_name" id="middle_name" aria-label="Middle Name" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="middle_name">
        </div>
        <div>
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" aria-label="Last Name" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="last_name">
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 my-4">
        <div>
            <label for="suffix">Suffix</label>
            <select name="suffix" id="suffix" class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="suffix">
                <option value="">Select Suffix</option>

            </select>
        </div>
        <div>
            <label for="birthdate">Birthdate</label>
            <input type="date" name="birthdate" id="birthdate" aria-label="Birthdate" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="birthdate">
        </div>
        <div>
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="gender">
                <option value="">Select Gender</option>
                @foreach($genders as $gender)
                    <option value="{{ $gender->id }}">{{ $gender->gender }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 my-4">
        <div>
            <label for="marital_status">Marital Status</label>
            <select name="marital_status" id="marital_status" class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="marital_status">
                <option value="">Select Marital Status</option>
                @foreach($marital_statuses as $marital_status)
                    <option value="{{ $marital_status->id }}">{{ $marital_status->marital_status }}</option>
                @endforeach
            </select>
        </div>
    </div>





    <h2 class="text-black text-3xl font-semibold font-['Open Sans']">Contact Information</h2>
    <div class="grid grid-cols-1 gap-4 my-4">
        <div>
            <label for="home_address">Home Address (House No. / Street / Barangay)</label>
            <input type="text" name="home_address" id="home_address" aria-label="Home Address" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="home_address">
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 my-4">
        <div>
            <label for="region" class="text-zinc-800 text-sm font-semibold font-['Open Sans']">Region</label>
            <select
                name="region"
                id="region"
                aria-label="Region"
                aria-required="true" required
                class="w-full h-10 rounded-[5px] border-2 border-neutral-200 px-2"
                data-label="Region"
                wire:model="region"
                wire:change="loadProvinces"
            >
            <option value="" selected>Select Region</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}">{{ $region->region }}</option>
            @endforeach
            </select>
        </div>
        <div>
            <label for="province" class="text-zinc-800 text-sm font-semibold font-['Open Sans']">Province</label>
            <select
                name="province"
                id="province"
                aria-label="Province"
                aria-required="true" required
                class="w-full h-10 rounded-[5px] border-2 border-neutral-200 px-2"
                data-label="Province"
                wire:model="province"
                wire:change="loadCities"
            >
            <option value="" selected>Select Province</option>
            @foreach($provinces as $province)
                <option value="{{ $province->id }}">{{ $province->province }}</option>
            @endforeach
            </select>
        </div>
        <div>
            <label for="city" class="text-zinc-800 text-sm font-semibold font-['Open Sans']">City</label>
            <select
                name="city"
                id="city"
                aria-label="City"
                aria-required="true" required
                class="w-full h-10 rounded-[5px] border-2 border-neutral-200 px-2"
                data-label="City"
                wire:model="city"
                wire:change=""
            >
            <option value="" selected>Select City</option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}">{{ $city->city }}</option>
            @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 my-4">
        <div class="">
            <label for="email_address">Email Address</label>
            <input type="email" name="email_address" id="email_address" aria-label="Email Address" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="email_address">
        </div>
        <div>
            <label for="mobile_number">Mobile Number</label>
            <input type="text" name="mobile_number" id="mobile_number" aria-label="Mobile Number" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="mobile_number">
        </div>
    </div>





    <h2 class="text-black text-3xl font-semibold font-['Open Sans']">Login Information</h2>
    <div class="grid grid-cols-1 gap-4 my-4">
        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" aria-label="Username" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="username">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" aria-label="Password" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="password">
        </div>
        <div>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" aria-label="Confirm Password" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="confirm_password">
        </div>
    </div>

    <button
        class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        type="submit"
        wire:click="sign_up"
        >
        Sign Up
    </button>
    <a
        href="/"
        class="text-blue-800 py-2 px-4 hover:underline focus:underline rounded focus:outline-none"
        >
        Already have an account?
    </a>
</main>
