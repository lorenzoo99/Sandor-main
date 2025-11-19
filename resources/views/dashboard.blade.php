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
            value="$45,231,890"
            :trend="'up'"
            trendValue="+12.5%"
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
            value="$23,456,000"
            :trend="'down'"
            trendValue="-5.2%"
            color="red"
        >
            <x-slot name="icon">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </x-slot>
        </x-stat-card>

        <x-stat-card
            title="Cuentas por Cobrar"
            value="$12,345,000"
            color="yellow"
        >
            <x-slot name="icon">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </x-slot>
        </x-stat-card>

        <x-stat-card
            title="Facturas Emitidas"
            value="156"
            :trend="'up'"
            trendValue="+8"
            color="blue"
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
                @foreach([
                    ['type' => 'Venta', 'client' => 'Cliente ABC', 'amount' => '+$1,234,500', 'date' => 'Hoy, 10:30 AM', 'positive' => true],
                    ['type' => 'Compra', 'client' => 'Proveedor XYZ', 'amount' => '-$890,000', 'date' => 'Ayer, 3:45 PM', 'positive' => false],
                    ['type' => 'Venta', 'client' => 'Cliente DEF', 'amount' => '+$567,800', 'date' => 'Ayer, 11:20 AM', 'positive' => true],
                    ['type' => 'Nómina', 'client' => 'Empleados', 'amount' => '-$4,500,000', 'date' => '2 días', 'positive' => false],
                ] as $transaction)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full {{ $transaction['positive'] ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center">
                            @if($transaction['positive'])
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
                            <p class="font-medium text-gray-900">{{ $transaction['type'] }}</p>
                            <p class="text-sm text-gray-500">{{ $transaction['client'] }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold {{ $transaction['positive'] ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction['amount'] }}
                        </p>
                        <p class="text-xs text-gray-500">{{ $transaction['date'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <x-slot name="footer">
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Ver todas las transacciones →
                </a>
            </x-slot>
        </x-card>

        <!-- Pending Tasks -->
        <x-card title="Tareas Pendientes">
            <div class="space-y-3">
                @foreach([
                    ['task' => 'Revisar facturas pendientes de aprobación', 'count' => 5, 'priority' => 'high'],
                    ['task' => 'Conciliación bancaria mensual', 'count' => 1, 'priority' => 'high'],
                    ['task' => 'Generar reporte IVA del mes', 'count' => 1, 'priority' => 'medium'],
                    ['task' => 'Actualizar datos de proveedores', 'count' => 3, 'priority' => 'low'],
                    ['task' => 'Revisar cuentas por cobrar vencidas', 'count' => 12, 'priority' => 'medium'],
                ] as $task)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $task['task'] }}</p>
                            @if($task['priority'] === 'high')
                                <x-badge type="error">Alta prioridad</x-badge>
                            @elseif($task['priority'] === 'medium')
                                <x-badge type="warning">Media prioridad</x-badge>
                            @else
                                <x-badge type="default">Baja prioridad</x-badge>
                            @endif
                        </div>
                    </div>
                    <x-badge type="info">{{ $task['count'] }}</x-badge>
                </div>
                @endforeach
            </div>
            <x-slot name="footer">
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Ver todas las tareas →
                </a>
            </x-slot>
        </x-card>
    </div>

    <!-- Quick Actions -->
    <x-card title="Acciones Rápidas">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <a href="{{ route('facturas.crear') }}" class="flex flex-col items-center justify-center p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition group">
                <svg class="w-10 h-10 text-blue-600 mb-3 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-sm font-medium text-gray-900">Nueva Factura</span>
            </a>

            <a href="{{ route('reportes.ingresos-gastos') }}" class="flex flex-col items-center justify-center p-6 bg-purple-50 rounded-lg hover:bg-purple-100 transition group">
                <svg class="w-10 h-10 text-purple-600 mb-3 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-sm font-medium text-gray-900">Generar Reporte</span>
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
