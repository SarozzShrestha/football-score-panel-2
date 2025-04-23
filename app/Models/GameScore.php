<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameScore extends Model
{
    use HasFactory;

    protected $table = 'game_scores';

    protected $fillable = ['game_id', 'team_id', 'scored_by', 'scorer_name', 'assist_name', 'is_penalty', 'is_own_goal', 'assist_by', 'scored_at', 'created_at', 'updated_at'];
}
