<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use App\Models\Resident;
use App\Models\User;

class VisitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $visits = Visit::with(['resident', 'user'])
            ->when($search, function ($query, $search) {
                $query->whereHas('resident', function ($q) use ($search) {
                    $q->where('dni', 'like', "%{$search}%");
                });
            })
            ->orderBy('visit_date', 'desc')
            ->paginate(10);

        return view('visits.index', compact('visits', 'search'));
    }


    public function create()
    {
        return view('visits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'resident_id'  => 'required|exists:residents,id',
            'user_id'      => 'required|exists:users,id',
            'visit_date'   => 'required|date',
            'visit_time'   => 'required',
            'relationship' => 'required|string',
        ]);

        Visit::create([
            'resident_id'  => $request->resident_id,
            'user_id'      => $request->user_id,
            'visit_date'   => $request->visit_date,
            'visit_time'   => $request->visit_time,
            'relationship' => $request->relationship,
        ]);

        return redirect()->route('visits.index')->with('success', 'Visita registrada correctamente.');
    }

    public function edit(string $id)
    {
        $visit = Visit::findOrFail($id);
        return view('visits.edit', compact('visit'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'resident_id'  => 'required|exists:residents,id',
            'user_id'      => 'required|exists:users,id',
            'visit_date'   => 'required|date',
            'visit_time'   => 'required',
            'relationship' => 'required|string',
        ]);

        $visit = Visit::findOrFail($id);
        $visit->update([
            'resident_id'  => $request->resident_id,
            'user_id'      => $request->user_id,
            'visit_date'   => $request->visit_date,
            'visit_time'   => $request->visit_time,
            'relationship' => $request->relationship,
        ]);

        return redirect()->route('visits.index')->with('success', 'Visita actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $visit = Visit::findOrFail($id);
        $visit->delete();

        return redirect()->route('visits.index')->with('success', 'Visita eliminada.');
    }

    // === Métodos de búsqueda por DNI ===
    public function findResidentByDni(Request $request)
    {
        $resident = Resident::where('dni', $request->dni)->first();
        if ($resident) {
            return response()->json([
                'success' => true,
                'id'      => $resident->id,
                'name'    => $resident->name,
            ]);
        }
        return response()->json(['success' => false]);
    }

    public function findUserByDni(Request $request)
    {
        $user = User::where('dni', $request->dni)->first();
        if ($user) {
            return response()->json([
                'success' => true,
                'id'      => $user->id,
                'name'    => $user->name,
            ]);
        }
        return response()->json(['success' => false]);
    }
}
