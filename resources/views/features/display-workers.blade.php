<div class="px-4 py-8">
    <h2 class="text-2xl font-bold mb-4">Featured Workers</h2>

    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($workers as $worker)
        <a href="{{ route('worker.profile', ['userId' => $worker->user_id, 'workerProfileId' => $worker->id]) }}" class="block bg-white border-2 border-white hover:border-blue-800 focus:border-blue-800 focus:outline-none rounded-lg shadow-lg transition duration-300">
            <div class="bg-white rounded-lg overflow-hidden">
                <img class="w-full h-40 object-cover object-center" src="{{ asset('images/Default Profile Picture.png') }}" alt="{{ $worker->user->userProfile->first_name }} {{ $worker->user->userProfile->last_name }}'s Profile Picture">

                <div class="p-4">
                    <h3 class="text-lg font-bold mb-2 text-center">{{ $worker->user->userProfile->first_name }} {{ $worker->user->userProfile->last_name }}</h3>
                    <p class="text-gray-600 text-center mb-2">{{ $worker->category->category }}</p>
                    <p class="text-gray-600 text-center mb-4">{{ $worker->service->service }}</p>
                    <p class="text-dark text-xl font-bold text-center mb-2">₱{{ $worker->pricing }}</p>

                    <div class="flex items-center text-center justify-center text-gray-600 mb-4">
                        <svg class="w-5 h-5 text-center items-center" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22s-8-4.5-8-11a8 8 0 0116 0c0 6.5-8 11-8 11z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <p>{{ $worker->user->address->city->city }}, {{ $worker->user->address->province->province }}</p>
                    </div>

                    @if ($worker->average_rating != null)
                        <div class="flex flex-col items-center justify-center text-gray-600 mb-4">
                            <div class="flex items-center mb-1">
                                <span class="mr-1">{{ number_format($worker->average_rating, 2) }}</span>
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $worker->average_rating)
                                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p>{{ $worker->bookings_count }} Ratings</p>
                        </div>


                    @else
                        <p class="text-gray-600 text-center mb-2">No ratings yet</p>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>


<div class="px-4 py-8">
    <h2 class="text-2xl font-bold mb-4">Workers in {{ Auth::user()->address->city->city }}</h2>

    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($same_city_workers as $worker)
        <a href="{{ route('worker.profile', ['userId' => $worker->user_id, 'workerProfileId' => $worker->id]) }}" class="block bg-white border-2 border-white hover:border-blue-800 focus:border-blue-800 focus:outline-none rounded-lg shadow-lg transition duration-300">
            <div class="bg-white rounded-lg overflow-hidden">
                <img class="w-full h-40 object-cover object-center" src="{{ asset('images/Default Profile Picture.png') }}" alt="{{ $worker->user->userProfile->first_name }} {{ $worker->user->userProfile->last_name }}'s Profile Picture">

                <div class="p-4">
                    <h3 class="text-lg font-bold mb-2 text-center">{{ $worker->user->userProfile->first_name }} {{ $worker->user->userProfile->last_name }}</h3>
                    <p class="text-gray-600 text-center mb-2">{{ $worker->category->category }}</p>
                    <p class="text-gray-600 text-center mb-4">{{ $worker->service->service }}</p>
                    <p class="text-dark text-xl font-bold text-center mb-2">₱{{ $worker->pricing }}</p>

                    <div class="flex items-center text-center justify-center text-gray-600 mb-4">
                        <svg class="w-5 h-5 text-center items-center" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22s-8-4.5-8-11a8 8 0 0116 0c0 6.5-8 11-8 11z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <p>{{ $worker->user->address->city->city }}, {{ $worker->user->address->province->province }}</p>
                    </div>

                    @if ($worker->average_rating != null)
                        <div class="flex flex-col items-center justify-center text-gray-600 mb-4">
                            <div class="flex items-center mb-1">
                                <span class="mr-1">{{ number_format($worker->average_rating, 2) }}</span>
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $worker->average_rating)
                                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p>{{ $worker->bookings_count }} Ratings</p>
                        </div>


                    @else
                        <p class="text-gray-600 text-center mb-2">No ratings yet</p>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
