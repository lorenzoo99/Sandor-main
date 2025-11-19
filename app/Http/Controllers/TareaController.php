<?php

namespace App\Http\Controllers;

use App\Models\TareaPendiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    /**
     * Agregar una nueva tarea
     */
    public function agregar(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'prioridad' => 'required|in:alta,media,baja'
        ]);

        $tarea = TareaPendiente::create([
            'descripcion' => $request->descripcion,
            'prioridad' => $request->prioridad,
            'id_usuario' => Auth::id(),
            'fecha_creacion' => now()
        ]);

        return response()->json([
            'success' => true,
            'tarea' => [
                'id' => $tarea->id_tarea,
                'descripcion' => $tarea->descripcion,
                'prioridad' => $tarea->prioridad
            ]
        ]);
    }

    /**
     * Completar una tarea
     */
    public function completar($id)
    {
        $tarea = TareaPendiente::where('id_tarea', $id)
            ->where('id_usuario', Auth::id())
            ->firstOrFail();

        $tarea->completada = true;
        $tarea->fecha_completada = now();
        $tarea->save();

        return response()->json([
            'success' => true,
            'message' => 'Tarea completada'
        ]);
    }

    /**
     * Eliminar una tarea
     */
    public function eliminar($id)
    {
        $tarea = TareaPendiente::where('id_tarea', $id)
            ->where('id_usuario', Auth::id())
            ->firstOrFail();

        $tarea->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tarea eliminada'
        ]);
    }

    /**
     * Obtener tareas pendientes del usuario
     */
    public function listar()
    {
        $tareas = TareaPendiente::where('id_usuario', Auth::id())
            ->where('completada', false)
            ->orderByRaw("FIELD(prioridad, 'alta', 'media', 'baja')")
            ->orderBy('fecha_creacion', 'desc')
            ->get();

        return response()->json($tareas);
    }
}
