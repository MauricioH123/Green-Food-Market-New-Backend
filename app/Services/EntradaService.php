<?php

namespace App\Services;

use App\Models\Entrada;
use App\Models\DetalleEntrada;
use App\Models\Inventario;
use Exception;
use GuzzleHttp\Psr7\Request;

class EntradaService
{

    public function crearEntrdada($request)
    {
        $entrada = Entrada::create([
            'proveedor_id' => $request->proveedor_id,
            'fecha_entrada' => $request->fecha_entrada
        ]);

        $detalleEntrada = array();

        foreach ($request->productos as $producto) {
            $detalleEntrada[] = DetalleEntrada::create([
                'entrada_id' => $entrada->id,
                'producto_id' => $producto['producto_id'],
                'precio_compra' => $producto['precio_compra'],
                'cantidad' => $producto['cantidad']
            ]);
        }

        try {
            $productosProcesados = [];

            foreach ($request->productos as $producto) {
                $productoInventario = Inventario::where('producto_id', $producto['producto_id'])->first();

                if (!$productoInventario) {
                    $productoInventario = Inventario::create([
                        'producto_id' => $producto['producto_id'],
                        'cantidad' => $producto['cantidad']
                    ]);
                } else {
                    $productoInventario->cantidad += $producto['cantidad'];
                    $productoInventario->save();
                }

                $productosProcesados[] = $productoInventario;
            }
            return $productosProcesados;
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el inventario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function actualizarInventario($producto, $productoA)
    {
        $productoInventario = Inventario::where('producto_id', $producto['producto_id'])->first();

        if (!$productoInventario) {
            return;
        }

        if( $producto['eliminar'] == 1){
            $productoInventario->cantidad -= $producto['cantidad'];
            $productoInventario->save();

            $this->eliminarDetalleEntrada($productoA);
            return;
        }

        $productoInventario->cantidad = ($productoInventario->cantidad - $productoA->cantidad) + $producto['cantidad'];
        $productoInventario->save();
    }

    public function actualizacionEntarda($request)
    {
        $productosM = array();

        try {
            foreach ($request->productos as $producto) {
                $productoA = DetalleEntrada::find($producto['id']);

                if (!$productoA) {
                    continue;
                }

                $this->actualizarInventario($producto, $productoA);

                if($producto['eliminar'] != 1){
                    $productoA->producto_id = $producto['producto_id'];
                    $productoA->precio_compra = $producto['precio_compra'];
                    $productoA->cantidad = $producto['cantidad'];
                    $productoA->save();
    
                    $productosM[] = $productoA;
                }
            }

            return [
                "error" => false,
                "message" => "Productos actualizados correctamente",
                "productos" => $productosM
            ];
        } catch (Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function eliminarDetalleEntrada($productoA)
    {

        try {
            $productoA->delete();

            return [
                'error' => false,
                'message' => "Producto eliminado",
                'producto' => $productoA
            ];
        } catch (Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
}
