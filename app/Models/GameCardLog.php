<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameCardLog extends Model
{
    use HasFactory;

    protected $table = 'game_card_logs';

    protected $fillable = ['game_id', 'team_id', 'player', 'player_name', 'is_yellow_card', 'is_red_card', 'fouled_at', 'created_at', 'updated_at'];
}
