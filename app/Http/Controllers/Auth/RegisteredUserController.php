<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'correo' => ['required', 'string', 'email', 'max:100', 'unique:Usuario,correo'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contraseña_hash' => Hash::make($request->password),
            'rol' => 'CLIENTE_SAAS',
            'fecha_creacion' => now(),
            'activo' => true,
        ]);


        event(new Registered($usuario));

        Auth::login($usuario);

        return redirect(route('dashboard', absolute: false));
    }
}
