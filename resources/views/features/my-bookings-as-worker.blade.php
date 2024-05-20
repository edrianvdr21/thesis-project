<div class="text-lg font-medium text-center my-4">
    <ul class="flex justify-center w-full">
        <li class="w-1/2">
            <a href="{{ route('my_bookings', ['my_bookings_as_role' => 'as Client']) }}"
                class="inline-block w-full p-4 rounded text-dark border border-white hover:border-blue-800 focus:border-blue-800 focus:outline-none
                @if ($my_bookings_as_role == "as Client") bg-blue-300 @endif
                "
                @if ($my_bookings_as_role == "client") aria-current="page" @endif
                >
                As Client
            </a>
        </li>
        <li class="w-1/2">
            <a href="{{ route('my_bookings', ['my_bookings_as_role' => 'as Worker']) }}"
                class="inline-block w-full p-4 rounded text-dark border border-white hover:border-blue-800 focus:border-blue-800 focus:outline-none
                @if ($my_bookings_as_role != "as Client") bg-blue-300 @endif
                "
                @if ($my_bookings_as_role != "Client") aria-current="page" @endif
                >
                As Worker
            </a>
        </li>
    </ul>
</div>

@if ($my_bookings_as_role != "as Client")
    {{-- Filter by Status --}}
    @include('features.filter-by-status', ['role' => "Worker"])
@endif


@if ($my_bookings_as_role == "as Client")
    @include('features.my-bookings-as-client')
@else
    @if($workerBookings->isEmpty())
        <p class="text-center text-gray-600 border-t-2 border-gray-800 py-4">No bookings available as worker.</p>
    @else
        {{-- Displaying of Bookings --}}
        <div class="container mx-auto border-t-2 border-gray-800">
            @foreach ($workerBookings as $workerBooking)
            <div class="bg-white rounded-lg shadow-md mb-4 p-4 border-b border-gray-500">
                <div class="md:grid md:grid-cols-4 md:text-center border-b border-gray-300 py-4">
                    <div>
                        <p class="text-dark">{{ $workerBooking->user->userProfile->first_name }} {{ $workerBooking->user->userProfile->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-dark">{{ $workerBooking->workerProfile->category->category}}</p>
                    </div>
                    <div>
                        <p class="text-dark">{{ $workerBooking->workerProfile->service->service}}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xl font-bold">₱{{ $workerBooking->workerProfile->pricing }}</p>
                    </div>
                </div>

                <div class="md:grid md:grid-cols-2 my-4">
                    <div>
                        <p class="text-gray-800 pr-4">
                            Home Address: {{ $workerBooking->user->address->home_address }},
                            {{ $workerBooking->user->address->city->city }},
                            {{ $workerBooking->user->address->province->province }},
                            {{ $workerBooking->user->address->region->region }}
                        </p>
                        <p class="text-gray-800">
                            Mobile Number: (+63) {{ $workerBooking->user->userProfile->mobile_number }}
                        </p>
                        <p class="text-gray-800">
                            Email Address: {{ $workerBooking->user->userProfile->email_address }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-800">
                            @if ($workerBooking->status == "Pending")
                                Initial Schedule:
                            @elseif ($workerBooking->status != "Pending")
                                Schedule:
                            @endif
                            {{ DateTime::createFromFormat('Y-m-d', $workerBooking->date)->format('F d, Y') }},
                            {{ DateTime::createFromFormat('H:i:s', $workerBooking->time)->format('g:i A') }}
                        </p>

                        <p class="text-gray-800">Notes: {{ $workerBooking->notes }}</p>

                        @if ($workerBooking->status == "Pending")
                            @php
                                $booked_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->booked_datetime);
                            @endphp

                            <p class="text-gray-800 mt-4">
                                Booked on
                                {{ $booked_datetime->format('F d, Y, g:i A') }}
                            </p>
                        @elseif ($workerBooking->status == "Accepted")
                            @php
                                $booked_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->booked_datetime);
                                $accepted_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->accepted_datetime);
                            @endphp

                            <p class="text-gray-800 mt-4">
                                Booked on
                                {{ $booked_datetime->format('F d, Y, g:i A') }}
                            </p>
                            <p class="text-gray-800">
                                Accepted on
                                {{ $accepted_datetime->format('F d, Y, g:i A') }}
                            </p>
                        @elseif ($workerBooking->status == "Completed")
                            @php
                                $booked_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->booked_datetime);
                                $accepted_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->accepted_datetime);
                                $completed_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->completed_datetime);
                            @endphp

                            <p class="text-gray-800 mt-4">
                                Booked on
                                {{ $booked_datetime->format('F d, Y, g:i A') }}
                            </p>
                            <p class="text-gray-800">
                                Accepted on
                                {{ $accepted_datetime->format('F d, Y, g:i A') }}
                            </p>
                            <p class="text-gray-800">
                                Completed on
                                {{ $completed_datetime->format('F d, Y, g:i A') }}
                            </p>
                        @elseif ($workerBooking->status == "Cancelled")
                            @php
                                $booked_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->booked_datetime);
                                $cancelled_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->cancelled_datetime);
                            @endphp

                            <p class="text-gray-800 mt-4">
                                Booked on
                                {{ $booked_datetime->format('F d, Y, g:i A') }}
                            </p>
                            <p class="text-gray-800">
                                Cancelled by
                                @if ($workerBooking->cancelled_by == 0)
                                    Client
                                @elseif ($workerBooking->cancelled_by == 1)
                                    Worker
                                @endif
                                on {{ $cancelled_datetime->format('F d, Y, g:i A') }}
                            </p>
                        @endif
                    </div>
                </div>

                <div>
                    <div class="flex justify-center items-center mt-4">
                        @if ($workerBooking->status == "Pending")
                            <button disabled class="bg-white text-dark py-2 px-4 underline">
                                {{ $workerBooking->status }}
                            </button>

                            <form
                                action="{{ route('accept.booking', ['booking' => $workerBooking->id]) }}"
                                method="POST"
                                onsubmit="return confirm('You\'re about to accept this booking service. Do you wish to proceed?');"
                                >
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold mx-2 py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Accept
                                </button>
                            </form>
                            <form
                                action="{{ route('cancel.booking', ['booking' => $workerBooking->id]) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to cancel this booking?');"
                                >
                                @csrf
                                <input type="hidden"name="my_bookings_as_role" value="{{ $my_bookings_as_role }}">
                                <input type="hidden"name="filter_by_status" value="{{ $filter_by_status }}">

                                <button type="submit" class="bg-red-800 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Cancel
                                </button>
                            </form>
                        @elseif ($workerBooking->status == "Accepted")
                            <button disabled class="bg-white text-dark py-2 px-4 underline">
                                {{ $workerBooking->status }}
                            </button>

                            <form
                                action="{{ route('complete.booking', ['booking' => $workerBooking->id]) }}"
                                method="POST"
                                onsubmit="return confirm('Are you certain you want to mark this booking as completed?');"
                                >
                                @csrf
                                <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white font-bold mx-2 py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Mark as Completed
                                </button>
                            </form>
                            <form
                                action="{{ route('cancel.booking', ['booking' => $workerBooking->id]) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to cancel this booking?');"
                                >
                                @csrf
                                <input type="hidden"name="my_bookings_as_role" value="{{ $my_bookings_as_role }}">
                                <input type="hidden"name="filter_by_status" value="{{ $filter_by_status }}">

                                <button type="submit" class="bg-red-800 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Cancel
                                </button>
                            </form>
                        @elseif ($workerBooking->status == "Completed")
                            <div class="justify-center items-center text-center">
                                @if ($workerBooking->rating != null)
                                    <p class="text-lg font-bold text-gray-800">Rating: {{ number_format($workerBooking->rating, 1) }}</p>
                                    <p class="text-gray-700 mt-2">{{ $workerBooking->review }}</p>
                                @endif

                                <button class="bg-blue-300 text-gray-900 font-bold py-2 px-4 rounded cursor-not-allowed" style="pointer-events: none;">
                                    Completed
                                </button>
                            </div>
                        @elseif ($workerBooking->status == "Cancelled")
                            <button class="bg-red-200 text-gray-600 font-bold py-2 px-4 rounded cursor-not-allowed" style="pointer-events: none;">
                                Cancelled
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
@endif
