<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        // Verificar que el usuario sea administrador
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        // Verificar que el usuario sea administrador
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Verificar que el usuario sea administrador
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'rol' => ['required', 'string', 'in:admin,consultor'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
        ]);

        return redirect()->route('users.index')
                        ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $user)
    {
        // Verificar que el usuario sea administrador
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        // Evitar que un usuario se elimine a sí mismo
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                            ->with('error', 'No puedes eliminarte a ti mismo.');
        }

        $user->delete();

        return redirect()->route('users.index')
                        ->with('success', 'Usuario eliminado exitosamente.');
    }

    public function changePassword(Request $request, User $user)
    {
        // Verificar que el usuario sea administrador
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
                        ->with('success', 'Contraseña actualizada exitosamente.');
    }
}
