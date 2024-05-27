<div>
    <h2>{{ $heading2 }}</h2>

    <div>
        @foreach ($workers as $worker)
            <form action="{{ route('track.worker.profile.view') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $worker->user_id }}">
                <input type="hidden" name="worker_id" value="{{ $worker->id }}">
                <input type="hidden" name="category_id" value="{{ $worker->category_id }}">
                <input type="hidden" name="service_id" value="{{ $worker->service_id }}">

                <button role="link" type="submit">
                    <div>
                        <img src="{{ asset('images/Default Profile Picture.png') }}" alt="{{ $worker->user->userProfile->first_name }} {{ $worker->user->userProfile->last_name }}'s Profile Picture">

                        <div>
                            <h3>{{ $worker->user->userProfile->first_name }} {{ $worker->user->userProfile->last_name }}</h3>
                            <p>{{ $worker->category->category }}</p>
                            <p>{{ $worker->service->service }}</p>
                            <p>₱{{ $worker->pricing }}</p>

                            <div>
                                <p>{{ $worker->user->address->city->city }}, {{ $worker->user->address->province->province }}</p>
                            </div>

                            @if ($worker->average_rating != null)
                                <div>
                                    <div>
                                        <span>{{ number_format($worker->average_rating, 1) }}</span>
                                    </div>
                                </div>
                            @else
                                <p>No ratings yet</p>
                            @endif

                            @if ($worker->completed_count != 0)
                                <p>{{ $worker->completed_count }} {{ $worker->completed_count == 1 ? 'Completed Service' : 'Completed Services' }}</p>
                            @endif
                        </div>
                    </div>
                </button>
            </form>
        @endforeach
    </div>
</div>
