<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FacturaController;
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
