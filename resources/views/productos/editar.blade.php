@extends('layouts.admin')

@section('title', 'Editar Producto')
@section('page-title', 'Editar Producto')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <x-card>
        <form action="{{ route('productos.actualizar', $producto) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <h3 class="text-lg font-semibold text-gray-900">Información del Producto</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Código/Referencia</label>
                    <input
                        type="text"
                        value="{{ $producto->codigo }}"
                        disabled
                        class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600"
                    >
                    <p class="text-xs text-gray-500 mt-1">(No se puede modificar)</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock Actual *</label>
                    <input
                        type="number"
                        name="stock"
                        value="{{ old('stock', $producto->stock) }}"
                        required
                        min="0"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Producto *</label>
                    <input
                        type="text"
                        name="nombre"
                        value="{{ old('nombre', $producto->nombre) }}"
                        required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea
                        name="descripcion"
                        rows="3"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mt-6">Información de Precio</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Precio (sin IVA) *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                        <input
                            type="number"
                            name="precio"
                            value="{{ old('precio', $producto->precio) }}"
                            required
                            min="0"
                            step="0.01"
                            class="block w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Porcentaje de IVA *</label>
                    <select
                        name="porcentaje_iva"
                        required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="0" {{ old('porcentaje_iva', $producto->porcentaje_iva) == '0' ? 'selected' : '' }}>0% - Medicamentos (Exento)</option>
                        <option value="5" {{ old('porcentaje_iva', $producto->porcentaje_iva) == '5' ? 'selected' : '' }}>5% - Productos especiales</option>
                        <option value="19" {{ old('porcentaje_iva', $producto->porcentaje_iva) == '19' ? 'selected' : '' }}>19% - Productos generales</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <x-button-link href="{{ route('productos.index') }}" variant="secondary">
                    Cancelar
                </x-button-link>
                <button
                    type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition"
                >
                    Actualizar Producto
                </button>
            </div>
        </form>
    </x-card>
</div>
@endsection
