<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id', // clave foranea a la tabla clientes
        'fecha'
    ];

    public function cliente(){
        return  $this->belongsTo(Cliente::class,'cliente_id');
    }

    public function detalleFactura(){
        return $this->hasMany(DetalleFactura::class,'factura_id');
    }
}
