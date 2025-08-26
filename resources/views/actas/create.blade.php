@extends('layouts.app')

@section('content')
<style>
    div label{
         color: #EDEDED;
         font-weight: bold;
    }
    input[type="text"], input[type="date"]{
        background-color:#333;
    }
    body{
        background-color:#333;
    }

</style>    
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 text-dark">Crear Nueva Acta de Entrega</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('actas.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="fecha_entrega" class="form-label">Fecha de Entrega *</label>
                            <input type="date" class="form-control @error('fecha_entrega') is-invalid @enderror"
                                   id="fecha_entrega" name="fecha_entrega" value="{{ old('fecha_entrega') }}" required>
                            @error('fecha_entrega')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="programador_id" class="form-label">Encargado *</label>
                            <select style="background-color:#333333;" class="form-control @error('programador_id') is-invalid @enderror"
                                    id="programador_id" name="programador_id" required>
                                <option value="">Seleccione un encargado</option>
                                @foreach($programadores as $programador)
                                    <option value="{{ $programador->id }}" {{ old('programador_id') == $programador->id ? 'selected' : '' }}>
                                        {{ $programador->nombre }} ({{ $programador->correo }})
                                    </option>
                                @endforeach
                            </select>
                            @error('programador_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- DESDE ACAAAA ---->
                        <div class="mb-3">
                            <label for="servidor_id" class="form-label">Servidor *</label>
                            <select style="background-color:#333333;" class="form-control @error('servidor_id') is-invalid @enderror"
                                    id="servidor_id" name="servidor_id" required>
                                <option value="">Seleccione un servidor</option>
                                @foreach($servidores as $servidor)
                                    <option value="{{ $servidor->id }}" {{ old('servidor_id') == $servidor->id ? 'selected' : '' }}>
                                        {{ (old('servidor_id', $servidorSeleccionado ?? '') == $servidor->id) ? 'selected' : '' }}
                                        {{ $servidor->descripcion_completa }}
                                    </option>
                                @endforeach
                            </select>
                            @error('servidor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- HASTA ACAAAA ---->

                        <!-- Campos adicionales -->

                        <div class="mb-3">
                            <label for="comuna" class="form-label">Comuna *</label>
                            <input type="text" class="form-control @error('comuna') is-invalid @enderror" 
                                   id="comuna" name="comuna" value="{{ old('comuna', 'Santiago') }}" required>
                            @error('comuna')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="oficina_origen" class="form-label">Oficina Origen *</label>
                            <input type="text" class="form-control @error('oficina_origen') is-invalid @enderror" 
                                   id="oficina_origen" name="oficina_origen" value="{{ old('oficina_origen', 'OFICINA DE APLICACIONES Y BASES DE DATOS') }}" required>
                            @error('oficina_origen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="oficina_destino" class="form-label">Oficina Destino *</label>
                            <input type="text" class="form-control @error('oficina_destino') is-invalid @enderror" 
                                   id="oficina_destino" name="oficina_destino" value="{{ old('oficina_destino') }}" required placeholder="Ej: DEPTO. PROYECTOS T.I.C.">
                            @error('oficina_destino')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="texto_introduccion" class="form-label">Texto Introducción</label>
                            <textarea style="background-color:#333333;" class="form-control @error('texto_introduccion') is-invalid @enderror" 
                                        id="texto_introduccion" name="texto_introduccion" rows="4" placeholder="Texto introductorio...">{{ old('texto_introduccion', 'La Oficina de Aplicaciones y Bases de Datos de la Sección Gestión de Servicios, hace entrega de la Administración total del Servidor Virtual, cuyas características se mencionan a continuación.') }}</textarea>
                            @error('texto_introduccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="texto_confidencialidad" class="form-label">Texto Confidencialidad</label>
                            <textarea style="background-color:#333333;" class="form-control @error('texto_confidencialidad') is-invalid @enderror" 
                                        id="texto_confidencialidad" name="texto_confidencialidad" rows="4" placeholder="Texto sobre confidencialidad...">{{ old('texto_confidencialidad','Las credenciales de acceso al servidor por SSH serán enviadas mediante correo electrónico, una vez que la presente acta sea firmada por la persona responsable de administrar dicho servidor. Una vez recibida las credenciales de acceso, éstas deben ser modificadas para que no exista conflicto de responsabilidades. Lo anterior ya que solamente una entidad puede ser administradora del servidor. Siendo responsable de su seguridad.

Los servidores virtuales son asignados a la repartición que lo solicita, no al usuario que los administra. Por lo tanto, si el usuario cambia de repartición, no puede trasladar consigo la administración del servidor virtual. Debe entregárselo a otro profesional e informar lo anterior.

Los servidores virtuales deben ser utilizados únicamente para los fines que fueron solicitados, ya sea para entornos de desarrollo o de producción. Se informa que los servidores en ambiente de desarrollo no cuentan con respaldos bajo ninguna circunstancia, mientas que los servidores en ambiente productivo se respaldan según los recursos disponibles.

Los servidores virtuales en ambiente de desarrollo que no registren actividad durante un periodo superior a 150 días serán eliminados sin consulta ni previo aviso. En el caso de servidores en ambiente productivo, se dará aviso previo al administrador por DOE. Lo anterior con el fin de priorizar el uso eficiente de los recursos de espacio en disco, memoria ram y cpu.

Se hace presente la confidencialidad que se debe tener sobre la información que se hace entrega y el resguardo de la misma. Atendido a lo dispuesto en la Ley N° 21459 relativa a delitos informáticos, Ley No 19.628 sobre protección de la vida privada o protección de datos de carácter personal, Ley 20.285 acceso a la información pública y Artículo 436 código justicia militar.') }} </textarea>
                            @error('texto_confidencialidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                                           
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('actas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-save"></i> Guardar Acta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
