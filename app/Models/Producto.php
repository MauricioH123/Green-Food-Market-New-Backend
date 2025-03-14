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
}
