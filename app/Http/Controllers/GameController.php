<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use App\Models\GameCardLog;
use App\Models\Staff;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::all();
        return view('games.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = Team::get();
        $staffs = Staff::where('role', '1')->get();

        return view('games.create', compact('teams', 'staffs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameRequest $request)
    {
        Game::create([
            'name' => $request->name,
            'date_time' => $request->date_time,
            'venue' => $request->venue,
            'weather' => $request->weather,
            'team_a_id' => $request->team_a_id,
            'team_b_id' => $request->team_b_id,
            'referee' => $request->referee,
            'first_linesmen' => $request->first_linesmen,
            'second_linesmen' => $request->second_linesmen,
            'official' => $request->official,
        ]);

        return redirect()->route('admin.games.index')->with('success', 'New Game Created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
//        $game->load('teamA', 'teamB');

        $data = $game->toArray();

        $data['team_a_image'] = $game->teamA->logo ?? null;
        $data['team_b_image'] = $game->teamB->logo ?? null;

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameRequest $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        //
    }

    public function gamePlayingXI(Game $game)
    {
        $team_a = $game->teamA()->first()->players()
            ->orderBy('jersey_no', 'ASC')
            ->get()
            ->map(function ($player) use ($game) {
                $playerStatus = DB::table('game_team_players')
                    ->where('game_id', $game->id)
                    ->where('player_id', $player->id)
                    ->value('status');

                $isCaptain = DB::table('game_team_players')
                    ->where('game_id', $game->id)
                    ->where('player_id', $player->id)
                    ->value('is_captain');

                $player->is_playing_xi = $playerStatus == '1';
                $player->is_substitute = $playerStatus == '2';
                $player->is_captain = $isCaptain == '1';

                return $player;
            });

        $team_b = $game->teamB()->first()->players()
            ->orderBy('jersey_no', 'ASC')
            ->get()
            ->map(function ($player) use ($game) {
                $playerStatus = DB::table('game_team_players')
                    ->where('game_id', $game->id)
                    ->where('player_id', $player->id)
                    ->value('status');

                $isCaptain = DB::table('game_team_players')
                    ->where('game_id', $game->id)
                    ->where('player_id', $player->id)
                    ->value('is_captain');

                $player->is_playing_xi = $playerStatus == '1';
                $player->is_substitute = $playerStatus == '2';
                $player->is_captain = $isCaptain == '1';

                return $player;
            });

        return view('games.playingXI', compact('game', 'team_a', 'team_b'));
    }

    public function updateGamePlayingXI(Request $request, Game $game)
    {
        $teamAPlayingXI = $request->team_a_playing_xi ?? [];
        $teamBPlayingXI = $request->team_b_playing_xi ?? [];
        $teamASubs = $request->team_a_subs ?? [];
        $teamBSubs = $request->team_b_subs ?? [];
        $teamACaptain = $request->team_a_captain ?? null;
        $teamBCaptain = $request->team_b_captain ?? null;

        $allPlayers = array_merge($teamAPlayingXI, $teamBPlayingXI, $teamASubs, $teamBSubs);

        $playerDetails = DB::table('players')
            ->whereIn('id', $allPlayers)
            ->pluck('name', 'id');

        $playerJerseyNumbers = DB::table('team_players')
            ->whereIn('player_id', $allPlayers)
            ->pluck('jersey_no', 'player_id');

        $updateOrInsertPlayer = static function ($playerId, $teamId, $status, $teamCaptain) use ($game, $playerDetails, $playerJerseyNumbers) {
            DB::table('game_team_players')->updateOrInsert(
                [
                    'game_id' => $game->id,
                    'team_id' => $teamId,
                    'player_id' => $playerId,
                ],
                [
                    'player_name' => $playerDetails[$playerId] ?? 'Unknown',
                    'jersey_no' => $playerJerseyNumbers[$playerId] ?? '',
                    'status' => $status,
                    'is_captain' => $playerId === $teamCaptain ? '1' : '0',
                    'subbed_at' => null,
                    'subbed_for' => null,
                    'has_yellow_carded' => '0',
                    'has_red_carded' => '0',
                    'updated_at' => now(),
                ]
            );
        };

        foreach ($teamAPlayingXI as $playerId) {
            $updateOrInsertPlayer($playerId, $game->team_a_id, '1', $teamACaptain);
        }

        foreach ($teamBPlayingXI as $playerId) {
            $updateOrInsertPlayer($playerId, $game->team_b_id, '1', $teamBCaptain);
        }

        foreach ($teamASubs as $playerId) {
            $updateOrInsertPlayer($playerId, $game->team_a_id, '2', $teamACaptain);
        }

        foreach ($teamBSubs as $playerId) {
            $updateOrInsertPlayer($playerId, $game->team_b_id, '2', $teamBCaptain);
        }

        return response()->json([
            'status' => 'success',
            'url' => route('admin.games.index')
        ]);
    }

    public function gameDashboardView(Request $request, Game $game)
    {
        return view('games.gamingDashboard', compact('game'));
    }

    public function gameCardLogAction(Request $request, Game $game, Team $team)
    {
        $isYellowCard = $request->get('is_yellow_card') ? '1' : '0';
        $isRedCard = $request->get('is_red_card') ? '1' : '0';

        $player = $team->players()->where('players.id', $request->get('card_issued_player'))->first();
        if (!$player)
        {
            return redirect()->back()->with('error', 'Error: Invalid Player Detail.');
        }

        GameCardLog::create([
            'game_id' => $game->id,
            'team_id' => $team->id,
            'player' => $player->id,
            'player_name' => $player->name,
            'is_yellow_card' => $isYellowCard,
            'is_red_card' => $isRedCard,
            'fouled_at' => $request->get('fouled_at'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Foul Log updated.');
    }
}
