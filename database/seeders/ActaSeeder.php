<?php

namespace Database\Seeders;

use App\Models\Acta;
use App\Models\Programador;
use App\Models\Servidor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ActaSeeder extends Seeder
{

    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Eliminar datos existentes
        Acta::truncate();

        // Obtener IDs existentes
        $programadorIds = Programador::pluck('id')->toArray();
        $servidorIds = Servidor::pluck('id')->toArray();

        if (empty($programadorIds) || empty($servidorIds)) {
            $this->command->info('No hay programadores o servidores para crear actas. Ejecute primero los seeders de Programador y Servidor.');
            return;
        }

        // Crear actas ficticias
        for ($i = 0; $i < 25; $i++) {
            Acta::create([
                'fecha_entrega' => now()->subDays(rand(1, 365)),
                'observaciones' => $this->faker->paragraph(),
                'programador_id' => $this->faker->randomElement($programadorIds),
                'servidor_id' => $this->faker->randomElement($servidorIds),
                'es_acta_existente' => rand(0, 1),
                'firmada' => rand(0, 1),
                'usuario_id' => 1, // Suponiendo que hay un usuario admin
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
