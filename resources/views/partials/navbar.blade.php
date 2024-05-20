<nav class="bg-blue-800 p-4">
    <div class="container mx-auto flex justify-center items-center">
        <div class="text-white text-xl font-bold">
            <a
                href="/"
                class="flex items-center text-white text-xl font-bold px-2 border border-blue-800 focus:border-white focus:outline-none"
                >
                <img class="h-8 mr-2" src="{{ asset('images/Logo v2.png') }}" alt="{{ config('app.name') }} logo">
                {{ config('app.name') }}
            </a>
        </div>
        {{-- <div>
            <a href="#" class="text-white hover:text-blue-300">Login</a>
            <a href="{{ route('sign_up') }}" class="text-white hover:text-blue-300">Sign Up</a>
        </div> --}}
    </div>
</nav>
