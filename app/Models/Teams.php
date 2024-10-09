<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function points()
    {
        return $this->hasMany(Points::class, 'fk_team');
    }

    public function readTeams(): array
    {
        return self::get()->toArray();
    }

    public function readTeamId(int $id): array
    {
        return self::where('id', $id)
            ->get()
            ->toArray();
    }

    public function createTeams(array $teams): array
    {
        foreach ($teams as $key => $team) {
            self::create([
                'name' => $team
            ])->toArray();

            if (($key + 1) == count($teams)) {
                return self::get()
                    ->toArray();
            }
        }
    }
}
