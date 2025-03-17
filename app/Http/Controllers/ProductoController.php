<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
class ProductoController extends Controller
{

    protected function validacion($request){
        $request->validate([
            'proveedor_id' => 'required|integer',
            'nombre_producto' => 'required|string',
            'precio_venta' => 'required|numeric'
        ]);
    }

    // Metodo para extraer todos los productos
    public function listarPorductos(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $productos = DB::table('productos')->paginate($perPage);
        return response()->json($productos, 200);
    }

    public function crearProducto(Request $request)
    {
       
        try {

            $this->validacion($request);

            $producto = Producto::create([
                'proveedor_id' => $request->proveedor_id,
                'nombre_producto' => $request->nombre_producto,
                'precio_venta' => $request->precio_venta
            ]);
            
            return response()->json([
                'message' => 'Producto creado',
                $producto
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al crear el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function actualizarPorducto(Request $request, $id){
        try{
            
            $this->validacion($request);

            $producto = Producto::find($id);

            $producto -> proveedor_id = $request -> proveedor_id;
            $producto -> nombre_producto = $request -> nombre_producto;
            $producto -> precio_venta = $request->precio_venta;

            $producto->save();

            return response()->json([
                'message' => 'Producto actualizado',
                $producto
            ], 200);

        }catch(Exception $e){
            return response()->json('Error al actualizar el producto');
        }
    }

    public function eliminarProducto($id){
        $producto = Producto::find($id);
        $producto->delete();
        return response()->json('Producto eliminado', 200);
    }
}
