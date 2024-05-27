    <ul>
        <li>
            <a href="{{ route('my_bookings', ['my_bookings_as_role' => 'as Client']) }}">
                As Client
            </a>
        </li>
        <li>
            <a href="{{ route('my_bookings', ['my_bookings_as_role' => 'as Worker']) }}">
                As Worker
            </a>
        </li>
    </ul>

@if ($my_bookings_as_role != "as Client")
    {{-- Filter by Status --}}
    @include('features.filter-by-status', ['role' => "Worker"])
@endif

@if ($my_bookings_as_role == "as Client")
    @include('features.my-bookings-as-client')
@else
    @if($workerBookings->isEmpty())
        <p>No bookings available as worker.</p>
    @else
        {{-- Displaying of Bookings --}}
            @foreach ($workerBookings as $workerBooking)

                            <p>{{ $workerBooking->user->userProfile->first_name }} {{ $workerBooking->user->userProfile->last_name }}</p>


                            <p>{{ $workerBooking->workerProfile->category->category}}</p>


                            <p>{{ $workerBooking->workerProfile->service->service}}</p>


                            <p>₱{{ $workerBooking->workerProfile->pricing }}</p>




                            <p>
                                Home Address: {{ $workerBooking->user->address->home_address }},
                                {{ $workerBooking->user->address->city->city }},
                                {{ $workerBooking->user->address->province->province }},
                                {{ $workerBooking->user->address->region->region }}
                            </p>
                            <p>
                                Mobile Number: (+63) {{ $workerBooking->user->userProfile->mobile_number }}
                            </p>
                            <p>
                                Email Address: {{ $workerBooking->user->userProfile->email_address }}
                            </p>


                            <p>
                                @if ($workerBooking->status == "Pending")
                                    Initial Schedule:
                                @elseif ($workerBooking->status != "Pending")
                                    Schedule:
                                @endif
                                {{ DateTime::createFromFormat('Y-m-d', $workerBooking->date)->format('F d, Y') }},
                                {{ DateTime::createFromFormat('H:i:s', $workerBooking->time)->format('g:i A') }}
                            </p>

                            <p>Notes: {{ $workerBooking->notes }}</p>

                            @if ($workerBooking->status == "Pending")
                                @php
                                    $booked_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->booked_datetime);
                                @endphp

                                <p>
                                    Booked on
                                    {{ $booked_datetime->format('F d, Y, g:i A') }}
                                </p>
                            @elseif ($workerBooking->status == "Accepted")
                                @php
                                    $booked_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->booked_datetime);
                                    $accepted_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->accepted_datetime);
                                @endphp

                                <p>
                                    Booked on
                                    {{ $booked_datetime->format('F d, Y, g:i A') }}
                                </p>
                                <p>
                                    Accepted on
                                    {{ $accepted_datetime->format('F d, Y, g:i A') }}
                                </p>
                            @elseif ($workerBooking->status == "Completed")
                                @php
                                    $booked_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->booked_datetime);
                                    $accepted_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->accepted_datetime);
                                    $completed_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->completed_datetime);
                                @endphp

                                <p>
                                    Booked on
                                    {{ $booked_datetime->format('F d, Y, g:i A') }}
                                </p>
                                <p>
                                    Accepted on
                                    {{ $accepted_datetime->format('F d, Y, g:i A') }}
                                </p>
                                <p>
                                    Completed on
                                    {{ $completed_datetime->format('F d, Y, g:i A') }}
                                </p>
                            @elseif ($workerBooking->status == "Cancelled")
                                @php
                                    $booked_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->booked_datetime);
                                    $cancelled_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $workerBooking->cancelled_datetime);
                                @endphp

                                <p>
                                    Booked on
                                    {{ $booked_datetime->format('F d, Y, g:i A') }}
                                </p>
                                <p>
                                    Cancelled by
                                    @if ($workerBooking->cancelled_by == 0)
                                        Client
                                    @elseif ($workerBooking->cancelled_by == 1)
                                        Worker
                                    @endif
                                    on {{ $cancelled_datetime->format('F d, Y, g:i A') }}
                                </p>
                            @endif




                            @if ($workerBooking->status == "Pending")
                                <button disabled>
                                    {{ $workerBooking->status }}
                                </button>

                                <form action="{{ route('accept.booking', ['booking' => $workerBooking->id]) }}" method="POST" onsubmit="return confirm('You\'re about to accept this booking service. Do you wish to proceed?');">
                                    @csrf
                                    <button type="submit">
                                        Accept
                                    </button>
                                </form>
                                <form action="{{ route('cancel.booking', ['booking' => $workerBooking->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                    @csrf
                                    <input type="hidden" name="my_bookings_as_role" value="{{ $my_bookings_as_role }}">
                                    <input type="hidden" name="filter_by_status" value="{{ $filter_by_status }}">
                                    <button type="submit">
                                        Cancel
                                    </button>
                                </form>
                            @elseif ($workerBooking->status == "Accepted")
                                <button disabled>
                                    {{ $workerBooking->status }}
                                </button>

                                <form action="{{ route('complete.booking', ['booking' => $workerBooking->id]) }}" method="POST" onsubmit="return confirm('Are you certain you want to mark this booking as completed?');">
                                    @csrf
                                    <button type="submit">
                                        Mark as Completed
                                    </button>
                                </form>
                                <form action="{{ route('cancel.booking', ['booking' => $workerBooking->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                    @csrf
                                    <input type="hidden" name="my_bookings_as_role" value="{{ $my_bookings_as_role }}">
                                    <input type="hidden" name="filter_by_status" value="{{ $filter_by_status }}">
                                    <button type="submit">
                                        Cancel
                                    </button>
                                </form>
                            @elseif ($workerBooking->status == "Completed")
                                    @if ($workerBooking->rating != null)
                                        <p>Rating: {{ number_format($workerBooking->rating, 1) }}</p>
                                        <p>{{ $workerBooking->review }}</p>
                                    @endif
                                    <button disabled>
                                        Completed
                                    </button>

                            @elseif ($workerBooking->status == "Cancelled")
                                <button disabled>
                                    Cancelled
                                </button>
                            @endif



            @endforeach

    @endif
@endif
