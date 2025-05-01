<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function listarProductosInventario(){
        $datos = DB::table('inventarios as in')
        ->select([
            'pr.nombre_producto',
            'in.cantidad'
        ])
        ->join('productos as pr', 'pr.id', '=', 'in.producto_id')
        ->get();

        return response()->json($datos);
    }
}
