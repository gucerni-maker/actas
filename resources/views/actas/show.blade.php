@extends('layouts.app')

@section('content')

<style>
    .letra{
        font-size:12px;
    }
</style>    

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark">Detalles del Acta de Entrega #{{ $acta->id }}</h5>
                    <a href="{{ route('actas.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body letra" style="background-color: #3D3B3B;">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><strong>Datos de la Entrega</strong></h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th class="text-dark">Fecha de Entrega:</th>
                                    <td>{{ $acta->fecha_entrega->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-dark">Creada por:</th>
                                    <td>{{ $acta->usuario->name }}</td>
                                </tr>

				<tr>
				    <th class="text-dark">Tipo de Acta:</th>
				    <td>
	              			@if($acta->es_acta_existente)
                                          <span class="badge bg-secondary">Acta Existente Cargada</span>
                                       @else
                                          <span class="badge bg-secondary">Acta Generada por Sistema</span>
                                       @endif
				    </td>
				</tr>

                                <tr>
                                    <th class="text-dark">Fecha de Registro:</th>
                                    <td>{{ $acta->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h6><strong>Datos del Encargado</strong></h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th class="text-dark">Nombre:</th>
                                    <td>{{ $acta->programador->nombre }}</td>
                                </tr>
                                <tr>
                                    <th class="text-dark">Correo:</th>
                                    <td>{{ $acta->programador->correo }}</td>
                                </tr>
                                <tr>
                                    <th class="text-dark">Grado:</th>
                                    <td>{{ $acta->programador->cargo }}</td>
                                </tr>
                                <tr>
                                    <th class="text-dark">Dotación:</th>
                                <td>{{ $acta->programador->oficina }}</td>
                                </tr>                                
                            </table>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h6><strong>Datos del Servidor</strong></h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th class="text-dark">Tipo:</th>
                                    <td>
                                        <span class="badge bg-{{ $acta->servidor->tipo == 'produccion' ? 'danger' : 'dark' }}">
                                            {{ ucfirst($acta->servidor->tipo) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-dark">Sistema Operativo:</th>
                                    <td>{{ $acta->servidor->sistema_operativo }}</td>
                                </tr>
                                <tr>
                                    <th class="text-dark">CPU:</th>
                                    <td>{{ $acta->servidor->cpu }}</td>
                                </tr>
                                <tr>
                                    <th class="text-dark">RAM:</th>
                                    <td>{{ $acta->servidor->ram }}</td>
                                </tr>
                                <tr>
                                    <th class="text-dark">Disco:</th>
                                    <td>{{ $acta->servidor->disco }}</td>
                                </tr>
                                <tr>
                                    <th class="text-dark">Reparticion:</th>
                                    <td>{{ $acta->servidor->notas_tecnicas ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    

		   @if($acta->archivo_pdf)
		     <div class="row">
                       <div class="col-md-12">
                         <h6><strong>Documento PDF</strong></h6>
                         <div class="mb-2">
                           @if($acta->es_acta_existente)
                             <span class="badge bg-secondary">Acta Existente Cargada</span>
                           @else
                             <span class="badge bg-secondary">Acta Generada por Sistema</span>
                           @endif
                        </div>
           	        <a href="{{ route('actas.pdf', $acta) }}" class="btn btn-danger">
                          <i class="fas fa-file-pdf"></i> Descargar PDF
                        </a>
                      </div>
                    </div>
                  @endif

                    @if(Auth::user()->isAdmin())
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('actas.edit', $acta) }}" class="btn btn-dark">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        
                        <form action="{{ route('actas.destroy', $acta) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('¿Estás seguro de eliminar esta acta?')">
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
