<?php

namespace Database\Seeders;

use App\Models\Servidor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OficinaSeeder extends Seeder
{
    public function run()
    {
        // Deshabilitar restricciones de clave foránea temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Lista de oficinas más descriptivas
        $oficinas = [
            'Departamento de Sistemas',
            'Área de Desarrollo',
            'División de Infraestructura',
            'Sección de Seguridad Informática',
            'Unidad de Soporte Técnico',
            'Dirección de Tecnología',
            'Área de Proyectos',
            'División de Redes',
            'Sección de Base de Datos',
            'Unidad de Calidad de Software',
            'Departamento de Seguridad TI',
            'Área de Cloud Computing',
            'División de DevOps',
            'Sección de Monitoreo',
            'Unidad de Backup y Recuperación',
            'Departamento de Análisis de Datos',
            'Área de Inteligencia Artificial',
            'División de Automatización',
            'Sección de Pruebas',
            'Unidad de Documentación Técnica'
        ];

        $servidores = Servidor::all();

        foreach ($servidores as $servidor) {
            $servidor->update([
                'notas_tecnicas' => $oficinas[array_rand($oficinas)]
            ]);
        }

        $this->command->info('Oficinas actualizadas correctamente.');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
