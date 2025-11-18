<x-app-layout>
  <h2 class="text-xl font-bold mb-4">Crear factura</h2>

  @if(session('success')) <div class="bg-green-100 p-2 mb-4">{{ session('success') }}</div> @endif
  @if(session('error')) <div class="bg-red-100 p-2 mb-4">{{ session('error') }}</div> @endif

  <form method="POST" action="{{ route('facturas.guardar') }}">
    @csrf

    <!-- Metadatos -->
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label>Prefijo</label>
        <input name="prefijo" value="SETP" class="border rounded w-full" required>
      </div>
      <div>
        <label>Número resolución</label>
        <input name="numero_resolucion" value="18760000001" class="border rounded w-full" required>
      </div>
      <div>
        <label>Medio de pago</label>
        <input name="medio_pago" value="Transferencia" class="border rounded w-full">
      </div>
      <div>
        <label>Forma de pago</label>
        <input name="forma_pago" value="Contado" class="border rounded w-full">
      </div>
      <div>
        <label>Moneda</label>
        <input name="moneda" value="COP" class="border rounded w-full">
      </div>
    </div>

    <!-- Cliente -->
    <div class="mt-4">
      <label>Cliente</label>
      <select name="id_cliente" class="border rounded w-full">
        @foreach($clientes as $cliente)
          <option value="{{ $cliente->id_cliente }}"
            data-nit="{{ $cliente->numero_identificacion }}" 
            data-tipo="{{ $cliente->tipo_identificacion }}">
            {{ $cliente->nombre }} — {{ $cliente->numero_identificacion }}
          </option>
        @endforeach
      </select>
    </div>

    <!-- Items: simple UI con 3 items (podemos mejorar con JS dinámico) -->
    <div class="mt-4">
      <label>Detalles (items)</label>
      <div id="items">
        <div class="item mb-2">
          <input name="items[0][descripcion]" placeholder="Descripción" class="border rounded w-full mb-1" required>
          <div class="grid grid-cols-3 gap-2">
            <input name="items[0][cantidad]" type="number" step="1" placeholder="Cantidad" class="border rounded" required>
            <input name="items[0][valor_unitario]" type="number" step="0.01" placeholder="Valor unitario" class="border rounded" required>
            <input name="items[0][iva]" type="number" step="0.01" placeholder="IVA línea" class="border rounded" value="0.00">
          </div>
        </div>
      </div>

      <button type="button" id="addItem" class="mt-2 bg-gray-200 p-2 rounded">Agregar item</button>
    </div>

    <div class="mt-4">
      <label>Observaciones</label>
      <textarea name="observacion" class="border rounded w-full"></textarea>
    </div>

    <div class="mt-4">
      <label>Subtotal</label>
      <input type="number" step="0.01" name="subtotal" class="border rounded w-full" required>
    </div>
    <div class="mt-3">
      <label>IVA total</label>
      <input type="number" step="0.01" name="iva" class="border rounded w-full" required>
    </div>
    <div class="mt-3">
      <label>Total</label>
      <input type="number" step="0.01" name="total" class="border rounded w-full" required>
    </div>

    <button type="submit" class="bg-blue-500 text-white p-2 rounded mt-4">Guardar y enviar a DIAN</button>
  </form>

  <script>
    let idx = 1;
    document.getElementById('addItem').addEventListener('click', () => {
      const container = document.getElementById('items');
      const html = `
        <div class="item mb-2">
          <input name="items[${idx}][descripcion]" placeholder="Descripción" class="border rounded w-full mb-1" required>
          <div class="grid grid-cols-3 gap-2">
            <input name="items[${idx}][cantidad]" type="number" step="1" placeholder="Cantidad" class="border rounded" required>
            <input name="items[${idx}][valor_unitario]" type="number" step="0.01" placeholder="Valor unitario" class="border rounded" required>
            <input name="items[${idx}][iva]" type="number" step="0.01" placeholder="IVA línea" class="border rounded" value="0.00">
          </div>
        </div>`;
      container.insertAdjacentHTML('beforeend', html);
      idx++;
    });
  </script>
</x-app-layout>
