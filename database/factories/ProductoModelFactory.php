<?php

namespace Database\Factories;

use App\Models\ProductoModel;
use App\Models\CategoriaModel; // Importa el modelo CategoriaModel
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductoModel>
 */
class ProductoModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->sentence(2),
            'descripcion' => "test",
            'stock' => $this->faker->numberBetween(1, 30),
            'precio' => $this->faker->randomFloat(2, 10),
            'categoria_id' => CategoriaModel::factory(), // Crea una categoría relacionada
        ];
    }
}