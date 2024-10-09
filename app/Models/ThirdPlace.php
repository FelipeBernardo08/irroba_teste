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

    public function team()
    {
        return $this->belongsTo(Teams::class, 'fk_team');
    }

    public function createThirdPlace(int $idTeam, int $idChampionship): array
    {
        return self::create([
            'fk_team' => $idTeam,
            'fk_championship' => $idChampionship
        ])->toArray();
    }
}
