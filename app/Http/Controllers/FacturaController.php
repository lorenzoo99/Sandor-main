<?php

namespace App\Http\Controllers;

use App\Models\FacturaVenta;
use App\Models\DetalleFacturaVenta;
use App\Models\Cliente;
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
        $clientes = Cliente::orderBy('nombre')->get();

        // Generar próximo número de factura
        $ultimaFactura = FacturaVenta::latest('id_factura')->first();
        $siguienteNumero = $ultimaFactura ?
            intval(str_replace('FV-', '', $ultimaFactura->numero_factura)) + 1 :
            1;
        $numeroFactura = 'FV-' . str_pad($siguienteNumero, 6, '0', STR_PAD_LEFT);

        return view('facturas.crear', compact('clientes', 'numeroFactura'));
    }

    /**
     * Guardar nueva factura
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:Cliente,id_cliente',
            'prefijo' => 'required|string|max:10',
            'numero_resolucion' => 'required|string|max:50',
            'medio_pago' => 'required|string',
            'forma_pago' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.descripcion' => 'required|string',
            'items.*.cantidad' => 'required|numeric|min:1',
            'items.*.valor_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
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
                'fecha_emision' => now(),
                'id_cliente' => $request->id_cliente,
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

        $factura->update(['estado' => 'PAGADA']);

        return redirect()->back()
            ->with('success', "Factura {$factura->numero_factura} marcada como pagada.");
    }
}
