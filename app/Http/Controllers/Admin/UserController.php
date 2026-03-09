<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
   /*
    public function index()
    {
        $users = User::all(); 
        return view('admin.users.index', compact('users'));
    }

    /**
     * Formulario para crear un nuevo usuario manualmente.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Guardar el nuevo usuario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,clubber,organizer'] 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Mostrar detalles (opcional, normalmente con edit sobra).
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Editar un usuario específico.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualizar los datos del usuario.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'string'],
        ]);

        $user->fill($request->only('name', 'email', 'role'));

        // Solo actualizamos el password si el admin escribió algo en el campo
        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', Rules\Password::defaults()]]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.events.index')->with('success', 'Usuario actualizado.');
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propia cuenta de administrador.');
        }

        $user->delete();

        return redirect()->route('admin.events.index')->with('success', 'Usuario eliminado.');
    }
}