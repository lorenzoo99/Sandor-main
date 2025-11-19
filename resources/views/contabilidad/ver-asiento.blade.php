@extends('layouts.admin')

@section('title', 'Detalle de Asiento Contable')
@section('page-title', 'Detalle de Asiento Contable')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Asiento #{{ $asiento->id_asiento }}</h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ \Carbon\Carbon::parse($asiento->fecha)->format('d/m/Y') }}
            </p>
        </div>
        <div>
            <x-button-link href="{{ route('contabilidad.asientos') }}" variant="secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </x-button-link>
        </div>
    </div>

    <!-- Información del Asiento -->
    <x-card>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Descripción</h3>
                <p class="text-base text-gray-900">{{ $asiento->descripcion }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Registrado por</h3>
                <p class="text-base text-gray-900">{{ $asiento->usuario->nombre ?? 'Sistema' }}</p>
            </div>
        </div>
    </x-card>

    <!-- Detalles del Asiento -->
    <x-card>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Movimientos Contables</h3>
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
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Débito
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Crédito
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($asiento->detalles as $detalle)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-mono font-bold text-gray-900">
                                    {{ $detalle->cuenta->codigo }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $detalle->cuenta->nombre }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    <x-badge color="{{ $detalle->cuenta->tipo === 'ACTIVO' ? 'blue' : ($detalle->cuenta->tipo === 'INGRESO' ? 'green' : ($detalle->cuenta->tipo === 'PASIVO' ? 'red' : 'yellow')) }}">
                                        {{ $detalle->cuenta->tipo }}
                                    </x-badge>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                @if($detalle->tipo_movimiento === 'DEBITO')
                                    <div class="text-sm font-medium text-gray-900">
                                        ${{ number_format($detalle->valor, 2) }}
                                    </div>
                                @else
                                    <div class="text-sm text-gray-400">-</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                @if($detalle->tipo_movimiento === 'CREDITO')
                                    <div class="text-sm font-medium text-gray-900">
                                        ${{ number_format($detalle->valor, 2) }}
                                    </div>
                                @else
                                    <div class="text-sm text-gray-400">-</div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-right">
                            <span class="text-sm font-semibold text-gray-900">TOTALES:</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="text-sm font-bold text-gray-900">
                                ${{ number_format($asiento->total_debito, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="text-sm font-bold text-gray-900">
                                ${{ number_format($asiento->total_credito, 2) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="px-6 py-3 text-center">
                            @if(abs($asiento->total_debito - $asiento->total_credito) < 0.01)
                                <x-badge color="green" size="lg">✓ Asiento Balanceado</x-badge>
                            @else
                                <x-badge color="red" size="lg">⚠ Asiento Desbalanceado</x-badge>
                            @endif
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </x-card>

    <!-- Ayuda -->
    <x-card>
        <h3 class="text-sm font-semibold text-gray-900 mb-2">💡 Información</h3>
        <div class="text-xs text-gray-600 space-y-1">
            <p><strong>Partida Doble:</strong> La suma de débitos siempre debe ser igual a la suma de créditos.</p>
            <p><strong>Débito:</strong> Aumenta activos y gastos, disminuye pasivos e ingresos.</p>
            <p><strong>Crédito:</strong> Aumenta pasivos e ingresos, disminuye activos y gastos.</p>
        </div>
    </x-card>
</div>
@endsection
