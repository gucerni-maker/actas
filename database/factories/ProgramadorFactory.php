<?php

namespace Database\Factories;

use App\Models\Programador;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramadorFactory extends Factory
{
    protected $model = Programador::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'correo' => $this->faker->unique()->safeEmail(),
            'cargo' => $this->faker->jobTitle(),
            'oficina' => $this->faker->word(),
            'departamento' => $this->faker->word(),
            'rut' => $this->faker->numerify('########-#'),
            'codigo_programador' => $this->faker->bothify('???#####'),
            'telefono' => $this->faker->phoneNumber(),
        ];
    }
}
