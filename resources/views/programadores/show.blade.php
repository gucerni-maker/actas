@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detalles del Encargado</h5>
                    <a href="{{ route('programadores.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>ID:</th>
                            <td>{{ $programador->id }}</td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td>{{ $programador->nombre }}</td>
                        </tr>
                        <tr>
                            <th>Rut:</th>
                            <td>{{ $programador->rut }}</td>
                        </tr>

                        <tr>
                            <th>Codigo:</th>
                            <td>{{ $programador->codigo_programador }}</td>
                        </tr>                        

                        <tr>
                            <th>Correo:</th>
                            <td>{{ $programador->correo }}</td>
                        </tr>
                        <tr>
                            <th>Grado:</th>
                            <td>{{ $programador->cargo }}</td>
                        </tr>
                        <tr>
                            <th>Reparticion:</th>
                            <td>{{ $programador->oficina }}</td>
                        </tr>                        

                        <tr>
                            <th>Fecha de Registro:</th>
                            <td>{{ $programador->created_at->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Última Actualización:</th>
                            <td>{{ $programador->updated_at->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                    
                    @if(Auth::user()->isAdmin())
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('programadores.edit', $programador) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        
                        <form action="{{ route('programadores.destroy', $programador) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('¿Estás seguro de eliminar este encargado?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
