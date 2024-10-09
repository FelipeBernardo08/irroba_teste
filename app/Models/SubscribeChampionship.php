<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscribeChampionship extends Model
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

    public function createSubscribe(int $idTeam, int $idChampionship): array
    {
        return self::create([
            'fk_team' => $idTeam,
            'fk_championship' => $idChampionship
        ])->toArray();
    }

    public function readTeamsSubscribedByChampionshipId(int $idChampionship): array
    {
        return self::where('fk_championship', $idChampionship)
            ->get()
            ->toArray();
    }

    public function getSubscribeByArrayTeams(array $ids, int $idChampionship): array
    {
        return self::where('fk_championship', $idChampionship)
            ->whereIn('fk_team', $ids)
            ->get()
            ->toArray();
    }
}
