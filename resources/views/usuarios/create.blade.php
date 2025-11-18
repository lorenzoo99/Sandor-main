@extends('layouts.admin')

@section('title', 'Crear Usuario')
@section('page-title', 'Crear Nuevo Usuario')

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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Crear</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Formulario -->
    <x-card title="Información del Usuario">
        <form method="POST" action="{{ route('usuarios.store') }}" class="space-y-6">
            @csrf

            <!-- Nombre Completo -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre Completo <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="nombre"
                    id="nombre"
                    value="{{ old('nombre') }}"
                    required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nombre') border-red-500 @enderror"
                    placeholder="Ej: Juan Pérez González"
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
                    value="{{ old('correo') }}"
                    required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('correo') border-red-500 @enderror"
                    placeholder="usuario@farmaprof.com"
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
                    <option value="">Seleccione un rol</option>
                    <option value="SUPERADMIN" {{ old('rol') === 'SUPERADMIN' ? 'selected' : '' }}>
                        SUPERADMIN - Acceso total al sistema
                    </option>
                    <option value="CLIENTE_SAAS" {{ old('rol') === 'CLIENTE_SAAS' ? 'selected' : '' }}>
                        CLIENTE_SAAS - Acceso estándar
                    </option>
                </select>
                <p class="mt-1 text-xs text-gray-500">
                    <strong>SUPERADMIN:</strong> Puede gestionar usuarios y tiene acceso completo.
                    <strong>CLIENTE_SAAS:</strong> Acceso a funciones contables estándar.
                </p>
                @error('rol')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="border-t border-gray-200 pt-6"></div>

            <!-- Contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Contraseña <span class="text-red-500">*</span>
                </label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                    placeholder="Mínimo 8 caracteres"
                >
                <p class="mt-1 text-xs text-gray-500">Debe tener al menos 8 caracteres</p>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Confirmar Contraseña <span class="text-red-500">*</span>
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Repita la contraseña"
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
                    {{ old('activo', true) ? 'checked' : '' }}
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                >
                <label for="activo" class="ml-2 block text-sm text-gray-900">
                    Usuario activo
                </label>
            </div>
            <p class="text-xs text-gray-500">Los usuarios inactivos no pueden iniciar sesión</p>

            <!-- Botones de acción -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
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
                    Crear Usuario
                </button>
            </div>
        </form>
    </x-card>

    <!-- Info Card -->
    <x-card>
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-900">Información importante</h3>
                <div class="mt-2 text-sm text-gray-600 space-y-1">
                    <p>• El usuario recibirá sus credenciales y podrá cambiar su contraseña después del primer inicio de sesión.</p>
                    <p>• Los usuarios SUPERADMIN tienen permisos completos para gestionar el sistema.</p>
                    <p>• Puedes desactivar un usuario en cualquier momento sin eliminarlo.</p>
                </div>
            </div>
        </div>
    </x-card>
</div>
@endsection
