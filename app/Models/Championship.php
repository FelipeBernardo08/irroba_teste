<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Championship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function quarters()
    {
        return $this->hasMany(QuarterFinals::class, 'fk_championship');
    }

    public function semiFinals()
    {
        return $this->hasMany(SemiFinals::class, 'fk_championship');
    }

    public function thirdPlacePlay()
    {
        return $this->hasMany(PlayThirdPlace::class, 'fk_championship');
    }

    public function finals()
    {
        return $this->hasMany(Finals::class, 'fk_championship');
    }

    public function subscribed()
    {
        return $this->hasMany(SubscribeChampionship::class, 'fk_championship');
    }

    public function secondPlace()
    {
        return $this->hasMany(SecondPlace::class, 'fk_championship');
    }

    public function thirdPlace()
    {
        return $this->hasMany(ThirdPlace::class, 'fk_championship');
    }

    public function champion()
    {
        return $this->hasMany(Champion::class, 'fk_championship');
    }

    public function readChampionships(): array
    {
        return self::with('quarters')->get()->toArray();
    }

    public function points()
    {
        return $this->hasMany(Points::class, 'fk_championship');
    }

    public function readChampionshipId(int $id): array
    {
        return self::where('id', $id)
            ->with('subscribed')
            ->with('subscribed.team')
            ->with('quarters')
            ->with('quarters.team1')
            ->with('quarters.team2')
            ->with('semiFinals')
            ->with('semiFinals.team1')
            ->with('semiFinals.team2')
            ->with('thirdPlacePlay')
            ->with('thirdPlacePlay.team1')
            ->with('thirdPlacePlay.team2')
            ->with('finals')
            ->with('finals.team1')
            ->with('finals.team2')
            ->with('thirdPlace')
            ->with('thirdPlace.team')
            ->with('secondPlace')
            ->with('secondPlace.team')
            ->with('champion')
            ->with('champion.team')
            ->with('points')
            ->with('points.team')
            ->get()
            ->toArray();
    }

    public function createChampionship(object $team): array
    {
        return self::create([
            'name' => $team->name
        ])->toArray();
    }
}
