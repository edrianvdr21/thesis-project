<div>
    <h2 class="text-2xl font-bold mb-4">User Profiles</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($workers as $worker)
        <a href="{{ route('worker.profile', ['userId' => $worker->user_id, 'workerProfileId' => $worker->id]) }}" class="bg-white border-2 border-white hover:border-blue-800 focus:border-blue-800 focus:outline-none">
            <div class="bg-white">
                <img class="w-full h-40 object-cover object-center" src="{{ asset('images/Default Profile Picture.png') }}" alt="{{ $worker->user->userProfile->first_name }} {{ $worker->user->userProfile->last_name }}'s Profile Picture">
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2 text-center">{{ $worker->user->userProfile->first_name }} {{ $worker->user->userProfile->last_name }}</h3>
                        <p class="text-gray-600">{{ $worker->category->category }}</p>
                        <p class="text-gray-600">{{ $worker->service->service }}</p>
                        <p class="text-dark text-xl font-bold">₱{{ $worker->pricing }}</p>
                        {{-- <p class="text-gray-600">asdas {{ $worker->address->id }}</p> --}}
                        <p class="text-gray-600">{{ $worker->user->address->user_id }}</p>
                        <p class="text-gray-600">{{ $worker->user->address->city->city }}, {{ $worker->user->address->province->province }}</p>



                        {{-- <p class="text-gray-600">Birthdate: {{ DateTime::createFromFormat('Y-m-d', $worker->user->userProfile->birthdate)->format('F d, Y') }}
                        <p class="text-gray-600">{{ $worker->user->userProfile->gender->gender }}</p>
                        <p class="text-gray-600">{{ $worker->user->userProfile->marital_status->marital_status }}</p>
                        <p class="text-gray-600">Email Address: {{ $worker->user->userProfile->email_address }}</p>
                        <p class="text-gray-600">Mobile Number: {{ $worker->user->userProfile->mobile_number }}</p> --}}
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
