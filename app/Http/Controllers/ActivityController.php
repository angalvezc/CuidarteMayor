<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Resident;
use App\Models\User;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::with(['resident', 'responsible'])->get();
        return view('activities.index', compact('activities'));
    }

    public function create()
    {
        $residents = Resident::all();
        $users = User::all();
        return view('activities.create', compact('residents', 'users'));
    }

    public function store(Request $request)
    {
        $activity = new Activity();
        $activity->name = $request->name;
        $activity->schedule = $request->schedule;
        $activity->resident_id = $request->resident_id;
        $activity->responsible_id = $request->responsible_id;
        $activity->save();

        return redirect()->route('activities.index');
    }

    public function show(string $id)
    {
        $activity = Activity::with(['resident', 'responsible'])->findOrFail($id);
        return view('activities.show', compact('activity'));
    }

    public function edit(string $id)
    {
        $activity = Activity::findOrFail($id);
        $residents = Resident::all();
        $users = User::all();
        return view('activities.edit', compact('activity', 'residents', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $activity = Activity::findOrFail($id);
        $activity->name = $request->name;
        $activity->schedule = $request->schedule;
        $activity->resident_id = $request->resident_id;
        $activity->responsible_id = $request->responsible_id;
        $activity->save();

        return redirect()->route('activities.index');
    }

    public function destroy(string $id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return redirect()->route('activities.index');
    }
}
