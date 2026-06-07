<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pipe_type',
        'planned_at',
        'installed_at',
        'length',
        'geometry'
    ];
}
