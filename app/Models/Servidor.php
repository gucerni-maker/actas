<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    use HasFactory;

    protected $table = 'servidores';

    protected $fillable = [
        'nombre',
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
    
    // Método para obtener una descripción completa del servidor
    public function getDescripcionCompletaAttribute()
    {
        return ($this->nombre ? $this->nombre . ' - ' : '') . 
               $this->sistema_operativo . ' - ' . 
               $this->cpu . ' - ' . 
               $this->ram . ' - ' . 
               $this->disco . 
               ($this->notas_tecnicas ? ' (' . substr($this->notas_tecnicas, 0, 50) . '...)' : '');
    }
}
