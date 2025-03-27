<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DetallePagoController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\TipoPagoController;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // RUTAS PARA CLIENTES
Route::prefix('clientes')->controller(ClienteController::class)->group(function () {
    Route::get('/', 'listarTodosLosClientes');
    Route::post('/', 'agregarCliente');
    Route::get('/{id}', 'obtenerCliente');
    Route::put('/{id}', 'actualizarCliente');
    Route::delete('/{id}', 'eliminarCliente');
});

// RUTAS PARA FACTURAS
Route::prefix('facturas')->controller(FacturaController::class)->group(function () {
    Route::get('/', 'listarFacturas');
    Route::post('/', 'crearFactura');
    Route::delete('/{id}', 'eliminarFactura');
    Route::get('/{id}', 'listarDetalle');
});

// RUTAS PARA PRODUCTOS
Route::prefix('productos')->controller(ProductoController::class)->group(function () {
    Route::get('/', 'listarProductos');
    Route::post('/', 'crearProducto');
    Route::put('/{id}', 'actualizarProducto');
    Route::delete('/{id}', 'eliminarProducto');
});

// RUTAS PARA PROVEEDORES
Route::prefix('proveedores')->controller(ProveedorController::class)->group(function () {
    Route::get('/', 'listarProveedores');
    Route::post('/', 'crearProveedor');
    Route::put('/{id}', 'actualizarProveedor');
    Route::delete('/{id}', 'eliminarProveedor');
});

// RUTAS PARA TIPOS DE PAGO
Route::prefix('pagos')->controller(TipoPagoController::class)->group(function () {
    Route::get('/', 'listarTipoPago');
    Route::post('/', 'crearTipoPago');
    Route::put('/{id}', 'actualizarTipoPago');
    Route::delete('/{id}', 'eliminarTipoPago');
});

// RUTAS PARA DETALLE DE PAGO
Route::prefix('detalle-pago')->controller(DetallePagoController::class)->group(function () {
    Route::get('/', 'listarEstadosDeFacturas');
    Route::put('/{factura_id}', 'actualizarDetalleFactura');
});

// RUTAS PARA ENTRADAS
Route::prefix('entradas')->controller(EntradaController::class)->group(function () {
    Route::get('/', 'listarEntradas');
    Route::get('/{id}/detalle', 'listarEntradasDetalle');
    Route::post('/', 'creacionEntrada');
    Route::get("/{id}",'actualizarEntrada');
    Route::put('/', 'actualizarEntrada');
});

});

