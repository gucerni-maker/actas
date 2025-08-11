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
		    <a href="{{ route('actas.cargar-existente.form') }}" class="btn btn-success ms-2">
	                <i class="fas fa-upload"></i> Cargar Acta Existente
	            </a>
                    @endif
                </div>
                <div class="card-body">

                    <!-- Formulario de filtros -->
                    <form method="GET" action="{{ route('actas.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="buscar" class="form-label">Buscar</label>
                                <input type="text" class="form-control" id="buscar" name="buscar"
                                       value="{{ request('buscar') }}" placeholder="Programador o servidor">
                            </div>
                            <div class="col-md-2">
                                <label for="fecha_desde" class="form-label">Fecha desde</label>
                                <input type="date" class="form-control" id="fecha_desde" name="fecha_desde"
                                       value="{{ request('fecha_desde') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="fecha_hasta" class="form-label">Fecha hasta</label>
                                <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta"
                                       value="{{ request('fecha_hasta') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="programador_id" class="form-label">Programador</label>
                                <select class="form-control" id="programador_id" name="programador_id">
                                    <option value="">Todos</option>
                                    @foreach($programadores as $programador)
                                        <option value="{{ $programador->id }}" {{ request('programador_id') == $programador->id ? 'selected' : '' }}>
                                            {{ $programador->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="servidor_tipo" class="form-label">Tipo servidor</label>
                                <select class="form-control" id="servidor_tipo" name="servidor_tipo">
                                    <option value="">Todos</option>
                                    <option value="desarrollo" {{ request('servidor_tipo') == 'desarrollo' ? 'selected' : '' }}>Desarrollo</option>
                                    <option value="produccion" {{ request('servidor_tipo') == 'produccion' ? 'selected' : '' }}>Producción</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filtrar
                                </button>
                                <a href="{{ route('actas.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Limpiar
                                </a>
                            </div>
                        </div>
                    </form>

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
                                        <th>
					   <a href="{{ route('actas.index', array_merge(request()->except('orden', 'direccion'), ['orden' => 'id', 'direccion' => request('orden') == 'id' && request('direccion') == 'asc' ? 'desc' : 'asc'])) }}">
                                             ID @if(request('orden') == 'id') <i class="fas fa-sort-{{ request('direccion') == 'asc' ? 'up' : 'down' }}"></i> @endif
                                           </a>
					</th>
                                        <th>
					   <a href="{{ route('actas.index', array_merge(request()->except('orden', 'direccion'), ['orden' => 'fecha_entrega', 'direccion' => request('orden') == 'fecha_entrega' && request('direccion') == 'asc' ? 'desc' : 'asc'])) }}">
                                             Fecha Entrega @if(request('orden') == 'fecha_entrega') <i class="fas fa-sort-{{ request('direccion') == 'asc' ? 'up' : 'down' }}"></i> @endif
                                           </a>
					</th>
                                        <th>Programador</th>
                                        <th>Servidor</th>
                                        <th>Tipo</th>
					<th>Tipo Acta</th>
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
                                            <td>{{ $acta->servidor->nombre }} - {{ $acta->servidor->sistema_operativo }}</td>
                                            <td>
                                                <span class="badge bg-{{ $acta->servidor->tipo == 'produccion' ? 'danger' : 'warning' }}">
                                                    {{ ucfirst($acta->servidor->tipo) }}
                                                </span>
                                            </td>
                                            <td>
                                               @if($acta->es_acta_existente)
                                                   <span class="badge bg-secondary">Existente</span>
                                               @else
                                                   <span class="badge bg-primary">Generada</span>
                                               @endif
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
