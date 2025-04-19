<?php

namespace App\Http\Controllers;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Proveedor;

class ProveedorController extends Controller
{

    protected function validaciones($request)
    {
        $request->validate([
            'nombre_proveedor' => 'required|string'
        ]);
    }



    public function listarProveedores(Request $request)
    {

        try {
            $perPage = $request->query('per_page', 10);
            $proveedores = DB::table('proveedors')->paginate($perPage);
            return response()->json([
                // 'message' => 'Listado de los proveedores',
                $proveedores
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al listar los proveedores'
            ], $e->getMessage());
        }
    }

    public function listarTodosLosProveedores(){
        try{
            $proveedores = DB::table('proveedors')->get();
            return response()->json($proveedores, 200);
        }catch(Exception $e){
            return response()->json(
            ['message' => 'Error al listar los proveedores'],
            $e->getMessage());
        }
    }

    public function crearProveedor(Request $request)
    {

        try {

            $this->validaciones($request);

            $proveedor = Proveedor::create([
                'nombre_proveedor' => $request->nombre_proveedor
            ]);

            return response()->json([
                'message' => 'Proveedor creado exitosamente',
                $proveedor
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se puedo crear el proveedor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function actualizarProveedor(Request $request, $id)
    {

        try {
            $this->validaciones($request);

            $proveedor = Proveedor::find($id);

            $proveedor->nombre_proveedor = $request->nombre_proveedor;

            $proveedor->save();

            return response()->json([
                'message' => 'Proveedor actulizado',
                $proveedor
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el proveedor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function eliminarProveedor($id)
    {

        try {
            $proveedor = Proveedor::find($id);

            $proveedor->delete();

            return response()->json([
                'message' => "Proveedor eliminado",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el proveedor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
