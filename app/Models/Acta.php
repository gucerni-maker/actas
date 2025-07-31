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
        'programador_id',
        'servidor_id',
        'usuario_id',
    ];

    protected $casts = [
        'fecha_entrega' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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
