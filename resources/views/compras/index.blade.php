@extends('layouts.admin')

@section('title', 'Facturas de Compra')
@section('page-title', 'Facturas de Compra')

@section('content')
<div class="space-y-6">
    <!-- Header con botón crear -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Facturas de Compra</h2>
            <p class="mt-1 text-sm text-gray-600">Gestiona todas las facturas de compra a proveedores</p>
        </div>
        <x-button-link href="{{ route('compras.crear') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Registrar Compra
        </x-button-link>
    </div>

    <!-- Filtros y Búsqueda -->
    <x-card>
        <form method="GET" action="{{ route('compras.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Búsqueda -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                        Buscar
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="Número de factura o proveedor..."
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Estado -->
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">
                        Estado
                    </label>
                    <select
                        name="estado"
                        id="estado"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">Todos</option>
                        <option value="PENDIENTE" {{ request('estado') == 'PENDIENTE' ? 'selected' : '' }}>Pendiente</option>
                        <option value="PAGADA" {{ request('estado') == 'PAGADA' ? 'selected' : '' }}>Pagada</option>
                        <option value="ANULADA" {{ request('estado') == 'ANULADA' ? 'selected' : '' }}>Anulada</option>
                    </select>
                </div>

                <!-- Botón Buscar -->
                <div class="flex items-end">
                    <button
                        type="submit"
                        class="w-full px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white font-medium rounded-lg transition"
                    >
                        Filtrar
                    </button>
                </div>
            </div>

            <!-- Filtros de Fecha -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t">
                <div>
                    <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha Desde
                    </label>
                    <input
                        type="date"
                        name="fecha_desde"
                        id="fecha_desde"
                        value="{{ request('fecha_desde') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div>
                    <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha Hasta
                    </label>
                    <input
                        type="date"
                        name="fecha_hasta"
                        id="fecha_hasta"
                        value="{{ request('fecha_hasta') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div class="flex items-end">
                    <a
                        href="{{ route('compras.index') }}"
                        class="w-full px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition text-center"
                    >
                        Limpiar Filtros
                    </a>
                </div>
            </div>
        </form>
    </x-card>

    <!-- Tabla de Facturas -->
    <x-card>
        <div class="overflow-x-auto">
            <x-table>
                <x-slot name="header">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Número
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Fecha
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Proveedor
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Total
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Estado
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Acciones
                    </th>
                </x-slot>

                @forelse($facturas as $factura)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $factura->numero_factura }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $factura->proveedor->nombre }}</div>
                            <div class="text-xs text-gray-500">NIT: {{ $factura->proveedor->nit }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">
                                ${{ number_format($factura->total, 2) }}
                            </div>
                            <div class="text-xs text-gray-500">
                                Subtotal: ${{ number_format($factura->subtotal, 2) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($factura->estado === 'PENDIENTE')
                                <x-badge color="yellow">Pendiente</x-badge>
                            @elseif($factura->estado === 'PAGADA')
                                <x-badge color="green">Pagada</x-badge>
                            @else
                                <x-badge color="red">Anulada</x-badge>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a
                                href="{{ route('compras.show', $factura) }}"
                                class="text-blue-600 hover:text-blue-900"
                                title="Ver detalles"
                            >
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>

                            @if($factura->estado === 'PENDIENTE')
                                <form
                                    action="{{ route('compras.marcar-pagada', $factura) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('¿Marcar esta factura como pagada?')"
                                >
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        class="text-green-600 hover:text-green-900"
                                        title="Marcar como pagada"
                                    >
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endif

                            @if($factura->estado !== 'ANULADA')
                                <form
                                    action="{{ route('compras.anular', $factura) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('¿Está seguro de anular esta factura? Esta acción no se puede deshacer.')"
                                >
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        class="text-red-600 hover:text-red-900"
                                        title="Anular factura"
                                    >
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay facturas de compra</h3>
                            <p class="mt-1 text-sm text-gray-500">Comienza registrando una factura de compra.</p>
                            <div class="mt-6">
                                <a href="{{ route('compras.crear') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Registrar Compra
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </div>

        <!-- Paginación -->
        @if($facturas->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $facturas->links() }}
            </div>
        @endif
    </x-card>
</div>
@endsection
