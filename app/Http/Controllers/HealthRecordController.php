<?php

namespace App\Http\Controllers;

use App\Models\HealthRecord;
use Illuminate\Http\Request;

class HealthRecordController extends Controller
{
    public function index()
    {
        return response()->json(HealthRecord::with(['doctor','resident'])->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id'   => 'required|exists:users,id',
            'resident_id' => 'required|exists:residents,id',
            'description' => 'required|string',
            'date'        => 'required|date',
        ]);

        $record = HealthRecord::create($validated);

        return response()->json($record, 201);
    }

    public function show(HealthRecord $healthRecord)
    {
        return response()->json($healthRecord->load(['doctor','resident']), 200);
    }

    public function update(Request $request, HealthRecord $healthRecord)
    {
        $validated = $request->validate([
            'doctor_id'   => 'sometimes|exists:users,id',
            'resident_id' => 'sometimes|exists:residents,id',
            'description' => 'sometimes|string',
            'date'        => 'sometimes|date',
        ]);

        $healthRecord->update($validated);

        return response()->json($healthRecord, 200);
    }

    public function destroy(HealthRecord $healthRecord)
    {
        $healthRecord->delete();
        return response()->json(null, 204);
    }
}
