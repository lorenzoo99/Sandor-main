@extends('layouts.admin')

@section('title', 'Registrar Compra')
@section('page-title', 'Registrar Factura de Compra')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('compras.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    Facturas de Compra
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Registrar Compra</span>
                </div>
            </li>
        </ol>
    </nav>

    <form method="POST" action="{{ route('compras.guardar') }}" class="space-y-6">
        @csrf

        <!-- Información de la Factura -->
        <x-card title="📄 Información de la Factura">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Número de Factura -->
                <div>
                    <label for="numero_factura" class="block text-sm font-medium text-gray-700 mb-1">
                        Número de Factura <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="numero_factura"
                        id="numero_factura"
                        value="{{ old('numero_factura', $numeroFactura) }}"
                        readonly
                        class="w-full rounded-lg border-gray-300 bg-gray-50 shadow-sm"
                    >
                    <p class="mt-1 text-xs text-gray-500">Generado automáticamente</p>
                </div>

                <!-- Fecha de Emisión -->
                <div>
                    <label for="fecha_emision" class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha de Emisión <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        name="fecha_emision"
                        id="fecha_emision"
                        value="{{ old('fecha_emision', date('Y-m-d')) }}"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                    <p class="mt-1 text-xs text-gray-500">Fecha de la factura del proveedor</p>
                </div>
            </div>
        </x-card>

        <!-- Información del Proveedor -->
        <x-card title="🏢 Información del Proveedor">
            <p class="text-sm text-gray-600 mb-4">Ingresa los datos del proveedor</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nombre/Razón Social -->
                <div>
                    <label for="proveedor_nombre" class="block text-sm font-medium text-gray-700 mb-1">
                        Razón Social <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="proveedor_nombre"
                        id="proveedor_nombre"
                        value="{{ old('proveedor_nombre') }}"
                        required
                        placeholder="Ej: Empresa Proveedora S.A.S."
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('proveedor_nombre') border-red-500 @enderror"
                    >
                    @error('proveedor_nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIT -->
                <div>
                    <label for="proveedor_nit" class="block text-sm font-medium text-gray-700 mb-1">
                        NIT <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="proveedor_nit"
                        id="proveedor_nit"
                        value="{{ old('proveedor_nit') }}"
                        required
                        placeholder="Ej: 900123456-1"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('proveedor_nit') border-red-500 @enderror"
                    >
                    @error('proveedor_nit')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dirección -->
                <div>
                    <label for="proveedor_direccion" class="block text-sm font-medium text-gray-700 mb-1">
                        Dirección
                    </label>
                    <input
                        type="text"
                        name="proveedor_direccion"
                        id="proveedor_direccion"
                        value="{{ old('proveedor_direccion') }}"
                        placeholder="Ej: Calle 123 #45-67"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                    <p class="mt-1 text-xs text-gray-500">Opcional</p>
                </div>

                <!-- Teléfono -->
                <div>
                    <label for="proveedor_telefono" class="block text-sm font-medium text-gray-700 mb-1">
                        Teléfono
                    </label>
                    <input
                        type="text"
                        name="proveedor_telefono"
                        id="proveedor_telefono"
                        value="{{ old('proveedor_telefono') }}"
                        placeholder="Ej: 6012345678"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                    <p class="mt-1 text-xs text-gray-500">Opcional</p>
                </div>

                <!-- Correo Electrónico -->
                <div class="md:col-span-2">
                    <label for="proveedor_correo" class="block text-sm font-medium text-gray-700 mb-1">
                        Correo Electrónico
                    </label>
                    <input
                        type="email"
                        name="proveedor_correo"
                        id="proveedor_correo"
                        value="{{ old('proveedor_correo') }}"
                        placeholder="proveedor@ejemplo.com"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                    <p class="mt-1 text-xs text-gray-500">Opcional</p>
                </div>
            </div>
        </x-card>

        <!-- Totales -->
        <x-card title="💰 Valores de la Factura">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Subtotal -->
                <div>
                    <label for="subtotal" class="block text-sm font-medium text-gray-700 mb-1">
                        Subtotal <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="subtotal"
                        id="subtotal"
                        value="{{ old('subtotal', 0) }}"
                        min="0"
                        step="0.01"
                        required
                        onchange="calcularTotal()"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('subtotal') border-red-500 @enderror"
                    >
                    <p class="mt-1 text-xs text-gray-500">Antes de IVA</p>
                    @error('subtotal')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- IVA -->
                <div>
                    <label for="iva" class="block text-sm font-medium text-gray-700 mb-1">
                        IVA <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="iva"
                        id="iva"
                        value="{{ old('iva', 0) }}"
                        min="0"
                        step="0.01"
                        required
                        onchange="calcularTotal()"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('iva') border-red-500 @enderror"
                    >
                    <p class="mt-1 text-xs text-gray-500">Valor del IVA</p>
                    @error('iva')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Total -->
                <div>
                    <label for="total" class="block text-sm font-medium text-gray-700 mb-1">
                        Total <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="total"
                        id="total"
                        value="{{ old('total', 0) }}"
                        min="0"
                        step="0.01"
                        required
                        readonly
                        class="w-full rounded-lg border-gray-300 bg-gray-50 shadow-sm font-bold text-lg"
                    >
                    <p class="mt-1 text-xs text-gray-500">Calculado automáticamente</p>
                    @error('total')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </x-card>

        <!-- Botones de Acción -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('compras.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                Registrar Factura de Compra
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function calcularTotal() {
    const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
    const iva = parseFloat(document.getElementById('iva').value) || 0;
    const total = subtotal + iva;

    document.getElementById('total').value = total.toFixed(2);
}

// Calcular total al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    calcularTotal();
});
</script>
@endpush
@endsection
