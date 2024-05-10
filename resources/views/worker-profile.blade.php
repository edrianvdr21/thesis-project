@extends('layout')

@section('content')

@include('partials.home-navbar')

<div class="max-w-2xl mx-auto mt-8 px-4">
    <h1 class="text-3xl font-bold mb-4">{{ $userProfile->first_name }} {{ $userProfile->last_name }}'s Profile</h1>

    <div class="bg-white shadow-md rounded-md p-6 mt-4">
        <h3 class="text-xl font-semibold mb-4">Worker Profile:</h3>
        <p class="mb-2"><span class="font-semibold">Worker ID:</span> {{ $workerProfile->id }}</p>
        <p class="mb-2"><span class="font-semibold">User ID:</span> {{ $workerProfile->user_id }}</p>
        <p class="mb-2"><span class="font-semibold">Category ID:</span> {{ $workerProfile->category_id }}</p>
        <p class="mb-2"><span class="font-semibold">Service ID:</span> {{ $workerProfile->service_id }}</p>
        <p class="mb-2"><span class="font-semibold">Description:</span> {{ $workerProfile->description }}</p>
        <p class="mb-2"><span class="font-semibold">Pricing:</span> {{ $workerProfile->pricing }}</p>
        <p class="mb-2"><span class="font-semibold">Minimum Duration:</span> {{ $workerProfile->minimum_duration }}</p>
        <p class="mb-2"><span class="font-semibold">Maximum Duration:</span> {{ $workerProfile->maximum_duration }}</p>
        <p class="mb-2"><span class="font-semibold">Working Days:</span> {{ $workerProfile->working_days }}</p>
        <p class="mb-2"><span class="font-semibold">Start Time:</span> {{ $workerProfile->start_time }}</p>
        <p class="mb-2"><span class="font-semibold">End Time:</span> {{ $workerProfile->end_time }}</p>
        <p class="mb-2"><span class="font-semibold">Valid ID:</span> {{ $workerProfile->valid_id }}</p>
        <p class="mb-2"><span class="font-semibold">Resume:</span> {{ $workerProfile->resume }}</p>

        <div class="max-w-lg mx-auto mt-8 px-4">
            <form action="/book" method="POST">
            @csrf
                {{-- Hidden fields to pass on controller --}}
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="hidden" name="worker_id" value="{{ $workerProfile->id }}">

                <div>
                    <label for="booking_date">Booking Date</label>
                    <input type="date" name="booking_date" id="booking_date" aria-label="Booking Date" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="booking_date">
                </div>
                <div>
                    <label for="booking_time">Booking Time</label>
                    <input type="time" name="booking_time" id="booking_time" aria-label="Booking Time" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="booking_time">
                </div>
                <div>
                    <label for="booking_notes">Notes</label>
                    <textarea rows=5 name="booking_notes" id="booking_notes" aria-label="Notes" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" wire:model="booking_notes"></textarea>
                </div>

                <x-button
                    value="Book a Service"
                    />
            </form>
        </div>
    </div>


</div>

@include('partials.footer')

@endsection
