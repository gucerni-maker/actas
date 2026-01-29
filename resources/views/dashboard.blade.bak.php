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
                    <a href="{{ route('admin.register') }}" class="btn btn-dark">
                        <i class="fas fa-user-plus"></i> Registrar Nuevo Usuario
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>


    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-start border-white shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Actas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalActas }}</div>
                            <div class="mt-2">
                                <a href="{{ route('actas.index') }}" class="btn btn-sm btn-outline-danger">
                                    Ver todas
                                </a>
                            </div>

                            <div class="mt-3">
                                <form method="GET" action="{{ route('dashboard') }}" class="d-flex">
                                    <input type="text" 
                                           name="buscar_rapido" 
                                           class="form-control form-control-sm me-2" 
                                           placeholder="Buscar por encargado o IP..." 
                                           value="{{ $terminoBusqueda }}">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
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
        <div class="card border-start border-white shadow h-100 py-2 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Encargados
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProgramadores }}</div>
                        <div class="mt-2">
                            <a href="{{ route('programadores.index') }}" class="btn btn-sm btn-outline-danger">
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
        <div class="card border-start border-white shadow h-100 py-2 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Servidores
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalServidores }}</div>
                        <div class="mt-2">
                            <a href="{{ route('servidores.index') }}" class="btn btn-sm btn-outline-danger">
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
        <div class="card border-start border-white shadow h-100 py-2 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Administradores
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAdministradores }}</div>
                        <div class="mt-2">
			    <a href="{{ route('users.administradores') }}" class="btn btn-sm btn-outline-danger">
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
        <div class="card border-start border-white shadow h-100 py-2 dashboard-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Consultores
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalConsultores }}</div>
                            <div class="mt-2">
	            	    	    <a href="{{ route('users.consultores') }}" class="btn btn-sm btn-outline-danger">
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

    <!-- Resultados de búsqueda rápida -->
    @if(isset($resultadosBusqueda) && $terminoBusqueda)
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-search me-2"></i> Resultados de búsqueda para "{{ $terminoBusqueda }}"
                        <span class="float-end">
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-times"></i> Cerrar
                            </a>
                        </span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($resultadosBusqueda->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-dark">Fecha</th>
                                        <th class="text-dark">Encargado</th>
                                        <th class="text-dark">Servidor (IP)</th>
                                        <th class="text-dark">Tipo</th>
                                        <th class="text-dark">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($resultadosBusqueda as $acta)
                                        <tr>
                                            <td>{{ $acta->fecha_entrega->format('d/m/Y') }}</td>
                                            <td>{{ $acta->programador->nombre }}</td>
                                            <td>{{ $acta->servidor->nombre }}</td>
                                            <td>
                                                <span class="badge bg-{{ $acta->servidor->tipo == 'produccion' ? 'danger' : 'warning' }}">
                                                    {{ ucfirst($acta->servidor->tipo) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('actas.show', $acta) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($resultadosBusqueda->count() >= 10)
                            <div class="alert alert-info small">
                                <i class="fas fa-info-circle me-2"></i>
                                Se muestran los primeros 10 resultados. 
                                <a href="{{ route('actas.index', ['buscar' => $terminoBusqueda]) }}">Ver todos los resultados</a>.
                            </div>
                        @endif
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No se encontraron actas que coincidan con "{{ $terminoBusqueda }}"</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif


    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-history me-2"></i> Últimas Actas de Entrega
                    </h6>
                    @if(Auth::user()->isAdmin())
                    <div>
                        <a href="{{ route('actas.create') }}" class="btn btn-danger btn-sm me-2">
                            <i class="fas fa-plus me-1"></i> Nueva Acta
                        </a>
                        <a href="{{ route('actas.cargar-existente.form') }}" class="btn btn-dark btn-sm">
                            <i class="fas fa-upload me-1"></i> Cargar Acta Existente
                        </a>
                        <!--
                        <a href="{{ route('plantillas.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-signature me-1"></i> Crear Plantilla
                        </a> -->
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    @if($ultimasActas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-dark">Fecha</th>
                                        <th class="text-dark">Encargado</th>
                                        <th class="text-dark">Servidor</th>
                                        <th class="text-dark">Tipo</th>
                                        <th class="text-dark">Acciones</th>
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
                                                <a href="{{ route('actas.show', $acta) }}" class="btn btn-sm btn-outline-light" style="color:#666;">
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

    <!-- Sección de servidores sin actas -->
    @if($servidoresSinActas->count() > 0 && Auth::user()->isAdmin())
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-exclamation-triangle me-2 text-warning"></i> Servidores Sin Actas Asociadas
                    </h6>
                    <a href="{{ route('servidores.index') }}" class="btn btn-sm btn-outline-dark">
                        <i class="fas fa-server me-1"></i> Ver Todos los Servidores
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-dark">Dirección IP</th>
                                    <th class="text-dark">Sistema Operativo</th>
                                    <th class="text-dark">Tipo</th>
                                    <th class="text-dark">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($servidoresSinActas as $servidor)
                                    <tr>
                                        <td>{{ $servidor->nombre }}</td>
                                        <td>{{ $servidor->sistema_operativo }}</td>
                                        <td>
                                            <span class="badge bg-{{ $servidor->tipo == 'produccion' ? 'danger' : 'warning' }}">
                                                {{ ucfirst($servidor->tipo) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('actas.create') }}?servidor_id={{ $servidor->id }}" 
                                               class="btn btn-sm btn-success me-1">
                                                <i class="fas fa-plus me-1"></i> Crear Acta
                                            </a>
                                            <a href="{{ route('actas.cargar-existente.form') }}?servidor_id={{ $servidor->id }}" 
                                               class="btn btn-sm btn-dark me-1">
                                                <i class="fas fa-upload me-1"></i> Cargar Acta
                                            </a>
                                            <a href="{{ route('servidores.show', $servidor) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($servidoresSinActas->count() >= 10)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Se muestran solo los primeros 10 servidores sin actas. 
                            Hay más servidores sin actas asociadas.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif    

    <!-- Nueva sección: Actas sin firmar -->
    @if($actasSinFirmar->count() > 0 && Auth::user()->isAdmin())
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-file-signature me-2 text-warning"></i> Actas Sin Firmar
                    </h6>
                    <a href="{{ route('actas.index') }}" class="btn btn-sm btn-outline-dark">
                        <i class="fas fa-file-contract me-1"></i> Ver Todas las Actas
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-dark">ID</th>
                                    <th class="text-dark">Fecha Entrega</th>
                                    <th class="text-dark">Programador</th>
                                    <th class="text-dark">Servidor</th>
                                    <th class="text-dark">Tipo</th>
                                    <th class="text-dark">Días Transcurridos</th>
                                    <th class="text-dark">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($actasSinFirmar as $acta)
                                    <tr>
                                        <td>{{ $acta->id }}</td>
                                        <td>{{ $acta->fecha_entrega->format('d/m/Y') }}</td>
                                        <td>{{ $acta->programador->nombre }}</td>
                                        <td>{{ $acta->servidor->nombre }} - {{ $acta->servidor->sistema_operativo }}</td>
                                        <td>
                                            <span class="badge bg-{{ $acta->servidor->tipo == 'produccion' ? 'danger' : 'warning' }}">
                                                {{ ucfirst($acta->servidor->tipo) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $diasTranscurridos = $acta->fecha_entrega->diffInDays(now());
                                            @endphp
                                            <span class="badge bg-{{ $diasTranscurridos > 7 ? 'danger' : ($diasTranscurridos > 3 ? 'warning' : 'info') }}">
                                                {{  intval($diasTranscurridos) }} días
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('actas.show', $acta) }}" class="btn btn-sm btn-info me-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('actas.pdf', $acta) }}" class="btn btn-sm btn-success me-1" target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            <a href="{{ route('actas.edit', $acta) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($actasSinFirmar->count() >= 10)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Se muestran solo las primeras 10 actas sin firmar. 
                            Hay más actas pendientes de firma.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif    

</div>
@endsection
