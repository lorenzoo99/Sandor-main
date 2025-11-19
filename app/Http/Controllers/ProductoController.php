<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Listar productos
     */
    public function index(Request $request)
    {
        $query = Producto::query();

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->has('estado') && $request->estado !== '') {
            $query->where('estado', $request->estado);
        }

        // Filtro por IVA
        if ($request->has('iva') && $request->iva !== '') {
            $query->where('porcentaje_iva', $request->iva);
        }

        $productos = $query->orderBy('nombre')->paginate(15);

        return view('productos.index', compact('productos'));
    }

    /**
     * Mostrar formulario crear producto
     */
    public function crear()
    {
        return view('productos.crear');
    }

    /**
     * Guardar producto
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:Producto,codigo',
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'porcentaje_iva' => 'required|numeric|in:0,5,19',
            'stock' => 'required|integer|min:0'
        ]);

        Producto::create([
            'codigo' => strtoupper($request->codigo),
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'porcentaje_iva' => $request->porcentaje_iva,
            'stock' => $request->stock,
            'estado' => 1
        ]);

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Ver detalles de producto
     */
    public function ver(Producto $producto)
    {
        return view('productos.ver', compact('producto'));
    }

    /**
     * Mostrar formulario editar producto
     */
    public function editar(Producto $producto)
    {
        return view('productos.editar', compact('producto'));
    }

    /**
     * Actualizar producto
     */
    public function actualizar(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'porcentaje_iva' => 'required|numeric|in:0,5,19',
            'stock' => 'required|integer|min:0'
        ]);

        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'porcentaje_iva' => $request->porcentaje_iva,
            'stock' => $request->stock
        ]);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Cambiar estado de producto
     */
    public function toggleEstado(Producto $producto)
    {
        $producto->update(['estado' => $producto->estado == 1 ? 0 : 1]);

        $mensaje = $producto->estado == 1 ? 'activado' : 'desactivado';
        return redirect()->back()
            ->with('success', "Producto {$mensaje} exitosamente.");
    }

    /**
     * API: Buscar productos para facturación
     */
    public function buscar(Request $request)
    {
        $search = $request->get('q', '');

        $productos = Producto::activos()
            ->where(function($query) use ($search) {
                $query->where('codigo', 'like', "%{$search}%")
                      ->orWhere('nombre', 'like', "%{$search}%");
            })
            ->limit(20)
            ->get()
            ->map(function($producto) {
                return [
                    'id' => $producto->id_producto,
                    'codigo' => $producto->codigo,
                    'nombre' => $producto->nombre,
                    'precio' => $producto->precio,
                    'porcentaje_iva' => $producto->porcentaje_iva,
                    'iva' => $producto->calcularIva(),
                    'precio_con_iva' => $producto->precioConIva(),
                    'stock' => $producto->stock,
                    'text' => "{$producto->codigo} - {$producto->nombre} - \${$producto->precio}"
                ];
            });

        return response()->json($productos);
    }

    /**
     * API: Obtener detalles de un producto
     */
    public function detalle(Producto $producto)
    {
        return response()->json([
            'id' => $producto->id_producto,
            'codigo' => $producto->codigo,
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion,
            'precio' => $producto->precio,
            'porcentaje_iva' => $producto->porcentaje_iva,
            'iva' => $producto->calcularIva(),
            'precio_con_iva' => $producto->precioConIva(),
            'stock' => $producto->stock
        ]);
    }
}
