<?php

namespace App\Services;

use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\DetallePago;
use App\Models\Inventario;
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

    public function CrearDetallePago($factura, $request)
    {
        $detallePago = DetallePago::create([
            'factura_id' => $factura->id,
            'tipo_pago_id' => $request->tipo_pago_id,
            'estado' => $request->estado
        ]);

        return $detallePago;
    }

    public function actualizarInventario($request)
    {
        foreach ($request->productos as $producto) {
            $inventario = Inventario::where('producto_id', $producto['producto_id'])->first();
            $inventario->cantidad -= $producto['cantidad'];
            $inventario->save();
        }
    }

    public function eliminarFactura($id)
    {

        try {
            $factura = Factura::find($id);
            $facturaDetalle = DetalleFactura::where('factura_id', $id)->get();
            foreach ($facturaDetalle as $detalle) {
                $inventario = Inventario::where('producto_id', $detalle->producto_id)->first();
                $inventario->cantidad += $detalle->cantidad;
                $inventario->save();
            }
            $factura->delete();

            return [
                "error" => false,
                "message" => "Se elimino con exito la facutura"
            ];
        } catch (Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
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

            $this->actualizarInventario($request);

            return [
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
