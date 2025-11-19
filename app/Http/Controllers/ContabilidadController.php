<?php

namespace App\Http\Controllers;

use App\Models\CuentaContable;
use App\Models\AsientoContable;
use App\Models\DetalleAsiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContabilidadController extends Controller
{
    /**
     * Plan de Cuentas (PUC)
     */
    public function planCuentas(Request $request)
    {
        $query = CuentaContable::query();

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('nombre', 'like', "%{$search}%");
            });
        }

        // Filtro por tipo
        if ($request->has('tipo') && $request->tipo !== '') {
            $query->where('tipo', $request->tipo);
        }

        // Filtro por nivel
        if ($request->has('nivel') && $request->nivel !== '') {
            $query->where('nivel', $request->nivel);
        }

        $cuentas = $query->orderBy('codigo')->paginate(50);

        return view('contabilidad.plan-cuentas', compact('cuentas'));
    }

    /**
     * Listar asientos contables
     */
    public function asientos(Request $request)
    {
        $query = AsientoContable::with('usuario', 'detalles.cuenta');

        // Filtro por fecha
        if ($request->has('fecha_desde')) {
            $query->whereDate('fecha', '>=', $request->fecha_desde);
        }
        if ($request->has('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $request->fecha_hasta);
        }

        // Búsqueda por descripción
        if ($request->has('search')) {
            $query->where('descripcion', 'like', "%{$request->search}%");
        }

        $asientos = $query->orderBy('fecha', 'desc')
                          ->orderBy('id_asiento', 'desc')
                          ->paginate(20);

        return view('contabilidad.asientos', compact('asientos'));
    }

    /**
     * Ver detalle de un asiento
     */
    public function verAsiento(AsientoContable $asiento)
    {
        $asiento->load('usuario', 'detalles.cuenta');
        return view('contabilidad.ver-asiento', compact('asiento'));
    }

    /**
     * Libro Diario
     */
    public function libroDiario(Request $request)
    {
        $query = AsientoContable::with('detalles.cuenta');

        // Filtro por fecha
        $fechaDesde = $request->get('fecha_desde', now()->startOfMonth()->format('Y-m-d'));
        $fechaHasta = $request->get('fecha_hasta', now()->endOfMonth()->format('Y-m-d'));

        $query->whereDate('fecha', '>=', $fechaDesde)
              ->whereDate('fecha', '<=', $fechaHasta);

        $asientos = $query->orderBy('fecha')
                          ->orderBy('id_asiento')
                          ->get();

        return view('contabilidad.libro-diario', compact('asientos', 'fechaDesde', 'fechaHasta'));
    }

    /**
     * Libro Mayor
     */
    public function libroMayor(Request $request)
    {
        $fechaDesde = $request->get('fecha_desde', now()->startOfMonth()->format('Y-m-d'));
        $fechaHasta = $request->get('fecha_hasta', now()->endOfMonth()->format('Y-m-d'));
        $cuentaId = $request->get('cuenta_id');

        $cuentas = CuentaContable::activas()->orderBy('codigo')->get();

        $movimientos = [];
        $cuenta = null;

        if ($cuentaId) {
            $cuenta = CuentaContable::find($cuentaId);

            // Obtener movimientos de la cuenta
            $movimientos = DetalleAsiento::with('asiento', 'cuenta')
                ->where('id_cuenta', $cuentaId)
                ->whereHas('asiento', function($q) use ($fechaDesde, $fechaHasta) {
                    $q->whereDate('fecha', '>=', $fechaDesde)
                      ->whereDate('fecha', '<=', $fechaHasta);
                })
                ->get()
                ->map(function($detalle) {
                    return [
                        'fecha' => $detalle->asiento->fecha,
                        'descripcion' => $detalle->asiento->descripcion,
                        'debito' => $detalle->tipo_movimiento === 'DEBITO' ? $detalle->valor : 0,
                        'credito' => $detalle->tipo_movimiento === 'CREDITO' ? $detalle->valor : 0,
                    ];
                })
                ->sortBy('fecha')
                ->values();
        }

        return view('contabilidad.libro-mayor', compact('cuentas', 'cuenta', 'movimientos', 'fechaDesde', 'fechaHasta'));
    }

    /**
     * Balance de Comprobación
     */
    public function balanceComprobacion(Request $request)
    {
        $fechaDesde = $request->get('fecha_desde', now()->startOfMonth()->format('Y-m-d'));
        $fechaHasta = $request->get('fecha_hasta', now()->endOfMonth()->format('Y-m-d'));

        // Obtener todas las cuentas con movimientos
        $cuentas = DB::select("
            SELECT
                c.id_cuenta,
                c.codigo,
                c.nombre,
                c.tipo,
                COALESCE(SUM(CASE WHEN d.tipo_movimiento = 'DEBITO' THEN d.valor ELSE 0 END), 0) as total_debito,
                COALESCE(SUM(CASE WHEN d.tipo_movimiento = 'CREDITO' THEN d.valor ELSE 0 END), 0) as total_credito
            FROM CuentaContable c
            LEFT JOIN DetalleAsiento d ON c.id_cuenta = d.id_cuenta
            LEFT JOIN AsientoContable a ON d.id_asiento = a.id_asiento
            WHERE c.estado = 1
                AND (a.fecha IS NULL OR (a.fecha >= ? AND a.fecha <= ?))
            GROUP BY c.id_cuenta, c.codigo, c.nombre, c.tipo
            HAVING total_debito > 0 OR total_credito > 0
            ORDER BY c.codigo
        ", [$fechaDesde, $fechaHasta]);

        // Calcular totales
        $totalDebito = array_sum(array_column($cuentas, 'total_debito'));
        $totalCredito = array_sum(array_column($cuentas, 'total_credito'));

        return view('contabilidad.balance-comprobacion', compact('cuentas', 'totalDebito', 'totalCredito', 'fechaDesde', 'fechaHasta'));
    }
}
