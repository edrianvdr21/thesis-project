{{-- Filter by Status --}}
<div class="text-lg font-medium text-center my-4">
    <ul class="flex justify-center w-full">
        <li class="w-1/2">
            <a href="{{ route('my_bookings', [
                'my_bookings_as_role' => 'as Client',
                'filter_by_status' => ""
                ]) }}"
                class="inline-block w-full px-2 py-4 text-sm rounded text-dark border border-white hover:border-blue-800 focus:border-blue-800 focus:outline-none
                @if ($filter_by_status == "") bg-blue-300 @endif
                "
                @if ($filter_by_status == "") aria-current="page" @endif
                >
                All ({{ $totalCount }})
            </a>
        </li>
        <li class="w-1/2">
            <a href="{{ route('my_bookings', [
                'my_bookings_as_role' => 'as Client',
                'filter_by_status' => 'Pending'
                ]) }}"
                class="inline-block w-full px-2 py-4 text-sm rounded text-dark border border-white hover:border-blue-800 focus:border-blue-800 focus:outline-none
                @if ($filter_by_status == "Pending") bg-blue-300 @endif
                "
                @if ($filter_by_status == "Pending") aria-current="page" @endif
                >
                Pending ({{ $pendingCount }})
            </a>
        </li>
        <li class="w-1/2">
            <a href="{{ route('my_bookings', [
                'my_bookings_as_role' => 'as Client',
                'filter_by_status' => 'Accepted'
                ]) }}"
                class="inline-block w-full px-2 py-4 text-sm rounded text-dark border border-white hover:border-blue-800 focus:border-blue-800 focus:outline-none
                @if ($filter_by_status == "Accepted") bg-blue-300 @endif
                "
                @if ($filter_by_status == "Accepted") aria-current="page" @endif
                >
                Accepted ({{ $acceptedCount }})
            </a>
        </li>
        <li class="w-1/2">
            <a href="{{ route('my_bookings', [
                'my_bookings_as_role' => 'as Client',
                'filter_by_status' => 'Completed'
                ]) }}"
                class="inline-block w-full px-2 py-4 text-sm rounded text-dark border border-white hover:border-blue-800 focus:border-blue-800 focus:outline-none
                @if ($filter_by_status == "Completed") bg-blue-300 @endif
                "
                @if ($filter_by_status == "Completed") aria-current="page" @endif
                >
                Completed ({{ $completedCount }})
            </a>
        </li>
        <li class="w-1/2">
            <a href="{{ route('my_bookings', [
                'my_bookings_as_role' => 'as Client',
                'filter_by_status' => 'Cancelled'
                ]) }}"
                class="inline-block w-full px-2 py-4 text-sm rounded text-dark border border-white hover:border-blue-800 focus:border-blue-800 focus:outline-none
                @if ($filter_by_status == "Cancelled") bg-blue-300 @endif
                "
                @if ($filter_by_status == "Cancelled") aria-current="page" @endif
                >
                Cancelled ({{ $cancelledCount }})
            </a>
        </li>
    </ul>
</div>


@if($bookings->isEmpty())
        <p class="text-center text-gray-600 border-t-2 border-gray-800 py-4">No bookings available.</p>
    @else
        {{-- Sort --}}
        {{-- <a role="button" href="{{ route('my_bookings', ['sort' => 'booking_id']) }}" class="bg-blue-800 text-white px-4 py-2 border border-blue-800 rounded hover:bg-white hover:text-blue-800 focus:bg-white focus:text-blue-800 focus:border-blue-800 focus:outline-none">Sort by Booking ID</a> --}}
        {{-- <a role="button" href="{{ route('my_bookings', ['sort' => 'upcoming_date']) }}" class="bg-blue-800 text-white px-4 py-2 border border-blue-800 rounded hover:bg-white hover:text-blue-800 focus:bg-white focus:text-blue-800 focus:border-blue-800 focus:outline-none">Sort by Upcoming Date</a> --}}

        <div class="container mx-auto border-t-2 border-gray-800">
            @foreach ($bookings as $booking)
            <div class="bg-white rounded-lg shadow-md mb-4 p-4">
                <p class="text-gray-600">Booking ID: {{ $booking->id }}</p>
                <p class="text-gray-600">Worker ID: {{ $booking->worker_id }}</p>

                <div class="md:grid md:grid-cols-4 md:text-center border-b border-gray-300 py-4">
                    <div>
                        <p class="text-dark">{{ $booking->workerProfile->user->userProfile->first_name }} {{ $booking->workerProfile->user->userProfile->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-dark">{{ $booking->workerProfile->category->category}}</p>
                    </div>
                    <div>
                        <p class="text-dark">{{ $booking->workerProfile->service->service}}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xl font-bold">₱{{ $booking->workerProfile->pricing }}</p>
                    </div>
                </div>

                <div class="md:grid md:grid-cols-2 my-4">
                    <div>
                        <p class="text-gray-800">
                            @if ($booking->status == "Pending")
                                Initial Schedule:
                            @elseif ($booking->status != "Pending")
                                Schedule:
                            @endif
                            {{ DateTime::createFromFormat('Y-m-d', $booking->date)->format('F d, Y') }},
                            {{ DateTime::createFromFormat('H:i:s', $booking->time)->format('g:i A') }}
                        </p>

                        <p class="text-gray-800">Notes: {{ $booking->notes }}</p>
                    </div>
                    <div class="flex md:justify-end md:items-end justify-center items-center mt-4">
                        @if ($booking->status == "Pending" || $booking->status == "Accepted")
                            <button disabled class="bg-white text-dark py-2 px-4 underline">
                                @if ($booking->status == "Pending")
                                    Pending
                                @elseif ($booking->status == "Accepted")
                                    Accepted
                                @endif
                            </button>

                            <form
                                action="{{ route('cancel.booking', ['booking' => $booking->id]) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to cancel this booking?');"
                                >
                                @csrf
                                <input type="hidden"name="my_bookings_as_role" value="{{ $my_bookings_as_role }}">
                                <input type="hidden"name="filter_by_status" value="{{ $filter_by_status }}">

                                <button type="submit" onclick="cancelBooking({{ $booking->id }})" class="bg-red-800 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Cancel
                                </button>
                            </form>

                        @elseif ($booking->status == "Cancelled")
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
