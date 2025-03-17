<?php

namespace App\Http\Controllers;

use App\Models\DetalleFactura;
use App\Models\DetallePago;
use Illuminate\Http\Request;
use Exception;

class DetallePagoController extends Controller
{
    public function actualizarDetalleFactura(Request $request, $factura_id)
{
    try {
        $request->validate([
            'estado' => 'required|boolean'
        ]);

        // Actualiza el estado directamente
        $actualizados = DetallePago::where("factura_id", $factura_id)
            ->update(['estado' => $request->estado]);

        if ($actualizados > 0) {
            return response()->json([
                'message' => "Estado actualizado correctamente",
                'factura_id' => $factura_id,
                'nuevo_estado' => $request->estado
            ], 200);
        } else {
            return response()->json([
                'message' => "No se encontró la factura con ID $factura_id o ya tenía el estado indicado"
            ], 404);
        }
    } catch (Exception $e) {
        return response()->json([
            'message' => 'Error al actualizar',
            "error" => $e->getMessage()
        ], 500);
    }
}

}
