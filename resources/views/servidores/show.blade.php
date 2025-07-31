@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detalles del Servidor</h5>
                    <a href="{{ route('servidores.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>ID:</th>
                            <td>{{ $servidor->id }}</td>
                        </tr>
                        <tr>
                            <th>Tipo:</th>
                            <td>
                                <span class="badge bg-{{ $servidor->tipo == 'produccion' ? 'danger' : 'warning' }}">
                                    {{ ucfirst($servidor->tipo) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Sistema Operativo:</th>
                            <td>{{ $servidor->sistema_operativo }}</td>
                        </tr>
                        <tr>
                            <th>CPU:</th>
                            <td>{{ $servidor->cpu }}</td>
                        </tr>
                        <tr>
                            <th>RAM:</th>
                            <td>{{ $servidor->ram }}</td>
                        </tr>
                        <tr>
                            <th>Disco:</th>
                            <td>{{ $servidor->disco }}</td>
                        </tr>
                        <tr>
                            <th>Notas Técnicas:</th>
                            <td>{{ $servidor->notas_tecnicas ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Fecha de Registro:</th>
                            <td>{{ $servidor->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Última Actualización:</th>
                            <td>{{ $servidor->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                    
                    @if(Auth::user()->isAdmin())
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('servidores.edit', $servidor) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        
                        <form action="{{ route('servidores.destroy', $servidor) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('¿Estás seguro de eliminar este servidor?')">
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
