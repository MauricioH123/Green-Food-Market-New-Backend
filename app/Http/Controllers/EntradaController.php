<?php

namespace App\Http\Controllers;

use App\Models\DetalleEntrada;
use App\Models\Entrada;
use App\Models\Producto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\EntradaService;
use Illuminate\Support\Facades\Redis;

class EntradaController extends Controller
{

    protected $entradaService;

    public function __construct(EntradaService $entradaService)
    {
        $this->entradaService = $entradaService;
    }

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
            $entradas = DB::table('detalle_entradas as da')
            ->select(
                'en.id',
                'pr.nombre_proveedor',
                'en.fecha_entrada',
                DB::raw('SUM(da.cantidad * da.precio_compra) AS total')
            )
            ->join('entradas as en', 'en.id', '=', 'da.entrada_id')
            ->join('proveedors as pr','pr.id', '=', 'en.proveedor_id')
            ->groupBy('en.id','pr.nombre_proveedor','en.fecha_entrada')
            ->paginate(10);

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

            $detalleDeFactura = DB::table('detalle_entradas as da')
            ->select(
                'da.entrada_id',
                'pr.nombre_proveedor',
                'en.fecha_entrada',
                'pd.nombre_producto',
                'da.precio_compra',
                'da.cantidad'
            )
            ->join('entradas as en', 'en.id', '=', 'da.entrada_id')
            ->join('proveedors as pr', 'pr.id', '=', 'en.proveedor_id')
            ->join('productos as pd', 'pd.id', '=', 'da.producto_id')
            ->where('da.entrada_id',$id)->get();

            $entrada = null;
            $productos = [];

            foreach($detalleDeFactura as $detalle){
                if(!$entrada){
                    $entrada = [
                        'entrada_id'=> $detalle->entrada_id,
                        'fecha_entrada' => $detalle->fecha_entrada,
                        'nombre_proveedor' => $detalle->nombre_proveedor,
                        'productos' => []
                    ];
                }

                $entrada['productos'][] = [
                    'nombre_producto'=>$detalle->nombre_producto,
                    'precio_compra' => $detalle->precio_compra,
                    'cantidad' => $detalle->cantidad
                ];
            }

            if ($detalleDeFactura->isEmpty()) {
                return response()->json(['mensaje' => 'No se encontraron detalles para esta entrada'], 404);
            }

            return response()->json($entrada, 200);
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

            $creacionFactura = $this->entradaService->crearEntrdada($request);


            return response()->json([
                'message' => 'Creacion de la entrada de forma exitosa',
                $creacionFactura
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'No se puede crear la entrada',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function actualizarEntrada(Request $request)
    {
        $request->validate([
            'productos' => 'required|array|min:1',
            'porductos.*.'
        ]);

        $resultado = $this->entradaService->actualizacionEntarda($request);

        if ($resultado['error']) {
            return response()->json($resultado, 400);
        }

        return response()->json($resultado, 200);
    }
}
