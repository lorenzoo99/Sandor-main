@extends('layouts.admin')

@section('title', 'Libro Mayor')
@section('page-title', 'Libro Mayor')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Libro Mayor</h2>
            <p class="mt-1 text-sm text-gray-600">Movimientos por cuenta contable</p>
        </div>
    </div>

    <!-- Filtros -->
    <x-card>
        <form method="GET" action="{{ route('contabilidad.libro-mayor') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Cuenta -->
            <div class="md:col-span-2">
                <label for="cuenta_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Cuenta Contable *
                </label>
                <select
                    name="cuenta_id"
                    id="cuenta_id"
                    required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Seleccione una cuenta...</option>
                    @foreach($cuentas as $cta)
                        <option
                            value="{{ $cta->id_cuenta }}"
                            {{ request('cuenta_id') == $cta->id_cuenta ? 'selected' : '' }}
                        >
                            {{ $cta->codigo }} - {{ $cta->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

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
            <div class="md:col-span-4 flex justify-end">
                <button
                    type="submit"
                    class="px-6 py-2 bg-gray-800 hover:bg-gray-900 text-white font-medium rounded-lg transition"
                >
                    Consultar
                </button>
            </div>
        </form>
    </x-card>

    @if($cuenta)
        <!-- Información de la Cuenta -->
        <x-card>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <h3 class="text-xs text-gray-500 uppercase tracking-wide mb-1">Código</h3>
                    <p class="text-lg font-mono font-bold text-gray-900">{{ $cuenta->codigo }}</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="text-xs text-gray-500 uppercase tracking-wide mb-1">Nombre</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ $cuenta->nombre }}</p>
                </div>
                <div>
                    <h3 class="text-xs text-gray-500 uppercase tracking-wide mb-1">Tipo</h3>
                    <div class="mt-1">
                        @if($cuenta->tipo === 'ACTIVO')
                            <x-badge color="blue" size="lg">{{ $cuenta->tipo }}</x-badge>
                        @elseif($cuenta->tipo === 'PASIVO')
                            <x-badge color="red" size="lg">{{ $cuenta->tipo }}</x-badge>
                        @elseif($cuenta->tipo === 'PATRIMONIO')
                            <x-badge color="purple" size="lg">{{ $cuenta->tipo }}</x-badge>
                        @elseif($cuenta->tipo === 'INGRESO')
                            <x-badge color="green" size="lg">{{ $cuenta->tipo }}</x-badge>
                        @else
                            <x-badge color="yellow" size="lg">{{ $cuenta->tipo }}</x-badge>
                        @endif
                    </div>
                </div>
            </div>
        </x-card>

        <!-- Movimientos -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Movimientos del Período</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
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
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Saldo
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $saldo = 0;
                        @endphp
                        @forelse($movimientos as $mov)
                            @php
                                // Calcular saldo según tipo de cuenta
                                if (in_array($cuenta->tipo, ['ACTIVO', 'GASTO'])) {
                                    $saldo += $mov['debito'] - $mov['credito'];
                                } else {
                                    $saldo += $mov['credito'] - $mov['debito'];
                                }
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($mov['fecha'])->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $mov['descripcion'] }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    @if($mov['debito'] > 0)
                                        <div class="text-sm font-medium text-gray-900">
                                            ${{ number_format($mov['debito'], 2) }}
                                        </div>
                                    @else
                                        <div class="text-sm text-gray-400">-</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    @if($mov['credito'] > 0)
                                        <div class="text-sm font-medium text-gray-900">
                                            ${{ number_format($mov['credito'], 2) }}
                                        </div>
                                    @else
                                        <div class="text-sm text-gray-400">-</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-bold {{ $saldo >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        ${{ number_format(abs($saldo), 2) }} {{ $saldo >= 0 ? 'DB' : 'CR' }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay movimientos</h3>
                                    <p class="mt-1 text-sm text-gray-500">Esta cuenta no tiene movimientos en el período seleccionado.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($movimientos->count() > 0)
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-right">
                                    <span class="text-sm font-semibold text-gray-900">Saldo Final:</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <span class="text-sm font-bold text-gray-900">
                                        ${{ number_format($movimientos->sum('debito'), 2) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <span class="text-sm font-bold text-gray-900">
                                        ${{ number_format($movimientos->sum('credito'), 2) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <span class="text-sm font-bold {{ $saldo >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        ${{ number_format(abs($saldo), 2) }} {{ $saldo >= 0 ? 'DB' : 'CR' }}
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </x-card>
    @else
        <x-card>
            <div class="py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Seleccione una cuenta</h3>
                <p class="mt-1 text-sm text-gray-500">Elija una cuenta contable para ver sus movimientos.</p>
            </div>
        </x-card>
    @endif

    <!-- Ayuda -->
    <x-card>
        <h3 class="text-sm font-semibold text-gray-900 mb-2">💡 Libro Mayor</h3>
        <div class="text-xs text-gray-600 space-y-1">
            <p>El Libro Mayor muestra todos los movimientos de una cuenta específica y su saldo acumulado.</p>
            <p><strong>DB (Débito):</strong> Saldo deudor | <strong>CR (Crédito):</strong> Saldo acreedor</p>
        </div>
    </x-card>
</div>
@endsection
