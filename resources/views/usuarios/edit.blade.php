@extends('layouts.admin')

@section('title', 'Editar Usuario')
@section('page-title', 'Editar Usuario')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('usuarios.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    Usuarios
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Editar</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Formulario -->
    <x-card title="Editar Información del Usuario">
        <form method="POST" action="{{ route('usuarios.update', $usuario->id_usuario) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nombre Completo -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre Completo <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="nombre"
                    id="nombre"
                    value="{{ old('nombre', $usuario->nombre) }}"
                    required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nombre') border-red-500 @enderror"
                >
                @error('nombre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Correo Electrónico -->
            <div>
                <label for="correo" class="block text-sm font-medium text-gray-700 mb-1">
                    Correo Electrónico <span class="text-red-500">*</span>
                </label>
                <input
                    type="email"
                    name="correo"
                    id="correo"
                    value="{{ old('correo', $usuario->correo) }}"
                    required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('correo') border-red-500 @enderror"
                >
                @error('correo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rol -->
            <div>
                <label for="rol" class="block text-sm font-medium text-gray-700 mb-1">
                    Rol <span class="text-red-500">*</span>
                </label>
                <select
                    name="rol"
                    id="rol"
                    required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('rol') border-red-500 @enderror"
                >
                    <option value="SUPERADMIN" {{ old('rol', $usuario->rol) === 'SUPERADMIN' ? 'selected' : '' }}>
                        SUPERADMIN - Acceso total al sistema
                    </option>
                    <option value="CLIENTE_SAAS" {{ old('rol', $usuario->rol) === 'CLIENTE_SAAS' ? 'selected' : '' }}>
                        CLIENTE_SAAS - Acceso estándar
                    </option>
                </select>
                @error('rol')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="border-t border-gray-200 pt-6"></div>

            <!-- Cambiar Contraseña (Opcional) -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Cambiar Contraseña</h3>
                        <p class="text-sm text-yellow-700 mt-1">Deja estos campos vacíos si no deseas cambiar la contraseña</p>
                    </div>
                </div>
            </div>

            <!-- Nueva Contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Nueva Contraseña
                </label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                    placeholder="Dejar vacío para mantener la actual"
                >
                <p class="mt-1 text-xs text-gray-500">Mínimo 8 caracteres</p>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmar Nueva Contraseña -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Confirmar Nueva Contraseña
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Repita la nueva contraseña"
                >
            </div>

            <div class="border-t border-gray-200 pt-6"></div>

            <!-- Estado Activo -->
            <div class="flex items-center">
                <input
                    type="checkbox"
                    name="activo"
                    id="activo"
                    value="1"
                    {{ old('activo', $usuario->activo) ? 'checked' : '' }}
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                >
                <label for="activo" class="ml-2 block text-sm text-gray-900">
                    Usuario activo
                </label>
            </div>

            <!-- Botones de acción -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <div class="flex space-x-3">
                    <a
                        href="{{ route('usuarios.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium"
                    >
                        Cancelar
                    </a>
                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium inline-flex items-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Guardar Cambios
                    </button>
                </div>

                @if($usuario->id_usuario !== auth()->user()->id_usuario)
                <form
                    action="{{ route('usuarios.destroy', $usuario->id_usuario) }}"
                    method="POST"
                    onsubmit="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')"
                >
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium inline-flex items-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Eliminar Usuario
                    </button>
                </form>
                @endif
            </div>
        </form>
    </x-card>
</div>
@endsection
