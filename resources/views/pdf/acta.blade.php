<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acta de Entrega #{{ $acta->id }}</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        line-height: 1.4;
        color: #333;
        margin: 20px;
    }
    
    .header {
        text-align: left;
        margin-bottom: 20px;
        width: 100%;
    }
    
    .header p {
        margin: 2px 0;
        font-size: 10px;
        font-weight: bold;
    }
    
    .header h1 {
        margin: 0;
        font-size: 16px;
        text-align: center;
        margin-bottom: 10px;
    }
    
    .header .location {
        text-align: right;
        margin-top: 10px;
        font-size: 12px;
    }
    
    .section {
        margin-bottom: 20px;
    }
    
    .section-title {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .data-row {
        margin-bottom: 8px;
    }
    
    .data-label {
        font-weight: bold;
        display: inline-block;
        width: 150px;
    }
    
    .data-value {
        display: inline-block;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    
    th, td {
        border: 1px solid #333;
        padding: 8px;
        text-align: left;
    }
    
    th {
        background-color: #f0f0f0;
        font-weight: bold;
    }
    
    .signature-section {
        margin-top: 25px;
        width: 100%;
    }
    
    .signature-box {
        width: 45%;
        text-align: center;
        display: inline-block;
        vertical-align: top;
        margin-right: 5%;
    }
    
    .signature-box:last-child {
        margin-right: 0;
    }
    
    .signature-line {
        margin-top: 25px;
        border-top: 1px solid #333;
        padding-top: 5px;
    }
    
    .footer {
        position: fixed;
        bottom: 20px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 10px;
        color: #666;
    }
</style>

</head>
<body>
    <!-- Encabezado -->
    
    <div class="header">
        <div style="text-align: left; display: inline-block; min-width: 300px;">
            <p style="text-align: center; margin: 2px 0; font-size: 10px;">DEPTO. OPERACIONES T.I.C.</p>
            <p style="text-align: center; margin: 2px 0; font-size: 10px;">SECCIÓN GESTION DE SERVICIOS T.I.C.</p>
            <p style="text-align: center; margin: 2px 0; font-size: 10px;">OFICINA DE APLIC. Y BASES DE DATOS</p>
        </div>

        <h1>ACTA DE ENTREGA</h1>
        
        <div class="location">
            {{ $acta->comuna }}, {{ $acta->fecha_entrega->format('d') }} de 
            @php
                $meses = [
                    'January' => 'Enero',
                    'February' => 'Febrero',
                    'March' => 'Marzo',
                    'April' => 'Abril',
                    'May' => 'Mayo',
                    'June' => 'Junio',
                    'July' => 'Julio',
                    'August' => 'Agosto',
                    'September' => 'Septiembre',
                    'October' => 'Octubre',
                    'November' => 'Noviembre',
                    'December' => 'Diciembre'
                ];
                $mesEspanol = $meses[$acta->fecha_entrega->format('F')] ?? $acta->fecha_entrega->format('F');
            @endphp
            {{ $mesEspanol }} del {{ $acta->fecha_entrega->format('Y') }}
        </div>
    </div>
    
    <!-- Información de origen y destino -->
    
    <div class="section">
        <div class="data-row">
            <span class="data-label">DE:</span>
            <span class="data-value">{{ $acta->oficina_origen }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">A:</span>
            <span class="data-value">{{ $acta->oficina_destino }}</span>
        </div>
    </div>
    
    <!-- Texto introducción -->    
    <div class="section">
        <p style="text-indent: 300px;">{{ $acta->texto_introduccion }}</p>
    </div>
    
    <!-- Características del servidor -->    
    <div class="section">
        <table>
            <tr>
                <th>Dirección IP:</th>
                <td>{{ $acta->servidor->nombre }}</td>
            </tr>
            <tr>
                <th>Sistema Operativo:</th>
                <td>{{ $acta->servidor->sistema_operativo }}</td>
            </tr>
            <tr>
                <th>Memoria Ram:</th>
                <td>{{ $acta->servidor->ram }}</td>
            </tr>
            <tr>
                <th>Disco Duro:</th>
                <td>{{ $acta->servidor->disco }}</td>
            </tr>
        </table>
    </div>
    
    <!-- Texto confidencialidad -->    
@if($acta->texto_confidencialidad)
<div class="section">
    @php
        // Separar párrafos y limpiar espacios
        $parrafos = array_filter(array_map('trim', preg_split('/\n\s*\n/', $acta->texto_confidencialidad)));
    @endphp
    @foreach($parrafos as $parrafo)
        <p style="text-align: justify; margin-bottom: 1em; line-height: 1.4;text-indent: 300px;">
            {!! nl2br(e($parrafo)) !!}
        </p>
    @endforeach
</div>
@endif
    
    <!-- Firmas -->    
    <div class="signature-section">
        <div class="signature-box">
            <p class="signature-line">ENTREGADO POR</p>
            <div style="font-weight: bold;">{{ $acta->usuario->name }}</div>
            <div >{{ $acta->programador->cargo }}</div>
            <div style="font-weight: bold;">{{ $acta->oficina_origen }}</div>
        </div>
        <div class="signature-box">
            <p class="signature-line">RECEPCIONADO POR</p>
            <div style="font-weight: bold;">{{ $acta->programador->nombre }}</div>
            <div >{{ $acta->programador->cargo }}</div>
            <div style="font-weight: bold;">{{ $acta->oficina_destino }}</div>
        </div>
    </div>
    
</body>
</html>