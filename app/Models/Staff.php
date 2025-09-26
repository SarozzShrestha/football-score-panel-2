<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;

    use HasFactory;

    protected $table = 'staffs';

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'role', 'image', 'status'];
}
