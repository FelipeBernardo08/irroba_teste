<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemiFinals extends Model
{
    use HasFactory;

    protected $fillable = [
        'fk_team_1',
        'fk_team_2',
        'goals_team_1',
        'goals_team_2',
        'fk_championship'
    ];
}
