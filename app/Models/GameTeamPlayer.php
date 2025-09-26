<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameTeamPlayer extends Model
{
    use HasFactory;

    protected $table = 'game_team_players';

    protected $guarded = [];
}
