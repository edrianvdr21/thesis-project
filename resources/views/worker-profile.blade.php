@extends('layout')

@section('content')

@include('partials.home-navbar')

<h1>{{ $userProfile->first_name }} {{ $userProfile->last_name }}'s Profile</h1>

<img src="{{ asset('images/Default Profile Picture.png') }}" alt="{{ $userProfile->first_name }} {{ $userProfile->last_name }}'s Profile Picture">

<p>Category: {{ $workerProfile->category->category }}</p>
<p>Service: {{ $workerProfile->service->service }}</p>
<p>Service Description: {{ $workerProfile->description }}</p>
<p>₱{{ $workerProfile->pricing }}</p>
<p>Estimated Duration: {{ $workerProfile->minimum_duration }} to {{ $workerProfile->maximum_duration }} hours</p>
<p>Working Day/s:
    @if(!empty($availableDays))
        {{ implode(', ', $availableDays) }}
    @else
        Not available on any day.
    @endif
</p>
<p>Time Availability:
    {{ DateTime::createFromFormat('H:i:s', $workerProfile->start_time)->format('g:i A') }}
    to
    {{ DateTime::createFromFormat('H:i:s', $workerProfile->end_time)->format('g:i A') }}
</p>

<h2>Book a Service</h2>

@if (session('success'))
    <strong>{{ session('success') }}</strong>
@endif

<form action="/book" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
    <input type="hidden" name="worker_id" value="{{ $workerProfile->id }}">

    <label for="booking_date">Booking Date</label>
    <input type="date" name="booking_date" id="booking_date" required>

    <label for="booking_time">Booking Time</label>
    <input type="time" name="booking_time" id="booking_time" required>

    <label for="booking_notes">Notes</label>
    <textarea rows="5" name="booking_notes" id="booking_notes" required></textarea>

    <button type="submit">
        Book a Service
    </button>
</form>

@include('partials.footer')

@endsection
