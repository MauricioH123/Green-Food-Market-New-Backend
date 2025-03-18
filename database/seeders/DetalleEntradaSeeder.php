<?php

namespace Database\Seeders;

use App\Models\DetalleEntrada;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetalleEntradaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DetalleEntrada::factory(10)->create();
    }
}
