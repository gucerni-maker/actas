@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark">Detalles del Encargado</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th class="text-dark">ID:</th>
                            <td>{{ $programador->id }}</td>
                        </tr>
                        <tr>
                            <th class="text-dark">Nombre:</th>
                            <td>{{ $programador->nombre }}</td>
                        </tr>
                        <tr>
                            <th class="text-dark">Rut:</th>
                            <td>{{ $programador->rut }}</td>
                        </tr>

                        <tr>
                            <th class="text-dark">Codigo:</th>
                            <td>{{ $programador->codigo_programador }}</td>
                        </tr>                        

                        <tr>
                            <th class="text-dark">Correo:</th>
                            <td>{{ $programador->correo }}</td>
                        </tr>
                        <tr>
                            <th class="text-dark">Grado:</th>
                            <td>{{ $programador->cargo }}</td>
                        </tr>
                        <tr>
                            <th class="text-dark">Dotacion:</th>
                            <td>{{ $programador->oficina }}</td>
                        </tr>                        
                    </table>
                    
                    <div class="d-flex justify-content-between mt-3">
                        <a href="" class="btn btn-secondary">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        
                            <button type="submit" class="btn btn-dark btn-outline-light" >
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
