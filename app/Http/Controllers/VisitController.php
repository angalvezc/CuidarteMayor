<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function index()
    {
        return response()->json(Visit::with(['resident','user'])->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'visitor_name' => 'required|string|max:255',
            'date'         => 'required|date',
            'resident_id'  => 'required|exists:residents,id',
            'user_id'      => 'required|exists:users,id',
        ]);

        $visit = Visit::create($validated);

        return response()->json($visit, 201);
    }

    public function show(Visit $visit)
    {
        return response()->json($visit->load(['resident','user']), 200);
    }

    public function update(Request $request, Visit $visit)
    {
        $validated = $request->validate([
            'visitor_name' => 'sometimes|string|max:255',
            'date'         => 'sometimes|date',
            'resident_id'  => 'sometimes|exists:residents,id',
            'user_id'      => 'sometimes|exists:users,id',
        ]);

        $visit->update($validated);

        return response()->json($visit, 200);
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();
        return response()->json(null, 204);
    }
}
