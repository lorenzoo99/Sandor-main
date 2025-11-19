@extends('layouts.admin')

@section('title', 'Crear Factura')
@section('page-title', 'Nueva Factura de Venta')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('facturas.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    Facturas
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Nueva Factura</span>
                </div>
            </li>
        </ol>
    </nav>

    <form method="POST" action="{{ route('facturas.guardar') }}" id="facturaForm" class="space-y-6">
        @csrf

        <!-- Selector de Tipo de Factura -->
        <x-card>
            <div class="max-w-md">
                <label for="tipo_factura" class="block text-sm font-medium text-gray-700 mb-2">
                    Tipo de Factura <span class="text-red-500">*</span>
                </label>
                <select
                    name="tipo_factura"
                    id="tipo_factura"
                    required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tipo_factura') border-red-500 @enderror"
                    onchange="toggleClienteSection()"
                >
                    <option value="NORMAL" {{ old('tipo_factura', 'NORMAL') === 'NORMAL' ? 'selected' : '' }}>
                        📄 Factura Normal (Venta rápida / POS)
                    </option>
                    <option value="ELECTRONICA" {{ old('tipo_factura') === 'ELECTRONICA' ? 'selected' : '' }}>
                        ⚡ Factura Electrónica (Con datos completos de cliente)
                    </option>
                </select>
                <p class="mt-2 text-xs text-gray-500">
                    <strong>Factura Normal:</strong> Para ventas rápidas sin datos del cliente.<br>
                    <strong>Factura Electrónica:</strong> Requiere datos completos del cliente para la DIAN.
                </p>
                @error('tipo_factura')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </x-card>

        <!-- Información DIAN -->
        <x-card title="📋 Información DIAN" id="dianSection">
            <p class="text-sm text-gray-600 mb-4">Datos requeridos por la DIAN para facturación electrónica</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Número de Factura -->
                <div>
                    <label for="numero_factura" class="block text-sm font-medium text-gray-700 mb-1">
                        Número de Factura <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="numero_factura"
                        id="numero_factura"
                        value="{{ old('numero_factura', $numeroFactura) }}"
                        readonly
                        class="w-full rounded-lg border-gray-300 bg-gray-50 shadow-sm"
                    >
                    <p class="mt-1 text-xs text-gray-500">Generado automáticamente</p>
                </div>

                <!-- Prefijo -->
                <div>
                    <label for="prefijo" class="block text-sm font-medium text-gray-700 mb-1">
                        Prefijo <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="prefijo"
                        id="prefijo"
                        value="{{ old('prefijo', 'FV') }}"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('prefijo') border-red-500 @enderror"
                    >
                    <p class="mt-1 text-xs text-gray-500">Ej: FV, SETP</p>
                    @error('prefijo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Número de Resolución -->
                <div>
                    <label for="numero_resolucion" class="block text-sm font-medium text-gray-700 mb-1">
                        Número de Resolución DIAN <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="numero_resolucion"
                        id="numero_resolucion"
                        value="{{ old('numero_resolucion', '18760000001') }}"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('numero_resolucion') border-red-500 @enderror"
                    >
                    <p class="mt-1 text-xs text-gray-500">Resolución autorizada por la DIAN</p>
                    @error('numero_resolucion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Medio de Pago -->
                <div>
                    <label for="medio_pago" class="block text-sm font-medium text-gray-700 mb-1">
                        Medio de Pago <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="medio_pago"
                        id="medio_pago"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="Efectivo">Efectivo</option>
                        <option value="Transferencia" selected>Transferencia Bancaria</option>
                        <option value="Tarjeta">Tarjeta de Crédito/Débito</option>
                        <option value="Cheque">Cheque</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Cómo pagará el cliente</p>
                </div>

                <!-- Forma de Pago -->
                <div>
                    <label for="forma_pago" class="block text-sm font-medium text-gray-700 mb-1">
                        Forma de Pago <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="forma_pago"
                        id="forma_pago"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="Contado" selected>Contado</option>
                        <option value="Crédito">Crédito</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Contado o crédito</p>
                </div>

                <!-- Moneda -->
                <div>
                    <label for="moneda" class="block text-sm font-medium text-gray-700 mb-1">
                        Moneda
                    </label>
                    <input
                        type="text"
                        name="moneda"
                        id="moneda"
                        value="COP"
                        readonly
                        class="w-full rounded-lg border-gray-300 bg-gray-50 shadow-sm"
                    >
                    <p class="mt-1 text-xs text-gray-500">Pesos colombianos</p>
                </div>
            </div>
        </x-card>

        <!-- Información del Cliente -->
        <x-card title="👤 Información del Cliente" id="clienteSection">
            <p class="text-sm text-gray-600 mb-4">Ingresa los datos del cliente que recibirá la factura electrónica</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Tipo de Persona -->
                <div>
                    <label for="tipo_persona" class="block text-sm font-medium text-gray-700 mb-1">
                        Tipo de Persona <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="tipo_persona"
                        id="tipo_persona"
                        onchange="updateTipoIdentificacion()"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tipo_persona') border-red-500 @enderror"
                    >
                        <option value="NATURAL" {{ old('tipo_persona', 'NATURAL') === 'NATURAL' ? 'selected' : '' }}>
                            👤 Persona Natural (CC/CE)
                        </option>
                        <option value="JURIDICA" {{ old('tipo_persona') === 'JURIDICA' ? 'selected' : '' }}>
                            🏢 Persona Jurídica (NIT)
                        </option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Selecciona si es persona o empresa</p>
                    @error('tipo_persona')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo de Identificación -->
                <div>
                    <label for="cliente_tipo_identificacion" class="block text-sm font-medium text-gray-700 mb-1">
                        Tipo de Identificación <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="cliente_tipo_identificacion"
                        id="cliente_tipo_identificacion"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('cliente_tipo_identificacion') border-red-500 @enderror"
                    >
                        <option value="CC" {{ old('cliente_tipo_identificacion', 'CC') === 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía (CC)</option>
                        <option value="CE" {{ old('cliente_tipo_identificacion') === 'CE' ? 'selected' : '' }}>Cédula de Extranjería (CE)</option>
                        <option value="NIT" {{ old('cliente_tipo_identificacion') === 'NIT' ? 'selected' : '' }}>NIT</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Documento de identificación</p>
                    @error('cliente_tipo_identificacion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nombre/Razón Social -->
                <div>
                    <label for="cliente_nombre" class="block text-sm font-medium text-gray-700 mb-1">
                        <span id="label_nombre">Nombre Completo</span> <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="cliente_nombre"
                        id="cliente_nombre"
                        value="{{ old('cliente_nombre') }}"
                        placeholder="Ej: Juan Pérez o Empresa S.A.S."
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('cliente_nombre') border-red-500 @enderror"
                    >
                    <p class="mt-1 text-xs text-gray-500">Nombre completo o razón social</p>
                    @error('cliente_nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Número de Identificación -->
                <div>
                    <label for="cliente_identificacion" class="block text-sm font-medium text-gray-700 mb-1">
                        Número de Identificación <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="cliente_identificacion"
                        id="cliente_identificacion"
                        value="{{ old('cliente_identificacion') }}"
                        placeholder="Ej: 1234567890"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('cliente_identificacion') border-red-500 @enderror"
                    >
                    <p class="mt-1 text-xs text-gray-500">Número de cédula o NIT</p>
                    @error('cliente_identificacion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dirección -->
                <div>
                    <label for="cliente_direccion" class="block text-sm font-medium text-gray-700 mb-1">
                        Dirección
                    </label>
                    <input
                        type="text"
                        name="cliente_direccion"
                        id="cliente_direccion"
                        value="{{ old('cliente_direccion') }}"
                        placeholder="Ej: Calle 123 #45-67"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                    <p class="mt-1 text-xs text-gray-500">Dirección física (opcional)</p>
                </div>

                <!-- Teléfono -->
                <div>
                    <label for="cliente_telefono" class="block text-sm font-medium text-gray-700 mb-1">
                        Teléfono
                    </label>
                    <input
                        type="text"
                        name="cliente_telefono"
                        id="cliente_telefono"
                        value="{{ old('cliente_telefono') }}"
                        placeholder="Ej: 3001234567"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                    <p class="mt-1 text-xs text-gray-500">Teléfono o celular (opcional)</p>
                </div>

                <!-- Correo Electrónico -->
                <div class="md:col-span-2">
                    <label for="cliente_correo" class="block text-sm font-medium text-gray-700 mb-1">
                        Correo Electrónico
                    </label>
                    <input
                        type="email"
                        name="cliente_correo"
                        id="cliente_correo"
                        value="{{ old('cliente_correo') }}"
                        placeholder="cliente@ejemplo.com"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                    <p class="mt-1 text-xs text-gray-500">Correo para envío de factura electrónica (opcional)</p>
                </div>
            </div>
        </x-card>

        <!-- Productos/Servicios -->
        <x-card title="🛒 Productos o Servicios">
            <p class="text-sm text-gray-600 mb-4">Agrega los productos o servicios que incluye esta factura</p>

            <div id="items-container" class="space-y-4">
                <!-- Item 1 (inicial) -->
                <div class="item-row border border-gray-200 rounded-lg p-4 bg-gray-50">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-medium text-gray-700">Item #1</h4>
                        <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-800 text-sm hidden">
                            Eliminar
                        </button>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <!-- Descripción -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Descripción del Producto/Servicio <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="items[0][descripcion]"
                                placeholder="Ej: Ibuprofeno 400mg x 30 tabletas"
                                required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <div class="grid grid-cols-4 gap-3">
                            <!-- Cantidad -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Cantidad <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    name="items[0][cantidad]"
                                    min="1"
                                    step="1"
                                    value="1"
                                    required
                                    onchange="calcularTotales()"
                                    class="cantidad w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                >
                                <p class="mt-1 text-xs text-gray-500">Unidades</p>
                            </div>

                            <!-- Valor Unitario -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Valor Unitario <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    name="items[0][valor_unitario]"
                                    min="0"
                                    step="0.01"
                                    value="0"
                                    required
                                    onchange="calcularTotales()"
                                    class="valor-unitario w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                >
                                <p class="mt-1 text-xs text-gray-500">Precio c/u</p>
                            </div>

                            <!-- IVA -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    IVA (opcional)
                                </label>
                                <input
                                    type="number"
                                    name="items[0][iva]"
                                    min="0"
                                    step="0.01"
                                    value="0"
                                    onchange="calcularTotales()"
                                    class="iva-item w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                >
                                <p class="mt-1 text-xs text-gray-500">IVA del item</p>
                            </div>

                            <!-- Subtotal Item -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Subtotal
                                </label>
                                <input
                                    type="text"
                                    readonly
                                    value="$0"
                                    class="subtotal-item w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm"
                                >
                                <p class="mt-1 text-xs text-gray-500">Calculado</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button
                type="button"
                onclick="agregarItem()"
                class="mt-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition inline-flex items-center"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Agregar otro item
            </button>
        </x-card>

        <!-- Totales -->
        <x-card title="💰 Totales de la Factura">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subtotal</label>
                        <div class="text-2xl font-bold text-gray-900" id="display-subtotal">$0</div>
                        <p class="text-xs text-gray-500 mt-1">Sin IVA</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">IVA Total</label>
                        <div class="text-2xl font-bold text-gray-900" id="display-iva">$0</div>
                        <p class="text-xs text-gray-500 mt-1">Impuestos</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total a Pagar</label>
                        <div class="text-3xl font-bold text-blue-600" id="display-total">$0</div>
                        <p class="text-xs text-gray-500 mt-1">Subtotal + IVA</p>
                    </div>
                </div>
            </div>
        </x-card>

        <!-- Botones de Acción -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a
                href="{{ route('facturas.index') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium"
            >
                Cancelar
            </a>
            <button
                type="submit"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium inline-flex items-center text-lg"
            >
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Guardar Factura
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
let itemIndex = 1;

function agregarItem() {
    const container = document.getElementById('items-container');
    const newIndex = itemIndex;

    const itemHTML = `
        <div class="item-row border border-gray-200 rounded-lg p-4 bg-gray-50">
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-medium text-gray-700">Item #${newIndex + 1}</h4>
                <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-800 text-sm">
                    Eliminar
                </button>
            </div>

            <div class="grid grid-cols-1 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Descripción del Producto/Servicio <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="items[${newIndex}][descripcion]"
                        placeholder="Ej: Ibuprofeno 400mg x 30 tabletas"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>

                <div class="grid grid-cols-4 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Cantidad <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            name="items[${newIndex}][cantidad]"
                            min="1"
                            step="1"
                            value="1"
                            required
                            onchange="calcularTotales()"
                            class="cantidad w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                        <p class="mt-1 text-xs text-gray-500">Unidades</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Valor Unitario <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            name="items[${newIndex}][valor_unitario]"
                            min="0"
                            step="0.01"
                            value="0"
                            required
                            onchange="calcularTotales()"
                            class="valor-unitario w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                        <p class="mt-1 text-xs text-gray-500">Precio c/u</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            IVA (opcional)
                        </label>
                        <input
                            type="number"
                            name="items[${newIndex}][iva]"
                            min="0"
                            step="0.01"
                            value="0"
                            onchange="calcularTotales()"
                            class="iva-item w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                        <p class="mt-1 text-xs text-gray-500">IVA del item</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Subtotal
                        </label>
                        <input
                            type="text"
                            readonly
                            value="$0"
                            class="subtotal-item w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm"
                        >
                        <p class="mt-1 text-xs text-gray-500">Calculado</p>
                    </div>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', itemHTML);
    itemIndex++;
    calcularTotales();
}

function removeItem(button) {
    button.closest('.item-row').remove();
    calcularTotales();
}

function calcularTotales() {
    let subtotalTotal = 0;
    let ivaTotal = 0;

    document.querySelectorAll('.item-row').forEach((item, index) => {
        const cantidad = parseFloat(item.querySelector('.cantidad').value) || 0;
        const valorUnitario = parseFloat(item.querySelector('.valor-unitario').value) || 0;
        const ivaItem = parseFloat(item.querySelector('.iva-item').value) || 0;

        const subtotalItem = cantidad * valorUnitario;

        // Actualizar subtotal del item
        item.querySelector('.subtotal-item').value = formatCurrency(subtotalItem);

        subtotalTotal += subtotalItem;
        ivaTotal += ivaItem;
    });

    const total = subtotalTotal + ivaTotal;

    // Actualizar displays
    document.getElementById('display-subtotal').textContent = formatCurrency(subtotalTotal);
    document.getElementById('display-iva').textContent = formatCurrency(ivaTotal);
    document.getElementById('display-total').textContent = formatCurrency(total);
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount);
}

// Actualizar tipo de identificación según tipo de persona
function updateTipoIdentificacion() {
    const tipoPersona = document.getElementById('tipo_persona').value;
    const tipoIdentificacion = document.getElementById('cliente_tipo_identificacion');
    const labelNombre = document.getElementById('label_nombre');

    if (tipoPersona === 'JURIDICA') {
        // Persona Jurídica: solo NIT
        tipoIdentificacion.value = 'NIT';
        tipoIdentificacion.innerHTML = '<option value="NIT">NIT</option>';
        labelNombre.textContent = 'Razón Social';
    } else {
        // Persona Natural: CC o CE
        tipoIdentificacion.innerHTML = `
            <option value="CC">Cédula de Ciudadanía (CC)</option>
            <option value="CE">Cédula de Extranjería (CE)</option>
        `;
        labelNombre.textContent = 'Nombre Completo';
    }
}

// Mostrar/Ocultar secciones según tipo de factura
function toggleClienteSection() {
    const tipoFactura = document.getElementById('tipo_factura').value;
    const clienteSection = document.getElementById('clienteSection');
    const dianSection = document.getElementById('dianSection');

    if (tipoFactura === 'ELECTRONICA') {
        // Mostrar secciones de cliente y DIAN para factura electrónica
        clienteSection.style.display = 'block';
        dianSection.style.display = 'block';
    } else {
        // Ocultar secciones de cliente y DIAN para factura normal/POS
        clienteSection.style.display = 'none';
        dianSection.style.display = 'none';
    }
}

// Calcular totales al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    calcularTotales();
    toggleClienteSection(); // Inicializar estado de sección de cliente
});
</script>
@endpush
@endsection
