<div>
        <h1>Login</h1>
        <form action="/login" method="POST">
        @csrf
                @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</sp>
                        @endforeach
                @endif
                <input
                    type="text"
                    name="username"
                    placeholder="Username"
                    required
                    aria-label="Username"
                    wire:model="username"
                    >
                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                    aria-label="Password"
                    wire:model="password"
                    >
                <button
                    type="submit"
                    {{-- wire:click="login" --}}
                    >
                    LOGIN
                </button>
                <a
                    href="{{ route('sign_up') }}"
                    >
                    Create an Account
                </a>
                <a
                    href="{{ route('sign_up_and_become_a_worker') }}"
                    >
                    Become a Worker
                </a>
        </form>
</div>
