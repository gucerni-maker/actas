<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProgramadorExterno extends Model
{
    // Usar la misma conexión que la aplicación
    protected $connection = 'mysql';
    
    // Nombre de la tabla principal
    protected $table = 'pesbasi';
    
    // Desactivar timestamps ya que las tablas externas pueden no tenerlos
    public $timestamps = false;
    
    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'PEFBNOM',
        'PEFBCOD',
        'PEFBRUT',
        'PEFBGRA',
        'PEFBESC',
        'PEFBREP',
    ];
    
    // Método para buscar programador por RUT con todos los datos relacionados
    public static function buscarPorRut($rut)
    {
        // Esta consulta replica la que me diste
        $resultado = DB::select("
            SELECT 
                r.DESCRIPCION as oficina,
                t.GRADO_DESCRIPCION as cargo_descripcion,
                p.PEFBNOM as nombre,
                p.PEFBCOD as codigo_programador,
                p.PEFBRUT as rut
            FROM pesbasi p
            JOIN tescalafongrado t ON p.PEFBGRA = t.GRADO_CODIGO AND t.ESCALAFON_CODIGO = p.PEFBESC
            JOIN REPARTICION r ON r.ID_CODIGO_VIGENTE = p.PEFBREP
            WHERE p.PEFBRUT = ?
        ", [$rut]);
        
        return !empty($resultado) ? $resultado[0] : null;
    }
}
