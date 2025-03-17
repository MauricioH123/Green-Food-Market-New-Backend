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
    

    public function listarTipoPago(Request $request){
        $perPage = $request->query('per_page', 10);
        $tipoPagos = DB::table('tipo_pagos')->paginate($perPage);
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

    public function actualizarTipoPago(Request $request, $id){
        try{
            $this->validacion($request);
            $tipoPago = TipoPago::find($id);
            $tipoPago->tipo = $request->tipo;

            $tipoPago->save();

            return response()->json([
                'message' => 'El tipo de pago se a actualizado',
                $tipoPago
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'message' => 'No se puedo actualizar el tipo de pago',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function eliminarTipoPago($id){
        try{
            $tipoPago = TipoPago::find($id);

            $tipoPago->delete();

            return response()->json([
                'message' => 'Tipo de pago eliminado exitosamente'
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'message' => 'No se puedo eliminar el tipo de pago',
                'error' => $e->getMessage()
            ],500);
        }
    }
}
