<div>
    <div class="flex items-center justify-center mt-4">
        <img class="mx-auto my-4 max-w-full max-h-48" src="{{ asset('images/Logo v1.png') }}" alt="{{ config('app.name') }} logo">
    </div>
    <div>
        <h1 class="text-center text-3xl font-bold my-4">Login</h1>
    </div>
    <div class="grid place-content-center gap-[25px]">
        <form action="/login" method="POST">
        @csrf
            <div class="relative my-2">
                @if ($errors->any())
                    <div class="text-center">
                        @foreach ($errors->all() as $error)
                            <p class="bg-red-200 p-2">{{ $error }}</sp>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="relative">
                <svg class="absolute left-4 top-[11px]" width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 7.532C9.57107 7.532 11.25 5.8459 11.25 3.766C11.25 1.6861 9.57107 0 7.5 0C5.42893 0 3.75 1.6861 3.75 3.766C3.75 5.8459 5.42893 7.532 7.5 7.532ZM7.5 1.883C8.53553 1.883 9.375 2.72605 9.375 3.766C9.375 4.80595 8.53553 5.649 7.5 5.649C6.46447 5.649 5.625 4.80595 5.625 3.766C5.625 2.72605 6.46447 1.883 7.5 1.883ZM9.375 9.415H5.625C2.5184 9.415 0 11.9441 0 15.064V18.83H15V15.064C15 11.9441 12.4816 9.415 9.375 9.415ZM13.125 16.947H1.875V15.064C1.875 12.9841 3.55393 11.298 5.625 11.298H9.375C11.4461 11.298 13.125 12.9841 13.125 15.064V16.947Z" fill="#333333"/>
                    </svg>
                <input
                    class="pl-12 w-[346px] h-10 bg-white rounded-[5px] border-2 border-teal-800"
                    type="text"
                    name="username"
                    placeholder="Username"
                    required
                    aria-label="Username"
                    wire:model="username"
                    >
            </div>

            <div class="relative">
                <svg class="absolute left-4 top-[11px]" width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 0C10.5977 0 13.125 2.54624 13.125 5.649V9.415H15V18.83H0V9.415H1.875V5.649C1.875 2.54624 4.4023 0 7.5 0ZM13.125 11.298H1.875V16.947H13.125V11.298ZM7.5 1.883C5.42003 1.883 3.75 3.604 3.75 5.649V9.415H11.25V5.649C11.25 3.604 9.57994 1.883 7.5 1.883Z" fill="#333333"/>
                </svg>
                <input
                    class="pl-12 w-[346px] h-10 bg-white rounded-[5px] border-2 border-teal-800 mt-2"
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                    aria-label="Password"
                    wire:model="password"
                    >
            </div>
            <div class="flex flex-col items-center justify-center my-4">
                <button
                    class="w-[346px] h-10 bg-blue-800 text-white hover:bg-white focus:bg-white hover:text-blue-800 focus:text-blue-800 rounded-[5px] border border-blue-800 border-opacity-50 focus:outline-none  transition-colors duration-300 mb-2"
                    type="submit"
                    {{-- wire:click="login" --}}
                    >
                    LOGIN
                </button>
                <a
                    href="{{ route('sign_up') }}"
                    class="flex justify-center items-center text-center text-blue-800 hover:underline focus:underline rounded-[5px] focus:outline-none"
                    >
                    Create an Account
                </a>
                <a
                    href="{{ route('sign_up_and_become_a_worker') }}"
                    class="flex justify-center items-center text-center mt-4 text-blue-800 hover:underline focus:underline rounded-[5px] focus:outline-none"
                    >
                    Become a Worker
                </a>
            </div>
        </form>
    </div>




</div>
