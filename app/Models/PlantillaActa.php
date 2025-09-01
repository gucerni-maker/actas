<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantillaActa extends Model
{
    use HasFactory;

    protected $table = 'plantillas_actas';

    protected $fillable = [
        'nombre',        
        'texto_introduccion',
        'texto_confidencialidad',
        'encabezado_personalizado',
        'pie_personalizado',
        'campos_requeridos',
        'activa',
    ];

    protected $casts = [
        'campos_requeridos' => 'array',
        'activa' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scope para obtener solo plantillas activas
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    // Scope para filtrar por tipo
    /*public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }*/
}
