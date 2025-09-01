<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Previa de la Plantilla</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        line-height: 1.4;
        color: #333;
        margin: 20px;
        background: #f8f9fa;
    }
    
    .preview-container {
        background: white;
        padding: 30px;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin: 20px auto;
        max-width: 800px;
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
        margin-bottom: 10px;
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
        margin-top: 30px;
        width: 100%;
        position: relative;
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
        margin-top: 5px;
        border-top: 1px solid #333;
        padding-top: 5px;
    }

    /* Estilo específico para la firma */
    .signature-box img {
        margin-top: 5px;
        max-height: 60px;
        max-width: 200px;
        margin-left: auto;
        margin-right: auto;
    }

    @media print {
        body {
            background: white;
            margin: 0;
        }
        
        .preview-container {
            box-shadow: none;
            border: none;
            padding: 20px;
        }
        
        .card-header, .btn {
            display: none !important;
        }
    }
    </style>
</head>
<body>
    <div class="preview-container">
        <!-- Encabezado -->
        <div class="header">
            <div style="text-align: left; display: inline-block; min-width: 300px;">
                <p style="text-align: center; margin: 2px 0; font-size: 10px;">DEPTO. OPERACIONES T.I.C.</p>
                <p style="text-align: center; margin: 2px 0; font-size: 10px;">SECCIÓN GESTION DE SERVICIOS T.I.C.</p>
                <p style="text-align: center; margin: 2px 0; font-size: 10px;">OFICINA DE APLIC. Y BASES DE DATOS</p>
            </div>

            <h1 style="text-align: center; margin: 0; font-size: 16px; margin-bottom: 10px;">ACTA DE ENTREGA</h1>
            
            <div class="location" style="text-align: right; margin-top: 10px; font-size: 12px;">
                SANTIAGO, 01 de ENERO del 2025
            </div>
        </div>
        
        <!-- Información de origen y destino -->
        <div class="section" style="margin-bottom: 10px;">
            <div class="data-row" style="margin-bottom: 8px;">
                <span class="data-label" style="font-weight: bold; display: inline-block; width: 150px;">DE:</span>
                <span class="data-value" style="display: inline-block;">OFICINA DE APLICACIONES Y BASES DE DATOS</span>
            </div>
            <div class="data-row" style="margin-bottom: 8px;">
                <span class="data-label" style="font-weight: bold; display: inline-block; width: 150px;">A:</span>
                <span class="data-value" style="display: inline-block;">OFICINA DATA CENTER</span>
            </div>
        </div>
        
        <!-- Texto introducción -->
        <div class="section" style="margin-bottom: 10px;">
            <p style="text-align: justify; margin-bottom: 1em; line-height: 1.4; text-indent: 300px;">
                {{ $plantilla->texto_introduccion ?? 'Texto introductorio de ejemplo...' }}
            </p>
        </div>
        
        <!-- Características del servidor -->
        <div class="section" style="margin-bottom: 10px;">
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <tr>
                    <th style="border: 1px solid #333; padding: 8px; text-align: left; background-color: #f0f0f0; font-weight: bold;">Dirección IP:</th>
                    <td style="border: 1px solid #333; padding: 8px; text-align: left;">192.168.1.100</td>
                </tr>
                <tr>
                    <th style="border: 1px solid #333; padding: 8px; text-align: left; background-color: #f0f0f0; font-weight: bold;">Sistema Operativo:</th>
                    <td style="border: 1px solid #333; padding: 8px; text-align: left;">Ubuntu Server 22.04 LTS</td>
                </tr>
                <tr>
                    <th style="border: 1px solid #333; padding: 8px; text-align: left; background-color: #f0f0f0; font-weight: bold;">Memoria Ram:</th>
                    <td style="border: 1px solid #333; padding: 8px; text-align: left;">16GB DDR4</td>
                </tr>
                <tr>
                    <th style="border: 1px solid #333; padding: 8px; text-align: left; background-color: #f0f0f0; font-weight: bold;">Disco Duro:</th>
                    <td style="border: 1px solid #333; padding: 8px; text-align: left;">500GB SSD</td>
                </tr>
                <tr>
                    <th style="border: 1px solid #333; padding: 8px; text-align: left; background-color: #f0f0f0; font-weight: bold;">CPU:</th>
                    <td style="border: 1px solid #333; padding: 8px; text-align: left;">Intel Xeon 4 cores</td>
                </tr>
            </table>
        </div>
        
        <!-- Texto confidencialidad -->
        <div class="section" style="margin-bottom: 10px;">
            @if($plantilla->texto_confidencialidad ?? false)
                @php
                    $parrafos = array_filter(array_map('trim', preg_split('/\n\s*\n/', $plantilla->texto_confidencialidad)));
                @endphp
                @foreach($parrafos as $parrafo)
                    <p style="text-align: justify; margin-bottom: 1em; line-height: 1.4; text-indent: 300px;">
                        {!! nl2br(e($parrafo)) !!}
                    </p>
                @endforeach
            @else
                <p style="text-align: justify; margin-bottom: 1em; line-height: 1.4; text-indent: 300px;">
                    Texto de confidencialidad de ejemplo...
                </p>
            @endif
        </div>
        
        <!-- Firmas -->
        <div class="signature-section" style="margin-top: 30px; width: 100%; position: relative;">
            <div class="signature-box" style="width: 45%; text-align: center; display: inline-block; vertical-align: top; margin-right: 5%;">
                <p style="margin: 0 0 5px 0; font-size: 10px;"><strong>ENTREGADO POR</strong></p>
                <div style="margin-top: 10px; padding-top: 5px; font-weight: bold;">
                    {{ auth()->user()->name }}
                </div>    
                <div>{{ auth()->user()->cargo ?? 'ADMINISTRADOR DE SISTEMAS' }}</div>            
                
                <div style="font-weight: bold; margin-top: 2px;">
                    OFICINA DE APLICACIONES Y BASES DE DATOS
                </div>
                
                @if(auth()->user()->ruta_firma)
                    @php
                        $rutaFirma = str_replace('public/', '', auth()->user()->ruta_firma);
                    @endphp
                    @if(Storage::exists($rutaFirma))
                        <div style="margin-top: 20px; text-align: center;">
                            <img src="{{ public_path('storage/' . $rutaFirma) }}" 
                                 alt="Firma" 
                                 style="max-height: 60px; max-width: 200px;">
                        </div>
                    @endif
                @endif
            </div>
            <div class="signature-box" style="width: 45%; text-align: center; display: inline-block; vertical-align: top;">
                <p style="margin: 0 0 5px 0; font-size: 10px;"><strong>RECEPCIONADO POR</strong></p>
                <div style="margin-top: 10px; padding-top: 5px; font-weight: bold;">
                    [Nombre del Programador]
                </div>    
                <div>[Cargo del Programador]</div>            
                
                <div style="font-weight: bold; margin-top: 2px;">
                    [Oficina del Programador]
                </div>
            </div>
        </div>
    </div>
</body>
</html>