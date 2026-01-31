<?php

namespace Database\Seeders;

use App\Models\Programador;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    public function run()
    {
        // Deshabilitar restricciones de clave foránea temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Lista de departamentos más descriptivos
        $departamentos = [
            'Tecnología de la Información',
            'Desarrollo de Software',
            'Infraestructura TI',
            'Seguridad Informática',
            'Soporte Técnico',
            'Proyectos de Sistemas',
            'Redes y Comunicaciones',
            'Análisis de Datos',
            'Calidad de Software',
            'Operaciones TI',
            'Inteligencia Artificial',
            'Cloud Services',
            'Automatización',
            'Monitoreo y Control',
            'Documentación Técnica'
        ];

        // Obtener todos los programadores
        $programadores = Programador::all();

        foreach ($programadores as $programador) {
            // Asignar un departamento aleatorio
            $programador->update([
                'departamento' => $departamentos[array_rand($departamentos)]
            ]);
        }

        $this->command->info('Departamentos actualizados correctamente.');
        
        // Habilitar restricciones de clave foránea nuevamente
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
