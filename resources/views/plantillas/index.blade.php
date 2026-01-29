@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark">Lista de Plantillas de Actas</h5>
                    <a href="{{ route('plantillas.create') }}" class="btn btn-dark btn-outline-light">
                        <i class="fas fa-plus"></i> Nueva Plantilla
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($plantillas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;" class="text-dark">ID</th>
                                        <th style="text-align:center;" class="text-dark">Nombre</th>
                                        <th style="text-align:center;" class="text-dark">Fecha de Creación</th>
                                        <th style="text-align:center;" class="text-dark">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($plantillas as $plantilla)
                                        <tr>
                                            <td style="text-align:center;">{{ $plantilla->id }}</td>
                                            <td style="text-align:center;">{{ $plantilla->nombre }}</td>
                                            <td style="text-align:center;">{{ $plantilla->created_at->format('d/m/Y H:i') }}</td>
                                            <td style="text-align:center;">
                                                <a href="{{ route('plantillas.vista-previa-pdf', $plantilla) }}" class="btn btn-dark btn-outline-light  btn-sm" target="_blank">
                                                    <i class="fas fa-search"></i> Vista Previa
                                                </a>
                                                <a href="{{ route('plantillas.edit', $plantilla) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <form action="{{ route('plantillas.destroy', $plantilla) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta plantilla?')">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $plantillas->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <p>No hay plantillas registradas.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
