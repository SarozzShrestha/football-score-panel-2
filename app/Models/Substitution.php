<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Substitution extends Model
{
    use SoftDeletes;
    protected $fillable = [
    "game_id",
    "team_id",
    "subbed_by",
    "subbed_for",
    "reason",
    "subbed_at",
    "extra_minutes",
    "deleted_at"
    ];

    protected function extraMinutes(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value === null ? 0 : $value,
        );
    }
}
