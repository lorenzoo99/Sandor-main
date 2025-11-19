<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\FacturaCompraController;
use App\Http\Controllers\ContabilidadController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('facturas')->name('facturas.')->group(function () {
    Route::get('/', [FacturaController::class, 'index'])->name('index');
    Route::get('/crear', [FacturaController::class, 'crear'])->name('crear');
    Route::post('/guardar', [FacturaController::class, 'guardar'])->name('guardar');
    Route::get('/{factura}', [FacturaController::class, 'show'])->name('show');
    Route::patch('/{factura}/anular', [FacturaController::class, 'anular'])->name('anular');
    Route::patch('/{factura}/marcar-pagada', [FacturaController::class, 'marcarPagada'])->name('marcar-pagada');
});

// Purchase Management Routes (Compras)
Route::middleware(['auth'])->prefix('compras')->name('compras.')->group(function () {
    Route::get('/', [FacturaCompraController::class, 'index'])->name('index');
    Route::get('/crear', [FacturaCompraController::class, 'crear'])->name('crear');
    Route::post('/guardar', [FacturaCompraController::class, 'guardar'])->name('guardar');
    Route::get('/{factura}', [FacturaCompraController::class, 'show'])->name('show');
    Route::patch('/{factura}/anular', [FacturaCompraController::class, 'anular'])->name('anular');
    Route::patch('/{factura}/marcar-pagada', [FacturaCompraController::class, 'marcarPagada'])->name('marcar-pagada');
});

// Accounting Routes (Contabilidad)
Route::middleware(['auth'])->prefix('contabilidad')->name('contabilidad.')->group(function () {
    Route::get('/plan-cuentas', [ContabilidadController::class, 'planCuentas'])->name('plan-cuentas');
    Route::get('/asientos', [ContabilidadController::class, 'asientos'])->name('asientos');
    Route::get('/asientos/{asiento}', [ContabilidadController::class, 'verAsiento'])->name('ver-asiento');
    Route::get('/libro-diario', [ContabilidadController::class, 'libroDiario'])->name('libro-diario');
    Route::get('/libro-mayor', [ContabilidadController::class, 'libroMayor'])->name('libro-mayor');
    Route::get('/balance-comprobacion', [ContabilidadController::class, 'balanceComprobacion'])->name('balance-comprobacion');
});

// Payroll Routes (Nómina)
Route::middleware(['auth'])->prefix('nomina')->name('nomina.')->group(function () {
    // Empleados
    Route::get('/empleados', [NominaController::class, 'indexEmpleados'])->name('empleados.index');
    Route::get('/empleados/crear', [NominaController::class, 'crearEmpleado'])->name('empleados.crear');
    Route::post('/empleados/guardar', [NominaController::class, 'guardarEmpleado'])->name('empleados.guardar');
    Route::get('/empleados/{empleado}', [NominaController::class, 'verEmpleado'])->name('empleados.ver');
    Route::get('/empleados/{empleado}/editar', [NominaController::class, 'editarEmpleado'])->name('empleados.editar');
    Route::put('/empleados/{empleado}', [NominaController::class, 'actualizarEmpleado'])->name('empleados.actualizar');
    Route::patch('/empleados/{empleado}/toggle-estado', [NominaController::class, 'toggleEstadoEmpleado'])->name('empleados.toggle-estado');

    // Nóminas
    Route::get('/nominas', [NominaController::class, 'indexNominas'])->name('nominas.index');
    Route::get('/nominas/procesar', [NominaController::class, 'procesarNomina'])->name('nominas.procesar');
    Route::post('/nominas/guardar', [NominaController::class, 'guardarNomina'])->name('nominas.guardar');
    Route::get('/nominas/{nomina}', [NominaController::class, 'verNomina'])->name('nominas.ver');
    Route::patch('/nominas/{nomina}/marcar-pagada', [NominaController::class, 'marcarPagada'])->name('nominas.marcar-pagada');
});

// Product Routes (Productos)
Route::middleware(['auth'])->prefix('productos')->name('productos.')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('index');
    Route::get('/crear', [ProductoController::class, 'crear'])->name('crear');
    Route::post('/guardar', [ProductoController::class, 'guardar'])->name('guardar');
    Route::get('/{producto}/editar', [ProductoController::class, 'editar'])->name('editar');
    Route::put('/{producto}', [ProductoController::class, 'actualizar'])->name('actualizar');
    Route::patch('/{producto}/toggle-estado', [ProductoController::class, 'toggleEstado'])->name('toggle-estado');

    // API routes for invoicing
    Route::get('/buscar', [ProductoController::class, 'buscar'])->name('buscar');
    Route::get('/{producto}/detalle', [ProductoController::class, 'detalle'])->name('detalle');
});

// Report Routes (Reportes)
Route::middleware(['auth'])->prefix('reportes')->name('reportes.')->group(function () {
    Route::get('/ingresos-gastos', [ReporteController::class, 'ingresosGastos'])->name('ingresos-gastos');
});

// User Management Routes (Protected - requires auth and SUPERADMIN role)
Route::middleware(['auth', 'role:SUPERADMIN'])->prefix('usuarios')->name('usuarios.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/crear', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{usuario}', [UserController::class, 'show'])->name('show');
    Route::get('/{usuario}/editar', [UserController::class, 'edit'])->name('edit');
    Route::put('/{usuario}', [UserController::class, 'update'])->name('update');
    Route::delete('/{usuario}', [UserController::class, 'destroy'])->name('destroy');
    Route::patch('/{usuario}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
});

require __DIR__.'/auth.php';
