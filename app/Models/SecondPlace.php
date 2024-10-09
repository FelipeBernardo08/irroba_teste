<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondPlace extends Model
{
    use HasFactory;

    protected $fillable = [
        'fk_team',
        'fk_championship'
    ];

    public function team()
    {
        return $this->belongsTo(Teams::class, 'fk_team');
    }

    public function createTeamSecondPlace(int $id_team, int $idChampionship): array
    {
        return self::create([
            'fk_team' => $id_team,
            'fk_championship' => $idChampionship
        ])->toArray();
    }
}
