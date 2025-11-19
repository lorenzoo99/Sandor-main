<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Nomina;
use App\Models\AsientoContable;
use App\Models\DetalleAsiento;
use App\Models\CuentaContable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NominaController extends Controller
{
    // ============================================
    // GESTIÓN DE EMPLEADOS
    // ============================================

    /**
     * Listar empleados
     */
    public function indexEmpleados(Request $request)
    {
        $query = Empleado::query();

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('numero_identificacion', 'like', "%{$search}%")
                  ->orWhere('cargo', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->has('estado') && $request->estado !== '') {
            $query->where('estado', $request->estado);
        }

        $empleados = $query->orderBy('nombre')->paginate(15);

        return view('nomina.empleados.index', compact('empleados'));
    }

    /**
     * Mostrar formulario crear empleado
     */
    public function crearEmpleado()
    {
        return view('nomina.empleados.crear');
    }

    /**
     * Guardar empleado
     */
    public function guardarEmpleado(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'tipo_identificacion' => 'required|in:CC,CE,NIT',
            'numero_identificacion' => 'required|string|max:30|unique:Empleado,numero_identificacion',
            'cargo' => 'required|string|max:100',
            'salario_base' => 'required|numeric|min:0',
            'fecha_ingreso' => 'required|date',
            'telefono' => 'nullable|string|max:30',
            'correo' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:200'
        ]);

        Empleado::create([
            'nombre' => $request->nombre,
            'tipo_identificacion' => $request->tipo_identificacion,
            'numero_identificacion' => $request->numero_identificacion,
            'cargo' => $request->cargo,
            'salario_base' => $request->salario_base,
            'fecha_ingreso' => $request->fecha_ingreso,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'estado' => 1
        ]);

        return redirect()->route('nomina.empleados.index')
            ->with('success', 'Empleado registrado exitosamente.');
    }

    /**
     * Ver detalles de empleado
     */
    public function verEmpleado(Empleado $empleado)
    {
        $empleado->load('nominas');
        return view('nomina.empleados.ver', compact('empleado'));
    }

    /**
     * Mostrar formulario editar empleado
     */
    public function editarEmpleado(Empleado $empleado)
    {
        return view('nomina.empleados.editar', compact('empleado'));
    }

    /**
     * Actualizar empleado
     */
    public function actualizarEmpleado(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'cargo' => 'required|string|max:100',
            'salario_base' => 'required|numeric|min:0',
            'telefono' => 'nullable|string|max:30',
            'correo' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:200'
        ]);

        $empleado->update([
            'nombre' => $request->nombre,
            'cargo' => $request->cargo,
            'salario_base' => $request->salario_base,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'direccion' => $request->direccion
        ]);

        return redirect()->route('nomina.empleados.index')
            ->with('success', 'Empleado actualizado exitosamente.');
    }

    /**
     * Cambiar estado de empleado
     */
    public function toggleEstadoEmpleado(Empleado $empleado)
    {
        $empleado->update(['estado' => $empleado->estado == 1 ? 0 : 1]);

        $mensaje = $empleado->estado == 1 ? 'activado' : 'desactivado';
        return redirect()->back()
            ->with('success', "Empleado {$mensaje} exitosamente.");
    }

    // ============================================
    // GESTIÓN DE NÓMINA
    // ============================================

    /**
     * Listar nóminas
     */
    public function indexNominas(Request $request)
    {
        $query = Nomina::with('empleado');

        // Filtro por período
        if ($request->has('periodo') && $request->periodo !== '') {
            $query->where('periodo', $request->periodo);
        }

        // Filtro por estado
        if ($request->has('estado') && $request->estado !== '') {
            $query->where('estado', $request->estado);
        }

        $nominas = $query->orderBy('fecha_pago', 'desc')->paginate(15);

        return view('nomina.nominas.index', compact('nominas'));
    }

    /**
     * Mostrar formulario procesar nómina
     */
    public function procesarNomina()
    {
        $empleados = Empleado::activos()->orderBy('nombre')->get();
        $periodoActual = now()->format('Y-m');

        return view('nomina.nominas.procesar', compact('empleados', 'periodoActual'));
    }

    /**
     * Guardar nómina procesada
     */
    public function guardarNomina(Request $request)
    {
        $request->validate([
            'periodo' => 'required|string',
            'fecha_pago' => 'required|date',
            'empleados' => 'required|array|min:1',
            'empleados.*' => 'exists:Empleado,id_empleado'
        ]);

        DB::beginTransaction();

        try {
            $empleadosIds = $request->empleados;
            $empleados = Empleado::whereIn('id_empleado', $empleadosIds)->get();

            $nominasCreadas = [];

            foreach ($empleados as $empleado) {
                // Verificar si ya existe nómina para este período
                $existente = Nomina::where('id_empleado', $empleado->id_empleado)
                    ->where('periodo', $request->periodo)
                    ->first();

                if ($existente) {
                    continue; // Saltar si ya existe
                }

                // Calcular deducciones
                $deduccionSalud = $empleado->calcularSalud();
                $deduccionPension = $empleado->calcularPension();
                $totalDeducciones = $deduccionSalud + $deduccionPension;
                $salarioNeto = $empleado->salario_base - $totalDeducciones;

                // Crear registro de nómina
                $nomina = Nomina::create([
                    'id_empleado' => $empleado->id_empleado,
                    'periodo' => $request->periodo,
                    'fecha_pago' => $request->fecha_pago,
                    'salario_base' => $empleado->salario_base,
                    'deduccion_salud' => $deduccionSalud,
                    'deduccion_pension' => $deduccionPension,
                    'total_deducciones' => $totalDeducciones,
                    'salario_neto' => $salarioNeto,
                    'estado' => 'PENDIENTE',
                    'id_usuario' => Auth::user()->id_usuario
                ]);

                $nominasCreadas[] = $nomina;
            }

            // Generar asiento contable consolidado
            if (count($nominasCreadas) > 0) {
                $this->generarAsientoNomina($nominasCreadas, $request->periodo);
            }

            DB::commit();

            return redirect()->route('nomina.nominas.index')
                ->with('success', "Nómina del período {$request->periodo} procesada exitosamente para " . count($nominasCreadas) . " empleado(s).");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al procesar la nómina: ' . $e->getMessage());
        }
    }

    /**
     * Ver detalles de nómina
     */
    public function verNomina(Nomina $nomina)
    {
        $nomina->load('empleado', 'usuario');
        return view('nomina.nominas.ver', compact('nomina'));
    }

    /**
     * Marcar nómina como pagada
     */
    public function marcarPagada(Nomina $nomina)
    {
        if ($nomina->estaPagada()) {
            return redirect()->back()
                ->with('error', 'La nómina ya está marcada como pagada.');
        }

        DB::beginTransaction();

        try {
            $nomina->update(['estado' => 'PAGADA']);

            // Generar asiento contable de pago
            $this->generarAsientoPagoNomina($nomina);

            DB::commit();

            return redirect()->back()
                ->with('success', "Nómina marcada como pagada.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al marcar como pagada: ' . $e->getMessage());
        }
    }

    // ============================================
    // ASIENTOS CONTABLES
    // ============================================

    /**
     * Generar asiento contable al procesar nómina
     * DEBITO: 5105 Gastos de Personal (salario base total)
     * CREDITO: 2505 Salarios por Pagar (salario neto total)
     * CREDITO: 2368 Retención Salud (total salud)
     * CREDITO: 2370 Retención Pensión (total pensión)
     */
    private function generarAsientoNomina($nominas, $periodo)
    {
        // Obtener cuentas contables
        $cuentaGastosPersonal = CuentaContable::where('codigo', '5105')->first();
        $cuentaSalariosPorPagar = CuentaContable::where('codigo', '2505')->first();
        $cuentaRetencionSalud = CuentaContable::where('codigo', '2368')->first();
        $cuentaRetencionPension = CuentaContable::where('codigo', '2370')->first();

        if (!$cuentaGastosPersonal || !$cuentaSalariosPorPagar) {
            throw new \Exception('No se encontraron las cuentas contables necesarias. Ejecute el seeder del PUC.');
        }

        // Calcular totales
        $totalSalarioBase = 0;
        $totalSalarioNeto = 0;
        $totalSalud = 0;
        $totalPension = 0;

        foreach ($nominas as $nomina) {
            $totalSalarioBase += $nomina->salario_base;
            $totalSalarioNeto += $nomina->salario_neto;
            $totalSalud += $nomina->deduccion_salud;
            $totalPension += $nomina->deduccion_pension;
        }

        // Crear asiento contable
        $asiento = AsientoContable::create([
            'fecha' => now(),
            'descripcion' => "Causación de nómina período {$periodo}",
            'id_usuario' => Auth::user()->id_usuario,
            'total_debito' => $totalSalarioBase,
            'total_credito' => $totalSalarioBase
        ]);

        // DEBITO: Gastos de Personal (salario base total)
        DetalleAsiento::create([
            'id_asiento' => $asiento->id_asiento,
            'id_cuenta' => $cuentaGastosPersonal->id_cuenta,
            'tipo_movimiento' => 'DEBITO',
            'valor' => $totalSalarioBase
        ]);

        // CREDITO: Salarios por Pagar (salario neto)
        DetalleAsiento::create([
            'id_asiento' => $asiento->id_asiento,
            'id_cuenta' => $cuentaSalariosPorPagar->id_cuenta,
            'tipo_movimiento' => 'CREDITO',
            'valor' => $totalSalarioNeto
        ]);

        // CREDITO: Retención Salud
        if ($totalSalud > 0 && $cuentaRetencionSalud) {
            DetalleAsiento::create([
                'id_asiento' => $asiento->id_asiento,
                'id_cuenta' => $cuentaRetencionSalud->id_cuenta,
                'tipo_movimiento' => 'CREDITO',
                'valor' => $totalSalud
            ]);
        }

        // CREDITO: Retención Pensión
        if ($totalPension > 0 && $cuentaRetencionPension) {
            DetalleAsiento::create([
                'id_asiento' => $asiento->id_asiento,
                'id_cuenta' => $cuentaRetencionPension->id_cuenta,
                'tipo_movimiento' => 'CREDITO',
                'valor' => $totalPension
            ]);
        }
    }

    /**
     * Generar asiento contable al pagar nómina
     * DEBITO: 2505 Salarios por Pagar (salario neto)
     * CREDITO: 1105 Caja (salario neto)
     */
    private function generarAsientoPagoNomina(Nomina $nomina)
    {
        // Obtener cuentas contables
        $cuentaSalariosPorPagar = CuentaContable::where('codigo', '2505')->first();
        $cuentaCaja = CuentaContable::where('codigo', '1105')->first();

        if (!$cuentaSalariosPorPagar || !$cuentaCaja) {
            throw new \Exception('No se encontraron las cuentas contables necesarias.');
        }

        // Crear asiento contable
        $asiento = AsientoContable::create([
            'fecha' => now(),
            'descripcion' => "Pago de nómina a {$nomina->empleado->nombre} - {$nomina->periodo}",
            'id_usuario' => Auth::user()->id_usuario,
            'total_debito' => $nomina->salario_neto,
            'total_credito' => $nomina->salario_neto
        ]);

        // DEBITO: Salarios por Pagar (reducimos la obligación)
        DetalleAsiento::create([
            'id_asiento' => $asiento->id_asiento,
            'id_cuenta' => $cuentaSalariosPorPagar->id_cuenta,
            'tipo_movimiento' => 'DEBITO',
            'valor' => $nomina->salario_neto
        ]);

        // CREDITO: Caja (sale el dinero)
        DetalleAsiento::create([
            'id_asiento' => $asiento->id_asiento,
            'id_cuenta' => $cuentaCaja->id_cuenta,
            'tipo_movimiento' => 'CREDITO',
            'valor' => $nomina->salario_neto
        ]);
    }
}
