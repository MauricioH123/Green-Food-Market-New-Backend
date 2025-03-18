<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    protected $fillable = [
        'proveedor_id', // Clave foránea producto
        'fecha_entrada',
    ];

    public function proveedor(){
        return $this->belongsTo(Proveedor::class,'proveedor_id');
    }

    public function detalleEntarda(){
        return $this->hasMany(DetalleEntrada::class,'entrada_id');
    }
}
