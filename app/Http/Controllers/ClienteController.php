<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;

class ClienteController extends Controller
{
    // este metodo es para listar todos los clientes
    public function listarTodosLosClientes(){
        $clientes = DB::table('clientes')->get();
        return response()->json($clientes);
    }

    
    // este metodo es para crear un cliente
    public function agregarCliente(Request $request){

        // validacion de los datos enviados por el cliente para la creacion del cliente
        $request->validate([ 
            'nombre' => 'required|string|max:255',
            'celular' => 'nullable|string|max:15',
            'correo' => 'required|email',
            'direccion' => 'nullable|string|max:255',
        ]);

        // creacion del cliente

        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'celular' => $request->celular,
            'direccion' => $request->direccion
        ]);

        // retirno de una respuesta json al cliente 
        return response()->json([
            'message' => 'Clente creado correctamente',
            'cliente' => $cliente
        ], 201);
    }
}
