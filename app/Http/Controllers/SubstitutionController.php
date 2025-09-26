<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameTeamPlayer;
use App\Models\Substitution;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubstitutionController extends Controller
{
    public function gameSubstitutionCreate(Request $request, Game $game, Team $team)
    {

        $getPlayers = GameTeamPlayer::where([
            ['team_id', $team->id],
            ['game_id', $game->id],
        ])->get();

        $subInEligiblePlayers = $getPlayers->where('latest_status', '2');
        $subOutEligiblePlayers = $getPlayers->where('latest_status', '1');

        return view('games.substitution.create', compact('game', 'team', 'subInEligiblePlayers', 'subOutEligiblePlayers'));
    }

    public function gameSubstitutionStore(Request $request, Game $game, Team $team)
    {

        $checkTable = function ($value) use ($team, $game) {
            return GameTeamPlayer::where([
                ['team_id', $team->id],
                ['game_id', $game->id],
                ['player_id', $value],
            ])->first();
        };

        $request->validate([
            'subbed_by' => [
                'required',
                function ($attribute, $value, $fail) use ($checkTable) {
                    $player = $checkTable($value);

                    if (!$player || $player->latest_status != '2') {
                        $fail('The subbed_by player is not eligible to be substituted in.');
                    }
                },
            ],
            'subbed_for' => [
                'required',
                'different:subbed_by',
                function ($attribute, $value, $fail) use ($checkTable) {
                    $player = $checkTable($value);

                    if (!$player || $player->latest_status != '1') {
                        $fail('The subbed_for player is not eligible to be substituted out.');
                    }
                },
            ],
            'reason' => [
                'required',
                'in:' . implode(',', array_keys(\App\Constants\AppConstants::SUBSTITUTION_REASONS)),
            ],
            'subbed_at' => [
                'required',
            ],
        ]);


        $data = $request->all();

        $data['game_id'] = $game->id;
        $data['team_id'] = $team->id;

        DB::beginTransaction();
        try {
            $updateGamePlayerStatus = fn($playerId, $latestStatus) => GameTeamPlayer::where([
                'game_id'   => $game->id,
                'team_id'   => $team->id,
                'player_id' => $playerId,
            ])->update([
                'latest_status' => $latestStatus,
            ]);

            $updateGamePlayerStatus($data['subbed_by'], '1'); // subbed in
            $updateGamePlayerStatus($data['subbed_for'], '3'); // subbed out
            Substitution::create($data);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
        DB::commit();

        return back()->with('success', 'Substitution Created.');
    }
}
