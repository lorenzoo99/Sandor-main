@extends('layouts.admin')

@section('title', 'Crear Empleado')
@section('page-title', 'Crear Empleado')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <x-card>
        <form action="{{ route('nomina.empleados.guardar') }}" method="POST" class="space-y-6">
            @csrf

            <h3 class="text-lg font-semibold text-gray-900">Información Personal</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo *</label>
                    <input
                        type="text"
                        name="nombre"
                        value="{{ old('nombre') }}"
                        required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Identificación *</label>
                    <select
                        name="tipo_identificacion"
                        required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="CC" {{ old('tipo_identificacion') == 'CC' ? 'selected' : '' }}>CC - Cédula de Ciudadanía</option>
                        <option value="CE" {{ old('tipo_identificacion') == 'CE' ? 'selected' : '' }}>CE - Cédula de Extranjería</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número de Identificación *</label>
                    <input
                        type="text"
                        name="numero_identificacion"
                        value="{{ old('numero_identificacion') }}"
                        required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mt-6">Información Laboral</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cargo *</label>
                    <input
                        type="text"
                        name="cargo"
                        value="{{ old('cargo') }}"
                        required
                        placeholder="Ej: Vendedor, Contador, etc."
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Salario Base *</label>
                    <input
                        type="number"
                        name="salario_base"
                        value="{{ old('salario_base') }}"
                        required
                        step="0.01"
                        min="0"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Ingreso *</label>
                    <input
                        type="date"
                        name="fecha_ingreso"
                        value="{{ old('fecha_ingreso', now()->format('Y-m-d')) }}"
                        required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mt-6">Información de Contacto</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                    <input
                        type="text"
                        name="telefono"
                        value="{{ old('telefono') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                    <input
                        type="email"
                        name="correo"
                        value="{{ old('correo') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                    <input
                        type="text"
                        name="direccion"
                        value="{{ old('direccion') }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <x-button-link href="{{ route('nomina.empleados.index') }}" variant="secondary">
                    Cancelar
                </x-button-link>
                <button
                    type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition"
                >
                    Guardar Empleado
                </button>
            </div>
        </form>
    </x-card>
</div>
@endsection
