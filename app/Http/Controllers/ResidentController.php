<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\User;

class ResidentController extends Controller
{
    public function index(Request $request)
    {
        $query = Resident::with('contactUser');

        if ($request->filled('dni')) {
            $query->where('dni', 'like', '%' . $request->dni . '%');
        }

        $residents = $query->get();

        return view('residents.index', compact('residents'));
    }


    public function create()
    {
        $users = User::all();
        return view('residents.create', compact('users'));
    }

    public function store(Request $request)
    {
        $resident = new Resident();
        $resident->dni = $request->dni;
        $resident->name = $request->name;
        $resident->birth_date = $request->birth_date;
        $resident->gender = $request->gender;
        $resident->medical_history = $request->medical_history;
        $resident->allergies = $request->allergies;
        $resident->mood = $request->mood;

        // Buscar usuario por DNI
        $contactUser = null;
        if ($request->contact_user_dni) {
            $contactUser = User::where('dni', $request->contact_user_dni)->first();
        }

        // Guardar solo el ID en la tabla residents
        $resident->contact_user_id = $contactUser ? $contactUser->id : null;
        $resident->contact_relation = $request->contact_relation;

        $resident->save();

        return redirect()->route('residents.index')->with('success', 'Residente creado correctamente');
    }



    public function edit(string $id)
    {
        $resident = Resident::findOrFail($id);
        $users = User::all();
        return view('residents.edit', compact('resident', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'dni' => 'required|unique:residents,dni,' . $id,
            'name' => 'required|string',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Masculino,Femenino,Otro',
            'contact_user_id' => 'nullable|exists:users,id',
            'contact_relation' => 'nullable|string',
        ]);

        $resident = Resident::findOrFail($id);
        $resident->dni = $request->dni;
        $resident->name = $request->name;
        $resident->birth_date = $request->birth_date;
        $resident->gender = $request->gender;
        $resident->medical_history = $request->medical_history;
        $resident->allergies = $request->allergies;
        $resident->mood = $request->mood;
        $resident->contact_user_id = $request->contact_user_id;
        $resident->contact_relation = $request->contact_relation; // ← nuevo

        $resident->save();

        return redirect()->route('residents.index')->with('success', 'Residente actualizado correctamente.');
    }


    public function destroy(string $id)
    {
        $resident = Resident::findOrFail($id);
        $resident->delete();

        return redirect()->route('residents.index');
    }



    public function searchByDni($dni)
{
    $resident = Resident::where('dni', $dni)->first();

    if ($resident) {
        return response()->json([
            'success' => true,
            'resident' => $resident
        ]);
    }

    return response()->json(['success' => false]);
}

}
