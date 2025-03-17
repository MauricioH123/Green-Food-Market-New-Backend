<?php

namespace App\Http\Controllers;

use App\Models\DetallePago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Factura;
use App\Models\DetalleFactura;

class FacturaController extends Controller
{

    public  function listarFacturas()
    {
        $facturas = DB::table('facturas')->get();
        return response()->json($facturas, 200);
    }

    public function crearFactura(Request $request)
    {

        try {
            // Validacion de lso datos de la factura y sus detalles
            $request->validate([
                // datos de la factura
                'cliente_id' => 'required|integer',
                'fecha' => 'required|date',
                //aparatir de aqui son los datos del detalled e la factura
                'productos' => 'required|array|min:1',
                'productos.*.producto_id' => 'required|integer',
                'productos.*.cantidad' => 'required|integer|min:1',
                'productos.*.precio_unitario' => 'required|numeric|min:0',
                'tipo_pago_id' => 'required|integer',
                'estado' => 'required|boolean'
            ]);

            $factura = Factura::create([
                'cliente_id' => $request->cliente_id,
                'fecha' => $request->fecha,
            ]);

            $detalleFactura = [];

            foreach($request->productos as $producto){
                $detalleFactura[] = DetalleFactura::create([
                    'factura_id' => $factura->id,
                    'producto_id' => $producto['producto_id'],
                    'cantidad' => $producto['cantidad'],
                    'precio_unitario' => $producto['precio_unitario']
                ]);
            }

            $detallePago = DetallePago::create([
                'factura_id' => $factura->id,
                'tipo_pago_id' => $request->tipo_pago_id,
                'estado' => $request->estado
            ]);

            return response()->json([
                'message' => 'Factura creada correctamente',
                'factura' => $factura,
                'detalleFactura' => $detalleFactura,
                'tipo_pago' => $detallePago
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la factura',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function eliminarFactura($id){

        try {
            $factura = Factura::find($id);
            $factura->delete();
            return response()->json([
                'message' => 'Factura eliminada correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la factura',
                'error' => $e->getMessage()
            ], 500);
            
        }

    }
}
