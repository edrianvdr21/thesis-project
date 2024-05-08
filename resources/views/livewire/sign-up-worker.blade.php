<div>
    @include('partials.home-navbar')
    <main class="max-w-screen-lg mx-auto">
        <h1 class="text-3xl font-bold my-4">Become a Worker</h1>

        <h2 class="text-black text-3xl font-semibold font-['Open Sans']">Worker Information</h2>
        {{-- start
        category_id
        service_id
        description
        pricing
        minimum_duration
        maximum_duration
        working_days
        start_time
        end_time
        valid_id
        resume
        end --}}

        <div class="grid grid-cols-2 gap-4 my-4">
            <div>
                <label for="category" class="text-zinc-800 text-sm font-semibold font-['Open Sans']">Category</label>
                <select
                    name="category"
                    id="category"
                    aria-label="Category"
                    aria-required="true" required
                    class="w-full h-10 rounded-[5px] border-2 border-neutral-200 px-2"
                    data-label="Category"
                    wire:model="category"
                    wire:change="loadServices"
                >
                <option value="" selected>Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                @endforeach
                </select>
            </div>
            <div>
                <label for="service" class="text-zinc-800 text-sm font-semibold font-['Open Sans']">Service</label>
                <select
                    name="service"
                    id="service"
                    aria-label="Service"
                    aria-required="true" required
                    class="w-full h-10 rounded-[5px] border-2 border-neutral-200 px-2"
                    data-label="Service"
                    wire:model="service"
                    wire:change=""
                >
                <option value="" selected>Select Service</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->service }}</option>
                @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 my-4">
            <div>
                <label for="description">Description</label>
                <textarea rows=5 name="description" id="description" aria-label="Description" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="description"></textarea>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 my-4">
            <div>
                <label for="pricing">Pricing</label>
                <input type="number" name="pricing" id="pricing" aria-label="Pricing" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="pricing">
            </div>
            <div>
                <label for="minimum_duration">Minimum Duration</label>
                <input type="number" name="minimum_duration" id="minimum_duration" aria-label="Minimum Duration" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="minimum_duration">
            </div>
            <div>
                <label for="maximum_duration">Maximum Duration</label>
                <input type="number" name="maximum_duration" id="maximum_duration" aria-label="Maximum Duration" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="maximum_duration">
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 my-4">
            <div>
                <label for="working_days">Working Days</label>
                <div class="flex flex-wrap gap-4">
                    <div>
                        <input type="checkbox" id="sunday" name="sunday" value="sunday" wire:model="working_days.sunday">
                        <label for="sunday">Sunday</label>
                    </div>
                    <div>
                        <input type="checkbox" id="monday" name="monday" value="monday" wire:model="working_days.monday">
                        <label for="monday">Monday</label>
                    </div>
                    <div>
                        <input type="checkbox" id="tuesday" name="tuesday" value="tuesday" wire:model="working_days.tuesday">
                        <label for="tuesday">Tuesday</label>
                    </div>
                    <div>
                        <input type="checkbox" id="wednesday" name="wednesday" value="wednesday" wire:model="working_days.wednesday">
                        <label for="wednesday">Wednesday</label>
                    </div>
                    <div>
                        <input type="checkbox" id="thursday" name="thursday" value="thursday" wire:model="working_days.thursday">
                        <label for="thursday">Thursday</label>
                    </div>
                    <div>
                        <input type="checkbox" id="friday" name="friday" value="friday" wire:model="working_days.friday">
                        <label for="friday">Friday</label>
                    </div>
                    <div>
                        <input type="checkbox" id="saturday" name="saturday" value="saturday" wire:model="working_days.saturday">
                        <label for="saturday">Saturday</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 my-4">
            <div>
                <label for="start_time">Start Time</label>
                <input type="time" name="start_time" id="start_time" aria-label="Start Time" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="start_time">
            </div>
            <div>
                <label for="end_time">End Time</label>
                <input type="time" name="end_time" id="end_time" aria-label="End Time" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="end_time">
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 my-4">
            <div>
                <label for="valid_id">Upload a Picture of Valid ID</label>
                <input type="file" accept="image/*" name="valid_id" id="valid_id" aria-label="Upload Valid ID" class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="valid_id">
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 my-4">
            <div>
                <label for="resume">Upload Resume</label>
                <input type="file" accept=".pdf,.doc,.docx" name="resume" id="resume" aria-label="Upload Resume" class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="resume">
            </div>
        </div>

        <button
            class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            wire:click="sign_up_as_a_worker"
            >
            Sign Up as a Worker
        </button>

        {{-- start
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
                    <option value="1">Female</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 my-4">
            <div>
                <label for="marital_status">Marital Status</label>
                <select name="marital_status" id="marital_status" class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="marital_status">
                    <option value="">Select Marital Status</option>
                    <option value="1">Single</option>
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
        end --}}
    </main>

</div>
