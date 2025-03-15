<?php

namespace App\Http\Controllers;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Proveedor;

class ProveedorController extends Controller
{

    protected function validaciones($request){
        $request->validate([
            'nombre_proveedor' => 'required|string'
        ]);
    }



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

    public function crearProveedor(Request $request){

        try{

            $this->validaciones($request);

            $proveedor = Proveedor::create([
                'nombre_proveedor' => $request->nombre_proveedor
            ]);

            return response()->json([
                'message' => 'Proveedor creado exitosamente',
                $proveedor
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'message' => 'No se puedo crear el proveedor',
                'error' => $e->getMessage()
            ], 500);
        }

    }
}