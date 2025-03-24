<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function getPrecioCompraAttribute($value)
    {
        return number_format($value / 100, 2, '.', '');
    }
}
