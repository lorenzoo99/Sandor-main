<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FacturaController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/facturas/crear', [FacturaController::class, 'crear'])->name('facturas.crear');
    Route::post('/facturas/guardar', [FacturaController::class, 'guardar'])->name('facturas.guardar');
});

require __DIR__.'/auth.php';
