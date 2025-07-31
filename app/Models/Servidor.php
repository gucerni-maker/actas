<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    use HasFactory;

    protected $table = 'servidores';

    protected $fillable = [
        'tipo',
        'sistema_operativo',
        'cpu',
        'ram',
        'disco',
        'notas_tecnicas',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación: Un servidor puede estar asociado a varias actas
    public function actas()
    {
        return $this->hasMany(Acta::class, 'servidor_id');
    }
}
