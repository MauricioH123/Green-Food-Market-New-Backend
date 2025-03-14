<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;

class ClienteController extends Controller
{
    // este metodo es para listar todos los clientes
    public function listarTodosLosClientes(){
        // obtencion de todos los clientes
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

    public function actualizarCliente(Request $request, $id){

        // Validación de datos antes de buscar el cliente
        $request->validate([ 
            'nombre' => 'required|string|max:255',
            'celular' => 'nullable|string|max:15',
            'correo' => 'required|email',
            'direccion' => 'nullable|string|max:255',
        ]);

        // Buscar el cliente por ID
        $cliente = Cliente::find($id);

        // Verificar si el cliente existe
        if(!$cliente){
            return response()->json([
                'message' => 'Cliente no encontrado'
            ], 404);
        };

        // Actualizar los datos
        $cliente -> nombre = $request->nombre;
        $cliente -> celular = $request->celular;
        $cliente -> correo = $request->correo;
        $cliente -> direccion = $request->direccion;

        // Guardar los cambios
        $cliente->save();

        // Retornar la respuesta
        return response()->json([
            'message' => 'Cliente actualizado correctamente',
            'cliente' => $cliente
        ], 200);
    }

    // este metodo es para obtener un cliente
    public function obtenerCliente(string $id){
        // obtencion de un cliente
        $cliente = Cliente::find($id);

        // retornar la respuesta de los datos en formato json del cliente
        return response()->json($cliente, 200);
    }

    // este metodo es para eliminar un cliente
    public function eliminarCliente(string $id){

        // obtener el cliente
        $cliente = Cliente::find($id);
        
        // eliminacion del cliente
        $cliente->delete();

        // retornar la respuesta de confirmacion de eliminacion
        return response()->json([
            'message' => 'Cliente eliminado correctamente'
        ], 200);
    }
}
