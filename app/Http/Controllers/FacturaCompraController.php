<?php

namespace App\Http\Controllers;

use App\Models\FacturaCompra;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FacturaCompraController extends Controller
{
    /**
     * Listar todas las facturas de compra
     */
    public function index(Request $request)
    {
        $query = FacturaCompra::with('proveedor');

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_factura', 'like', "%{$search}%")
                  ->orWhereHas('proveedor', function($q2) use ($search) {
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

        return view('compras.index', compact('facturas'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function crear()
    {
        // Generar próximo número de factura de compra
        $ultimaFactura = FacturaCompra::latest('id_factura_compra')->first();
        $siguienteNumero = $ultimaFactura ?
            intval(str_replace('FC-', '', $ultimaFactura->numero_factura)) + 1 :
            1;
        $numeroFactura = 'FC-' . str_pad($siguienteNumero, 6, '0', STR_PAD_LEFT);

        return view('compras.crear', compact('numeroFactura'));
    }

    /**
     * Guardar nueva factura de compra
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'proveedor_nombre' => 'required|string|max:150',
            'proveedor_nit' => 'required|string|max:30',
            'proveedor_direccion' => 'nullable|string|max:200',
            'proveedor_telefono' => 'nullable|string|max:30',
            'proveedor_correo' => 'nullable|email|max:100',
            'subtotal' => 'required|numeric|min:0',
            'iva' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Buscar o crear proveedor
            $proveedor = Proveedor::where('nit', $request->proveedor_nit)->first();

            if (!$proveedor) {
                $proveedor = Proveedor::create([
                    'nombre' => $request->proveedor_nombre,
                    'nit' => $request->proveedor_nit,
                    'direccion' => $request->proveedor_direccion,
                    'telefono' => $request->proveedor_telefono,
                    'correo' => $request->proveedor_correo,
                    'fecha_registro' => now()
                ]);
            }

            // Crear factura de compra
            $factura = FacturaCompra::create([
                'numero_factura' => $request->numero_factura,
                'id_proveedor' => $proveedor->id_proveedor,
                'fecha_emision' => $request->fecha_emision ?? now(),
                'subtotal' => $request->subtotal,
                'iva' => $request->iva,
                'total' => $request->total,
                'estado' => 'PENDIENTE',
                'id_usuario' => Auth::user()->id_usuario
            ]);

            DB::commit();

            return redirect()->route('compras.index')
                ->with('success', "Factura de compra {$factura->numero_factura} registrada exitosamente.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al registrar la factura de compra: ' . $e->getMessage());
        }
    }

    /**
     * Ver detalles de una factura de compra
     */
    public function show(FacturaCompra $factura)
    {
        $factura->load('proveedor');
        return view('compras.show', compact('factura'));
    }

    /**
     * Anular factura de compra
     */
    public function anular(FacturaCompra $factura)
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
    public function marcarPagada(FacturaCompra $factura)
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
