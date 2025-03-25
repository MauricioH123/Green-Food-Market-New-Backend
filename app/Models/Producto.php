<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'proveedor_id', // clave foranea de proveedor
        'nombre_producto',
        'precio_venta',
    ];

    public function entrada(){
        return $this->hasMany(Entrada::class, 'producto_id');
    }

    public function inventario(){
        return $this->hasOne(Inventario::class, 'producto_id');
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function detalleEntarda(){
        return $this->hasMany(DetalleEntrada::class,'producto_id');
    }

    public function detalleFactura(){
        return $this->hasMany(DetalleFactura::class, 'producto_id');
    }

       // ACCESOR Y MUTATOR PARA CONVERTIR EL VALOR DE PRECIO DE COMPRA EN VALORES NORMALES
       protected function precioVenta():Attribute{
        return Attribute::make(
            get: fn ($value) => number_format($value / 100, 2, '.', ''),
            set: fn ($value) => intval($value * 100)
        );
    }
}
