<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    use HasFactory;

    protected $fillable = [
        'factura_id', // clave foranea factura
        'producto_id', // clave foranea producto
        'cantidad',
        'cantidad_facturada',
        'precio_unitario',
    ];

    public function factura(){
        return $this->belongsTo(Factura::class,'factura_id');
    }
}
