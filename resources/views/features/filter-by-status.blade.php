
<div class="text-lg font-medium text-center my-4">
    <ul class="flex justify-center w-full">
        <li class="w-1/2">
            <a href="{{ route('my_bookings', [
                'my_bookings_as_role' => 'as ' . $role,
                'filter_by_status' => null
                ]) }}"
                class="inline-block w-full px-2 py-4 text-sm rounded text-dark border border-white hover:border-blue-800 focus:border-blue-800 focus:outline-none
                @if ($filter_by_status == null) bg-blue-300 @endif
                "
                @if ($filter_by_status == null) aria-current="page" @endif
                >
                All ({{ $totalCount }})
            </a>
        </li>
        <li class="w-1/2">
            <a href="{{ route('my_bookings', [
                'my_bookings_as_role' => 'as ' . $role,
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
                'my_bookings_as_role' => 'as ' . $role,
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
                'my_bookings_as_role' => 'as ' . $role,
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
                'my_bookings_as_role' => 'as ' . $role,
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
