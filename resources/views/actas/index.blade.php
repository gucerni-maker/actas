@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0 text-dark">Lista de Actas de Entrega</h5>
          <a class="btn btn-sm btn-outline-dark"><i class="fas fa-plus"></i> Nueva Acta</a>
          <a class="btn btn-sm btn-outline-dark"><i class="fas fa-upload"></i> Cargar Acta Existente</a>
        </div>
        <div class="card-body">

          <!-- Formulario de filtros -->
          <form method="GET" action="{{ route('actas.index') }}" class="mb-4">
            <div class="row">
              <div class="col-md-3">
                <label for="buscar" class="form-label">Buscar</label>
                <input type="text" class="form-control" id="buscar" name="buscar"
                  value="{{ request('buscar') }}" placeholder="Encargado o servidor">
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
                <label for="programador_id" class="form-label">Encargado</label>
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
                <button type="submit" class="btn btn-dark">
                  <i class="fas fa-search"></i> Filtrar
                </button>
                <a href="{{ route('actas.index') }}" class="btn btn-secondary">
                  <i class="fas fa-times"></i> Limpiar
                </a>
              </div>
            </div>
          </form>

          @if($actas->count() > 0)
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>
                    <a class="text-dark" href="{{ route('actas.index', array_merge(request()->except('orden', 'direccion'), ['orden' => 'fecha_entrega', 'direccion' => request('orden') == 'fecha_entrega' && request('direccion') == 'asc' ? 'desc' : 'asc'])) }}">
                      Fecha Entrega @if(request('orden') == 'fecha_entrega') <i class="fas fa-sort-{{ request('direccion') == 'asc' ? 'up' : 'down' }}"></i> @endif
                    </a>
                  </th>
                  <th class="text-dark">Encargado</th>
                  <th class="text-dark">Servidor</th>
                  <th class="text-dark">Tipo</th>
                  <th class="text-dark">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($actas as $acta)
                <tr>
                  <td>{{ $acta->fecha_entrega->format('d/m/Y') }}</td>
                  <td>{{ $acta->programador->nombre }}</td>
                  <td>{{ $acta->servidor->nombre }}</td>
                  <td>
                    <span class="badge bg-{{ $acta->servidor->tipo == 'produccion' ? 'secondary' : 'light' }}" style="color:#222">
                      {{ ucfirst($acta->servidor->tipo) }}
                    </span>
                  </td>

                  <td>
                    <div class="btn-group-horizontal btn-group-sm">
                      <a href="{{ route('actas.show', $acta) }}" class="btn btn-sm btn-outline-light" style="color:white-50;">
                        <i class="fas fa-eye"></i>Detalles
                      </a>
                      <button class="btn btn-sm btn-secondary me-1 btn-outline-light" style="color:#222">
                        <i class="fas fa-edit"></i>Editar
                      </button>
                      <button type="submit" class="btn btn-sm me-1 btn-outline-light">
                        <i class="fas fa-trash"></i>Borrar
                      </button>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="d-flex justify-content-center">
            {{ $actas->links('pagination::bootstrap-5') }}
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