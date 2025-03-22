<?php

namespace App\Services;

use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\DetallePago;
use Exception;

class FacturaService
{

    public function crearDetalleFactura($factura, $request)
    {
        $detalleFactura = [];

        foreach ($request->productos as $producto) {
            $detalleFactura[] = DetalleFactura::create([
                'factura_id' => $factura->id,
                'producto_id' => $producto['producto_id'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario']
            ]);
        }

        return $detalleFactura;
    }

    public function CrearDetallePago($factura, $request){
        $detallePago = DetallePago::create([
            'factura_id' => $factura->id,
            'tipo_pago_id' => $request->tipo_pago_id,
            'estado' => $request->estado
        ]);

        return $detallePago;
    }

    public function crearFactura($request)
    {
        try {
            $factura = Factura::create([
                'cliente_id' => $request->cliente_id,
                'fecha' => $request->fecha,
            ]);

            $detalleFactura = $this->crearDetalleFactura($factura, $request);

            $detallePago = $this->CrearDetallePago($factura, $request);

            return[
                'error' => false,
                'message' => 'Factura creada correctamente',
                'factura' => $factura,
                'detalleFactura' => $detalleFactura,
                'tipo_pago' => $detallePago
            ];
        } catch (Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
}
