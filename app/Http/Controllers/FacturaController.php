<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{

    function listarFacturas() {
        $facturas = DB::table('facturas')->get();
        return response()->json($facturas, 200);
    }

    
}
