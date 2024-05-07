<div>
    {{-- <div>
        <h1>Welcome, {{ $user->username }}</h1>
    </div> --}}

    <h2 class="text-2xl font-bold mb-4">User Profiles</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($userProfiles as $profile)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img class="w-full h-40 object-cover object-center" src="{{ $profile->image_url }}" alt="{{ $profile->first_name }} {{ $profile->last_name }}'s Profile Picture">
                <div class="p-4">
                    <h3 class="text-lg font-bold mb-2 text-center">{{ $profile->first_name }} {{ $profile->last_name }}</h3>
                    {{-- <p class="text-gray-600">Middle Name: {{ $profile->middle_name }}</p> --}}
                    {{-- <p class="text-gray-600">Suffix: {{ $profile->suffix }}</p> --}}
                    <p class="text-gray-600">Birthdate: {{ $profile->birthdate }}</p>
                    <p class="text-gray-600">Gender: {{ $profile->gender_id }}</p>
                    <p class="text-gray-600">Marital Status: {{ $profile->marital_status_id }}</p>
                    <p class="text-gray-600">Email Address: {{ $profile->email_address }}</p>
                    <p class="text-gray-600">Mobile Number: {{ $profile->mobile_number }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
