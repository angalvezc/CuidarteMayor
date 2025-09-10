<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HealthRecord;
use App\Models\Resident;
use App\Models\User;

class HealthRecordController extends Controller
{
    public function index()
    {
        $records = HealthRecord::with(['resident', 'doctor'])->get();
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
        $record = new HealthRecord();
        $record->resident_id = $request->resident_id;
        $record->doctor_id = $request->doctor_id;
        $record->diagnosis = $request->diagnosis;
        $record->treatment = $request->treatment;
        $record->record_date = $request->record_date;
        $record->save();

        return redirect()->route('health_records.index');
    }

    public function edit(string $id)
    {
        $record = HealthRecord::findOrFail($id);
        $residents = Resident::all();
        $doctors = User::all();
        return view('health_records.edit', compact('record', 'residents', 'doctors'));
    }

    public function update(Request $request, string $id)
    {
        $record = HealthRecord::findOrFail($id);
        $record->resident_id = $request->resident_id;
        $record->doctor_id = $request->doctor_id;
        $record->diagnosis = $request->diagnosis;
        $record->treatment = $request->treatment;
        $record->record_date = $request->record_date;
        $record->save();

        return redirect()->route('health_records.index');
    }

    public function destroy(string $id)
    {
        $record = HealthRecord::findOrFail($id);
        $record->delete();

        return redirect()->route('health_records.index');
    }
}
