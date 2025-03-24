<?php

namespace Database\Factories;

use App\Models\CategoriaModel; // Importa el modelo CategoriaModel
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategoriaModel>
 */
class CategoriaModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->sentence(2), // Genera un nombre aleatorio
            // Agrega otros atributos si los tienes
        ];
    }
}