@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Lista de Servidores</h5>
                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('servidores.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Servidor
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    <!-- Formulario de búsqueda -->
                    <form method="GET" action="{{ route('servidores.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="buscar" 
                                           placeholder="Buscar por nombre, sistema operativo, CPU, RAM, etc." 
                                           value="{{ request('buscar') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                    @if(request('buscar'))
                                    <a href="{{ route('servidores.index') }}" class="btn btn-outline-secondary">
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

                    @if($servidores->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <a href="{{ route('servidores.index', array_merge(request()->except('orden', 'direccion'), ['orden' => 'nombre', 'direccion' => request('orden') == 'nombre' && request('direccion') == 'asc' ? 'desc' : 'asc'])) }}">
                                                IP @if(request('orden') == 'nombre') <i class="fas fa-sort-{{ request('direccion') == 'asc' ? 'up' : 'down' }}"></i> @endif
                                            </a>
                                        </th>
                                        <th>Reparticion</th>
                                        <th>Tipo</th>
                                        <th>S.O.</th>
                                        <th>CPU</th>
                                        <th>RAM</th>
                                        <th>Disco</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($servidores as $servidor)
                                        <tr>
                                            <td>{{ $servidor->nombre ?? 'Sin nombre' }}</td>
                                            <td>{{ $servidor->notas_tecnicas }}</td>
                                            <td>
                                                <span class="badge bg-{{ $servidor->tipo == 'produccion' ? 'danger' : 'warning' }}">
                                                    {{ ucfirst($servidor->tipo) }}
                                                </span>
                                            </td>
                                            <td>{{ $servidor->sistema_operativo }}</td>
                                            <td>{{ $servidor->cpu }}</td>
                                            <td>{{ $servidor->ram }}</td>
                                            <td>{{ $servidor->disco }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('servidores.show', $servidor) }}" class="btn btn-info btn-sm p-1" style="font-size: 0.7rem; width: 30px; height: 30px;">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if(Auth::user()->isAdmin())
                                                    <a href="{{ route('servidores.edit', $servidor) }}" class="btn btn-warning btn-sm p-1" style="font-size: 0.7rem; width: 30px; height: 30px;">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('servidores.destroy', $servidor) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm p-1" style="font-size: 0.7rem; width: 30px; height: 30px;" onclick="return confirm('¿Estás seguro de eliminar este servidor?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $servidores->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-server fa-3x text-muted mb-3"></i>
                            @if(request('buscar'))
                                <p class="text-muted">No se encontraron servidores que coincidan con tu búsqueda.</p>
                            @else
                                <p class="text-muted">No hay servidores registrados.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
