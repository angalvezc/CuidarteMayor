<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use App\Models\Resident;
use App\Models\User;

class VisitController extends Controller
{
    public function index()
    {
        $visits = Visit::with(['resident', 'user'])->get();
        return view('visits.index', compact('visits'));
    }

    public function create()
    {
        $residents = Resident::all();
        $users = User::all();
        return view('visits.create', compact('residents', 'users'));
    }

    public function store(Request $request)
    {
        $visit = new Visit();
        $visit->resident_id = $request->resident_id;
        $visit->user_id = $request->user_id;
        $visit->visit_date = $request->visit_date;
        $visit->visit_time = $request->visit_time;
        $visit->relationship = $request->relationship;
        $visit->save();

        return redirect()->route('visits.index');
    }

    public function edit(string $id)
    {
        $visit = Visit::findOrFail($id);
        $residents = Resident::all();
        $users = User::all();
        return view('visits.edit', compact('visit', 'residents', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $visit = Visit::findOrFail($id);
        $visit->resident_id = $request->resident_id;
        $visit->user_id = $request->user_id;
        $visit->visit_date = $request->visit_date;
        $visit->visit_time = $request->visit_time;
        $visit->relationship = $request->relationship;
        $visit->save();

        return redirect()->route('visits.index');
    }

    public function destroy(string $id)
    {
        $visit = Visit::findOrFail($id);
        $visit->delete();

        return redirect()->route('visits.index');
    }
}
