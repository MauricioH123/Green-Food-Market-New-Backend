<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    use HasFactory;

    protected $fillable = [
        'detalle_factura_id', // clave forane detalle factura 
        'factura_id', // clave forane factura
        'producto_id', // clave forane producto
        'motivo_devolucion_id', // clave forane motivo devolucion
        'cantidad',
        'precio'
    ];
}
