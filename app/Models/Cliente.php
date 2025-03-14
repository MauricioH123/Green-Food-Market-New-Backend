<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'celular',
        'correo',
        'direccion'
    ];
    

    public function factura(){
        return $this->hasMany(Factura::class, 'cliente_id');
    }
}
