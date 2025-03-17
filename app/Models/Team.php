<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;

    use HasFactory;

    protected $table = 'teams';

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'abb', 'logo', 'home_color_top', 'home_color_down', 'away_color_top', 'away_color_down', 'manager_id', 'status'];

    public function manager()
    {
        return $this->belongsTo(Staff::class, 'manager_id', 'id');
    }
}
