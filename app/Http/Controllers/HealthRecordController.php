<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HealthRecord;
use App\Models\Resident;
use App\Models\User;

class HealthRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = HealthRecord::with(['resident', 'doctor']);

        // Si hay búsqueda por DNI
        if ($request->filled('dni')) {
            $query->whereHas('resident', function ($q) use ($request) {
                $q->where('dni', 'like', '%' . $request->dni . '%');
            });
        }

        $records = $query->get();

        return view('health_records.index', compact('records'));
    }

    public function create()
    {
        $residents = Resident::all();
        $doctors = User::all();
        return view('health_records.create', compact('residents', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|exists:residents,dni',
            'resident_id' => 'required|exists:residents,id|unique:health_records,resident_id',
            'doctor_id' => 'required|exists:users,id',
            'diagnosis' => 'required|string',
            'treatment' => 'nullable|string',
            'record_date' => 'required|date',
        ]);

        if (HealthRecord::where('resident_id', $request->resident_id)->exists()) {
            return back()->withErrors(['resident_id' => 'Este residente ya tiene un historial médico registrado.']);
        }

        HealthRecord::create($request->all());

        return redirect()->route('health_records.index')->with('success', 'Historial registrado.');
    }

    public function edit(HealthRecord $healthRecord)
    {
        $residents = Resident::all();
        $doctors = User::all();
        return view('health_records.edit', compact('healthRecord', 'residents', 'doctors'));
    }

    public function update(Request $request, HealthRecord $healthRecord)
    {
        $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'doctor_id' => 'required|exists:users,id',
            'diagnosis' => 'required|string',
            'treatment' => 'nullable|string',
            'record_date' => 'required|date',
        ]);

        $healthRecord->update([
            'resident_id' => $request->resident_id,
            'doctor_id' => $request->doctor_id,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'record_date' => $request->record_date,
        ]);

        return redirect()->route('health_records.index')->with('success', 'Historial actualizado.');
    }

    public function destroy(string $id)
    {
        $record = HealthRecord::findOrFail($id);
        $record->delete();

        return redirect()->route('health_records.index');
    }
}
