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
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Cargo</th>
                                        <th>Teléfono</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($programadores as $programador)
                                        <tr>
                                            <td>{{ $programador->id }}</td>
                                            <td>{{ $programador->nombre }}</td>
                                            <td>{{ $programador->correo }}</td>
                                            <td>{{ $programador->cargo }}</td>
                                            <td>{{ $programador->telefono ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('programadores.show', $programador) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                                @if(Auth::user()->isAdmin())
                                                <a href="{{ route('programadores.edit', $programador) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <form action="{{ route('programadores.destroy', $programador) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este programador?')">
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
                            {{ $programadores->links() }}
                        </div>
                    @else
                        <p>No hay programadores registrados.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
