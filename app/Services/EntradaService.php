<?php

namespace App\Services;

use App\Models\Entrada;
use App\Models\DetalleEntrada;
use App\Models\Inventario;
use Exception;

class EntradaService{

    public function crearEntrdada($request){
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

        try{
            $productosProcesados = [];

            foreach($request->productos as $producto){
                $productoInventario = Inventario::where('producto_id', $producto['producto_id'])->first();

                if(!$productoInventario){
                    $productoInventario = Inventario::create([
                        'producto_id' => $producto['producto_id'],
                        'cantidad' => $producto['cantidad']
                    ]);
                }else{
                    $productoInventario->cantidad += $producto['cantidad'];
                    $productoInventario->save();
                }

                $productosProcesados[] = $productoInventario;
            }
            return $productosProcesados;
        }catch(Exception $e){
            return response()->json([
                'message' => 'Error al actualizar el inventario',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}