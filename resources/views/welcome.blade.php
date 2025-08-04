<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <div class="flex justify-center items-center h-screen">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800">Bienvenido a la Plataforma de Gestión de Actas</h1>
                <p class="mt-4 text-lg text-gray-600">
                    Esta es la página de inicio. Inicia sesión para acceder al sistema.
                </p>
                <div class="mt-6">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-secondary ms-2">
                        <i class="fas fa-user-plus"></i> Registrarse
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
