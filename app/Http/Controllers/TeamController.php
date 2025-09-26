<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Player;
use App\Models\Staff;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function viewTeamPlayers(Team $team)
    {
        $players = Player::select('players.*',
            DB::raw('IF(team_players.player_id IS NOT NULL, 1, 0) as player_in_team'),
            'team_players.is_captain',
            'team_players.jersey_no')
            ->leftJoin('team_players', function ($join) use ($team) {
                $join->on('players.id', '=', 'team_players.player_id')
                    ->where('team_players.team_id', '=', $team->id);
            })
            ->whereNull('players.deleted_at')
            ->where('players.status', '1')
            // Ensure the player is only in the current team (no other team association)
            ->whereNotIn('players.id', function ($query) use ($team) {
                $query->select('player_id')
                    ->from('team_players')
                    ->where('team_id', '!=', $team->id); // Player is in some other team
            })
            ->orderBy('players.name', 'ASC')
            ->get();;

        return view('teams.teamPlayer', compact('team', 'players'));
    }

    public function updateTeamPlayers(Request $request, Team $team)
    {
        $captainPlayer = $request->get('captainPlayer');
        $selectedPlayers = $request->get('selectedPlayers');
        $playerJerseyNos = $request->get('playerJersey');

        $team->players()->sync($selectedPlayers);

        if ($captainPlayer) {
            $team->players()->updateExistingPivot($captainPlayer, ['is_captain' => '1']);

            foreach ($selectedPlayers as $playerId) {
                if ($playerId !== $captainPlayer) {
                    $team->players()->updateExistingPivot($playerId, ['is_captain' => '0']);
                }
            }
        }

        foreach ($playerJerseyNos as $playerId => $jerseyNumber) {
            if (!empty($jerseyNumber) && $playerId != 0) {
                $team->players()->updateExistingPivot($playerId, ['jersey_no' => $jerseyNumber]);
            }
        }

        return response()->json(['message' => 'Team players updated successfully']);
    }
}
