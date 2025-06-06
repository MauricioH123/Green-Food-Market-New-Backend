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
            'precio_venta' => 'numeric'
        ]);
    }

    // Metodo para extraer todos los productos
    public function listarProductos(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $productos = DB::table('productos')->paginate($perPage);
        return response()->json($productos, 200);
    }

    public function listarTodosLosProductos(){
        $productos = DB::table('productos')->get();
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
            // $producto -> precio_venta = $request->precio_venta;

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

    public function detalleProducto($id){
        $producto = DB::table('productos')
        ->select([
            'productos.nombre_producto',
            'proveedors.id',
            'proveedors.nombre_proveedor'
        ])
        ->join('proveedors', 'proveedors.id','=', 'productos.proveedor_id')
        ->where('productos.id', $id)->get();

        return response()->json($producto);
    }

    public function totalProductosVendidos(){
        $totalProductos = DB::table('detalle_facturas', 'df',)
        ->select('pd.nombre_producto', 
        DB::raw('SUM(df.cantidad) AS total_vendido')
        )
        ->join('productos as pd', 'df.producto_id', '=', 'pd.id' )
        ->groupBy('df.producto_id', 'pd.nombre_producto')->get()
        ;

        return response()->json($totalProductos, 200);
    }
}
