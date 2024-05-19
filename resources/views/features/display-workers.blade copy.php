<div>
    <h2 class="text-2xl font-bold mb-4">User Profiles</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($users as $user)
            <a href="{{ route('worker.profile', $user->user_id) }}" class="hover:no-underline">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img class="w-full h-40 object-cover object-center" src="{{ $user->image_url }}" alt="{{ $user->first_name }} {{ $user->last_name }}'s Profile Picture">
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2 text-center">{{ $user->first_name }} {{ $user->last_name }}</h3>
                        {{-- <p class="text-gray-600">Middle Name: {{ $user->middle_name }}</p> --}}
                        {{-- <p class="text-gray-600">Suffix: {{ $user->suffix }}</p> --}}
                        <p class="text-gray-600">Birthdate: {{ $user->birthdate }}</p>
                        <p class="text-gray-600">Gender: {{ $user->gender_id }}</p>
                        <p class="text-gray-600">Marital Status: {{ $user->marital_status_id }}</p>
                        <p class="text-gray-600">Email Address: {{ $user->email_address }}</p>
                        <p class="text-gray-600">Mobile Number: {{ $user->mobile_number }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
