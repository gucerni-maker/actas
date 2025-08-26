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

		<!-- Agregar esta sección para usuarios administradores -->
		@if(Auth::check() && Auth::user()->isAdmin())
		<li class="nav-item">
		    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="nav-link">
		        <i class="fas fa-users-cog me-1"></i> {{ __('Usuarios') }}
		    </x-nav-link>
		</li>
		@endif

            </ul>

            <!-- Menú de usuario -->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <x-dropdown-link :href="route('profile.edit')" class="dropdown-item">
                                <i class="fas fa-user me-2"></i> {{ __('Profile') }}
                            </x-dropdown-link>
                        </li>
                        <li>
                            <x-dropdown-link :href="route('profile.firma')" class="dropdown-item">
                                <i class="fas fa-signature me-2"></i> {{ __('Firma Digital') }}
                            </x-dropdown-link>
                        </li>

                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" 
                                    onclick="event.preventDefault(); this.closest('form').submit();" 
                                    class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
