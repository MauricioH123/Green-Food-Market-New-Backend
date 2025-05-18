<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Mail\NotificacionProducto;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class CorreoController extends Controller
{
    public function enviar(Request $request, $idFactura)
    {
        $datosFactura = $this->obterDatosFactura($idFactura);

        if($datosFactura->isEmpty()){
            return response()->json(['mensaje' => 'Factura no encontrada'], 404);
        }

        $nombreCliente = $datosFactura[0]->nombre;
        $fecha = $datosFactura[0]->fecha;
        $correo = $datosFactura[0]->correo;

        $productos = [];
        $total = 0;

        foreach($datosFactura as $item){
            $subtotal = $item->cantidad * $item->precio_unitario/100;
            $productos[] = [
                'nombre' => $item->nombre_producto,
                'cantidad' => $item -> cantidad,
                'precio' => $item -> precio_unitario/100,
                'subtotal' => $subtotal
            ];

            $total += $subtotal;
        }

        $data = (object)[
            'nombre_cliente' => $nombreCliente,
            'fecha'  => $fecha,
            'datos_productos' => $productos,
            'valor_total' => $total,
            'correo_destino' => $correo,
        ];

        Mail::to($correo)->send(new NotificacionProducto($data));

        return response()->json(['mensaje' => 'correo enviado correctamente'], 200);
    }

    public function obterDatosFactura($id){
        $datos = DB::table('detalle_facturas as df')
        ->select('cl.nombre', 'f.fecha', 'pd.nombre_producto', 'df.cantidad', 'df.precio_unitario', 'cl.correo')
        ->join('facturas as f', 'df.factura_id', '=', 'f.id')
        ->join('clientes as cl', 'f.cliente_id', '=', 'cl.id')
        ->join('productos as pd', 'df.producto_id', '=', 'pd.id')
        ->where('df.factura_id', $id)->get();

        return $datos;
    }
}
