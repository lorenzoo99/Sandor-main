@extends('layouts.admin')

@section('title', 'Balance de Comprobación')
@section('page-title', 'Balance de Comprobación')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Balance de Comprobación</h2>
            <p class="mt-1 text-sm text-gray-600">Resumen de saldos por cuenta</p>
        </div>
    </div>

    <!-- Filtros -->
    <x-card>
        <form method="GET" action="{{ route('contabilidad.balance-comprobacion') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                    Generar Balance
                </button>
            </div>
        </form>
    </x-card>

    <!-- Balance de Comprobación -->
    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Código
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cuenta
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
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
                    @forelse($cuentas as $cuenta)
                        @php
                            $saldo = $cuenta->total_debito - $cuenta->total_credito;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-mono font-bold text-gray-900">
                                    {{ $cuenta->codigo }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $cuenta->nombre }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($cuenta->tipo === 'ACTIVO')
                                    <x-badge color="blue">Activo</x-badge>
                                @elseif($cuenta->tipo === 'PASIVO')
                                    <x-badge color="red">Pasivo</x-badge>
                                @elseif($cuenta->tipo === 'PATRIMONIO')
                                    <x-badge color="purple">Patrimonio</x-badge>
                                @elseif($cuenta->tipo === 'INGRESO')
                                    <x-badge color="green">Ingreso</x-badge>
                                @else
                                    <x-badge color="yellow">Gasto</x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm text-gray-900">
                                    ${{ number_format($cuenta->total_debito, 2) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm text-gray-900">
                                    ${{ number_format($cuenta->total_credito, 2) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-medium {{ $saldo >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    ${{ number_format(abs($saldo), 2) }} {{ $saldo >= 0 ? 'DB' : 'CR' }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay movimientos</h3>
                                <p class="mt-1 text-sm text-gray-500">No se encontraron movimientos contables en el período seleccionado.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($cuentas) > 0)
                    <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right">
                                <span class="text-base font-bold text-gray-900">TOTALES:</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="text-base font-bold text-gray-900">
                                    ${{ number_format($totalDebito, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="text-base font-bold text-gray-900">
                                    ${{ number_format($totalCredito, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                @php
                                    $diferencia = abs($totalDebito - $totalCredito);
                                @endphp
                                @if($diferencia < 0.01)
                                    <x-badge color="green" size="lg">✓ Balanceado</x-badge>
                                @else
                                    <x-badge color="red" size="lg">⚠ Diferencia: ${{ number_format($diferencia, 2) }}</x-badge>
                                @endif
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </x-card>

    <!-- Resumen por Tipo -->
    @if(count($cuentas) > 0)
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @php
                $tiposSaldo = [
                    'ACTIVO' => ['total' => 0, 'color' => 'blue', 'nombre' => 'Activos'],
                    'PASIVO' => ['total' => 0, 'color' => 'red', 'nombre' => 'Pasivos'],
                    'PATRIMONIO' => ['total' => 0, 'color' => 'purple', 'nombre' => 'Patrimonio'],
                    'INGRESO' => ['total' => 0, 'color' => 'green', 'nombre' => 'Ingresos'],
                    'GASTO' => ['total' => 0, 'color' => 'yellow', 'nombre' => 'Gastos']
                ];

                foreach ($cuentas as $cuenta) {
                    $saldo = $cuenta->total_debito - $cuenta->total_credito;
                    if (isset($tiposSaldo[$cuenta->tipo])) {
                        $tiposSaldo[$cuenta->tipo]['total'] += $saldo;
                    }
                }
            @endphp

            @foreach($tiposSaldo as $tipo => $data)
                <x-card>
                    <div class="text-center">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ $data['nombre'] }}</p>
                        <p class="text-lg font-bold text-gray-900">
                            ${{ number_format(abs($data['total']), 2) }}
                        </p>
                        <x-badge color="{{ $data['color'] }}">{{ $tipo }}</x-badge>
                    </div>
                </x-card>
            @endforeach
        </div>
    @endif

    <!-- Ayuda -->
    <x-card>
        <h3 class="text-sm font-semibold text-gray-900 mb-2">💡 Balance de Comprobación</h3>
        <div class="text-xs text-gray-600 space-y-1">
            <p>El Balance de Comprobación muestra los saldos de todas las cuentas con movimientos.</p>
            <p><strong>Verificación:</strong> La suma de débitos debe ser igual a la suma de créditos.</p>
            <p><strong>DB:</strong> Saldo deudor | <strong>CR:</strong> Saldo acreedor</p>
        </div>
    </x-card>
</div>
@endsection
