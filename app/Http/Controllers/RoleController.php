<?php

namespace App\Http\Controllers;

use App\Enums\Membership;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function edit(int $id, Request $request): RedirectResponse
    {
        if (session('role') !== 'administrador') {
            return redirect('/')->with('message', ['danger', 'No tienes autorización a cambiar estos datos']);
        }

        $data = $request->validate([
            'role' => ['required', 'array'],
            'role.*' => ['required', Rule::enum(Membership::class)],
        ], [
            'role.*.required' => 'Debes ingresar un rol de usuario valido',
            'role.*.enum' => 'Debes ingresar un rol de usuario valido',
        ]);

        Role::updateOrCreate(
            ['id_business' => $id],
            ['role' => array_values($data['role'])[0]]
        );

        return back()->with('message', ['success', 'Datos actualizados ' . $id]);
    }
}
