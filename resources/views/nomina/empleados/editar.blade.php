@extends('layouts.admin')

@section('title', 'Editar Empleado')
@section('page-title', 'Editar Empleado')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <x-card>
        <form action="{{ route('nomina.empleados.actualizar', $empleado) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <h3 class="text-lg font-semibold text-gray-900">Información Personal</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo *</label>
                    <input
                        type="text"
                        name="nombre"
                        value="{{ old('nombre', $empleado->nombre) }}"
                        required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Identificación</label>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm text-gray-600">
                            {{ $empleado->tipo_identificacion }}: {{ $empleado->numero_identificacion }}
                        </span>
                        <span class="text-xs text-gray-500">(No se puede modificar)</span>
                    </div>
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mt-6">Información Laboral</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cargo *</label>
                    <input
                        type="text"
                        name="cargo"
                        value="{{ old('cargo', $empleado->cargo) }}"
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
                        value="{{ old('salario_base', $empleado->salario_base) }}"
                        required
                        step="0.01"
                        min="0"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Ingreso</label>
                    <input
                        type="text"
                        value="{{ $empleado->fecha_ingreso->format('d/m/Y') }}"
                        disabled
                        class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600"
                    >
                    <p class="text-xs text-gray-500 mt-1">(No se puede modificar)</p>
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mt-6">Información de Contacto</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                    <input
                        type="text"
                        name="telefono"
                        value="{{ old('telefono', $empleado->telefono) }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                    <input
                        type="email"
                        name="correo"
                        value="{{ old('correo', $empleado->correo) }}"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                    <input
                        type="text"
                        name="direccion"
                        value="{{ old('direccion', $empleado->direccion) }}"
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
                    Actualizar Empleado
                </button>
            </div>
        </form>
    </x-card>
</div>
@endsection
