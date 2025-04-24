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
        $perPage = $request->query('per_page', 10);
        $facturas = DetallePago::with('factura:id,cliente_id', 'factura.cliente:id,nombre')
        ->select('id', 'factura_id', 'estado')
        ->orderBy(
            Factura::select('id')
            ->whereColumn('facturas.id', 'detalle_pagos.factura_id')
            ->limit(1)
        )
        ->paginate($perPage);
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

        if($resultado['error']){
            return response()->json($resultado,400);
        }

        return response()->json($resultado, 200) ;
        
    }

    public function listarDetalle($id){
        $resultado = $this->facturaService->listarDetalleFactura($id);

        return response()->json(
            $resultado,
            200
        );
    }
}
