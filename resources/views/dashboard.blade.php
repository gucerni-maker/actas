@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    <p class="text-muted">Bienvenido, {{ Auth::user()->name }}. Rol: {{ ucfirst(Auth::user()->rol) }}</p>
                </div>
                @if(Auth::user()->isAdmin())
                <div>
                    <a href="{{ route('admin.register') }}" class="btn btn-success">
                        <i class="fas fa-user-plus"></i> Registrar Nuevo Usuario
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>


<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Actas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalActas }}</div>
                        <div class="mt-2">
                            <a href="{{ route('actas.index') }}" class="btn btn-sm btn-outline-primary">
                                Ver todas
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-contract fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Programadores
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProgramadores }}</div>
                        <div class="mt-2">
                            <a href="{{ route('programadores.index') }}" class="btn btn-sm btn-outline-success">
                                Ver todos
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Servidores
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalServidores }}</div>
                        <div class="mt-2">
                            <a href="{{ route('servidores.index') }}" class="btn btn-sm btn-outline-info">
                                Ver todos
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-server fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- NUEVAS TARJETAS PARA USUARIOS -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Administradores
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAdministradores }}</div>
                        <div class="mt-2">
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-warning">
                                Ver todos
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-cog fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Consultores
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalConsultores }}</div>
                        <div class="mt-2">
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-danger">
                                Ver todos
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history me-2"></i> Últimas Actas de Entrega
                    </h6>
                    @if(Auth::user()->isAdmin())
                    <div>
                        <a href="{{ route('actas.create') }}" class="btn btn-primary btn-sm me-2">
                            <i class="fas fa-plus me-1"></i> Nueva Acta
                        </a>
                        <a href="{{ route('actas.cargar-existente.form') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-upload me-1"></i> Cargar Acta Existente
                        </a>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    @if($ultimasActas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
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
                                                <a href="{{ route('actas.show', $acta) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-contract fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay actas registradas aún.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
