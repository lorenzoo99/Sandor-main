@extends('layouts.admin')

@section('title', 'Crear Producto')
@section('page-title', 'Crear Producto')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <x-card>
        <form action="{{ route('productos.guardar') }}" method="POST" class="space-y-6">
            @csrf

            <h3 class="text-lg font-semibold text-gray-900">Información del Producto</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Código/Referencia *</label>
                    <input
                        type="text"
                        name="codigo"
                        value="{{ old('codigo') }}"
                        required
                        placeholder="Ej: MED001"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 uppercase"
                    >
                    <p class="text-xs text-gray-500 mt-1">Código único del producto</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock Inicial *</label>
                    <input
                        type="number"
                        name="stock"
                        value="{{ old('stock', 0) }}"
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
                        value="{{ old('nombre') }}"
                        required
                        placeholder="Ej: Acetaminofén 500mg x 20 tabletas"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea
                        name="descripcion"
                        rows="3"
                        placeholder="Descripción opcional del producto"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >{{ old('descripcion') }}</textarea>
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
                            value="{{ old('precio') }}"
                            required
                            min="0"
                            step="0.01"
                            placeholder="0.00"
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
                        <option value="0" {{ old('porcentaje_iva') == '0' ? 'selected' : '' }}>0% - Medicamentos (Exento)</option>
                        <option value="5" {{ old('porcentaje_iva') == '5' ? 'selected' : '' }}>5% - Productos especiales</option>
                        <option value="19" {{ old('porcentaje_iva') == '19' ? 'selected' : '' }}>19% - Productos generales</option>
                    </select>
                </div>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>Nota:</strong> Los medicamentos generalmente están exentos de IVA (0%).
                            Los productos cosméticos e higiene personal llevan 19% de IVA.
                        </p>
                    </div>
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
                    Guardar Producto
                </button>
            </div>
        </form>
    </x-card>
</div>
@endsection
