<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        return response()->json(Activity::with(['resident','responsible'])->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'schedule'      => 'required|date',
            'resident_id'   => 'required|exists:residents,id',
            'responsible_id'=> 'required|exists:users,id',
        ]);

        $activity = Activity::create($validated);

        return response()->json($activity, 201);
    }

    public function show(Activity $activity)
    {
        return response()->json($activity->load(['resident','responsible']), 200);
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'name'          => 'sometimes|string|max:255',
            'schedule'      => 'sometimes|date',
            'resident_id'   => 'sometimes|exists:residents,id',
            'responsible_id'=> 'sometimes|exists:users,id',
        ]);

        $activity->update($validated);

        return response()->json($activity, 200);
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return response()->json(null, 204);
    }
}
