@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Dashboard</h1>
            <p class="text-muted">Bienvenido, {{ Auth::user()->name }}. Rol: {{ ucfirst(Auth::user()->rol) }}</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header"><i class="fas fa-file-contract"></i> Total Actas</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalActas }}</h5>
                    <p class="card-text">Actas de entrega registradas</p>
                    <a href="{{ route('actas.index') }}" class="btn btn-light btn-sm">Ver todas</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header"><i class="fas fa-users"></i> Programadores</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalProgramadores }}</h5>
                    <p class="card-text">Programadores registrados</p>
                    <a href="{{ route('programadores.index') }}" class="btn btn-light btn-sm">Ver todos</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header"><i class="fas fa-server"></i> Servidores</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalServidores }}</h5>
                    <p class="card-text">Servidores configurados</p>
                    <a href="{{ route('servidores.index') }}" class="btn btn-light btn-sm">Ver todos</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-history"></i> Últimas Actas de Entrega</h5>
                    <a href="{{ route('actas.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nueva Acta
                    </a>
                </div>
                <div class="card-body">
                    @if($ultimasActas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Programador</th>
                                        <th>Servidor</th>
                                        <th>Tipo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ultimasActas as $acta)
                                        <tr>
                                            <td>{{ $acta->fecha_entrega->format('d/m/Y') }}</td>
                                            <td>{{ $acta->programador->nombre }}</td>
                                            <td>{{ $acta->servidor->sistema_operativo }} - {{ $acta->servidor->cpu }}</td>
                                            <td>
                                                <span class="badge bg-{{ $acta->servidor->tipo == 'produccion' ? 'danger' : 'warning' }}">
                                                    {{ ucfirst($acta->servidor->tipo) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('actas.show', $acta) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No hay actas registradas aún.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
