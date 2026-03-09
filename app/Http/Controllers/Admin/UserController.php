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
            'nickname' => ['required', 'string', 'max:255'],
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

        return redirect()->route('admin.index')->with('success', 'Usuario creado correctamente.');
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
            'nickname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:admin,clubber,organizer'],
            'points' => ['nullable', 'integer', 'min:0'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max ?
        ]);

        $user->fill($request->only('nickname', 'email', 'role', 'points'));

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return redirect()->route('admin.index')->with('success', 'Usuario actualizado correctamente.');
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

        return redirect()->route('admin.index')->with('success', 'Usuario eliminado.');
    }
}