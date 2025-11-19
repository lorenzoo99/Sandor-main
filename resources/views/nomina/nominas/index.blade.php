@extends('layouts.admin')

@section('title', 'Nóminas')
@section('page-title', 'Nóminas')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Nóminas</h2>
            <p class="mt-1 text-sm text-gray-600">Gestión de pagos de nómina</p>
        </div>
        <x-button-link href="{{ route('nomina.nominas.procesar') }}">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Procesar Nómina
        </x-button-link>
    </div>

    <!-- Filtros -->
    <x-card>
        <form method="GET" action="{{ route('nomina.nominas.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Período</label>
                <input
                    type="month"
                    name="periodo"
                    value="{{ request('periodo') }}"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select
                    name="estado"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Todos</option>
                    <option value="PENDIENTE" {{ request('estado') == 'PENDIENTE' ? 'selected' : '' }}>Pendiente</option>
                    <option value="PAGADA" {{ request('estado') == 'PAGADA' ? 'selected' : '' }}>Pagada</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white font-medium rounded-lg transition">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Empleado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Período</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Salario Base</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Deducciones</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Salario Neto</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($nominas as $nomina)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $nomina->empleado->nombre }}</div>
                                <div class="text-xs text-gray-500">{{ $nomina->empleado->cargo }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $nomina->periodo }}</td>
                            <td class="px-6 py-4 text-right text-sm text-gray-900">
                                ${{ number_format($nomina->salario_base, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-red-600">
                                -${{ number_format($nomina->total_deducciones, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-green-600">
                                ${{ number_format($nomina->salario_neto, 2) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($nomina->estado === 'PAGADA')
                                    <x-badge color="green">Pagada</x-badge>
                                @else
                                    <x-badge color="yellow">Pendiente</x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('nomina.nominas.ver', $nomina) }}" class="text-blue-600 hover:text-blue-900 text-sm">Ver</a>
                                @if($nomina->estado === 'PENDIENTE')
                                    <form action="{{ route('nomina.nominas.marcar-pagada', $nomina) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:text-green-900 text-sm">
                                            Marcar Pagada
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                No hay nóminas procesadas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($nominas->hasPages())
            <div class="px-6 py-4 border-t">{{ $nominas->links() }}</div>
        @endif
    </x-card>
</div>
@endsection
