<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Player;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players = Player::whereNull('deleted_at')->orderBy('name', 'ASC')->get();
        return view('players.index', compact('players'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('players.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlayerRequest $request)
    {
        Player::create([
            'name' => $request->name,
            'role' => $request->role,
            'position' => $request->position,
            'image' => $request->image,
            'nationality' => $request->nationality,
            'height' => $request->height,
            'height_unit' => $request->height_unit,
            'weight' => $request->weight,
            'weight_unit' => $request->weight_unit,
            'age' => $request->age,
            'status' => isset($request->status) ? '1' : '0',
        ]);

        return redirect()->route('admin.players.index')->with('success', 'New player added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        return response()->json($player->toJson());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        return view('players.edit', compact('player'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlayerRequest $request, Player $player)
    {
        $request->merge(['status' => (string)(int)$request->has('status')]);

        $player->update($request->all());

        return redirect()->route('admin.players.index')->with('success', 'Player information updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        $player->delete();
        return redirect()->back()->with('success', 'Player Deleted.');
    }
}
