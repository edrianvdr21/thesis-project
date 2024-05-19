@extends('layout')

@section('content')

@include('partials.home-navbar')

<div class="max-w-2xl mx-auto px-4 my-4">
    <h1 class="text-3xl font-bold mb-4">My Bookings  </h1>

    {{-- Client --}}
    @if ($user->userProfile->role_id == 2)
        @include('features.my-bookings-as-client')
    {{-- Worker --}}
    @elseif ($user->userProfile->role_id == 3)
        @include('features.my-bookings-as-worker')
    @endif
</div>

@include('partials.footer')




@endsection
