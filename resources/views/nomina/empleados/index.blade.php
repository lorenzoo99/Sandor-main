@extends('layouts.admin')

@section('title', 'Empleados')
@section('page-title', 'Empleados')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Empleados</h2>
            <p class="mt-1 text-sm text-gray-600">Gestión de empleados</p>
        </div>
        <x-button-link href="{{ route('nomina.empleados.crear') }}">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nuevo Empleado
        </x-button-link>
    </div>

    <!-- Filtros -->
    <x-card>
        <form method="GET" action="{{ route('nomina.empleados.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Buscar por nombre, identificación o cargo..."
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div>
                <select
                    name="estado"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Todos los estados</option>
                    <option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>Activos</option>
                    <option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>Inactivos</option>
                </select>
            </div>
            <div class="md:col-span-3 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white font-medium rounded-lg transition">
                    Filtrar
                </button>
            </div>
        </form>
    </x-card>

    <!-- Tabla -->
    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Identificación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cargo</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Salario</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($empleados as $empleado)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $empleado->nombre }}</div>
                                <div class="text-xs text-gray-500">{{ $empleado->correo }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $empleado->tipo_identificacion }}: {{ $empleado->numero_identificacion }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $empleado->cargo }}</td>
                            <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                                ${{ number_format($empleado->salario_base, 2) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($empleado->estado == 1)
                                    <x-badge color="green">Activo</x-badge>
                                @else
                                    <x-badge color="red">Inactivo</x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('nomina.empleados.ver', $empleado) }}" class="text-blue-600 hover:text-blue-900 text-sm">Ver</a>
                                <a href="{{ route('nomina.empleados.editar', $empleado) }}" class="text-yellow-600 hover:text-yellow-900 text-sm">Editar</a>
                                <form action="{{ route('nomina.empleados.toggle-estado', $empleado) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-gray-600 hover:text-gray-900 text-sm">
                                        {{ $empleado->estado == 1 ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                No hay empleados registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($empleados->hasPages())
            <div class="px-6 py-4 border-t">{{ $empleados->links() }}</div>
        @endif
    </x-card>
</div>
@endsection
