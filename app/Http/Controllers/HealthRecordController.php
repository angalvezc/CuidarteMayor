<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HealthRecord;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // <-- necesario para el doctor logueado

class HealthRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = HealthRecord::with(['resident', 'doctor']);

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
        // No necesitamos doctores en el create porque se asigna automáticamente
        return view('health_records.create', compact('residents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|exists:residents,dni',
            'resident_id' => 'required|exists:residents,id|unique:health_records,resident_id',
            'diagnosis' => 'required|string',
            'treatment' => 'nullable|string',
            'record_date' => 'required|date',
            'allergies' => 'nullable|string', // <-- validar alergias
        ]);

        if (HealthRecord::where('resident_id', $request->resident_id)->exists()) {
            return back()->withErrors(['resident_id' => 'Este residente ya tiene un historial médico registrado.']);
        }

        // Crear historial médico
        HealthRecord::create([
            'resident_id' => $request->resident_id,
            'doctor_id'   => Auth::id(), // doctor logueado
            'diagnosis'   => $request->diagnosis,
            'treatment'   => $request->treatment,
            'record_date' => now(),
        ]);

        // Actualizar alergia del residente
        $resident = Resident::find($request->resident_id);
        $resident->update([
            'allergies' => $request->allergies,
        ]);

        return redirect()->route('health_records.index')->with('success', 'Historial registrado correctamente.');
    }


    public function edit(HealthRecord $healthRecord)
    {
        $residents = Resident::all();
        // No necesitamos pasar doctores al edit, se mantiene el que creó
        return view('health_records.edit', compact('healthRecord', 'residents'));
    }

    public function update(Request $request, HealthRecord $healthRecord)
    {
        $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'diagnosis'   => 'required|string',
            'treatment'   => 'nullable|string',
            'alergies'    => 'nullable|string', // validar alergias
            'record_date' => 'required|date',
        ]);

        // Actualizar historial médico
        $healthRecord->update([
            'resident_id' => $request->resident_id,
            'doctor_id'   => auth()->id(), // ahora se guarda el doctor que edita
            'diagnosis'   => $request->diagnosis,
            'treatment'   => $request->treatment,
            'record_date' => now(),
        ]);

        // Actualizar alergias del residente
        $healthRecord->resident->update([
            'allergies' => $request->alergies,
        ]);

        return redirect()->route('health_records.index')->with('success', 'Historial actualizado correctamente.');
    }


    public function destroy(string $id)
    {
        $record = HealthRecord::findOrFail($id);
        $record->delete();

        return redirect()->route('health_records.index');
    }
}
