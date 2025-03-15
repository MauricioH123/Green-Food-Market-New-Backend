<?php

namespace App\Http\Controllers;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    public function listarProveedores(){

        try{
            $proveedores = DB::table('proveedors')->get();
            return response()->json([
                // 'message' => 'Listado de los proveedores',
                $proveedores
            ]);
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error al listar los proveedores'
            ], $e->getMessage());
        }
    }
}