@extends('layouts.admin')

@section('title', 'Productos')
@section('page-title', 'Productos')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Catálogo de Productos</h2>
            <p class="mt-1 text-sm text-gray-600">Gestión de medicamentos y productos</p>
        </div>
        <x-button-link href="{{ route('productos.crear') }}">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nuevo Producto
        </x-button-link>
    </div>

    <!-- Filtros -->
    <x-card>
        <form method="GET" action="{{ route('productos.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Buscar por código, nombre o descripción..."
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div>
                <select
                    name="iva"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Todos los IVA</option>
                    <option value="0" {{ request('iva') === '0' ? 'selected' : '' }}>0% (Exento)</option>
                    <option value="5" {{ request('iva') === '5' ? 'selected' : '' }}>5%</option>
                    <option value="19" {{ request('iva') === '19' ? 'selected' : '' }}>19%</option>
                </select>
            </div>
            <div>
                <select
                    name="estado"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Todos los estados</option>
                    <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Activos</option>
                    <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Inactivos</option>
                </select>
            </div>
            <div class="md:col-span-4 flex justify-end">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Precio</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">IVA</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Stock</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($productos as $producto)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono font-bold text-gray-900">{{ $producto->codigo }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $producto->nombre }}</div>
                                @if($producto->descripcion)
                                    <div class="text-xs text-gray-500">{{ Str::limit($producto->descripcion, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-medium text-gray-900">${{ number_format($producto->precio, 0) }}</div>
                                <div class="text-xs text-gray-500">+ IVA: ${{ number_format($producto->calcularIva(), 0) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($producto->porcentaje_iva == 0)
                                    <x-badge color="gray">0% Exento</x-badge>
                                @elseif($producto->porcentaje_iva == 5)
                                    <x-badge color="yellow">5%</x-badge>
                                @else
                                    <x-badge color="blue">19%</x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($producto->stock > 10)
                                    <span class="text-sm font-medium text-green-600">{{ $producto->stock }}</span>
                                @elseif($producto->stock > 0)
                                    <span class="text-sm font-medium text-yellow-600">{{ $producto->stock }}</span>
                                @else
                                    <span class="text-sm font-medium text-red-600">Agotado</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($producto->estado == 1)
                                    <x-badge color="green">Activo</x-badge>
                                @else
                                    <x-badge color="red">Inactivo</x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                <a href="{{ route('productos.editar', $producto) }}" class="text-yellow-600 hover:text-yellow-900 text-sm">Editar</a>
                                <form action="{{ route('productos.toggle-estado', $producto) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-gray-600 hover:text-gray-900 text-sm">
                                        {{ $producto->estado == 1 ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                No hay productos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($productos->hasPages())
            <div class="px-6 py-4 border-t">{{ $productos->links() }}</div>
        @endif
    </x-card>
</div>
@endsection
