<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function index()
    {
        return response()->json(Resident::with('contact')->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'birth_date'      => 'required|date',
            'gender'          => 'required|string',
            'medical_history' => 'nullable|string',
            'allergies'       => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'mood'            => 'nullable|string|max:255',
            'contact_user_id' => 'nullable|exists:users,id',
        ]);

        $resident = Resident::create($validated);

        return response()->json($resident, 201);
    }

    public function show(Resident $resident)
    {
        return response()->json($resident->load('contact'), 200);
    }

    public function update(Request $request, Resident $resident)
    {
        $validated = $request->validate([
            'name'            => 'sometimes|string|max:255',
            'birth_date'      => 'sometimes|date',
            'gender'          => 'sometimes|string',
            'medical_history' => 'nullable|string',
            'allergies'       => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'mood'            => 'nullable|string|max:255',
            'contact_user_id' => 'nullable|exists:users,id',
        ]);

        $resident->update($validated);

        return response()->json($resident, 200);
    }

    public function destroy(Resident $resident)
    {
        $resident->delete();
        return response()->json(null, 204);
    }
}
