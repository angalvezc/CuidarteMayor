<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function index()
    {
        return response()->json(Medication::with(['resident','responsible'])->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'dose'          => 'required|string|max:255',
            'resident_id'   => 'required|exists:residents,id',
            'responsible_id'=> 'required|exists:users,id',
        ]);

        $medication = Medication::create($validated);

        return response()->json($medication, 201);
    }

    public function show(Medication $medication)
    {
        return response()->json($medication->load(['resident','responsible']), 200);
    }

    public function update(Request $request, Medication $medication)
    {
        $validated = $request->validate([
            'name'          => 'sometimes|string|max:255',
            'dose'          => 'sometimes|string|max:255',
            'resident_id'   => 'sometimes|exists:residents,id',
            'responsible_id'=> 'sometimes|exists:users,id',
        ]);

        $medication->update($validated);

        return response()->json($medication, 200);
    }

    public function destroy(Medication $medication)
    {
        $medication->delete();
        return response()->json(null, 204);
    }
}
