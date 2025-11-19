@extends('layouts.admin')

@section('title', 'Reporte de Ingresos y Gastos')
@section('page-title', 'Reporte de Ingresos y Gastos')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Reporte de Ingresos y Gastos</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Filtros -->
    <x-card title="📅 Filtros de Periodo">
        <form method="GET" action="{{ route('reportes.ingresos-gastos') }}" class="flex items-end gap-4">
            <div>
                <label for="mes" class="block text-sm font-medium text-gray-700 mb-1">Mes</label>
                <select name="mes" id="mes" class="rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $mes == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->locale('es')->monthName }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="anio" class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                <select name="anio" id="anio" class="rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach(range(date('Y') - 3, date('Y')) as $y)
                        <option value="{{ $y }}" {{ $anio == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Generar Reporte
            </button>
        </form>
    </x-card>

    <!-- Resumen del Periodo -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-6 text-white">
        <h2 class="text-xl font-bold mb-2">
            Periodo: {{ $fechaInicio->locale('es')->isoFormat('MMMM YYYY') }}
        </h2>
        <p class="text-blue-100">
            {{ $fechaInicio->locale('es')->isoFormat('D [de] MMMM') }} al {{ $fechaFin->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
        </p>
    </div>

    <!-- KPIs Principales -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Ingresos -->
        <x-card>
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Total Ingresos</h3>
                <p class="text-3xl font-bold text-green-600">${{ number_format($totalIngresos, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ $ingresos->total_facturas ?? 0 }} facturas emitidas</p>
            </div>
        </x-card>

        <!-- Gastos -->
        <x-card>
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Total Gastos</h3>
                <p class="text-3xl font-bold text-red-600">${{ number_format($totalGastos, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500 mt-2">
                    {{ ($gastos->total_compras ?? 0) }} compras + {{ ($nomina->total_nominas ?? 0) }} nóminas
                </p>
            </div>
        </x-card>

        <!-- Balance -->
        <x-card>
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 {{ $balance >= 0 ? 'bg-blue-100' : 'bg-yellow-100' }} rounded-full mb-4">
                    <svg class="w-8 h-8 {{ $balance >= 0 ? 'text-blue-600' : 'text-yellow-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Balance Neto</h3>
                <p class="text-3xl font-bold {{ $balance >= 0 ? 'text-blue-600' : 'text-yellow-600' }}">
                    ${{ number_format($balance, 0, ',', '.') }}
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    @if($balance >= 0)
                        <span class="text-green-600">✓ Utilidad del periodo</span>
                    @else
                        <span class="text-red-600">✗ Pérdida del periodo</span>
                    @endif
                </p>
            </div>
        </x-card>
    </div>

    <!-- Detalles de Ingresos -->
    <x-card title="💰 Detalle de Ingresos (Facturas de Venta)">
        @if($ingresos && $ingresos->total_facturas > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600 mb-1">Subtotal (Sin IVA)</p>
                <p class="text-2xl font-bold text-gray-900">${{ number_format($ingresos->subtotal_ingresos ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600 mb-1">IVA Recaudado</p>
                <p class="text-2xl font-bold text-gray-900">${{ number_format($ingresos->total_iva ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600 mb-1">Total con IVA</p>
                <p class="text-2xl font-bold text-green-600">${{ number_format($ingresos->total_ingresos ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        @if($ingresosPorDia->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Facturas</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($ingresosPorDia as $dia)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($dia->fecha)->locale('es')->isoFormat('dddd, D [de] MMMM') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            {{ $dia->cantidad }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600 text-right">
                            ${{ number_format($dia->total, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        @else
        <div class="text-center py-8 text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p>No hay facturas emitidas en este periodo</p>
        </div>
        @endif
    </x-card>

    <!-- Detalles de Gastos -->
    <x-card title="💸 Detalle de Gastos">
        <div class="space-y-6">
            <!-- Compras -->
            <div>
                <h4 class="font-medium text-gray-900 mb-4">Compras a Proveedores</h4>
                @if($gastos && $gastos->total_compras > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Subtotal (Sin IVA)</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($gastos->subtotal_gastos ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">IVA Pagado</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($gastos->total_iva ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Total con IVA</p>
                        <p class="text-2xl font-bold text-red-600">${{ number_format($gastos->total_gastos ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>

                @if($gastosPorDia->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Compras</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($gastosPorDia as $dia)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($dia->fecha)->locale('es')->isoFormat('dddd, D [de] MMMM') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                    {{ $dia->cantidad }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600 text-right">
                                    ${{ number_format($dia->total, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                @else
                <div class="text-center py-6 text-gray-500">
                    <p>No hay compras registradas en este periodo</p>
                </div>
                @endif
            </div>

            <!-- Nómina -->
            <div class="border-t pt-6">
                <h4 class="font-medium text-gray-900 mb-4">Nómina de Empleados</h4>
                @if($nomina && $nomina->total_nominas > 0)
                <div class="bg-red-50 p-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Nómina Pagada</p>
                            <p class="text-2xl font-bold text-red-600">${{ number_format($nomina->total_nomina ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Nóminas procesadas</p>
                            <p class="text-xl font-bold text-gray-900">{{ $nomina->total_nominas }}</p>
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center py-6 text-gray-500">
                    <p>No hay nóminas procesadas en este periodo</p>
                </div>
                @endif
            </div>
        </div>
    </x-card>

    <!-- Acciones -->
    <div class="flex justify-between">
        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            Volver al Dashboard
        </a>
        <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Imprimir Reporte
        </button>
    </div>
</div>

@push('styles')
<style>
    @media print {
        .no-print {
            display: none;
        }
        body {
            font-size: 12px;
        }
    }
</style>
@endpush
@endsection
