<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programador extends Model
{
    use HasFactory;

    protected $table = 'programadores';

    protected $fillable = [
        'nombre',
        'correo',
        'cargo',
        'telefono',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación: Un programador puede tener múltiples actas
    public function actas()
    {
        return $this->hasMany(Acta::class, 'programador_id');
    }
}
