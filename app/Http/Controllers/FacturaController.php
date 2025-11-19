<?php

namespace App\Http\Controllers;

use App\Models\FacturaVenta;
use App\Models\DetalleFacturaVenta;
use App\Models\Cliente;
use App\Models\AsientoContable;
use App\Models\DetalleAsiento;
use App\Models\CuentaContable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    /**
     * Listar todas las facturas emitidas
     */
    public function index(Request $request)
    {
        $query = FacturaVenta::with('cliente');

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_factura', 'like', "%{$search}%")
                  ->orWhereHas('cliente', function($q2) use ($search) {
                      $q2->where('nombre', 'like', "%{$search}%");
                  });
            });
        }

        // Filtro por estado
        if ($request->has('estado') && $request->estado !== '') {
            $query->where('estado', $request->estado);
        }

        // Filtro por fecha
        if ($request->has('fecha_desde')) {
            $query->whereDate('fecha_emision', '>=', $request->fecha_desde);
        }
        if ($request->has('fecha_hasta')) {
            $query->whereDate('fecha_emision', '<=', $request->fecha_hasta);
        }

        $facturas = $query->orderBy('fecha_emision', 'desc')->paginate(15);

        return view('facturas.index', compact('facturas'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function crear()
    {
        // Generar próximo número de factura
        $ultimaFactura = FacturaVenta::latest('id_factura')->first();
        $siguienteNumero = $ultimaFactura ?
            intval(str_replace('FV-', '', $ultimaFactura->numero_factura)) + 1 :
            1;
        $numeroFactura = 'FV-' . str_pad($siguienteNumero, 6, '0', STR_PAD_LEFT);

        return view('facturas.crear', compact('numeroFactura'));
    }

    /**
     * Guardar nueva factura
     */
    public function guardar(Request $request)
    {
        // Validación base
        $rules = [
            'tipo_factura' => 'required|in:ELECTRONICA,NORMAL',
            'prefijo' => 'required|string|max:10',
            'numero_resolucion' => 'required|string|max:50',
            'medio_pago' => 'required|string',
            'forma_pago' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.descripcion' => 'required|string',
            'items.*.cantidad' => 'required|numeric|min:1',
            'items.*.valor_unitario' => 'required|numeric|min:0',
        ];

        // Solo requerir datos de cliente si es factura electrónica
        if ($request->tipo_factura === 'ELECTRONICA') {
            $rules['cliente_nombre'] = 'required|string|max:150';
            $rules['cliente_tipo_identificacion'] = 'required|in:CC,CE,NIT';
            $rules['cliente_identificacion'] = 'required|string|max:30';
            $rules['cliente_direccion'] = 'nullable|string|max:200';
            $rules['cliente_telefono'] = 'nullable|string|max:30';
            $rules['cliente_correo'] = 'nullable|email|max:100';
        }

        $request->validate($rules);

        DB::beginTransaction();

        try {
            $idCliente = null;

            // Si es factura electrónica, buscar o crear el cliente
            if ($request->tipo_factura === 'ELECTRONICA') {
                $cliente = Cliente::where('numero_identificacion', $request->cliente_identificacion)->first();

                if (!$cliente) {
                    // Crear nuevo cliente
                    $cliente = Cliente::create([
                        'nombre' => $request->cliente_nombre,
                        'tipo_identificacion' => $request->cliente_tipo_identificacion,
                        'numero_identificacion' => $request->cliente_identificacion,
                        'direccion' => $request->cliente_direccion,
                        'telefono' => $request->cliente_telefono,
                        'correo' => $request->cliente_correo,
                        'fecha_registro' => now()
                    ]);
                }

                $idCliente = $cliente->id_cliente;
            }

            // Calcular totales desde los items
            $subtotal = 0;
            $totalIva = 0;

            foreach ($request->items as $item) {
                $cantidad = floatval($item['cantidad']);
                $valorUnitario = floatval($item['valor_unitario']);
                $ivaItem = isset($item['iva']) ? floatval($item['iva']) : 0;

                $subtotalItem = $cantidad * $valorUnitario;
                $subtotal += $subtotalItem;
                $totalIva += $ivaItem;
            }

            $total = $subtotal + $totalIva;

            // Crear factura
            $factura = FacturaVenta::create([
                'numero_factura' => $request->numero_factura,
                'tipo_factura' => $request->tipo_factura,
                'fecha_emision' => now(),
                'id_cliente' => $idCliente,
                'subtotal' => $subtotal,
                'iva' => $totalIva,
                'total' => $total,
                'estado' => 'PENDIENTE',
                'id_usuario' => Auth::user()->id_usuario,
                'prefijo' => $request->prefijo,
                'numero_resolucion' => $request->numero_resolucion,
                'medio_pago' => $request->medio_pago,
                'forma_pago' => $request->forma_pago,
                'moneda' => $request->moneda ?? 'COP'
            ]);

            // Guardar detalles
            foreach ($request->items as $item) {
                $cantidad = floatval($item['cantidad']);
                $valorUnitario = floatval($item['valor_unitario']);
                $ivaItem = isset($item['iva']) ? floatval($item['iva']) : 0;

                $subtotalItem = $cantidad * $valorUnitario;
                $totalItem = $subtotalItem + $ivaItem;

                DetalleFacturaVenta::create([
                    'id_factura' => $factura->id_factura,
                    'descripcion' => $item['descripcion'],
                    'cantidad' => $cantidad,
                    'valor_unitario' => $valorUnitario,
                    'subtotal' => $subtotalItem,
                    'iva' => $ivaItem,
                    'total' => $totalItem
                ]);
            }

            // Generar asiento contable automático
            $this->generarAsientoVenta($factura);

            DB::commit();

            return redirect()->route('facturas.index')
                ->with('success', "Factura {$factura->numero_factura} creada exitosamente.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear la factura: ' . $e->getMessage());
        }
    }

    /**
     * Ver detalles de una factura
     */
    public function show(FacturaVenta $factura)
    {
        $factura->load('cliente', 'detalles');
        return view('facturas.show', compact('factura'));
    }

    /**
     * Anular factura
     */
    public function anular(FacturaVenta $factura)
    {
        if ($factura->estado === 'ANULADA') {
            return redirect()->back()
                ->with('error', 'La factura ya está anulada.');
        }

        $factura->update(['estado' => 'ANULADA']);

        return redirect()->back()
            ->with('success', "Factura {$factura->numero_factura} anulada exitosamente.");
    }

    /**
     * Marcar factura como pagada
     */
    public function marcarPagada(FacturaVenta $factura)
    {
        if ($factura->estado === 'PAGADA') {
            return redirect()->back()
                ->with('error', 'La factura ya está marcada como pagada.');
        }

        DB::beginTransaction();

        try {
            $factura->update(['estado' => 'PAGADA']);

            // Generar asiento contable de pago
            $this->generarAsientoPago($factura);

            DB::commit();

            return redirect()->back()
                ->with('success', "Factura {$factura->numero_factura} marcada como pagada.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al marcar como pagada: ' . $e->getMessage());
        }
    }

    /**
     * Generar asiento contable al crear factura de venta
     * DEBITO: 1305 Clientes (total)
     * CREDITO: 4135 Ventas (subtotal)
     * CREDITO: 2408 IVA por Pagar (iva)
     */
    private function generarAsientoVenta(FacturaVenta $factura)
    {
        // Obtener cuentas contables
        $cuentaClientes = CuentaContable::where('codigo', '1305')->first();
        $cuentaVentas = CuentaContable::where('codigo', '4135')->first();
        $cuentaIva = CuentaContable::where('codigo', '2408')->first();

        if (!$cuentaClientes || !$cuentaVentas) {
            throw new \Exception('No se encontraron las cuentas contables necesarias. Ejecute el seeder del PUC.');
        }

        // Crear asiento contable
        $asiento = AsientoContable::create([
            'fecha' => $factura->fecha_emision,
            'descripcion' => "Venta según factura {$factura->numero_factura}",
            'id_usuario' => Auth::user()->id_usuario,
            'total_debito' => $factura->total,
            'total_credito' => $factura->total
        ]);

        // DEBITO: Clientes (por el total)
        DetalleAsiento::create([
            'id_asiento' => $asiento->id_asiento,
            'id_cuenta' => $cuentaClientes->id_cuenta,
            'tipo_movimiento' => 'DEBITO',
            'valor' => $factura->total
        ]);

        // CREDITO: Ventas (por el subtotal)
        DetalleAsiento::create([
            'id_asiento' => $asiento->id_asiento,
            'id_cuenta' => $cuentaVentas->id_cuenta,
            'tipo_movimiento' => 'CREDITO',
            'valor' => $factura->subtotal
        ]);

        // CREDITO: IVA por Pagar (si hay IVA)
        if ($factura->iva > 0 && $cuentaIva) {
            DetalleAsiento::create([
                'id_asiento' => $asiento->id_asiento,
                'id_cuenta' => $cuentaIva->id_cuenta,
                'tipo_movimiento' => 'CREDITO',
                'valor' => $factura->iva
            ]);
        }
    }

    /**
     * Generar asiento contable al pagar factura
     * DEBITO: 1105 Caja (total)
     * CREDITO: 1305 Clientes (total)
     */
    private function generarAsientoPago(FacturaVenta $factura)
    {
        // Obtener cuentas contables
        $cuentaCaja = CuentaContable::where('codigo', '1105')->first();
        $cuentaClientes = CuentaContable::where('codigo', '1305')->first();

        if (!$cuentaCaja || !$cuentaClientes) {
            throw new \Exception('No se encontraron las cuentas contables necesarias.');
        }

        // Crear asiento contable
        $asiento = AsientoContable::create([
            'fecha' => now(),
            'descripcion' => "Pago recibido de factura {$factura->numero_factura}",
            'id_usuario' => Auth::user()->id_usuario,
            'total_debito' => $factura->total,
            'total_credito' => $factura->total
        ]);

        // DEBITO: Caja (recibimos el dinero)
        DetalleAsiento::create([
            'id_asiento' => $asiento->id_asiento,
            'id_cuenta' => $cuentaCaja->id_cuenta,
            'tipo_movimiento' => 'DEBITO',
            'valor' => $factura->total
        ]);

        // CREDITO: Clientes (reducimos la cuenta por cobrar)
        DetalleAsiento::create([
            'id_asiento' => $asiento->id_asiento,
            'id_cuenta' => $cuentaClientes->id_cuenta,
            'tipo_movimiento' => 'CREDITO',
            'valor' => $factura->total
        ]);
    }
}
