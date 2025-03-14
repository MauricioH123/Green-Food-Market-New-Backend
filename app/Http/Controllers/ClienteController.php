<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function listarTodosLosClientes(){
        $clientes = DB::table('clientes')->get();
        return response()->json($clientes);
    }
}
