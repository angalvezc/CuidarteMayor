<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\User;

class ResidentController extends Controller
{
    public function index()
    {
        $residents = Resident::with('contactUser')->get();
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
        $resident->contact_user_id = $request->contact_user_id;
        $resident->save();

        return redirect()->route('residents.index');
    }

    public function edit(string $id)
    {
        $resident = Resident::findOrFail($id);
        $users = User::all();
        return view('residents.edit', compact('resident', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $resident = Resident::findOrFail($id);
        $resident->dni = $request->dni;
        $resident->name = $request->name;
        $resident->birth_date = $request->birth_date;
        $resident->gender = $request->gender;
        $resident->medical_history = $request->medical_history;
        $resident->allergies = $request->allergies;
        $resident->mood = $request->mood;
        $resident->contact_user_id = $request->contact_user_id;
        $resident->save();

        return redirect()->route('residents.index');
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
