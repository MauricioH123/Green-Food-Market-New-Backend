<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'proveedor_id', // clave foranea de proveedor
        'nombre_producto',
        'precio_venta',
        'descripcion',
        'imagen',
    ];
}
