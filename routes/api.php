<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// RUTAS PARA CLIENTE
Route::get('/cliente',[ClienteController::class, 'listarTodosLosClientes']);
Route::post('/clientecrear', [ClienteController::class, 'agregarCliente']);
Route::put('/clienteActualizar/{id}', [ClienteController::class, 'actualizarCliente']);
Route::get('/cliente/{id}', [ClienteController::class, 'obtenerCliente']);
Route::delete('/clienteEliminar/{id}', [ClienteController::class, 'eliminarCliente']);

// RUTAS PARA FACTURAS

Route::get('/factura', [FacturaController::class, 'listarFacturas']);
Route::post('/facturaCrear', [FacturaController::class, 'crearFactura']);
Route::delete('/facturaEliminar/{id}', [FacturaController::class, 'eliminarFactura']);

// RUTAS DE PRODUCTOS
Route::get('/productos', [ProductoController::class, 'listarPorductos']);
Route::post('/producto', [ProductoController::class, 'crearProducto']);
Route::put('/producto/{id}',[ProductoController::class, 'actualizarPorducto']);
Route::delete('/producto/{id}',[ProductoController::class, 'eliminarProducto']);