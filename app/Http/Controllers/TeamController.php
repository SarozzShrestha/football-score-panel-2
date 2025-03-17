<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Staff;
use App\Models\Team;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::whereNull('deleted_at')->orderBy('name', 'ASC')->get();
        return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $managers = Staff::whereNull('deleted_at')->where('status', '1')->where('role', '0')->orderBy('name', 'ASC')->get();
        return view('teams.create', compact('managers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        Team::create([
            'name' => $request->name,
            'abb' => $request->abb,
            'logo' => $request->image,
            'home_color_top' => $request->home_jersey_top,
            'home_color_down' => $request->home_jersey_down,
            'away_color_top' => $request->away_jersey_top,
            'away_color_down' => $request->away_jersey_down,
            'manager_id' => $request->manager,
            'status' => isset($request->status) ? '1' : '0',
        ]);

        return redirect()->route('admin.teams.index')->with('success', 'New Team added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return response()->json($team->toJson());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        $managers = Staff::whereNull('deleted_at')->where('status', '1')->where('role', '0')->orderBy('name', 'ASC')->get();
        return view('teams.edit', compact('team', 'managers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $request->merge([
            'status' => (string)(int)$request->has('status'),
            'logo' => $request->image,
            'home_color_top' => $request->home_jersey_top,
            'home_color_down' => $request->home_jersey_down,
            'away_color_top' => $request->away_jersey_top,
            'away_color_down' => $request->away_jersey_down,
        ]);

        $team->update($request->all());

        return redirect()->route('admin.teams.index')->with('success', 'Team information updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->back()->with('success', 'Team Deleted.');
    }
}
