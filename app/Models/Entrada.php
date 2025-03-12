<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id', // Clave foránea producto
        'cantidad_entrada',
        'precio_entrada',
        'fecha_entrada',
    ];
}
