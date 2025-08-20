@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Lista de Programadores</h5>
                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('programadores.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Programador
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    <!-- Formulario de búsqueda -->
                    <form method="GET" action="{{ route('programadores.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="buscar" 
                                           placeholder="Buscar por nombre, correo, cargo, RUT, etc." 
                                           value="{{ request('buscar') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                    @if(request('buscar'))
                                    <a href="{{ route('programadores.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i> Limpiar
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($programadores->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <a href="{{ route('programadores.index', array_merge(request()->except('orden', 'direccion'), ['orden' => 'nombre', 'direccion' => request('orden') == 'nombre' && request('direccion') == 'asc' ? 'desc' : 'asc'])) }}">
                                                Nombre @if(request('orden') == 'nombre') <i class="fas fa-sort-{{ request('direccion') == 'asc' ? 'up' : 'down' }}"></i> @endif
                                            </a>
                                        </th>
                                        <th>Correo</th>
                                        <th>Cargo</th>
                                        <th>Teléfono</th>
                                        @if(Auth::user()->isAdmin())
                                        <th>Acciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($programadores as $programador)
                                        <tr>
                                            <td>{{ $programador->nombre }}</td>
                                            <td>{{ $programador->correo }}</td>
                                            <td>{{ $programador->cargo }}</td>
                                            <td>{{ $programador->telefono ?? 'N/A' }}</td>
                                            @if(Auth::user()->isAdmin())
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('programadores.show', $programador) }}" class="btn btn-info btn-sm p-1" style="font-size: 0.7rem; width: 30px; height: 30px;">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('programadores.edit', $programador) }}" class="btn btn-warning btn-sm p-1" style="font-size: 0.7rem; width: 30px; height: 30px;">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('programadores.destroy', $programador) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm p-1" style="font-size: 0.7rem; width: 30px; height: 30px;" onclick="return confirm('¿Estás seguro de eliminar este programador?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $programadores->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            @if(request('buscar'))
                                <p class="text-muted">No se encontraron programadores que coincidan con tu búsqueda.</p>
                            @else
                                <p class="text-muted">No hay programadores registrados.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
