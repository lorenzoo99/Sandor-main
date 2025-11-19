@extends('layouts.admin')

@section('title', 'Asientos Contables')
@section('page-title', 'Asientos Contables')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Asientos Contables</h2>
            <p class="mt-1 text-sm text-gray-600">Registro de movimientos contables</p>
        </div>
    </div>

    <!-- Filtros -->
    <x-card>
        <form method="GET" action="{{ route('contabilidad.asientos') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Fecha Desde -->
            <div>
                <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-1">
                    Desde
                </label>
                <input
                    type="date"
                    name="fecha_desde"
                    id="fecha_desde"
                    value="{{ request('fecha_desde') }}"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                >
            </div>

            <!-- Fecha Hasta -->
            <div>
                <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 mb-1">
                    Hasta
                </label>
                <input
                    type="date"
                    name="fecha_hasta"
                    id="fecha_hasta"
                    value="{{ request('fecha_hasta') }}"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                >
            </div>

            <!-- Búsqueda -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                    Buscar
                </label>
                <input
                    type="text"
                    name="search"
                    id="search"
                    value="{{ request('search') }}"
                    placeholder="Descripción..."
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                >
            </div>

            <!-- Botón -->
            <div class="flex items-end">
                <button
                    type="submit"
                    class="w-full px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white font-medium rounded-lg transition"
                >
                    Filtrar
                </button>
            </div>
        </form>
    </x-card>

    <!-- Tabla de Asientos -->
    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Descripción
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Débito
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Crédito
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($asientos as $asiento)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $asiento->id_asiento }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($asiento->fecha)->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $asiento->descripcion }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $asiento->detalles->count() }} movimientos
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-medium text-gray-900">
                                    ${{ number_format($asiento->total_debito, 2) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-medium text-gray-900">
                                    ${{ number_format($asiento->total_credito, 2) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a
                                    href="{{ route('contabilidad.ver-asiento', $asiento) }}"
                                    class="text-blue-600 hover:text-blue-900 font-medium text-sm"
                                >
                                    Ver Detalle
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay asientos contables</h3>
                                <p class="mt-1 text-sm text-gray-500">Los asientos se generarán automáticamente al registrar facturas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($asientos->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $asientos->links() }}
            </div>
        @endif
    </x-card>
</div>
@endsection
