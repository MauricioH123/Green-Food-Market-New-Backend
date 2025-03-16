<?php

namespace App\Http\Controllers;

use App\Models\TipoPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoPagoController extends Controller
{
    protected function listarTipoPago(){
        $tipoPagos = DB::table('tipo_pagos')->get();
        return response()->json( $tipoPagos, 200);
    }

    
}
