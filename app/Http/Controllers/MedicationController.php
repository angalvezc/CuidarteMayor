<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medication;
use App\Models\Resident;
use App\Models\User;

class MedicationController extends Controller
{
    public function index()
    {
        $medications = Medication::with(['resident', 'responsible'])->get();
        return view('medications.index', compact('medications'));
    }

    public function create()
    {
        $residents = Resident::all();
        $users = User::all();
        return view('medications.create', compact('residents', 'users'));
    }

    public function store(Request $request)
    {
        $medication = new Medication();
        $medication->resident_id = $request->resident_id;
        $medication->name = $request->name;
        $medication->dosage = $request->dosage;
        $medication->frequency = $request->frequency;
        $medication->responsible_id = $request->responsible_id;
        $medication->save();

        return redirect()->route('medications.index');
    }

    public function edit(string $id)
    {
        $medication = Medication::findOrFail($id);
        $residents = Resident::all();
        $users = User::all();
        return view('medications.edit', compact('medication', 'residents', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $medication = Medication::findOrFail($id);
        $medication->resident_id = $request->resident_id;
        $medication->name = $request->name;
        $medication->dosage = $request->dosage;
        $medication->frequency = $request->frequency;
        $medication->responsible_id = $request->responsible_id;
        $medication->save();

        return redirect()->route('medications.index');
    }

    public function destroy(string $id)
    {
        $medication = Medication::findOrFail($id);
        $medication->delete();

        return redirect()->route('medications.index');
    }
}
