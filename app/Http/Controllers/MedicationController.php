<?php
namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\HealthRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicationController extends Controller
{
    // Listado de medicamentos
    public function index(Request $request)
    {
        $query = \App\Models\Resident::with(['healthRecords.medications.nurse']);

    if ($request->filled('dni')) {
        $query->where('dni', 'like', '%' . $request->dni . '%');
    }

    $residents = $query->get();

    return view('medications.index', compact('residents'));
    }

    // Formulario de registro
    public function create()
    {
        $healthRecords = HealthRecord::with('resident')->get();
        return view('medications.create', compact('healthRecords'));
    }

    // Guardar medicamento
    public function store(Request $request)
    {
        $request->validate([
            'health_record_id' => 'required|exists:health_records,id',
            'medication_name'  => 'nullable|string|max:255', // Opcional
            'dosage'           => 'required|string|max:255',
            'instructions'     => 'required|string',
        ]);

        Medication::create([
            'health_record_id'   => $request->health_record_id,
            'user_id'            => Auth::id(),
            'name'               => $request->medication_name ?? 'Dosis administrada',
            'dosage'             => $request->dosage,
            'instructions'       => $request->instructions,
            'administration_date'=> now(),
        ]);

        return redirect()->back()->with('success', 'Dosis registrada correctamente.');
    }

    public function complete($healthRecordId)
    {
        $record = \App\Models\HealthRecord::findOrFail($healthRecordId);

        // Aquí puedes crear un registro en medications para marcar que se administró
        \App\Models\Medication::create([
            'health_record_id' => $record->id,
            'user_id' => auth()->id(), // enfermera logueada
            'name' => 'Dosis administrada', // O podrías traer el medicamento real
            'dosage' => null,
            'instructions' => null,
            'administration_date' => now(),
        ]);

        return redirect()->route('medications.index')
            ->with('success', 'Dosis registrada correctamente.');
    }
    // Mostrar todas las dosis de un registro de salud
public function showRecord($healthRecordId)
{
    $record = HealthRecord::with('medications.user', 'resident')->findOrFail($healthRecordId);
    return view('medications.record', compact('record'));
}

// Actualizar dosis
public function update(Request $request, Medication $medication)
{
    $request->validate([
        'dosage' => 'required|string|max:255',
        'instructions' => 'required|string',
    ]);

    $medication->update([
        'dosage' => $request->dosage,
        'instructions' => $request->instructions,
    ]);

    return redirect()->back()->with('success', 'Dosis actualizada correctamente.');
}



}
