<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acta extends Model
{
    use HasFactory;

    protected $table = 'actas';

    protected $fillable = [
        'fecha_entrega',
        'observaciones',
        'archivo_pdf',
	    'es_acta_existente',
        'firmada',
        'programador_id',
        'servidor_id',
        'usuario_id',
        'comuna', 
        'oficina_origen', 
        'oficina_destino',
        'texto_introduccion', 
        'texto_confidencialidad',
    ];

    protected $casts = [
        'fecha_entrega' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'es_acta_existente' => 'boolean',
    ];

    // Relaciones
    public function programador()
    {
        return $this->belongsTo(Programador::class, 'programador_id');
    }

    public function servidor()
    {
        return $this->belongsTo(Servidor::class, 'servidor_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
