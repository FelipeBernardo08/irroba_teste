<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    use HasFactory;

    protected $fillable = [
        'fk_team',
        'fk_championship',
        'points'
    ];

    public function team()
    {
        return $this->belongsTo(Teams::class, 'fk_team');
    }

    public function createPoints(array $points): array
    {
        return self::create([
            'fk_team' => $points['fk_team'],
            'fk_championship' => $points['fk_championship'],
        ])->toArray();
    }

    public function incrementPoint(int $id_team, int $idChampionship, int $point): bool
    {
        return self::where('fk_team', $id_team)
            ->where('fk_championship', $idChampionship)
            ->increment('points', $point);
    }

    public function decrementPoint(int $id_team, int $idChampionship, int $point): bool
    {
        $points = self::where('fk_team', $id_team)
            ->where('fk_championship', $idChampionship)
            ->get()
            ->toArray();
        if ($points[0]['points'] > 0 && ($points[0]['points'] -= $point) >= 0) {
            return self::where('fk_team', $id_team)
                ->where('fk_championship', $idChampionship)
                ->decrement('points', $point);
        }
        return self::where('fk_team', $id_team)
            ->where('fk_championship', $idChampionship)
            ->update([
                'points' => 0
            ]);
    }

    public function getPointsByArrayIdTeam(array $ids, int $idChampionship): array
    {
        return self::where('fk_championship', $idChampionship)
            ->whereIn('fk_team', $ids)
            ->get()
            ->toArray();
    }
}
