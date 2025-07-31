@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Lista de Actas de Entrega</h5>
                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('actas.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nueva Acta
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($actas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha Entrega</th>
                                        <th>Programador</th>
                                        <th>Servidor</th>
                                        <th>Tipo</th>
                                        <th>Creada por</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($actas as $acta)
                                        <tr>
                                            <td>{{ $acta->id }}</td>
                                            <td>{{ $acta->fecha_entrega->format('d/m/Y') }}</td>
                                            <td>{{ $acta->programador->nombre }}</td>
                                            <td>{{ $acta->servidor->sistema_operativo }} - {{ $acta->servidor->cpu }}</td>
                                            <td>
                                                <span class="badge bg-{{ $acta->servidor->tipo == 'produccion' ? 'danger' : 'warning' }}">
                                                    {{ ucfirst($acta->servidor->tipo) }}
                                                </span>
                                            </td>
                                            <td>{{ $acta->usuario->name }}</td>
                                            <td>
                                                <a href="{{ route('actas.show', $acta) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                                @if(Auth::user()->isAdmin())
                                                <a href="{{ route('actas.edit', $acta) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <form action="{{ route('actas.destroy', $acta) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta acta?')">
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
                            {{ $actas->links() }}
                        </div>
                    @else
                        <p>No hay actas registradas.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
