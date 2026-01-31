<?php

namespace Database\Seeders;

use App\Models\Programador;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramadorSeeder extends Seeder
{
    public function run()
    {
        // Deshabilitar restricciones de clave foránea temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        /*
        // Eliminar datos existentes
        Programador::truncate();

        // Crear programadores ficticios
        Programador::factory()->count(20)->create();
        
        // Opcional: Crear algunos programadores específicos con nombres más realistas
        $programadoresEspecificos = [
            ['nombre' => 'María González', 'correo' => 'maria.gonzalez@empresa.com', 'cargo' => 'Analista de Sistemas', 'rut' => '12345678-9', 'codigo_programador' => 'AN001'],
            ['nombre' => 'Carlos Rodríguez', 'correo' => 'carlos.rodriguez@empresa.com', 'cargo' => 'Desarrollador Senior', 'rut' => '87654321-0', 'codigo_programador' => 'DS002'],
            ['nombre' => 'Ana Martínez', 'correo' => 'ana.martinez@empresa.com', 'cargo' => 'Jefa de Proyecto', 'rut' => '11223344-5', 'codigo_programador' => 'JP003'],
            ['nombre' => 'Pedro Sánchez', 'correo' => 'pedro.sanchez@empresa.com', 'cargo' => 'Arquitecto de Software', 'rut' => '55667788-1', 'codigo_programador' => 'AS004'],
            ['nombre' => 'Laura Fernández', 'correo' => 'laura.fernandez@empresa.com', 'cargo' => 'Especialista en Seguridad', 'rut' => '99887766-2', 'codigo_programador' => 'ES005'],
        ];

        foreach ($programadoresEspecificos as $programador) {
            Programador::create($programador);
        }
        */

        $cargos = [
            'Analista de Sistemas',
            'Desarrollador Senior',
            'Jefe de Proyecto',
            'Seguridad Informática',
            'Arquitecto de Software',
            'Especialista en Seguridad',
            'Análista de Datos'
        ];

        // Obtener todos los programadores
        $programadores = Programador::all();

        foreach ($programadores as $programador) {
            // Asignar un departamento aleatorio
            $programador->update([
                'cargo' => $cargos[array_rand($cargos)]
            ]);
        }

        // Habilitar restricciones de clave foránea nuevamente
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}