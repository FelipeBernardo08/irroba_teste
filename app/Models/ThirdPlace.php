<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThirdPlace extends Model
{
    use HasFactory;

    protected $fillable = [
        'fk_team',
        'fk_championship'
    ];
}
