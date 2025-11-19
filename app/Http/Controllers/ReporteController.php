<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    /**
     * Mostrar reporte de ingresos y gastos
     */
    public function ingresosGastos(Request $request)
    {
        // Obtener mes y año de la petición o usar el actual
        $mes = $request->input('mes', now()->month);
        $anio = $request->input('anio', now()->year);

        // Crear fechas de inicio y fin del periodo
        $fechaInicio = Carbon::create($anio, $mes, 1)->startOfMonth();
        $fechaFin = Carbon::create($anio, $mes, 1)->endOfMonth();

        // Obtener ingresos (Facturas de venta)
        $ingresos = DB::table('Factura')
            ->select(
                DB::raw('COUNT(*) as total_facturas'),
                DB::raw('SUM(subtotal) as subtotal_ingresos'),
                DB::raw('SUM(total_iva) as total_iva'),
                DB::raw('SUM(total) as total_ingresos')
            )
            ->whereBetween('fecha_emision', [$fechaInicio, $fechaFin])
            ->first();

        // Obtener gastos (Compras)
        $gastos = DB::table('Compra')
            ->select(
                DB::raw('COUNT(*) as total_compras'),
                DB::raw('SUM(subtotal) as subtotal_gastos'),
                DB::raw('SUM(total_iva) as total_iva'),
                DB::raw('SUM(total) as total_gastos')
            )
            ->whereBetween('fecha_compra', [$fechaInicio, $fechaFin])
            ->first();

        // Obtener nómina del mes
        $nomina = DB::table('Nomina')
            ->select(
                DB::raw('COUNT(*) as total_nominas'),
                DB::raw('SUM(salario_neto) as total_nomina')
            )
            ->where('periodo', 'like', "$anio-" . str_pad($mes, 2, '0', STR_PAD_LEFT) . '%')
            ->first();

        // Obtener facturas del mes agrupadas por día
        $ingresosPorDia = DB::table('Factura')
            ->select(
                DB::raw('DATE(fecha_emision) as fecha'),
                DB::raw('COUNT(*) as cantidad'),
                DB::raw('SUM(total) as total')
            )
            ->whereBetween('fecha_emision', [$fechaInicio, $fechaFin])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        // Obtener compras del mes agrupadas por día
        $gastosPorDia = DB::table('Compra')
            ->select(
                DB::raw('DATE(fecha_compra) as fecha'),
                DB::raw('COUNT(*) as cantidad'),
                DB::raw('SUM(total) as total')
            )
            ->whereBetween('fecha_compra', [$fechaInicio, $fechaFin])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        // Calcular totales
        $totalIngresos = ($ingresos->total_ingresos ?? 0);
        $totalGastos = ($gastos->total_gastos ?? 0) + ($nomina->total_nomina ?? 0);
        $balance = $totalIngresos - $totalGastos;

        return view('reportes.ingresos-gastos', compact(
            'ingresos',
            'gastos',
            'nomina',
            'totalIngresos',
            'totalGastos',
            'balance',
            'ingresosPorDia',
            'gastosPorDia',
            'mes',
            'anio',
            'fechaInicio',
            'fechaFin'
        ));
    }
}
