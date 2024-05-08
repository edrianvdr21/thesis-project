{{-- <div>
    @include('home-page')
</div> --}}


<div>
    @include('partials.home-navbar')
    @if(Auth::check())
        <h1 class="text-center text-3xl font-bold mt-4">
            Welcome {{ Auth::user()->profile->first_name }} {{ Auth::user()->profile->last_name }}!
        </h1>
    @endif

    <main class="max-w-screen-lg mx-auto">

        @include('features.display-workers')

    </main>


</div>
