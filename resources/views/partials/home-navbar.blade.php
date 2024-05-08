<nav class="bg-blue-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-white text-xl font-bold">{{ config('app.name') }}</div>
        <div>
            {{-- @if($userProfile->role_id == 2)
                <a href="{{ route('sign_up_worker') }}" class="text-white hover:text-blue-300">Become a Worker</a>
            @endif
            <a href="{{ route('logout') }}" class="text-white hover:text-blue-300">Logout</a> --}}

            <ul class="flex flex-col p-4 md:p-0 mt-4 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-blue-800">
                @if(Auth::user()->profile->role_id == 2)
                <li>
                  <a href="{{ route('sign_up_worker') }}" class="block py-2 px-3 text-white bg-blue-800 rounded hover:bg-white hover:text-blue-800 focus:bg-white focus:text-blue-800 focus:outline-none">Become a Worker</a>
                </li>
                @endif
                <li>
                  <a href="{{ route('logout') }}" class="block py-2 px-3 text-white bg-blue-800 rounded hover:bg-white hover:text-blue-800 focus:bg-white focus:text-blue-800 focus:outline-none">Logout</a>
                </li>
              </ul>
        </div>
    </div>
</nav>

{{-- form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
    <button type="submit">Logout</button>
</form> --}}
