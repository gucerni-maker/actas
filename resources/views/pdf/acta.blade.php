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
        margin-top: 40px;
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
        margin-top: 40px;
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
        <p>DEPTO. OPERACIONES T.I.C.</p>
        <p>SECCIÓN GESTION DE SERVICIOS T.I.C.</p>
        <p>OFICINA DE APLIC. Y BASES DE DATOS</p>
        
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
        <p>{{ $acta->texto_introduccion }}</p>
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
            <tr>
                <th>CPU:</th>
                <td>{{ $acta->servidor->cpu }}</td>
            </tr>
        </table>
    </div>
    
    <!-- Texto confidencialidad -->    
    <div class="section">
        <p>{{ $acta->texto_confidencialidad }}</p>
    </div>
    
    <!-- Firmas -->    
    <div class="signature-section">
        <div class="signature-box">
            <p>ENTREGADO POR</p>
            <div class="signature-line">{{ $acta->usuario->name }}</div>
            <div>{{ $acta->oficina_origen }}</div>
        </div>
        <div class="signature-box">
            <p>RECEPCIONADO POR</p>
            <div class="signature-line">{{ $acta->programador->nombre }}</div>
            <div>{{ $acta->oficina_destino }}</div>
        </div>
    </div>
    
    <div class="footer">
        <p>Documento generado el {{ now()->format('d/m/Y H:i') }} - Sistema de Gestión de Actas</p>
    </div>
</body>
</html>