{{-- Filter by Status --}}
@include('features.filter-by-status', ['role' => "Client"])

@if($bookings->isEmpty())
        <p class="text-center text-gray-600 border-t-2 border-gray-800 py-4">No bookings available.</p>
    @else
        <div class="container mx-auto border-t-2 border-gray-800">
            @foreach ($bookings as $booking)
            <div class="bg-white rounded-lg shadow-md mb-4 p-4 border-b border-gray-300">
                {{-- <p class="text-gray-600">Booking ID: {{ $booking->id }}</p> --}}
                {{-- <p class="text-gray-600">Worker ID: {{ $booking->worker_id }}</p> --}}

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

                        @if ($booking->status == "Pending")
                            @php
                                $booked_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $booking->booked_datetime);
                            @endphp

                            <p class="text-gray-800 mt-4">
                                Booked on
                                {{ $booked_datetime->format('F d, Y, g:i A') }}
                            </p>
                        @elseif ($booking->status == "Accepted")
                            @php
                                $booked_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $booking->booked_datetime);
                                $accepted_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $booking->accepted_datetime);
                            @endphp

                            <p class="text-gray-800 mt-4">
                                Booked on
                                {{ $booked_datetime->format('F d, Y, g:i A') }}
                            </p>
                            <p class="text-gray-800">
                                Accepted on
                                {{ $accepted_datetime->format('F d, Y, g:i A') }}
                            </p>
                        @elseif ($booking->status == "Completed")
                            @php
                                $booked_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $booking->booked_datetime);
                                $accepted_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $booking->accepted_datetime);
                                $completed_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $booking->completed_datetime);
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
                        @elseif ($booking->status == "Cancelled")
                            @php
                                $booked_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $booking->booked_datetime);
                                $cancelled_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $booking->cancelled_datetime);
                            @endphp

                            <p class="text-gray-800 mt-4">
                                Booked on
                                {{ $booked_datetime->format('F d, Y, g:i A') }}
                            </p>
                            <p class="text-gray-800">
                                Cancelled by
                                @if ($booking->cancelled_by == 0)
                                    Client
                                @elseif ($booking->cancelled_by == 1)
                                    Worker
                                @endif
                                on {{ $cancelled_datetime->format('F d, Y, g:i A') }}
                            </p>
                        @endif
                    </div>
                    @if ($booking->status != "Completed")
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
                                    <input type="hidden"name="cancelled_by" value="0">

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
                    @elseif ($booking->status == "Completed")
                        <div class="flex justify-center">
                            @if ($booking->rating == null)
                                <form
                                    action="{{ route('submit.rating', ['booking' => $booking->id]) }}"
                                    method="POST"
                                    class="w-full"
                                >
                                    @csrf
                                    @if ($errors->any())
                                        <div class="alert alert-danger  mb-4 w-full">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li class="text-red-600 text-base" role="alert" aria-live="polite">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="w-full">
                                        <label for="rating" class="sr-only block text-gray-800 font-bold">Rating:</label>
                                        <select name="rating" id="rating" class="form-select mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="">Select a Rating</option>
                                            <option value="5">5 - Excellent</option>
                                            <option value="4">4 - Very Good</option>
                                            <option value="3">3 - Good</option>
                                            <option value="2">2 - Fair</option>
                                            <option value="1">1 - Poor</option>
                                        </select>
                                    </div>

                                    <div class="mt-4">
                                        <label for="review" class="sr-only block text-gray-800 font-bold">Review:</label>
                                        <textarea name="review" id="review" rows="2" placeholder="Review" class="form-textarea mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="bg-blue-800 text-white px-4 py-2 border border-blue-800 rounded hover:bg-white hover:text-blue-800 focus:bg-white focus:text-blue-800 focus:border-blue-800 focus:outline-none w-full">
                                            Submit Review
                                        </button>
                                    </div>
                                </form>
                            @elseif ($booking->rating != null)
                                <div class="">
                                    <p class="text-lg font-bold text-gray-800">Rating: {{ number_format($booking->rating, 1) }}</p>
                                    <p class="text-gray-700 mt-2">{{ $booking->review }}</p>

                                    <button disabled class="bg-blue-300 text-gray-900 py-2 px-4 mt-4 rounded-lg cursor-not-allowed">
                                        Completed
                                    </button>
                                </div>

                            @endif
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
