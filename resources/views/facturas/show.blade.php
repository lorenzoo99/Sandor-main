@extends('layouts.admin')

@section('title', 'Detalle de Factura')
@section('page-title', 'Detalle de Factura')

@section('content')
<div class="space-y-6">
    <!-- Header con botones -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Factura {{ $factura->numero_factura }}</h2>
            <p class="mt-1 text-sm text-gray-600">
                Emitida el {{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y H:i') }}
            </p>
        </div>
        <div class="flex space-x-3">
            <x-button-link href="{{ route('facturas.index') }}" variant="secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </x-button-link>
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Imprimir
            </button>
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
                    <form action="{{ route('facturas.marcar-pagada', $factura) }}" method="POST" onsubmit="return confirm('¿Marcar esta factura como pagada?')">
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
                    <form action="{{ route('facturas.anular', $factura) }}" method="POST" onsubmit="return confirm('¿Está seguro de anular esta factura? Esta acción no se puede deshacer.')">
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
            <!-- Detalles de Items -->
            <x-card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Productos y Servicios
                </h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Unit.</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">IVA</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($factura->detalles as $detalle)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $detalle->descripcion }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 text-right">{{ $detalle->cantidad }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 text-right">${{ number_format($detalle->valor_unitario, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 text-right">${{ number_format($detalle->subtotal, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 text-right">${{ number_format($detalle->iva, 2) }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900 text-right">${{ number_format($detalle->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>

        <!-- Panel Lateral -->
        <div class="space-y-6">
            <!-- Resumen de Totales -->
            <x-card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumen</h3>
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
                            <dd class="text-base font-bold text-blue-600">${{ number_format($factura->total, 2) }} {{ $factura->moneda }}</dd>
                        </div>
                    </div>
                </dl>
            </x-card>

            <!-- Información del Cliente -->
            <x-card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Cliente
                </h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Nombre</dt>
                        <dd class="text-sm font-medium text-gray-900 mt-1">{{ $factura->cliente->nombre }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Identificación</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $factura->cliente->tipo_identificacion }} {{ $factura->cliente->identificacion }}</dd>
                    </div>
                    @if($factura->cliente->correo)
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Correo</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $factura->cliente->correo }}</dd>
                        </div>
                    @endif
                    @if($factura->cliente->telefono)
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Teléfono</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $factura->cliente->telefono }}</dd>
                        </div>
                    @endif
                    @if($factura->cliente->direccion)
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Dirección</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $factura->cliente->direccion }}</dd>
                        </div>
                    @endif
                </dl>
            </x-card>

            <!-- Información DIAN -->
            <x-card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Información DIAN
                </h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Prefijo</dt>
                        <dd class="text-sm font-medium text-gray-900 mt-1">{{ $factura->prefijo }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Número Resolución</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $factura->numero_resolucion }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Fecha Emisión</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y H:i:s') }}</dd>
                    </div>
                </dl>
            </x-card>

            <!-- Información de Pago -->
            <x-card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Información de Pago
                </h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Medio de Pago</dt>
                        <dd class="text-sm text-gray-900 mt-1">
                            @if($factura->medio_pago === 'EFECTIVO')
                                Efectivo
                            @elseif($factura->medio_pago === 'TARJETA_CREDITO')
                                Tarjeta de Crédito
                            @elseif($factura->medio_pago === 'TARJETA_DEBITO')
                                Tarjeta de Débito
                            @elseif($factura->medio_pago === 'TRANSFERENCIA')
                                Transferencia Bancaria
                            @else
                                {{ $factura->medio_pago }}
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Forma de Pago</dt>
                        <dd class="text-sm text-gray-900 mt-1">
                            @if($factura->forma_pago === 'CONTADO')
                                Contado
                            @elseif($factura->forma_pago === 'CREDITO')
                                Crédito
                            @else
                                {{ $factura->forma_pago }}
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Moneda</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $factura->moneda }}</dd>
                    </div>
                </dl>
            </x-card>
        </div>
    </div>
</div>

<!-- Estilos para impresión -->
@push('styles')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        body {
            background: white;
        }
    }
</style>
@endpush
@endsection
