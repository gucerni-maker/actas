@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        @if(isset($filtro) && $filtro == 'administradores')
                            Lista de Administradores
                        @elseif(isset($filtro) && $filtro == 'consultores')
                            Lista de Consultores
                        @else
                            Lista de Usuarios
                        @endif
                    </h5>
                    <div>
                        @if(!isset($filtro) || (isset($filtro) && $filtro != 'administradores' && $filtro != 'consultores'))
                            <a href="{{ route('admin.register') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Nuevo Usuario
                            </a>
                        @else
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-list"></i> Todos los Usuarios
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Filtros rápidos -->
                    @if(!isset($filtro))
                    <div class="mb-3">
                        <a href="{{ route('users.administradores') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-user-cog"></i> Solo Administradores
                        </a>
                        <a href="{{ route('users.consultores') }}" class="btn btn-outline-secondary btn-sm ms-2">
                            <i class="fas fa-user-tie"></i> Solo Consultores
                        </a>
                    </div>
                    @endif

                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Fecha de Registro</th>
                                        @if(!isset($filtro))
                                        <th>Acciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge bg-{{ $user->rol == 'admin' ? 'primary' : 'secondary' }}">
                                                    {{ ucfirst($user->rol) }}
                                                </span>
                                            </td>
                                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                            @if(!isset($filtro))
                                            <td>
                                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                @if($user->id !== auth()->id())
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                                @endif
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $users->links() }}
                        </div>
                    @else
                        <p>No hay usuarios registrados.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
