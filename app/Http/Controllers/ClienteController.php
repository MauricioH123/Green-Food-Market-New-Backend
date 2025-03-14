<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function listarTodosLosClientes(){
        $clientes = DB::table('clientes')->get();
        return response()->json($clientes);
    }

    public function agregarCliente(Request $request){
        $request->validate([
            'nombre' => 'required|string|max:255',
            'celular' => 'nullable|string|max:15',
            'correo' => 'required|email',
            'direccion' => 'nullable|string|max:255',
        ]);

        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'celular' => $request->celular,
            'direccion' => $request->direccion
        ]);
        return response()->json([
            'message' => 'Clente creado correctamente',
            'cliente' => $cliente
        ], 201);
    }
}
