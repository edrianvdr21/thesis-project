@extends('layout')

@section('content')

@include('partials.home-navbar')

<main class="max-w-screen-lg mx-auto">
    @livewire('home-page')
</main>

@include('partials.footer')

@endsection
