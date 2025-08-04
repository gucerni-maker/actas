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
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Sistema Operativo</th>
                                        <th>CPU</th>
                                        <th>RAM</th>
                                        <th>Disco</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($servidores as $servidor)
                                        <tr>
                                            <td>{{ $servidor->id }}</td>
					    <td>{{ $servidor->nombre ?? 'Sin nombre' }}</td>
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
                                                <a href="{{ route('servidores.show', $servidor) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                                @if(Auth::user()->isAdmin())
                                                <a href="{{ route('servidores.edit', $servidor) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <form action="{{ route('servidores.destroy', $servidor) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este servidor?')">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $servidores->links() }}
                        </div>
                    @else
                        <p>No hay servidores registrados.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
