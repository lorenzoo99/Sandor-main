@extends('layouts.admin')

@section('title', 'Plan de Cuentas (PUC)')
@section('page-title', 'Plan de Cuentas')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Plan Único de Cuentas (PUC)</h2>
            <p class="mt-1 text-sm text-gray-600">Catálogo de cuentas contables</p>
        </div>
    </div>

    <!-- Filtros y Búsqueda -->
    <x-card>
        <form method="GET" action="{{ route('contabilidad.plan-cuentas') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                        placeholder="Código o nombre de cuenta..."
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tipo -->
            <div>
                <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">
                    Tipo
                </label>
                <select
                    name="tipo"
                    id="tipo"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Todos</option>
                    <option value="ACTIVO" {{ request('tipo') == 'ACTIVO' ? 'selected' : '' }}>Activo</option>
                    <option value="PASIVO" {{ request('tipo') == 'PASIVO' ? 'selected' : '' }}>Pasivo</option>
                    <option value="PATRIMONIO" {{ request('tipo') == 'PATRIMONIO' ? 'selected' : '' }}>Patrimonio</option>
                    <option value="INGRESO" {{ request('tipo') == 'INGRESO' ? 'selected' : '' }}>Ingreso</option>
                    <option value="GASTO" {{ request('tipo') == 'GASTO' ? 'selected' : '' }}>Gasto</option>
                </select>
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

    <!-- Tabla de Cuentas -->
    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Código
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nivel
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($cuentas as $cuenta)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-mono font-bold text-gray-900">
                                    {{ $cuenta->codigo }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900" style="padding-left: {{ ($cuenta->nivel - 1) * 20 }}px">
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Nivel {{ $cuenta->nivel }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($cuenta->estado)
                                    <x-badge color="green">Activa</x-badge>
                                @else
                                    <x-badge color="gray">Inactiva</x-badge>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay cuentas contables</h3>
                                <p class="mt-1 text-sm text-gray-500">Ejecuta el seeder para cargar el PUC colombiano.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($cuentas->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $cuentas->links() }}
            </div>
        @endif
    </x-card>

    <!-- Ayuda -->
    <x-card>
        <h3 class="text-sm font-semibold text-gray-900 mb-2">💡 Información del PUC</h3>
        <div class="text-xs text-gray-600 space-y-1">
            <p><strong>Nivel 1 (Clase):</strong> 1=Activo, 2=Pasivo, 3=Patrimonio, 4=Ingresos, 5=Gastos, 6=Costos</p>
            <p><strong>Nivel 2 (Grupo):</strong> Agrupaciones generales (Ej: 11=Disponible, 41=Ingresos Operacionales)</p>
            <p><strong>Nivel 3 (Cuenta):</strong> Cuentas específicas (Ej: 1105=Caja, 4135=Ventas)</p>
        </div>
    </x-card>
</div>
@endsection
