<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id', // clave foranea de producto
         'cantidad',
    ];

    public function producto(){
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
