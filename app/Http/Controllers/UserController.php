<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {

        $users = User::with('role')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $user = new User();
         $user->dni = $request->dni;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route('users.index');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->dni = $request->dni;
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->phone = $request->phone;
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route('users.index');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index');
    }
    // UserController.php
    public function searchByDni($dni)
    {
        $user = User::where('dni', $dni)->first();

        if ($user) {
            return response()->json([
                'success' => true,
                'id' => $user->id,
                'name' => $user->name
            ]);
        }

        return response()->json(['success' => false]);
    }


}
