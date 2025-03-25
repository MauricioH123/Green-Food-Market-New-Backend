<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class DetalleEntrada extends Model
{
    use HasFactory;

    protected $fillable = [
        'entrada_id',
        'producto_id',
        'precio_compra',
        'cantidad'
    ];

    public function entrada(){
        return $this->belongsTo(Entrada::class,'entrada_id');
    }

    public function producto(){
        return $this->belongsTo(Producto::class,"producto_id");
    }

    // ACCESOR Y MUTATOR PARA CONVERTIR EL VALOR DE PRECIO DE COMPRA EN VALORES NORMALES
    protected function precioCompra():Attribute{
        return Attribute::make(
            get: fn ($value) => number_format($value / 100, 2, '.', ''),
            set: fn ($value) => intval($value * 100)
        );
    }
}
