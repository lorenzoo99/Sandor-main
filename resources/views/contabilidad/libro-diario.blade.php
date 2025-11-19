@extends('layouts.admin')

@section('title', 'Libro Diario')
@section('page-title', 'Libro Diario')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Libro Diario</h2>
            <p class="mt-1 text-sm text-gray-600">Registro cronológico de operaciones</p>
        </div>
    </div>

    <!-- Filtros -->
    <x-card>
        <form method="GET" action="{{ route('contabilidad.libro-diario') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Fecha Desde -->
            <div>
                <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-1">
                    Desde
                </label>
                <input
                    type="date"
                    name="fecha_desde"
                    id="fecha_desde"
                    value="{{ $fechaDesde }}"
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
                    value="{{ $fechaHasta }}"
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

    <!-- Libro Diario -->
    <x-card>
        <div class="overflow-x-auto">
            @forelse($asientos as $asiento)
                <div class="mb-6 pb-6 border-b border-gray-200 last:border-b-0">
                    <!-- Encabezado del Asiento -->
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">
                                Asiento #{{ $asiento->id_asiento }} - {{ \Carbon\Carbon::parse($asiento->fecha)->format('d/m/Y') }}
                            </h3>
                            <p class="text-xs text-gray-600 mt-1">{{ $asiento->descripcion }}</p>
                        </div>
                        <a
                            href="{{ route('contabilidad.ver-asiento', $asiento) }}"
                            class="text-xs text-blue-600 hover:text-blue-900 font-medium"
                        >
                            Ver detalle →
                        </a>
                    </div>

                    <!-- Movimientos -->
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cuenta</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Débito</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Crédito</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($asiento->detalles as $detalle)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <span class="text-xs font-mono font-bold text-gray-900">
                                            {{ $detalle->cuenta->codigo }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        <span class="text-xs text-gray-900">{{ $detalle->cuenta->nombre }}</span>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-right">
                                        @if($detalle->tipo_movimiento === 'DEBITO')
                                            <span class="text-xs font-medium text-gray-900">
                                                ${{ number_format($detalle->valor, 2) }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-right">
                                        @if($detalle->tipo_movimiento === 'CREDITO')
                                            <span class="text-xs font-medium text-gray-900">
                                                ${{ number_format($detalle->valor, 2) }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="2" class="px-4 py-2 text-right">
                                    <span class="text-xs font-semibold text-gray-900">Totales:</span>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-right">
                                    <span class="text-xs font-bold text-gray-900">
                                        ${{ number_format($asiento->total_debito, 2) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-right">
                                    <span class="text-xs font-bold text-gray-900">
                                        ${{ number_format($asiento->total_credito, 2) }}
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @empty
                <div class="py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay movimientos</h3>
                    <p class="mt-1 text-sm text-gray-500">No se encontraron asientos contables en el período seleccionado.</p>
                </div>
            @endforelse
        </div>
    </x-card>

    <!-- Ayuda -->
    <x-card>
        <h3 class="text-sm font-semibold text-gray-900 mb-2">💡 Libro Diario</h3>
        <div class="text-xs text-gray-600 space-y-1">
            <p>El Libro Diario registra todas las operaciones contables en orden cronológico.</p>
            <p>Cada asiento muestra la fecha, descripción y los movimientos de débito y crédito.</p>
        </div>
    </x-card>
</div>
@endsection
