<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
	    ServidorSeeder::class,
            ProgramadorSeeder::class,
            OficinaSeeder::class,
            DepartamentoSeeder::class,
            ActaSeeder::class,
        ]);
    }
}
