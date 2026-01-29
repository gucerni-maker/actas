<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom" style="margin-bottom:30px;">

    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo class="d-inline-block align-text-top" style="height: 32px;" />
            Gestión de Actas
        </a>

        <!-- Botón hamburguesa para móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Enlaces de navegación -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="nav-link">
                        <i class="fas fa-tachometer-alt me-1"></i> {{ __('Dashboard') }}
                    </x-nav-link>
                </li>
                
                <li class="nav-item">
                    <x-nav-link :href="route('programadores.index')" :active="request()->routeIs('programadores.*')" class="nav-link">
                        <i class="fas fa-users me-1"></i> {{ __('Encargados') }}
                    </x-nav-link>
                </li>
                
                <li class="nav-item">
                    <x-nav-link :href="route('servidores.index')" :active="request()->routeIs('servidores.*')" class="nav-link">
                        <i class="fas fa-server me-1"></i> {{ __('Servidores') }}
                    </x-nav-link>
                </li>
                
                <li class="nav-item">
                    <x-nav-link :href="route('actas.index')" :active="request()->routeIs('actas.*')" class="nav-link">
                        <i class="fas fa-file-contract me-1"></i> {{ __('Actas') }}
                    </x-nav-link>
                </li>

                <!-- Comentado para portafolio público -->
                <!--
                @if(Auth::check() && Auth::user()->isAdmin())
                <li class="nav-item">
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="nav-link">
                        <i class="fas fa-users-cog me-1"></i> {{ __('Usuarios') }}
                    </x-nav-link>
                </li>
                @endif
                -->

                <!-- plantillas
                <li class="nav-item">
                    <x-nav-link :href="route('plantillas.index')" :active="request()->routeIs('plantillas.*')" class="nav-link">
                        <i class="fas fa-file-contract me-1"></i> {{ __('Plantillas') }}
                    </x-nav-link>
                </li>
                -->
 
            </ul>

            <!-- Información de demostración en lugar del menú de usuario -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">
                        <i class="fas fa-user-circle me-1"></i> Modo Demostración
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>