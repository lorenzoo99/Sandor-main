@extends('layouts.admin')

@section('title', 'Detalle de Usuario')
@section('page-title', 'Detalle del Usuario')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $usuario->nombre }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Acciones rápidas -->
    <div class="flex justify-end space-x-3">
        <a
            href="{{ route('usuarios.edit', $usuario->id_usuario) }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium inline-flex items-center"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Editar
        </a>
        <a
            href="{{ route('usuarios.index') }}"
            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium"
        >
            Volver
        </a>
    </div>

    <!-- Información Principal -->
    <x-card>
        <div class="flex items-center space-x-6">
            <div class="flex-shrink-0">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                    <span class="text-white font-bold text-3xl">
                        {{ strtoupper(substr($usuario->nombre, 0, 2)) }}
                    </span>
                </div>
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900">{{ $usuario->nombre }}</h2>
                <p class="text-gray-600 mt-1">{{ $usuario->correo }}</p>
                <div class="mt-3 flex items-center space-x-3">
                    @if($usuario->rol === 'SUPERADMIN')
                        <x-badge type="primary">{{ $usuario->rol }}</x-badge>
                    @else
                        <x-badge type="info">{{ $usuario->rol }}</x-badge>
                    @endif

                    @if($usuario->activo)
                        <x-badge type="success">Activo</x-badge>
                    @else
                        <x-badge type="error">Inactivo</x-badge>
                    @endif
                </div>
            </div>
        </div>
    </x-card>

    <!-- Detalles del Usuario -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-card title="Información de la Cuenta">
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">ID de Usuario</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-mono">#{{ $usuario->id_usuario }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Correo Electrónico</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $usuario->correo }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Rol del Sistema</dt>
                    <dd class="mt-1">
                        @if($usuario->rol === 'SUPERADMIN')
                            <span class="text-sm text-gray-900 font-semibold">Superadministrador</span>
                            <p class="text-xs text-gray-500 mt-1">Acceso completo a todas las funciones del sistema</p>
                        @else
                            <span class="text-sm text-gray-900 font-semibold">Cliente SaaS</span>
                            <p class="text-xs text-gray-500 mt-1">Acceso estándar a funciones contables</p>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Estado de la Cuenta</dt>
                    <dd class="mt-1">
                        @if($usuario->activo)
                            <div class="flex items-center text-green-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium">Activo</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Puede iniciar sesión y acceder al sistema</p>
                        @else
                            <div class="flex items-center text-red-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium">Inactivo</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">No puede iniciar sesión en el sistema</p>
                        @endif
                    </dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Información Temporal">
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Fecha de Creación</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        @if($usuario->fecha_creacion)
                            {{ $usuario->fecha_creacion->format('d/m/Y H:i:s') }}
                            <span class="text-gray-500 text-xs block mt-1">
                                ({{ $usuario->fecha_creacion->diffForHumans() }})
                            </span>
                        @else
                            <span class="text-gray-400">No disponible</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Última Actualización</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <span class="text-gray-400">No disponible</span>
                        <span class="text-gray-500 text-xs block mt-1">
                            (timestamps deshabilitados en el modelo)
                        </span>
                    </dd>
                </div>
            </dl>
        </x-card>
    </div>

    <!-- Actividad Reciente (Placeholder) -->
    <x-card title="Actividad Reciente">
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Sin actividad registrada</h3>
            <p class="mt-1 text-sm text-gray-500">La auditoría de actividad se implementará próximamente</p>
        </div>
    </x-card>

    <!-- Acciones Administrativas -->
    @if($usuario->id_usuario !== auth()->user()->id_usuario)
    <x-card title="Acciones Administrativas">
        <div class="space-y-4">
            <form action="{{ route('usuarios.toggle-status', $usuario->id_usuario) }}" method="POST">
                @csrf
                @method('PATCH')
                <button
                    type="submit"
                    class="w-full md:w-auto px-4 py-2 {{ $usuario->activo ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition font-medium inline-flex items-center justify-center"
                >
                    @if($usuario->activo)
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                        Desactivar Usuario
                    @else
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Activar Usuario
                    @endif
                </button>
            </form>

            <form
                action="{{ route('usuarios.destroy', $usuario->id_usuario) }}"
                method="POST"
                onsubmit="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')"
            >
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="w-full md:w-auto px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium inline-flex items-center justify-center"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Eliminar Usuario Permanentemente
                </button>
            </form>
        </div>
    </x-card>
    @endif
</div>
@endsection
