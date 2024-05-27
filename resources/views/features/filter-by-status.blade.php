<ul>
    <li>
        <a href="{{ route('my_bookings', [
            'my_bookings_as_role' => 'as ' . $role,
            'filter_by_status' => null
            ]) }}"
            @if ($filter_by_status == null) aria-current="page" @endif
            >
            All ({{ $totalCount }})
        </a>
    </li>
    <li>
        <a href="{{ route('my_bookings', [
            'my_bookings_as_role' => 'as ' . $role,
            'filter_by_status' => 'Pending'
            ]) }}"
            @if ($filter_by_status == "Pending") aria-current="page" @endif
            >
            Pending ({{ $pendingCount }})
        </a>
    </li>
    <li>
        <a href="{{ route('my_bookings', [
            'my_bookings_as_role' => 'as ' . $role,
            'filter_by_status' => 'Accepted'
            ]) }}"
            @if ($filter_by_status == "Accepted") aria-current="page" @endif
            >
            Accepted ({{ $acceptedCount }})
        </a>
    </li>
    <li>
        <a href="{{ route('my_bookings', [
            'my_bookings_as_role' => 'as ' . $role,
            'filter_by_status' => 'Completed'
            ]) }}"
            @if ($filter_by_status == "Completed") aria-current="page" @endif
            >
            Completed ({{ $completedCount }})
        </a>
    </li>
    <li>
        <a href="{{ route('my_bookings', [
            'my_bookings_as_role' => 'as ' . $role,
            'filter_by_status' => 'Cancelled'
            ]) }}"
            @if ($filter_by_status == "Cancelled") aria-current="page" @endif
            >
            Cancelled ({{ $cancelledCount }})
        </a>
    </li>
</ul>
