<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

        // ACCESOR Y MUTATOR PARA CONVERTIR EL VALOR DE PRECIO DE COMPRA EN VALORES NORMALES
        protected function precioUnitario():Attribute{
            return Attribute::make(
                get: fn ($value) => number_format($value / 100, 2, '.', ''),
                set: fn ($value) => intval($value * 100)
            );
        }
}
