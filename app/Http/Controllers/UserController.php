<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = Usuario::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('correo', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('rol') && $request->rol !== '') {
            $query->where('rol', $request->rol);
        }

        // Filter by status
        if ($request->has('activo') && $request->activo !== '') {
            $query->where('activo', $request->activo);
        }

        $usuarios = $query->orderBy('fecha_creacion', 'desc')->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'correo' => ['required', 'string', 'email', 'max:100', 'unique:Usuario,correo'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rol' => ['required', 'in:SUPERADMIN,CLIENTE_SAAS'],
            'activo' => ['boolean'],
        ]);

        Usuario::create([
            'nombre' => $validated['nombre'],
            'correo' => $validated['correo'],
            'contraseña_hash' => Hash::make($validated['password']),
            'rol' => $validated['rol'],
            'fecha_creacion' => now(),
            'activo' => $request->has('activo') ? true : false,
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified user
     */
    public function show(Usuario $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, Usuario $usuario)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'correo' => ['required', 'string', 'email', 'max:100', 'unique:Usuario,correo,'.$usuario->id_usuario.',id_usuario'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'rol' => ['required', 'in:SUPERADMIN,CLIENTE_SAAS'],
            'activo' => ['boolean'],
        ]);

        $updateData = [
            'nombre' => $validated['nombre'],
            'correo' => $validated['correo'],
            'rol' => $validated['rol'],
            'activo' => $request->has('activo') ? true : false,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['contraseña_hash'] = Hash::make($validated['password']);
        }

        $usuario->update($updateData);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified user
     */
    public function destroy(Usuario $usuario)
    {
        // Prevent deleting own account
        if ($usuario->id_usuario === auth()->user()->id_usuario) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(Usuario $usuario)
    {
        $usuario->update([
            'activo' => !$usuario->activo
        ]);

        $status = $usuario->activo ? 'activado' : 'desactivado';

        return redirect()->back()
            ->with('success', "Usuario {$status} exitosamente.");
    }
}
