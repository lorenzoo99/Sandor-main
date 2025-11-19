@extends('layouts.admin')

@section('title', 'Detalle de Nómina')
@section('page-title', 'Detalle de Nómina')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Nómina - {{ $nomina->periodo }}</h2>
            <p class="mt-1 text-sm text-gray-600">{{ $nomina->empleado->nombre }}</p>
        </div>
        <div class="flex items-center space-x-3">
            @if($nomina->estado === 'PAGADA')
                <x-badge color="green" size="lg">Pagada</x-badge>
            @else
                <x-badge color="yellow" size="lg">Pendiente</x-badge>
            @endif
            <x-button-link href="{{ route('nomina.nominas.index') }}" variant="secondary">
                Volver
            </x-button-link>
        </div>
    </div>

    <!-- Información del Empleado -->
    <x-card>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Empleado</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-gray-500">Nombre</p>
                <p class="text-base font-medium text-gray-900">{{ $nomina->empleado->nombre }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Identificación</p>
                <p class="text-base font-medium text-gray-900">
                    {{ $nomina->empleado->tipo_identificacion }}: {{ $nomina->empleado->numero_identificacion }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Cargo</p>
                <p class="text-base font-medium text-gray-900">{{ $nomina->empleado->cargo }}</p>
            </div>
        </div>
    </x-card>

    <!-- Información de la Nómina -->
    <x-card>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detalles de la Nómina</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">Período</p>
                <p class="text-base font-medium text-gray-900">{{ $nomina->periodo }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Fecha de Pago</p>
                <p class="text-base font-medium text-gray-900">
                    {{ \Carbon\Carbon::parse($nomina->fecha_pago)->format('d/m/Y') }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Procesado por</p>
                <p class="text-base font-medium text-gray-900">{{ $nomina->usuario->name ?? 'Sistema' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Estado</p>
                <p class="text-base font-medium text-gray-900">
                    @if($nomina->estado === 'PAGADA')
                        <x-badge color="green">Pagada</x-badge>
                    @else
                        <x-badge color="yellow">Pendiente</x-badge>
                    @endif
                </p>
            </div>
        </div>
    </x-card>

    <!-- Desglose Financiero -->
    <x-card>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Desglose Financiero</h3>

        <div class="space-y-4">
            <!-- Salario Base -->
            <div class="flex justify-between items-center pb-2">
                <span class="text-base text-gray-700">Salario Base</span>
                <span class="text-lg font-bold text-gray-900">${{ number_format($nomina->salario_base, 2) }}</span>
            </div>

            <div class="border-t border-gray-200 pt-2">
                <p class="text-sm font-medium text-gray-700 mb-2">Deducciones:</p>

                <!-- Deducción Salud -->
                <div class="flex justify-between items-center pl-4 py-1">
                    <span class="text-sm text-gray-600">Salud (4%)</span>
                    <span class="text-sm font-medium text-red-600">-${{ number_format($nomina->deduccion_salud, 2) }}</span>
                </div>

                <!-- Deducción Pensión -->
                <div class="flex justify-between items-center pl-4 py-1">
                    <span class="text-sm text-gray-600">Pensión (4%)</span>
                    <span class="text-sm font-medium text-red-600">-${{ number_format($nomina->deduccion_pension, 2) }}</span>
                </div>

                <!-- Total Deducciones -->
                <div class="flex justify-between items-center pl-4 py-2 border-t border-gray-100 mt-2">
                    <span class="text-sm font-medium text-gray-700">Total Deducciones</span>
                    <span class="text-sm font-bold text-red-600">-${{ number_format($nomina->total_deducciones, 2) }}</span>
                </div>
            </div>

            <!-- Salario Neto -->
            <div class="flex justify-between items-center pt-4 border-t-2 border-gray-300">
                <span class="text-lg font-bold text-gray-900">Salario Neto a Pagar</span>
                <span class="text-2xl font-bold text-green-600">${{ number_format($nomina->salario_neto, 2) }}</span>
            </div>
        </div>

        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <p class="text-xs text-blue-700">
                <strong>Nota:</strong> Las deducciones de salud y pensión son obligatorias según la ley colombiana (8% del salario base).
            </p>
        </div>
    </x-card>

    <!-- Acciones -->
    @if($nomina->estado === 'PENDIENTE')
        <x-card>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones</h3>
            <form action="{{ route('nomina.nominas.marcar-pagada', $nomina) }}" method="POST" onsubmit="return confirm('¿Está seguro de marcar esta nómina como pagada? Esta acción generará un asiento contable.')">
                @csrf
                @method('PATCH')
                <button
                    type="submit"
                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition"
                >
                    Marcar como Pagada
                </button>
            </form>
        </x-card>
    @endif
</div>
@endsection
