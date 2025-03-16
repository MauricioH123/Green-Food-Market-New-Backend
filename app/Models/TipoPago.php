<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo'
    ];

    public function detallePago(){
        return $this->hasOne(DetallePago::class, 'tipo_pago_id');
    }
}
