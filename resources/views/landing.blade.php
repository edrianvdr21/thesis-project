@extends('layout')

@section('content')

@include('partials.navbar')

<main class="max-w-screen-lg mx-auto">
    @livewire('login')
</main>

@include('partials.footer')

@endsection
