@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark">Detalles del Servidor</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th class="text-dark">ID:</th>
                            <td>{{ $servidor->id }}</td>
                        </tr>
                        <tr>
                            <th class="text-dark">Tipo:</th>
                            <td>
                                <span class="badge bg-{{ $servidor->tipo == 'produccion' ? 'secondary' : 'light' }}" style="color:#222">
                                    {{ ucfirst($servidor->tipo) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-dark">Sistema Operativo:</th>
                            <td>{{ $servidor->sistema_operativo }}</td>
                        </tr>
                        <tr>
                            <th class="text-dark">CPU:</th>
                            <td>{{ $servidor->cpu }}</td>
                        </tr>
                        <tr>
                            <th class="text-dark">RAM:</th>
                            <td>{{ $servidor->ram }}</td>
                        </tr>
                        <tr>
                            <th class="text-dark">Disco:</th>
                            <td>{{ $servidor->disco }}</td>
                        </tr>
                        <tr>
                            <th class="text-dark">A cargo de:</th>
                            <td>{{ $servidor->notas_tecnicas ?? 'N/A' }}</td>
                        </tr>

                    </table>
                    
                    <div class="d-flex justify-content-between mt-3">
                        <a href="" class="btn btn-dark btn-outline-light">
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
