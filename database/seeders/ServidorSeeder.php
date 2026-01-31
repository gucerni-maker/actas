<?php

namespace Database\Seeders;

use App\Models\Servidor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServidorSeeder extends Seeder
{
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Eliminar datos existentes
        Servidor::truncate();

        // Crear servidores ficticios
        Servidor::factory()->count(15)->create();
        
        // Opcional: Crear algunos servidores específicos
        $servidoresEspecificos = [
            ['nombre' => '192.168.1.2', 'sistema_operativo' => 'Ubuntu Server 20.04', 'cpu' => 'Intel Xeon E5-2686 v4', 'ram' => '64GB DDR4', 'disco' => '1TB SSD', 'tipo' => 'produccion', 'notas_tecnicas' => 'Servidor principal de la aplicación'],
            ['nombre' => '192.168.1.3', 'sistema_operativo' => 'Windows Server 2019', 'cpu' => 'Xeon E5-2699 v4', 'ram' => '32GB DDR4', 'disco' => '500GB SSD', 'tipo' => 'desarrollo', 'notas_tecnicas' => 'Servidor de desarrollo'],
            ['nombre' => '192.168.1.4', 'sistema_operativo' => 'CentOS 8', 'cpu' => 'Xeon E5-2696 v4', 'ram' => '16GB DDR4', 'disco' => '2TB HDD', 'tipo' => 'desarrollo', 'notas_tecnicas' => 'Servidor de pruebas'],
            ['nombre' => '192.168.1.5', 'sistema_operativo' => 'Ubuntu Server 20.04', 'cpu' => 'Intel Xeon E5-2686 v4', 'ram' => '64GB DDR4', 'disco' => '1TB SSD', 'tipo' => 'produccion', 'notas_tecnicas' => 'Servidor principal de la aplicación'],
            ['nombre' => '192.168.1.6', 'sistema_operativo' => 'Windows Server 2019', 'cpu' => 'Xeon E5-2699 v4', 'ram' => '32GB DDR4', 'disco' => '500GB SSD', 'tipo' => 'desarrollo', 'notas_tecnicas' => 'Servidor de desarrollo'],
            ['nombre' => '192.168.1.7', 'sistema_operativo' => 'CentOS 8', 'cpu' => 'Xeon E5-2696 v4', 'ram' => '16GB DDR4', 'disco' => '2TB HDD', 'tipo' => 'desarrollo', 'notas_tecnicas' => 'Servidor de pruebas'],
            ['nombre' => '192.168.1.8', 'sistema_operativo' => 'Ubuntu Server 20.04', 'cpu' => 'Intel Xeon E5-2686 v4', 'ram' => '64GB DDR4', 'disco' => '1TB SSD', 'tipo' => 'produccion', 'notas_tecnicas' => 'Servidor principal de la aplicación'],
            ['nombre' => '192.168.1.9', 'sistema_operativo' => 'Windows Server 2019', 'cpu' => 'Xeon E5-2699 v4', 'ram' => '32GB DDR4', 'disco' => '500GB SSD', 'tipo' => 'desarrollo', 'notas_tecnicas' => 'Servidor de desarrollo'],
            ['nombre' => '192.168.1.10', 'sistema_operativo' => 'CentOS 8', 'cpu' => 'Xeon E5-2696 v4', 'ram' => '16GB DDR4', 'disco' => '2TB HDD', 'tipo' => 'desarrollo', 'notas_tecnicas' => 'Servidor de pruebas'],
            ['nombre' => '192.168.1.11', 'sistema_operativo' => 'Ubuntu Server 20.04', 'cpu' => 'Intel Xeon E5-2686 v4', 'ram' => '64GB DDR4', 'disco' => '1TB SSD', 'tipo' => 'produccion', 'notas_tecnicas' => 'Servidor principal de la aplicación'],
            ['nombre' => '192.168.1.12', 'sistema_operativo' => 'Windows Server 2019', 'cpu' => 'Xeon E5-2699 v4', 'ram' => '32GB DDR4', 'disco' => '500GB SSD', 'tipo' => 'desarrollo', 'notas_tecnicas' => 'Servidor de desarrollo'],
            ['nombre' => '192.168.1.13', 'sistema_operativo' => 'CentOS 8', 'cpu' => 'Xeon E5-2696 v4', 'ram' => '16GB DDR4', 'disco' => '2TB HDD', 'tipo' => 'desarrollo', 'notas_tecnicas' => 'Servidor de pruebas'],
            ['nombre' => '192.168.1.14', 'sistema_operativo' => 'Ubuntu Server 20.04', 'cpu' => 'Intel Xeon E5-2686 v4', 'ram' => '64GB DDR4', 'disco' => '1TB SSD', 'tipo' => 'produccion', 'notas_tecnicas' => 'Servidor principal de la aplicación'],
            ['nombre' => '192.168.1.15', 'sistema_operativo' => 'Windows Server 2019', 'cpu' => 'Xeon E5-2699 v4', 'ram' => '32GB DDR4', 'disco' => '500GB SSD', 'tipo' => 'desarrollo', 'notas_tecnicas' => 'Servidor de desarrollo'],
            ['nombre' => '192.168.1.16', 'sistema_operativo' => 'CentOS 8', 'cpu' => 'Xeon E5-2696 v4', 'ram' => '16GB DDR4', 'disco' => '2TB HDD', 'tipo' => 'desarrollo', 'notas_tecnicas' => 'Servidor de pruebas'],
            ['nombre' => '192.168.1.17', 'sistema_operativo' => 'Ubuntu Server 20.04', 'cpu' => 'Intel Xeon E5-2686 v4', 'ram' => '64GB DDR4', 'disco' => '1TB SSD', 'tipo' => 'produccion', 'notas_tecnicas' => 'Servidor principal de la aplicación'],
            ['nombre' => '192.168.1.18', 'sistema_operativo' => 'Windows Server 2019', 'cpu' => 'Xeon E5-2699 v4', 'ram' => '32GB DDR4', 'disco' => '500GB SSD', 'tipo' => 'desarrollo', 'notas_tecnicas' => 'Servidor de desarrollo'],
            ['nombre' => '192.168.1.19', 'sistema_operativo' => 'CentOS 8', 'cpu' => 'Xeon E5-2696 v4', 'ram' => '16GB DDR4', 'disco' => '2TB HDD', 'tipo' => 'desarrollo', 'notas_tecnicas' => 'Servidor de pruebas'],
        ];

        foreach ($servidoresEspecificos as $servidor) {
            Servidor::create($servidor);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
