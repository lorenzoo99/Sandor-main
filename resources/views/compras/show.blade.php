@extends('layouts.admin')

@section('title', 'Detalle de Factura de Compra')
@section('page-title', 'Detalle de Factura de Compra')

@section('content')
<div class="space-y-6">
    <!-- Header con botones -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Factura {{ $factura->numero_factura }}</h2>
            <p class="mt-1 text-sm text-gray-600">
                Registrada el {{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}
            </p>
        </div>
        <div class="flex space-x-3">
            <x-button-link href="{{ route('compras.index') }}" variant="secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </x-button-link>
        </div>
    </div>

    <!-- Estado y Acciones -->
    <x-card>
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Estado de la Factura</h3>
                @if($factura->estado === 'PENDIENTE')
                    <x-badge color="yellow" size="lg">Pendiente de Pago</x-badge>
                @elseif($factura->estado === 'PAGADA')
                    <x-badge color="green" size="lg">Pagada</x-badge>
                @else
                    <x-badge color="red" size="lg">Anulada</x-badge>
                @endif
            </div>

            <div class="flex space-x-2">
                @if($factura->estado === 'PENDIENTE')
                    <form action="{{ route('compras.marcar-pagada', $factura) }}" method="POST" onsubmit="return confirm('¿Marcar esta factura como pagada?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Marcar como Pagada
                        </button>
                    </form>
                @endif

                @if($factura->estado !== 'ANULADA')
                    <form action="{{ route('compras.anular', $factura) }}" method="POST" onsubmit="return confirm('¿Está seguro de anular esta factura? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Anular Factura
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-card>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Resumen de Totales -->
            <x-card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumen de la Compra</h3>
                <dl class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <dt class="text-gray-600">Subtotal:</dt>
                        <dd class="font-medium text-gray-900">${{ number_format($factura->subtotal, 2) }}</dd>
                    </div>
                    <div class="flex justify-between text-sm">
                        <dt class="text-gray-600">IVA:</dt>
                        <dd class="font-medium text-gray-900">${{ number_format($factura->iva, 2) }}</dd>
                    </div>
                    <div class="pt-3 border-t border-gray-200">
                        <div class="flex justify-between">
                            <dt class="text-base font-semibold text-gray-900">Total:</dt>
                            <dd class="text-base font-bold text-blue-600">${{ number_format($factura->total, 2) }} COP</dd>
                        </div>
                    </div>
                </dl>
            </x-card>
        </div>

        <!-- Panel Lateral -->
        <div class="space-y-6">
            <!-- Información del Proveedor -->
            <x-card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Proveedor
                </h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Razón Social</dt>
                        <dd class="text-sm font-medium text-gray-900 mt-1">{{ $factura->proveedor->nombre }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">NIT</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $factura->proveedor->nit }}</dd>
                    </div>
                    @if($factura->proveedor->correo)
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Correo</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $factura->proveedor->correo }}</dd>
                        </div>
                    @endif
                    @if($factura->proveedor->telefono)
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Teléfono</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $factura->proveedor->telefono }}</dd>
                        </div>
                    @endif
                    @if($factura->proveedor->direccion)
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Dirección</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $factura->proveedor->direccion }}</dd>
                        </div>
                    @endif
                </dl>
            </x-card>

            <!-- Información de la Factura -->
            <x-card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Información de la Factura
                </h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Número</dt>
                        <dd class="text-sm font-medium text-gray-900 mt-1">{{ $factura->numero_factura }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Fecha de Emisión</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}</dd>
                    </div>
                </dl>
            </x-card>
        </div>
    </div>
</div>
@endsection
