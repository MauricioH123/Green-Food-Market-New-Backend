<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'proveedor_id'=> $this->faker->numberBetween(1, 10),
            'nombre_producto' => $this->faker->name(),
            'precio_venta' => $this->faker->numberBetween(5000, 50000) * 100,
        ];
    }
}
