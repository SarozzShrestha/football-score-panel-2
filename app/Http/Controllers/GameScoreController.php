<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameScore;
use App\Models\Team;
use Illuminate\Http\Request;

class GameScoreController extends Controller
{

    public function gameScoreAction(Request $request, Game $game, Team $team)
    {
        $isPenalty = $request->get('is_penalty') ? '1' : '0';
        $isOwnGoal = $request->get('is_own_goal') ? '1' : '0';
        $teamA = $game->teamA()->first();
        $teamB = $game->teamB()->first();

        if ($teamA->id === $team->id)
        {
            ++$game->team_a_score;
        } else {
            ++$game->team_b_score;
        }

        if ($isOwnGoal === "1")
        {
            if ($teamA->id !== $team->id)
            {
                $scorer = $teamA->players()->where('players.id', $request->get('own_goal'))->first();
            } else {
                $scorer = $teamB->players()->where('players.id', $request->get('own_goal'))->first();
            }

        } else {
            $scorer = $team->players()->where('players.id', $request->get('scored_by'))->first();
        }

        if (!$scorer) {
            return redirect()->back()->with('error', 'Error: Invalid Scorer Detail.');
        }

        $assist_by = null;
        if (!empty($request->get('assist_by')))
        {
            $assist_by =  $team->players()->where('players.id', $request->get('assist_by'))->first();

            if (!$assist_by) {
                return redirect()->back()->with('error', 'Error: Invalid Assist Player Detail.');
            }
        }

        $gameScore = GameScore::create([
            'game_id'     => $game->id,
            'team_id'     => $team->id,
            'scored_by'   => $scorer->id,
            'scorer_name' => $scorer->name,
            'assist_by'   => $assist_by->id ?? null,
            'assist_name' => $assist_by->name ?? null,
            'scored_at'   => $request->get('scored_time'),
            'is_penalty'  => $isPenalty,
            'is_own_goal' => $isOwnGoal,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $game->save();

        return redirect()->back()->with('success', 'Score updated.');
    }
}
