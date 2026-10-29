<?php

namespace App\Http\Controllers;

use App\Role;
use App\Rules\nonEmptyFiltered;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function edit($id, Request $request)
    {
        if ("administrador" !== session()->get('role')) {
            return redirect('/')->with('message', ['danger', 'No tienes autorización a cambiar estos datos']);
        }

        $this->validate($request, [
            'role.*' => ['required']
        ], [
            'role.*.required' => "Debes ingresar un rol de usuario valido"
        ]);

        $id_business = $id;
        $role = $request->get('role');

        $roleArray = array_values($role);

        $updateRole = Role::updateOrCreate([
            'id_business' => $id_business
        ], [
            'id_business' => $id_business,
            'role' => $roleArray[0]
        ]);

        return back()->with('message', ['success', 'Datos actualizados ' . $id_business]);
    }
}
