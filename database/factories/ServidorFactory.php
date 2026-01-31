<?php

namespace Database\Factories;

use App\Models\Servidor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServidorFactory extends Factory
{
    protected $model = Servidor::class;

    public function definition()
    {

        $tiposValidos = ['desarrollo', 'produccion'];

        return [
            'nombre' => $this->faker->ipv4(),
            'sistema_operativo' => $this->faker->randomElement(['Ubuntu Server 24.04', 'Ubuntu Server 20.04', 'CentOS 8', 'Red Hat Enterprise Linux']),
            'cpu' => $this->faker->randomElement(['Intel Xeon E5-2686 v4', 'Xeon E5-2699 v4', 'Xeon E5-2696 v4', 'Xeon E5-2697 v4']),
            'ram' => $this->faker->randomElement(['16GB DDR4', '32GB DDR4', '64GB DDR4', '128GB DDR4']),
            'disco' => $this->faker->randomElement(['500GB SSD', '1TB SSD', '2TB HDD', '4TB HDD']),
            'tipo' => $tiposValidos[array_rand($tiposValidos)],
            'notas_tecnicas' => $this->faker->sentence(),
        ];
    }
}
