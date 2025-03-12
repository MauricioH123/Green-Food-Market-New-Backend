<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePago extends Model
{
    use HasFactory;

    protected $fillable = [
        'factura_id', // clave foranea factura
        'tipo_pago_id', // clave foranea tipo de pago 
        'estado',
    ];
}
