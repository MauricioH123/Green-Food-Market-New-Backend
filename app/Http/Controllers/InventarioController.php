<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function listarProductosInventario(Request $request){
        $datos = DB::table('inventarios as in')
        ->select([
            'pr.id',
            'pr.nombre_producto',
            'pb.nombre_proveedor',
            'in.cantidad'

        ])
        ->join('productos as pr', 'pr.id', '=', 'in.producto_id')
        ->join('proveedors as pb', 'pb.id', '=', 'pr.proveedor_id')
        ->paginate(10);

        return response()->json($datos);
    }
}
