<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntradaController extends Controller
{
    protected  function validaciones(Request $request){
        $request->validate([
            'proveedor_id' => 'required|integer',
            'fecha_entrada' => 'required|date',
            'entrada_id' => 'required|integer',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|integer',
            'productos.*.precio_compra' => 'required|numeric|min:0',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);
    }

    public function listarEntradas(Request $request){

        $perPage = $request->query('per_page', 10);
        $entradas = DB::table('entradas')->paginate($perPage);
        
        return response()->json($entradas, 200) ;
    }
}
