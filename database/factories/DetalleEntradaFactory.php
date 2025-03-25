<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetalleEntrada>
 */
class DetalleEntradaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'entrada_id'=> $this->faker->numberBetween(1, 10),
            'producto_id' => $this->faker->numberBetween(1,10),
            'precio_compra' => $this->faker->numberBetween(5000, 50000) * 100,
            'cantidad' => $this->faker-> numberBetween(1, 10),
        ];
    }
}
