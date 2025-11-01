<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use App\Models\GameTeamPlayer;
use App\Models\Substitution;
use Illuminate\Http\Request;

class GameLogController extends Controller
{
    public function fetchScoreLogs($gameId)
    {
        // Fetch score logs from the database based on the game ID
        $scoreLogs = \App\Models\GameScore::selectRaw("game_scores.*,
        (SELECT teams.name FROM teams WHERE teams.id = game_scores.team_id LIMIT 1) as team
        ")->where('game_id', $gameId)->orderBy('created_at', 'desc')->get();

        $players = GameTeamPlayer::selectRaw("game_team_players.*")
            ->where('game_id', $gameId)
            ->get()
            ->groupBy('team_id');

        // Return a view with the score logs
        return view('games.log.scoreLog', compact('scoreLogs', 'players'));
    }

    public function fetchFoulLogs($gameId)
    {
        // Fetch foul logs from the database based on the game ID
        $foulLogs = \App\Models\GameCardLog::selectRaw("game_card_logs.*,
        (SELECT teams.name FROM teams WHERE teams.id = game_card_logs.team_id LIMIT 1) as team
        ")->where('game_id', $gameId)->orderBy('created_at', 'desc')->get();

        $players = GameTeamPlayer::selectRaw("game_team_players.*")
            ->where('game_id', $gameId)
            ->get()
            ->groupBy('team_id');
        // Return a view with the foul logs
        return view('games.log.foulLog', compact('foulLogs', 'players'));
    }

    public function fetchSubstitutionLogs($gameId)
    {
        // Fetch substitution logs from the database based on the game ID
        $substitutionLogs = \App\Models\Substitution::selectRaw("substitutions.*,
        (SELECT teams.name FROM teams WHERE teams.id = substitutions.team_id LIMIT 1) as team,
        (select players.name FROM players WHERE players.id = substitutions.subbed_by LIMIT 1) as subbed_by_name,
        (select players.name FROM players WHERE players.id = substitutions.subbed_for LIMIT 1) as subbed_for_name
        ")->where('game_id', $gameId)->orderBy('created_at', 'desc')->get();

        $players = GameTeamPlayer::selectRaw("game_team_players.*")
            ->where('game_id', $gameId)
            ->get()
            ->groupBy('team_id');

        // Return a view with the substitution logs
        return view('games.log.substitutionLog', compact('substitutionLogs', 'players'));
    }


    public function updateScoreLog(Request $request, $gameId, $id)
    {
        $log = \App\Models\GameScore::where('game_id', $gameId)->findOrFail($id);

        // Accept only allowed fields
        $data = $request->only(['scored_by', 'assist_by', 'is_penalty', 'is_own_goal']);

        // Fill player names automatically if IDs are provided
        if (isset($data['scored_by'])) {
            $player = \App\Models\GameTeamPlayer::find($data['scored_by']);
            $data['scorer_name'] = $player?->player_name;
        }

        if (isset($data['assist_by'])) {
            $player = \App\Models\GameTeamPlayer::find($data['assist_by']);
            $data['assist_name'] = $player?->player_name;
        }

        $log->update($data);

        return response()->json(['success' => true, 'data' => $log]);
    }

    public function deleteScoreLog($gameId, $id)
    {
        $log = \App\Models\GameScore::where('game_id', $gameId)->findOrFail($id);
        // soft delete the log
        $log->delete();

        return response()->json(['success' => true]);
    }

    public function updateFoulLog(Request $request, $gameId, $id)
    {
        $log = \App\Models\GameCardLog::where('game_id', $gameId)->findOrFail($id);

        // Accept only allowed fields
        $data = $request->only(['player', 'is_yellow_card', 'is_red_card', 'fouled_at']);

        // Fill player name automatically if ID is provided
        if (isset($data['player'])) {
            $player = \App\Models\GameTeamPlayer::find($data['player']);
            $data['player_name'] = $player?->player_name;
        }

        $log->update($data);

        return response()->json(['success' => true, 'data' => $log]);
    }

    public function deleteFoulLog($gameId, $id)
    {
        $log = \App\Models\GameCardLog::where('game_id', $gameId)->findOrFail($id);
        // soft delete the log
        $log->delete();

        return response()->json(['success' => true]);
    }


    public function updateSubstitutionLog(Request $request, $gameId, $id)
    {
        $log = Substitution::findOrFail($id);

        $log->update($request->only([
            'subbed_by',
            'subbed_for',
            'reason',
            'subbed_at',
            'extra_minutes'
        ]));

        return response()->json(['success' => true]);
    }

    public function deleteSubstitutionLog($gameId, $id)
    {
        $log = Substitution::findOrFail($id);
        $log->delete();

        return response()->json(['success' => true]);
    }
}
