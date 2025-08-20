<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminUserController extends Controller
{
    public function store(Request $request)
    {
        // Verificar que el usuario sea administrador
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'rol' => ['required', 'string', 'in:admin,consultor'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('dashboard')->with('success', 'Usuario registrado exitosamente.');
    }

    // Nuevo método para buscar programador por RUT
    public function buscarPorRut($rut)
    {
        // Verificar que el usuario sea administrador
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para acceder a esta sección.'
            ]);
        }

        // Buscar en las tablas de la misma base de datos
        $resultado = \DB::select("
            SELECT 
                r.DESCRIPCION as oficina,
                t.GRADO_DESCRIPCION as cargo_descripcion,
                p.PEFBNOM as nombre,
                p.PEFBCOD as codigo_programador,
                p.PEFBRUT as rut
            FROM pesbasi p
            JOIN tescalafongrado t ON p.PEFBGRA = t.GRADO_CODIGO AND t.ESCALAFON_CODIGO = p.PEFBESC
            JOIN REPARTICION r ON r.ID_CODIGO_VIGENTE = p.PEFBREP
            WHERE p.PEFBRUT = ?
        ", [$rut]);
        
        if (!empty($resultado)) {
            $programador = $resultado[0];
            return response()->json([
                'success' => true,
                'programador' => [
                    'nombre' => $programador->nombre,
                    'correo' => '', // Este campo no viene en la consulta, se debe ingresar manualmente
                    'cargo' => $programador->cargo_descripcion,
                    'oficina' => $programador->oficina,
                    'departamento' => '', // Este campo no viene en la consulta
                    'rut' => $programador->rut,
                    'codigo_programador' => $programador->codigo_programador,
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Programador no encontrado en la base de datos'
            ]);
        }
    }
}
