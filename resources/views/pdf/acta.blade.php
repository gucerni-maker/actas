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
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #000;
        }
        
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        
        .section {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            border-bottom: 1px solid #666;
            padding-bottom: 5px;
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
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            width: 45%;
            text-align: center;
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
    <div class="header">
        <h1>ACTA DE ENTREGA DE SERVIDOR</h1>
        <p>Documento #{{ $acta->id }}</p>
        <p>Fecha: {{ $acta->fecha_entrega->format('d/m/Y') }}</p>
    </div>
    
    <div class="section">
        <div class="section-title">DATOS DE LA ENTREGA</div>
        <div class="data-row">
            <span class="data-label">Fecha de Entrega:</span>
            <span class="data-value">{{ $acta->fecha_entrega->format('d/m/Y') }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Creada por:</span>
            <span class="data-value">{{ $acta->usuario->name }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Fecha de Registro:</span>
            <span class="data-value">{{ $acta->created_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">DATOS DEL PROGRAMADOR</div>
        <div class="data-row">
            <span class="data-label">Nombre:</span>
            <span class="data-value">{{ $acta->programador->nombre }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Correo:</span>
            <span class="data-value">{{ $acta->programador->correo }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Cargo:</span>
            <span class="data-value">{{ $acta->programador->cargo }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Teléfono:</span>
            <span class="data-value">{{ $acta->programador->telefono ?? 'N/A' }}</span>
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">DATOS DEL SERVIDOR</div>
        <div class="data-row">
            <span class="data-label">Tipo:</span>
            <span class="data-value">{{ ucfirst($acta->servidor->tipo) }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Sistema Operativo:</span>
            <span class="data-value">{{ $acta->servidor->sistema_operativo }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">CPU:</span>
            <span class="data-value">{{ $acta->servidor->cpu }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">RAM:</span>
            <span class="data-value">{{ $acta->servidor->ram }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Disco:</span>
            <span class="data-value">{{ $acta->servidor->disco }}</span>
        </div>
        @if($acta->servidor->notas_tecnicas)
        <div class="data-row">
            <span class="data-label">Notas Técnicas:</span>
            <span class="data-value">{{ $acta->servidor->notas_tecnicas }}</span>
        </div>
        @endif
    </div>
    
    @if($acta->observaciones)
    <div class="section">
        <div class="section-title">OBSERVACIONES</div>
        <p>{{ $acta->observaciones }}</p>
    </div>
    @endif
    
    <div class="signature-section">
        <div class="signature-box">
            <p>Entregado por:</p>
            <div class="signature-line">{{ $acta->usuario->name }}</div>
        </div>
        <div class="signature-box">
            <p>Recibido por:</p>
            <div class="signature-line">{{ $acta->programador->nombre }}</div>
        </div>
    </div>
    
    <div class="footer">
        <p>Documento generado el {{ now()->format('d/m/Y H:i') }} - Sistema de Gestión de Actas</p>
    </div>
</body>
</html>
