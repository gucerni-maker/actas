
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Estilos personalizados para la página de login -->
    <style>
        /* Fondo oscuro */
        body {
            background-color: #121212;
        }

        /* Tarjeta de login */
        .card {
            background-color: #1e1e1e;
            border: 1px solid #333333;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        /* Título de la tarjeta */
        .card-header {
            background-color: #2a2a2a;
            border-bottom: 1px solid #333333;
            color: #e0e0e0;
        }

        /* Etiquetas de los campos */
        .form-label {
            color: #b0b0b0;
        }

        /* Campos de entrada */
        .form-control {
            background-color: #1e1e1e;
            border: 1px solid #333333;
            color: #e0e0e0;
        }

        /* Foco en los campos */
        .form-control:focus {
            border-color: #4a4a4a;
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.1);
        }

        /* Placeholder */
        .form-control::placeholder {
            color: #808080;
        }

        /* Botones */
        .btn-primary {
            background-color: #1a1a1a;
            color: #ffffff;
            border: 1px solid #333333;
        }

        .btn-primary:hover {
            background-color: #2a2a2a;
        }

        /* Enlaces */
        a {
            color: #6ea8fe;
        }

        a:hover {
            color: #8bb9fe;
        }
    </style>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" class="form-label" />
            <x-text-input id="email" class="form-control block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Password')" class="form-label" />

            <x-text-input id="password" class="form-control block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label form-label">{{ __('Remember me') }}</label>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a class="text-decoration-none" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="btn btn-primary ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
