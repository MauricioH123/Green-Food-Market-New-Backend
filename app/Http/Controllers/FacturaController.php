<?php

namespace App\Http\Controllers;

use App\Models\DetallePago;
use App\Services\FacturaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Factura;
use App\Models\DetalleFactura;
use Exception;

class FacturaController extends Controller
{

    protected  $facturaService;

    public function __construct(FacturaService $facturaService)
    {
        $this->facturaService = $facturaService;
    }


    protected function validacion($request)
    {
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
            'tipo_pago_id' => 'required|integer'
        ]);
    }

    public  function listarFacturas(Request $request)
    {
        $facturas = DB::table('detalle_pagos as dp')
        ->select(
            'f.id', 
            'c.nombre', 
            DB::raw('SUM(d.cantidad * d.precio_unitario) AS total'),
            'dp.estado'
        )
        ->join('facturas as f', 'f.id', '=', 'dp.factura_id')
        ->join('detalle_facturas as d', 'f.id', '=', 'd.factura_id')
        ->join('clientes as c', 'f.cliente_id', '=', 'c.id')
        ->groupBy('dp.factura_id', 'c.nombre', 'dp.estado')
        ->paginate(10); 
        return response()->json($facturas, 200);
    }


    public function crearFactura(Request $request)
    {
        $this->validacion($request);

        $resultado = $this->facturaService->crearFactura($request);
        if ($resultado["error"]) {
            return response()->json($resultado, 400);
        }

        return response()->json($resultado, 200);
    }



    public function eliminarFactura($id)
    {
        $resultado = $this->facturaService->eliminarFactura($id);

        if ($resultado['error']) {
            return response()->json($resultado, 400);
        }

        return response()->json($resultado, 200);
    }

    public function listarDetalle($id)
    {
        $resultado = $this->facturaService->listarDetalleFactura($id);

        return response()->json(
            $resultado,
            200
        );
    }
}
