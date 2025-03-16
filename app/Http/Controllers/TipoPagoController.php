<?php

namespace App\Http\Controllers;

use App\Models\TipoPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class TipoPagoController extends Controller
{
    protected function validacion($request){
        $request->validate([
            'tipo' => 'required|string'
        ]);
    }
    

    public function listarTipoPago(){
        $tipoPagos = DB::table('tipo_pagos')->get();
        return response()->json( $tipoPagos, 200);
    }

    public function crearTipoPago(Request $request){

        try{
            $this->validacion($request);

            $tipoPago = TipoPago::create([
               'tipo' => $request->tipo
            ]);

            return response()->json([
                'message'=> 'Creacion del tipo de pago exitosa',
                $tipoPago
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'message' => 'Error al crear el tipo de pago',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
