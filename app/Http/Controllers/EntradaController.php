<?php

namespace App\Http\Controllers;

use App\Models\DetalleEntrada;
use App\Models\Entrada;
use App\Models\Producto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntradaController extends Controller
{
    protected  function validaciones(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|integer',
            'fecha_entrada' => 'required|date',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|integer',
            'productos.*.precio_compra' => 'required|numeric|min:0',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);
    }

    public function listarEntradas(Request $request)
    {

        try {

            $perPage = $request->query('per_page', 10);
            $entradas = Entrada::with('proveedor:id,nombre_proveedor')
                ->select('proveedor_id', 'fecha_entrada')
                ->paginate($perPage);

            return response()->json($entradas, 200);
        } catch (Exception $e) {

            return response()->json([
                'message' => 'No se puedo mostrar el listado de las entradas',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function listarEntradasDetalle($id)
    {
        try {

            $detalleDeFactura = DetalleEntrada::with('producto:id,nombre_producto')
                ->where('entrada_id', $id)
                ->get();

            if ($detalleDeFactura->isEmpty()) {
                return response()->json(['mensaje' => 'No se encontraron detalles para esta entrada'], 404);
            }

            return response()->json($detalleDeFactura, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se puede traer la informacion',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function creacionEntrada(Request $request)
    {

        try {
            $this->validaciones($request);

            $entrada = Entrada::create([
                'proveedor_id' => $request->proveedor_id,
                'fecha_entrada' => $request->fecha_entrada
            ]);

            $detalleEntrada = array();

            foreach($request->productos as $producto){
                $detalleEntrada[] = DetalleEntrada::create([
                    'entrada_id' => $entrada->id,
                    'producto_id' => $producto['producto_id'],
                    'precio_compra' => $producto['precio_compra'],
                    'cantidad' => $producto['cantidad']
                ]);
            }

            return response()->json([
                'message' => 'Creacion de la entrada de forma exitosa',
                $detalleEntrada
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se puede crear la entrada',
                'error' => $e->getMessage()
            ]);
        }
    }
}
