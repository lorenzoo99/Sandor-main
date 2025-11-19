@extends('layouts.admin')

@section('title', 'Detalle del Empleado')
@section('page-title', 'Detalle del Empleado')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $empleado->nombre }}</h2>
            <p class="mt-1 text-sm text-gray-600">{{ $empleado->cargo }}</p>
        </div>
        <div class="flex items-center space-x-3">
            @if($empleado->estado == 1)
                <x-badge color="green" size="lg">Activo</x-badge>
            @else
                <x-badge color="red" size="lg">Inactivo</x-badge>
            @endif
            <x-button-link href="{{ route('nomina.empleados.editar', $empleado) }}">
                Editar
            </x-button-link>
            <x-button-link href="{{ route('nomina.empleados.index') }}" variant="secondary">
                Volver
            </x-button-link>
        </div>
    </div>

    <!-- Información Personal -->
    <x-card>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Personal</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">Tipo de Identificación</p>
                <p class="text-base font-medium text-gray-900">{{ $empleado->tipo_identificacion }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Número de Identificación</p>
                <p class="text-base font-medium text-gray-900">{{ $empleado->numero_identificacion }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Teléfono</p>
                <p class="text-base font-medium text-gray-900">{{ $empleado->telefono ?: 'No registrado' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Correo Electrónico</p>
                <p class="text-base font-medium text-gray-900">{{ $empleado->correo ?: 'No registrado' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Dirección</p>
                <p class="text-base font-medium text-gray-900">{{ $empleado->direccion ?: 'No registrada' }}</p>
            </div>
        </div>
    </x-card>

    <!-- Información Laboral -->
    <x-card>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Laboral</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-gray-500">Cargo</p>
                <p class="text-base font-medium text-gray-900">{{ $empleado->cargo }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Salario Base</p>
                <p class="text-lg font-bold text-green-600">${{ number_format($empleado->salario_base, 2) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Fecha de Ingreso</p>
                <p class="text-base font-medium text-gray-900">{{ $empleado->fecha_ingreso->format('d/m/Y') }}</p>
            </div>
        </div>
    </x-card>

    <!-- Deducciones -->
    <x-card>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Deducciones de Nómina</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <p class="text-sm text-gray-500">Salario Base</p>
                <p class="text-lg font-bold text-gray-900">${{ number_format($empleado->salario_base, 2) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Salud (4%)</p>
                <p class="text-lg font-bold text-red-600">-${{ number_format($empleado->calcularSalud(), 2) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Pensión (4%)</p>
                <p class="text-lg font-bold text-red-600">-${{ number_format($empleado->calcularPension(), 2) }}</p>
            </div>
            <div class="border-l-4 border-green-500 pl-4">
                <p class="text-sm text-gray-500">Salario Neto</p>
                <p class="text-xl font-bold text-green-600">${{ number_format($empleado->calcularSalarioNeto(), 2) }}</p>
            </div>
        </div>
        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
            <p class="text-xs text-blue-700">
                <strong>Total deducciones:</strong> ${{ number_format($empleado->calcularTotalDeducciones(), 2) }} (8% del salario base)
            </p>
        </div>
    </x-card>

    <!-- Historial de Nóminas -->
    <x-card>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Historial de Nóminas</h3>
        @if($empleado->nominas->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Período</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Pago</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Salario Base</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Deducciones</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Salario Neto</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($empleado->nominas as $nomina)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $nomina->periodo }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($nomina->fecha_pago)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-right text-sm text-gray-900">${{ number_format($nomina->salario_base, 2) }}</td>
                                <td class="px-6 py-4 text-right text-sm text-red-600">-${{ number_format($nomina->total_deducciones, 2) }}</td>
                                <td class="px-6 py-4 text-right text-sm font-bold text-green-600">${{ number_format($nomina->salario_neto, 2) }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($nomina->estado === 'PAGADA')
                                        <x-badge color="green">Pagada</x-badge>
                                    @else
                                        <x-badge color="yellow">Pendiente</x-badge>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Sin nóminas procesadas</h3>
                <p class="mt-1 text-sm text-gray-500">Este empleado aún no tiene nóminas registradas.</p>
            </div>
        @endif
    </x-card>
</div>
@endsection
