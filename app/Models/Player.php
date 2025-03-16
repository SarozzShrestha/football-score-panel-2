<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use SoftDeletes;

    use HasFactory;

    protected $table = 'players';

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'role', 'position', 'image', 'nationality', 'height', 'height_unit', 'weight', 'weight_unit', 'age', 'status'];
}
