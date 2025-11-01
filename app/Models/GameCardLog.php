<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameCardLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'game_card_logs';

    protected $fillable = ['game_id', 'team_id', 'player', 'player_name', 'is_yellow_card', 'is_red_card', 'fouled_at', 'created_at', 'updated_at', 'deleted_at'];
}
