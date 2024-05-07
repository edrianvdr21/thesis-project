<nav class="bg-blue-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-white text-xl font-bold">{{ config('app.name') }}</div>
        <div>
            <a href="{{ route('logout') }}" class="text-white hover:text-blue-300">Logout</a>
        </div>
    </div>
</nav>

{{-- form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
    <button type="submit">Logout</button>
</form> --}}
