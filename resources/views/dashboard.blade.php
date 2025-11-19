@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Panel de Control')

@section('content')
<div class="space-y-6">
    <!-- Welcome Message -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-6 text-white">
        <h2 class="text-2xl font-bold mb-2">¡Bienvenido, {{ Auth::user()->name }}!</h2>
        <p class="text-blue-100">Sistema Contable FarmaProf - Droguería</p>
        <p class="text-sm text-blue-200 mt-1">{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</p>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stat-card
            title="Ingresos del Mes"
            :value="'$' . number_format($ingresosMes, 0, ',', '.')"
            color="green"
        >
            <x-slot name="icon">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </x-slot>
        </x-stat-card>

        <x-stat-card
            title="Gastos del Mes"
            :value="'$' . number_format($gastosMes, 0, ',', '.')"
            color="red"
        >
            <x-slot name="icon">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </x-slot>
        </x-stat-card>

        <x-stat-card
            title="Balance del Mes"
            :value="'$' . number_format($balance, 0, ',', '.')"
            :color="$balance >= 0 ? 'blue' : 'yellow'"
        >
            <x-slot name="icon">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </x-slot>
        </x-stat-card>

        <x-stat-card
            title="Facturas Emitidas"
            :value="$facturasEmitidas"
            color="purple"
        >
            <x-slot name="icon">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </x-slot>
        </x-stat-card>
    </div>

    <!-- Charts and Tables Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Transactions -->
        <x-card title="Últimas Transacciones">
            <div class="space-y-4">
                @forelse($transacciones as $transaccion)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full {{ $transaccion->tipo === 'Venta' ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center">
                            @if($transaccion->tipo === 'Venta')
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $transaccion->tipo }} #{{ $transaccion->numero_factura }}</p>
                            <p class="text-sm text-gray-500">{{ $transaccion->entidad }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold {{ $transaccion->tipo === 'Venta' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaccion->tipo === 'Venta' ? '+' : '-' }}${{ number_format($transaccion->total, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($transaccion->fecha)->locale('es')->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    <p>No hay transacciones recientes</p>
                </div>
                @endforelse
            </div>
            <x-slot name="footer">
                <a href="{{ route('facturas.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Ver todas las facturas →
                </a>
            </x-slot>
        </x-card>

        <!-- Pending Tasks -->
        <x-card title="Tareas Pendientes">
            <!-- Formulario para agregar tarea -->
            <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                <form id="formAgregarTarea" class="space-y-2">
                    @csrf
                    <input
                        type="text"
                        name="descripcion"
                        id="nuevaTareaDescripcion"
                        placeholder="Nueva tarea..."
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                        required
                    >
                    <div class="flex gap-2">
                        <select name="prioridad" id="nuevaTareaPrioridad" class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option value="baja">Baja prioridad</option>
                            <option value="media" selected>Media prioridad</option>
                            <option value="alta">Alta prioridad</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                            Agregar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Lista de tareas -->
            <div class="space-y-3" id="listaTareas">
                @forelse($tareas as $tarea)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition" data-tarea-id="{{ $tarea->id_tarea }}">
                    <div class="flex items-center space-x-3">
                        <input
                            type="checkbox"
                            class="w-4 h-4 text-blue-600 rounded cursor-pointer"
                            onchange="completarTarea({{ $tarea->id_tarea }})"
                        >
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $tarea->descripcion }}</p>
                            @if($tarea->prioridad === 'alta')
                                <x-badge type="error">Alta prioridad</x-badge>
                            @elseif($tarea->prioridad === 'media')
                                <x-badge type="warning">Media prioridad</x-badge>
                            @else
                                <x-badge type="default">Baja prioridad</x-badge>
                            @endif
                        </div>
                    </div>
                    <button
                        onclick="eliminarTarea({{ $tarea->id_tarea }})"
                        class="text-red-500 hover:text-red-700 transition"
                        title="Eliminar tarea"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500" id="sinTareas">
                    <p>No hay tareas pendientes</p>
                </div>
                @endforelse
            </div>
        </x-card>
    </div>

    <!-- Quick Actions -->
    <x-card title="Acciones Rápidas">
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('facturas.crear') }}" class="flex flex-col items-center justify-center p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition group">
                <svg class="w-10 h-10 text-blue-600 mb-3 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-sm font-medium text-gray-900">Nueva Factura</span>
            </a>

            @if(Auth::user()->isSuperAdmin())
            <a href="{{ route('usuarios.create') }}" class="flex flex-col items-center justify-center p-6 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition group">
                <svg class="w-10 h-10 text-yellow-600 mb-3 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <span class="text-sm font-medium text-gray-900">Nuevo Usuario</span>
            </a>
            @endif
        </div>
    </x-card>
</div>
@endsection

@push('scripts')
<script>
    // CSRF token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Function to complete a task
    async function completarTarea(id) {
        try {
            const response = await fetch(`/tareas/${id}/completar`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                // Remove task element from DOM with animation
                const tareaElement = document.querySelector(`[data-tarea-id="${id}"]`);
                if (tareaElement) {
                    tareaElement.style.transition = 'opacity 0.3s, transform 0.3s';
                    tareaElement.style.opacity = '0';
                    tareaElement.style.transform = 'translateX(20px)';
                    setTimeout(() => {
                        tareaElement.remove();
                        checkEmptyTasks();
                    }, 300);
                }
            } else {
                alert('Error al completar la tarea');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al completar la tarea');
        }
    }

    // Function to delete a task
    async function eliminarTarea(id) {
        if (!confirm('¿Está seguro de eliminar esta tarea?')) {
            return;
        }

        try {
            const response = await fetch(`/tareas/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                // Remove task element from DOM with animation
                const tareaElement = document.querySelector(`[data-tarea-id="${id}"]`);
                if (tareaElement) {
                    tareaElement.style.transition = 'opacity 0.3s, transform 0.3s';
                    tareaElement.style.opacity = '0';
                    tareaElement.style.transform = 'translateX(-20px)';
                    setTimeout(() => {
                        tareaElement.remove();
                        checkEmptyTasks();
                    }, 300);
                }
            } else {
                alert('Error al eliminar la tarea');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al eliminar la tarea');
        }
    }

    // Check if task list is empty and show message
    function checkEmptyTasks() {
        const listaTareas = document.getElementById('listaTareas');
        const tareas = listaTareas.querySelectorAll('[data-tarea-id]');

        if (tareas.length === 0) {
            const emptyMessage = document.createElement('div');
            emptyMessage.className = 'text-center py-4 text-gray-500';
            emptyMessage.id = 'sinTareas';
            emptyMessage.innerHTML = '<p>No hay tareas pendientes</p>';
            listaTareas.appendChild(emptyMessage);
        }
    }

    // Form submit handler for adding tasks
    document.getElementById('formAgregarTarea').addEventListener('submit', async function(e) {
        e.preventDefault();

        const descripcion = document.getElementById('nuevaTareaDescripcion').value.trim();
        const prioridad = document.getElementById('nuevaTareaPrioridad').value;

        if (!descripcion) {
            alert('Por favor ingrese una descripción para la tarea');
            return;
        }

        try {
            const response = await fetch('/tareas/agregar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    descripcion: descripcion,
                    prioridad: prioridad
                })
            });

            const data = await response.json();

            if (data.success) {
                // Remove empty message if exists
                const sinTareas = document.getElementById('sinTareas');
                if (sinTareas) {
                    sinTareas.remove();
                }

                // Create new task element
                const listaTareas = document.getElementById('listaTareas');
                const nuevaTarea = document.createElement('div');
                nuevaTarea.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition';
                nuevaTarea.setAttribute('data-tarea-id', data.tarea.id);
                nuevaTarea.style.opacity = '0';
                nuevaTarea.style.transform = 'translateY(-10px)';

                // Determine badge color based on priority
                let badgeClass = '';
                let badgeText = '';
                if (data.tarea.prioridad === 'alta') {
                    badgeClass = 'bg-red-100 text-red-800';
                    badgeText = 'Alta prioridad';
                } else if (data.tarea.prioridad === 'media') {
                    badgeClass = 'bg-yellow-100 text-yellow-800';
                    badgeText = 'Media prioridad';
                } else {
                    badgeClass = 'bg-gray-100 text-gray-800';
                    badgeText = 'Baja prioridad';
                }

                nuevaTarea.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <input
                            type="checkbox"
                            class="w-4 h-4 text-blue-600 rounded cursor-pointer"
                            onchange="completarTarea(${data.tarea.id})"
                        >
                        <div>
                            <p class="text-sm font-medium text-gray-900">${data.tarea.descripcion}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${badgeClass}">
                                ${badgeText}
                            </span>
                        </div>
                    </div>
                    <button
                        onclick="eliminarTarea(${data.tarea.id})"
                        class="text-red-500 hover:text-red-700 transition"
                        title="Eliminar tarea"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                `;

                // Insert at the beginning of the list
                listaTareas.insertBefore(nuevaTarea, listaTareas.firstChild);

                // Animate in
                setTimeout(() => {
                    nuevaTarea.style.transition = 'opacity 0.3s, transform 0.3s';
                    nuevaTarea.style.opacity = '1';
                    nuevaTarea.style.transform = 'translateY(0)';
                }, 10);

                // Clear form
                document.getElementById('nuevaTareaDescripcion').value = '';
                document.getElementById('nuevaTareaPrioridad').value = 'media';
            } else {
                alert('Error al agregar la tarea');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al agregar la tarea');
        }
    });
</script>
@endpush
