<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: true }" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FarmaProf') }} - @yield('title', 'Sistema Contable')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Heroicons CDN -->
    <script src="https://cdn.jsdelivr.net/npm/heroicons@2.0.18/24/outline/index.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="h-full bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white transform lg:translate-x-0 lg:static lg:inset-0"
        >
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-6 bg-blue-950">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">FarmaProf</h1>
                        <p class="text-xs text-blue-200">Sistema Contable</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 px-3">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 mb-2 text-sm font-medium rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- Gestión de Usuarios -->
                @if(Auth::user()->isSuperAdmin())
                <div x-data="{ open: {{ request()->routeIs('usuarios.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 mb-2 text-sm font-medium text-blue-100 rounded-lg hover:bg-blue-700 transition">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            Usuarios
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="ml-4 space-y-1">
                        <a href="{{ route('usuarios.index') }}" class="flex items-center px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('usuarios.index') ? 'bg-blue-700' : '' }}">
                            Listar Usuarios
                        </a>
                        <a href="{{ route('usuarios.create') }}" class="flex items-center px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('usuarios.create') ? 'bg-blue-700' : '' }}">
                            Crear Usuario
                        </a>
                    </div>
                </div>
                @endif

                <!-- Contabilidad -->
                <div x-data="{ open: {{ request()->routeIs('contabilidad.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 mb-2 text-sm font-medium text-blue-100 rounded-lg hover:bg-blue-700 transition">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Contabilidad
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="ml-4 space-y-1">
                        <a href="{{ route('contabilidad.plan-cuentas') }}" class="flex items-center px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('contabilidad.plan-cuentas') ? 'bg-blue-700' : '' }}">
                            Plan de Cuentas (PUC)
                        </a>
                        <a href="{{ route('contabilidad.asientos') }}" class="flex items-center px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('contabilidad.asientos') || request()->routeIs('contabilidad.ver-asiento') ? 'bg-blue-700' : '' }}">
                            Asientos Contables
                        </a>
                        <a href="{{ route('contabilidad.libro-diario') }}" class="flex items-center px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('contabilidad.libro-diario') ? 'bg-blue-700' : '' }}">
                            Libro Diario
                        </a>
                        <a href="{{ route('contabilidad.libro-mayor') }}" class="flex items-center px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('contabilidad.libro-mayor') ? 'bg-blue-700' : '' }}">
                            Libro Mayor
                        </a>
                        <a href="{{ route('contabilidad.balance-comprobacion') }}" class="flex items-center px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('contabilidad.balance-comprobacion') ? 'bg-blue-700' : '' }}">
                            Balance de Comprobación
                        </a>
                    </div>
                </div>

                <!-- Facturación -->
                <div x-data="{ open: {{ request()->routeIs('facturas.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 mb-2 text-sm font-medium text-blue-100 rounded-lg hover:bg-blue-700 transition">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Facturación
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="ml-4 space-y-1">
                        <a href="{{ route('facturas.index') }}" class="flex items-center px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('facturas.index') || request()->routeIs('facturas.show') ? 'bg-blue-700' : '' }}">
                            Facturas Emitidas
                        </a>
                        <a href="{{ route('facturas.crear') }}" class="flex items-center px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('facturas.crear') ? 'bg-blue-700' : '' }}">
                            Crear Factura
                        </a>
                    </div>
                </div>

                <!-- Compras -->
                <div x-data="{ open: {{ request()->routeIs('compras.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 mb-2 text-sm font-medium text-blue-100 rounded-lg hover:bg-blue-700 transition">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Compras
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="ml-4 space-y-1">
                        <a href="{{ route('compras.index') }}" class="flex items-center px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('compras.index') || request()->routeIs('compras.show') ? 'bg-blue-700' : '' }}">
                            Facturas de Compra
                        </a>
                        <a href="{{ route('compras.crear') }}" class="flex items-center px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('compras.crear') ? 'bg-blue-700' : '' }}">
                            Registrar Compra
                        </a>
                    </div>
                </div>

                <!-- Nómina -->
                <div x-data="{ open: {{ request()->routeIs('nomina.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 mb-2 text-sm font-medium text-blue-100 rounded-lg hover:bg-blue-700 transition">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Nómina
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="ml-4 space-y-1">
                        <a href="{{ route('nomina.empleados.index') }}" class="flex items-center px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('nomina.empleados.*') ? 'bg-blue-700' : '' }}">
                            Empleados
                        </a>
                        <a href="{{ route('nomina.nominas.index') }}" class="flex items-center px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('nomina.nominas.index') || request()->routeIs('nomina.nominas.ver') ? 'bg-blue-700' : '' }}">
                            Nóminas
                        </a>
                        <a href="{{ route('nomina.nominas.procesar') }}" class="flex items-center px-4 py-2 text-sm text-blue-100 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('nomina.nominas.procesar') ? 'bg-blue-700' : '' }}">
                            Procesar Nómina
                        </a>
                    </div>
                </div>

                <!-- Reportes DIAN -->
                <a href="#" class="flex items-center px-4 py-3 mb-2 text-sm font-medium text-blue-100 rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Reportes DIAN
                </a>
            </nav>

            <!-- User Info at Bottom -->
            <div class="absolute bottom-0 w-64 p-4 bg-blue-950">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-blue-700 flex items-center justify-center">
                            <span class="text-sm font-medium">{{ substr(Auth::user()->name, 0, 2) }}</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-blue-300 truncate">{{ Auth::user()->rol }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-blue-300 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation Bar -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between h-16 px-6">
                    <!-- Mobile menu button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Page Title -->
                    <div class="flex-1 px-4 lg:px-0">
                        <h1 class="text-2xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    </div>

                    <!-- Top Right Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="text-gray-400 hover:text-gray-500 relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"></span>
                        </button>

                        <!-- Profile Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                                <span class="hidden md:block text-sm font-medium">{{ Auth::user()->name }}</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mi Perfil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="container mx-auto px-6 py-8">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <x-alert type="success" :message="session('success')" />
                    @endif

                    @if (session('error'))
                        <x-alert type="error" :message="session('error')" />
                    @endif

                    @if (session('warning'))
                        <x-alert type="warning" :message="session('warning')" />
                    @endif

                    @if ($errors->any())
                        <x-alert type="error">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-alert>
                    @endif

                    <!-- Main Content -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
