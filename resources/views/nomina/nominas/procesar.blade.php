@extends('layouts.admin')

@section('title', 'Procesar Nómina')
@section('page-title', 'Procesar Nómina')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <x-card>
        <form action="{{ route('nomina.nominas.guardar') }}" method="POST" class="space-y-6">
            @csrf

            <h3 class="text-lg font-semibold text-gray-900">Información del Período</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Período *</label>
                    <input
                        type="month"
                        name="periodo"
                        value="{{ $periodoActual }}"
                        required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Pago *</label>
                    <input
                        type="date"
                        name="fecha_pago"
                        value="{{ now()->format('Y-m-d') }}"
                        required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mt-6">Seleccionar Empleados</h3>
            <p class="text-sm text-gray-600">Seleccione los empleados a incluir en esta nómina</p>

            @if($empleados->count() > 0)
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left">
                                    <input
                                        type="checkbox"
                                        id="select-all"
                                        onclick="toggleAll(this)"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    >
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Empleado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cargo</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Salario Base</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Deducciones</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Salario Neto</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($empleados as $empleado)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <input
                                            type="checkbox"
                                            name="empleados[]"
                                            value="{{ $empleado->id_empleado }}"
                                            class="empleado-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                            checked
                                        >
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $empleado->nombre }}</div>
                                        <div class="text-xs text-gray-500">{{ $empleado->tipo_identificacion }}: {{ $empleado->numero_identificacion }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $empleado->cargo }}</td>
                                    <td class="px-6 py-4 text-right text-sm text-gray-900">
                                        ${{ number_format($empleado->salario_base, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm text-red-600">
                                        -${{ number_format($empleado->calcularTotalDeducciones(), 2) }}
                                        <div class="text-xs text-gray-500">
                                            Salud: ${{ number_format($empleado->calcularSalud(), 2) }}<br>
                                            Pensión: ${{ number_format($empleado->calcularPension(), 2) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-bold text-green-600">
                                        ${{ number_format($empleado->calcularSalarioNeto(), 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Deducciones:</strong> Salud 4% + Pensión 4% = 8% del salario base<br>
                                Al procesar, se generará automáticamente el asiento contable correspondiente.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <x-button-link href="{{ route('nomina.nominas.index') }}" variant="secondary">
                        Cancelar
                    </x-button-link>
                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition"
                    >
                        Procesar Nómina
                    </button>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay empleados activos</h3>
                    <p class="mt-1 text-sm text-gray-500">Primero debe registrar empleados activos.</p>
                    <div class="mt-6">
                        <x-button-link href="{{ route('nomina.empleados.crear') }}">
                            Registrar Empleado
                        </x-button-link>
                    </div>
                </div>
            @endif
        </form>
    </x-card>
</div>

<script>
function toggleAll(checkbox) {
    const checkboxes = document.querySelectorAll('.empleado-checkbox');
    checkboxes.forEach(cb => cb.checked = checkbox.checked);
}
</script>
@endsection
